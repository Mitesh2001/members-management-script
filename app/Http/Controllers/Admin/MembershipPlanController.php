<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipPlanRequest;
use App\Models\Member;
use App\Models\MembershipPlan;

class MembershipPlanController extends Controller
{
    /**
     * Display a Membership Plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membershipPlans = MembershipPlan::select('id', 'name', 'price', 'plan')
            ->with(['members' => function ($query) {
                $query->select('id', 'membership_plan_id');
            }
            ])
            ->get()
        ;

        $planOptions = MembershipPlan::getPlanOptions();

        return view('admin.membership_plans.index', compact('membershipPlans', 'planOptions'));
    }

    /**
     * Show the form for create a Membership Plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $membershipPlan = optional();

        $planOptions = MembershipPlan::getPlanOptions();

        return view('admin.membership_plans.add', compact('planOptions', 'membershipPlan'));
    }

    /**
     * Store the New Membership Plan.
     *
     * @param \App\Http\Requests\MembershipPlanRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MembershipPlanRequest $request)
    {
        MembershipPlan::create($request->validated());

        return redirect()->route('admin.membership-plans.index')
            ->with(['type' => 'success', 'message' => __('Membership Plan added successfully')])
        ;
    }

    /**
     * Show the form for edit the Membership Plan.
     *
     * @param \App\MembershipPlan $membershipPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(MembershipPlan $membershipPlan)
    {
        $planOptions = MembershipPlan::getPlanOptions();

        return view(
            'admin.membership_plans.edit',
            compact('planOptions', 'membershipPlan')
        );
    }

    /**
     * Update the Membership Plan.
     *
     * @param \App\Http\Requests\MembershipPlanRequest $request
     * @param \App\MembershipPlan $membershipPlan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MembershipPlanRequest $request, MembershipPlan $membershipPlan)
    {
        $membershipPlan->update($request->validated());

        return redirect()->route('admin.membership-plans.index')
            ->with(['type' => 'success', 'message' => __('Membership Plan updated successfully')])
        ;
    }

    /**
     * Remove the particular Membership Plan.
     *
     * @param \App\MembershipPlan $membershipPlan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        $hasMember = Member::where('membership_plan_id', $membershipPlan->id)->exists();

        if ($hasMember) {
            return redirect()->route('admin.membership-plans.index')
                ->with(['type' => 'warning', 'message' => __('This Membership Plan has assigned members !')])
            ;
        }

        $membershipPlan->delete();

        return redirect()->route('admin.membership-plans.index')
            ->with(['type' => 'success', 'message' => __('Membership Plan deleted successfully')])
        ;
    }

    /**
     * Members Monthly count.
     *
     * @param int $planeId
     * @return int
     */
    public function monthCount($planId)
    {
        switch ($planId) {
            case 1:
                return 1;
                break;
            case 2:
                return 3;
                break;
            case 3:
                return 6;
                break;
            case 4:
                return 12;
                break;
        }
    }
}
