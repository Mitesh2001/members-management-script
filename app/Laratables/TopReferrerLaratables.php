<?php

namespace App\Laratables;

use Illuminate\Support\Facades\DB;

class TopReferrerLaratables
{
    /**
     * Additional columns to be loaded for datatables.
     *
     * @return array
     */
    public static function laratablesAdditionalColumns()
    {
        return ['referred_by', DB::raw("COUNT(referred_by) as count")];
    }

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
     * Returns the action column html for datatables.
     *
     * @param \App\Member $member
     * @return int
     */
    public static function laratablesCustomCount($member)
    {
        return $member->referents_count;
    }

    /**
     * Adds the condition for searching the name of the user in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchFirstName($query, $searchValue)
    {
        return $query->orWhere('first_name', 'like', '%'. $searchValue. '%')
            ->orWhere('last_name', 'like', '%'. $searchValue. '%')
        ;
    }

    /**
     * Fetch only active users in the datatables.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesQueryConditions($query)
    {
        return $query->withCount('referents')
        ;
    }
}
