<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PaymentReportRequest;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Payment;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\Stripe;
use Stripe\WebhookEndpoint;

class PaymentController extends Controller
{
    /**
     * Display the Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payments.index');
    }

    /**
    * Return the list of payments datatables.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function datatables()
    {
        return Laratables::recordsOf(Payment::class);
    }

    /**
     * Show the form for Add New Payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment = optional();
        $members = Member::select('id', 'first_name', 'last_name')->get();

        return view(
            'admin.payments.add',
            compact('payment', 'members')
        );
    }

    /**
     * Store a New Payments for Member.
     *
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        $validateDate = $request->validated();
        $validateDate['status'] = 3;

        if (isset($validateDate['new_validity_date']) && $validateDate['new_validity_date'] == 1) {
            $member = Member::select('id', 'validity_date', 'membership_plan_id')
                ->with('membershipPlan')
                ->findOrFail($validateDate['member_id'])
            ;

            $planMonth = $member->membershipPlan ? $member->membershipPlan->plan : null;

            if ($member->validity_date && $planMonth) {
                $noOfMonths = (new MembershipPlanController)->monthCount($planMonth);

                $date = new Carbon($member->validity_date);

                $validateDate['new_validity_date'] = $date->addMonths($noOfMonths)->format('Y-m-d');
            }
        }

        DB::beginTransaction();

        try {
            Payment::create($validateDate);

            if (isset($member) && $validateDate['new_validity_date']) {
                $member->validity_date = $validateDate['new_validity_date'];
                $member->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with([
                'type' => 'error',
                'message' => __('Something Went Wrong')
            ]);
        }

        return redirect()->route('admin.payments.index')
            ->with(['type' => 'success', 'message' => __('Payment Added successfully')])
        ;
    }

    /**
     * Show the form for edit particular Member Payment.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $member = Member::select('id', 'first_name', 'last_name')
            ->where('id', $payment->member_id)
            ->first();

        return view(
            'admin.payments.edit',
            compact('payment', 'member')
        );
    }

    /**
     * Update the particular Member's Payment.
     *
     * @param \App\Http\Requests\PaymentRequest $request
     * @param \App\Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $validateData = $request->validated();

        if ($payment->webhook_id) {
            return redirect()->route('admin.payments.index')
                ->with(['type' => 'error', 'message' => __('Something went wrong!!!')])
            ;
        }

        $payment->update([
            'amount' => $validateData['amount'],
            'payment_date' => $validateData['payment_date'],
        ]);

        return redirect()->route('admin.payments.index')
            ->with(['type' => 'success', 'message' => __('Payment updated successfully')])
        ;
    }

    /**
      * Delete the Member's payment.
      *
      * @param \App\Payment $payment
      * @return \Illuminate\Http\RedirectResponse
      */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with(['type' => 'success', 'message' => __('Payments deleted successfully')])
        ;
    }

    /**
     * Display a Date wise Payments Report.
     *
     * @param \App\Http\Requests\PaymentReportRequest
     * @return mixed \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     */
    public function paymentsReport(PaymentReportRequest $request)
    {
        $dates = $request->validated();

        $startDate = isset($dates['start_date']) ? $dates['start_date'] : Carbon::now()->subDays(29);
        $tillDate = isset($dates['end_date']) ? $dates['end_date'] : Carbon::now();

        $paymentsReports = Payment::query()
            ->select(
                'id',
                'amount',
                'payment_date',
                DB::raw("SUM(amount) as date_total")
            )
            ->groupBy('id', 'payment_date')
            ->orderBy('payment_date', 'DESC')
            ->whereBetween('payment_date', [$startDate, $tillDate])
            ->get()
        ;

        if ($request->ajax()) {
            return [
                'data' => $paymentsReports,
            ];
        }

        return view('admin.payments.reports', compact('paymentsReports'));
    }

    /**
     * Show the Form for create a new Payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function onlinePaymentForm()
    {
        $payment = optional();
        $members = Member::select('id', 'first_name', 'last_name')->get();
        $membershipPlans = MembershipPlan::select('id', 'name')->get();

        return view(
            'admin.payments.online_payment',
            compact('payment', 'members', 'membershipPlans')
        );
    }

    /**
     * Store a online Payment and mail send to the Member.
     *
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onlinePayment(PaymentRequest $request)
    {
        $validateDate = $request->validated();

        if (isset($validateDate['new_validity_date']) && $validateDate['new_validity_date'] == 1) {
            $member = Member::select('id', 'validity_date', 'membership_plan_id')
                ->with('membershipPlan')
                ->findOrFail($validateDate['member_id'])
            ;

            $planMonth = $member->membershipPlan ? $member->membershipPlan->plan : null;

            if ($member->validity_date && $planMonth) {
                $noOfMonths = (new MembershipPlanController)->monthCount($planMonth);

                $date = new Carbon($member->validity_date);

                $validateDate['new_validity_date'] = $date->addMonths($noOfMonths)->format('Y-m-d');
            }
        }

        DB::beginTransaction();
        try {
            $payments = Payment::create($validateDate);

            Stripe::setApiKey(config('services.stripe.secret'));

            if ($payments->member->stripe_id) {
                $customer = Customer::retrieve($payments->member->stripe_id);
            } else {
                $customer = Customer::create([
                    'email' => $payments->member->email,
                ]);

                $payments->member->stripe_id = $customer->id;
                $payments->member->save();
            }

            InvoiceItem::create([
                'amount' => $payments->amount*100,
                'currency' => 'usd',
                'customer' => $customer->id,
                'description' => "#".$payments->id."- online payment",
            ]);

            $invoice = Invoice::create([
                'customer' => $customer->id,
                'billing' => 'send_invoice',
                'days_until_due' => 30,
            ]);

            $invoice->sendInvoice();

            $paymentWebhook = WebhookEndpoint::create([
                "url" => route('admin.payments-online.response'),
                "enabled_events" => ["charge.succeeded"]
            ]);

            $payments->webhook_id = $paymentWebhook->id;
            $payments->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with(['type' => 'error', 'message' => __('Something Went Wrong')])
            ;
        }

        return redirect()->route('admin.payments.index')
            ->with(['type' => 'success', 'message' => __('Payment Added successfully')])
        ;
    }

    /**
     * Stripe Payment Response.
     *
     * @return void
     */
    public function stripePaymentResponse()
    {
        $stripeResponse = request()->all();

        $payment = Payment::where('webhook_id', $stripeResponse['id'])
            ->first()
        ;

        if ($payment) {
            $payment->status = 3;
            $payment->save();
        }
    }

    /**
     * Download payment invoice.
     *
     * @param \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function paymentInvoice(Payment $payment)
    {
        $member = Member::select('first_name', 'last_name', 'email', 'address', 'phone')
            ->findOrFail($payment->member_id)
        ;

        return view('admin.payments.invoice', compact('payment', 'member'));
    }
}
