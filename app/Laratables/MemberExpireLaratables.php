<?php

namespace App\Laratables;

class MemberExpireLaratables
{
    /**
     * Returns full name for the datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesFirstName($member)
    {
        $name = $member->getName();
        $id = $member->id;

        return view('admin.members.name', compact('name', 'id'))->render();
    }

    /**
     * Returns the action column html for datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesCustomAvatar($member)
    {
        $avatar = getAvatarUrl($member, 'members', 'thumb');

        return view('admin.members.avatar', compact('avatar'))->render();
    }

    /**
     * Returns the status column text for datatables.
     *
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public static function laratablesStatus($member)
    {
        $status =  strtotime($member->validity_date) <= strtotime('today') ? "danger" : "warning";

        return view('admin.dashboard.dashboard_member_expire_status', compact('status', 'member'))->render();
    }
}
