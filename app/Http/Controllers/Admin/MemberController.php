<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Imports\MemberImport;
use App\Models\Member;
use App\Models\MemberMeasurement;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Timing;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Customer;
use Stripe\Stripe;

class MemberController extends Controller
{
    /**
     * Display the Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.members.index');
    }

    /**
     * Return the members datatables.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatables()
    {
        return Laratables::recordsOf(Member::class);
    }

    /**
     * Show the new Member Form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member = optional();
        $bmi = null;
        $membershipPlans = MembershipPlan::select('id', 'name')->get();
        $members = Member::select('id', 'first_name', 'last_name')->get();
        $timings = Timing::get();

        return view(
            'admin.members.add',
            compact('member', 'members', 'membershipPlans', 'timings', 'bmi')
        );
    }

    /**
     * Insert New Member.
     *
     * @param \App\Http\Requests\MemberRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MemberRequest $request)
    {
        $validatedData = $request->validated();

        $member = Member::create($validatedData);

        if (config('services.stripe.secret')) {
            Stripe::setApiKey(config('services.stripe.secret'));

            $customer = Customer::create([
                'email' => $member->email
            ]);

            $member->stripe_id = $customer->id;
            $member->save();
        }

        if (isset($validatedData['timings'])) {
            $member->timings()->sync($validatedData['timings']);
        }

        if (isset($validatedData['avatar'])) {
            $member->addMediaFromRequest('avatar')->toMediaCollection('members');
        }

        if (isset($validatedData['identity_proofs'])) {
            foreach ($validatedData['identity_proofs'] as $idProof) {
                $member->addMedia($idProof)
                    ->toMediaCollection('identity_proofs')
                ;
            }
        }

        return redirect()->route('admin.members.index')
            ->with(['type' => 'success', 'message' => __('Member Add successfully')])
        ;
    }

    /**
     * Show the Form for edit Member.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bmi = null;

        $member = Member::with('memberMeasurements', 'media')->findOrFail($id);
        $members = Member::select('id', 'first_name', 'last_name')
            ->where('id', '!=', $id)
            ->get()
        ;
        $membershipPlans = MembershipPlan::select('id', 'name')->get();
        $timings = Timing::get();

        $latestWeight = MemberMeasurement::query()
            ->select('measurement_type', 'member_id', 'measurement_date', 'measurement_value')
            ->where('measurement_type', 5)
            ->where('member_id', $id)
            ->orderBy('measurement_date', 'DESC')
            ->first();

        if ($latestWeight) {
            $weight = $latestWeight->measurement_value;

            // bmi = weight (kg) / (height (m))2
            $bmi = number_format($weight / (($member->height / 39.37007874) * ($member->height / 39.37007874)), 2);
        }

        return view(
            'admin.members.edit',
            compact(
                'member',
                'members',
                'membershipPlans',
                'timings',
                'bmi'
            )
        );
    }

    /**
     * Updates the specified Member.
     *
     * @param \App\Http\Requests\MemberRequest $request
     * @param \App\Member $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MemberRequest $request, Member $member)
    {
        $validatedData = $request->validated();

        $member->update($validatedData);

        if (isset($validatedData['timings'])) {
            $member->timings()->sync($validatedData['timings']);
        } else {
            $member->timings()->detach();
        }

        if (isset($validatedData['avatar'])) {
            $member->addMediaFromRequest('avatar')->toMediaCollection('members');
        }

        if (isset($validatedData['identity_proofs'])) {
            foreach ($validatedData['identity_proofs'] as $idProof) {
                $member->addMedia($idProof)
                    ->toMediaCollection('identity_proofs')
                ;
            }
        }

        return redirect()->route('admin.members.index')
            ->with(['type' => 'success', 'message' => __('Member Updated successfully')])
        ;
    }

    /**
     * Remove the particular Member identity proof.
     *
     * @param int $memberId
     * @param int $mediaId
     * @return void
     **/
    public function removeMedia($memberId, $mediaId)
    {
        $member = Member::with('media')->findOrFail($memberId);

        $member->media->firstWhere('id', $mediaId)->delete();
    }

    /**
      * Delete the Member.
      *
      * @param \App\Member $member
      * @return \Illuminate\Http\RedirectResponse
      */
    public function destroy(Member $member)
    {
        if (Member::where('referred_by', $member->id)->exists()) {
            return redirect()->route('admin.members.index')
                ->with(['type' => 'error', 'message' => __('This member has referred one or more members. Cannot be deleted.')])
            ;
        }

        if (Payment::where('member_id', $member->id)->exists()) {
            return redirect()->route('admin.members.index')
                ->with(['type' => 'error', 'message' => __('One or more payment records exist for this member. Cannot be deleted.')])
            ;
        }

        $member->memberMeasurements()->delete();
        $member->timings()->detach();
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with(['type' => 'success', 'message' => __('Member deleted successfully')])
        ;
    }

    /**
     * Displays Member's payments.
     *
     * @param int $memberId
     * @return \Illuminate\Http\Response
     */
    public function payments($memberId)
    {
        $member = Member::query()
            ->with(['payments' => function ($query) {
                $query->latest('payment_date');
            },
                'payments.membershipPlan'
            ])
            ->findOrFail($memberId)
        ;

        return view('admin.members.payments', compact('member'));
    }

    /**
      * Return Member's Membership plan detail.
      *
      * @return \Illuminate\Http\RedirectResponse
      */
    public function memberDetail()
    {
        $member = Member::select('id', 'membership_plan_id', 'validity_date')
            ->with('membershipPlan')
            ->findOrFail(request('id'))
        ;

        $planMonth = $member->membershipPlan ? $member->membershipPlan->plan : null;

        $newValidityDate = null;

        if ($member->validity_date && $planMonth) {
            $noOfMonths = (new MembershipPlanController)->monthCount($planMonth);

            $date = new Carbon($member->validity_date);
            $newValidityDate =  $date->addMonths($noOfMonths)->format('d/m/Y');
        }

        return response()
            ->json(['member' => $member, 'newValidityDate' => $newValidityDate], 200)
        ;
    }

    /**
     * Upload the Members from excel file.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadMember()
    {
        request()->validate([
            'members' => 'required|file'
        ]);

        $fileExtensions = array(request()->file('members')->getClientOriginalExtension());
        if (! in_array($fileExtensions[0], ["xls", "xlsx"])) {
            return redirect()->route('admin.members.index')
               ->with(['type' => 'error', 'message' => __('Please upload valid file like: xls or xlsx')])
            ;
        }

        DB::beginTransaction();

        try {
            Excel::import(new MemberImport, request()->file('members'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.members.index')
                ->with(['type' => 'error', 'message' => __('Member Upload Failed')])
            ;
        }

        return redirect()->route('admin.members.index')
            ->with(['type' => 'success', 'message' => __('Member Upload Successfully')])
        ;
    }
}
