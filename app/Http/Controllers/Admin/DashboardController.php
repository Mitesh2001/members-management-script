<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Laratables\MemberExpireLaratables;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Timing;
use App\Models\Trainer;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a chart report, Expire soon and Expired member.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentMonthMembersCount = Member::where('created_at', '>', (new Carbon)->subMonth())->count();

        $trainersCount = Trainer::count();

        $currentMonthPayments = Payment::where('created_at', '>', (new Carbon)->subMonth())->sum('amount');

        $membersPercentage = $this->getMembersPercentage($currentMonthMembersCount);

        $paymentsPercentage = $this->getPaymentsPercentage($currentMonthPayments);

        $membershipPlanMembers = MembershipPlan::select('id', 'name')
            ->withCount('members')
            ->groupBy('id')
            ->get()
        ;

        $timingMembers = Timing::select('id', DB::raw("CONCAT(start_time,' - ',end_time) AS full_time"))
            ->withCount('members')
            ->groupBy('id')
            ->get()
        ;

        $timingTrainers = Timing::select('id', DB::raw("CONCAT(start_time,' - ',end_time) AS full_time"))
            ->withCount('trainers')
            ->groupBy('id')
            ->get()
        ;

        $activeMembers = Member::select('id', 'first_name', 'last_name', 'validity_date')
            ->whereDate('validity_date', '>', (new Carbon))
            ->orderBy('validity_date')
            ->get()->count()
        ;

        $newPaymentSuccesses = Payment::select('id', 'member_id', 'payment_date', 'amount')
            ->with(['member' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where('status', 3)
            ->orderBy('updated_at', 'DESC')
            ->take(5)
            ->get()
        ;

        return view('admin.dashboard.index', compact(
            'currentMonthMembersCount',
            'trainersCount',
            'currentMonthPayments',
            'membersPercentage',
            'paymentsPercentage',
            'membershipPlanMembers',
            'timingMembers',
            'timingTrainers',
            'activeMembers',
            'newPaymentSuccesses'
        ));
    }

    /**
     * Calculates and returns the monthly difference of members count.
     *
     * @param int $currentMonthMembersCount
     * @return int
     **/
    private function getMembersPercentage($currentMonthMembersCount)
    {
        $previousMonthMembersCount = Member::query()
            ->whereBetween('created_at', [(new Carbon)->subMonths(2), (new Carbon)->subMonth()])
            ->count()
        ;

        if ($currentMonthMembersCount > 0 && $previousMonthMembersCount > 0) {
            return $this->getPercentageChange($previousMonthMembersCount, $currentMonthMembersCount);
        }

        return 0;
    }

    /**
     * Calculates and returns the monthly difference of payments total.
     *
     * @param int $currentMonthPayments
     * @return int
     **/
    private function getPaymentsPercentage($currentMonthPayments)
    {
        $previousMonthPayments = Payment::query()
            ->whereBetween('created_at', [(new Carbon)->subMonths(2), (new Carbon)->subMonth()])
            ->sum('amount')
        ;

        if ($currentMonthPayments > 0 && $previousMonthPayments > 0) {
            return $this->getPercentageChange($previousMonthPayments, $currentMonthPayments);
        }

        return 0;
    }

    /**
     * Returns the percentage change between two numbers.
     *
     * @param int $newNumber
     * @param int $oldNumber
     * @return int
     **/
    private function getPercentageChange($oldNumber, $newNumber)
    {
        $increase = $newNumber - $oldNumber;

        return round(($increase / $oldNumber) * 100);
    }

    /**
     * Returns the membership expire members Laratables.
     *
     * @return \Illuminate\Http\JsonResponse
     **/
    public function getExpireMembershipMember()
    {
        return Laratables::recordsOf(Member::class, MemberExpireLaratables::class);
    }
}
