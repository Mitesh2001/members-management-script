<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Laratables\TopReferrerLaratables;
use App\Models\Member;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\DB;

class ReferrerController extends Controller
{
    /**
     * Display the Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referrers = Member::query()
            ->select(
                'id'
            )
            ->withCount('referents')
            ->whereNotNull('referred_by')
            ->orderBy('referents_count', 'desc')
            ->get()
        ;
        return view('admin.referrers.index', compact('referrers'));
    }

    /**
     * Returns the top referrers list datatables.
     *
     * @return \Illuminate\Http\JsonResponse
     **/
    public function datatables()
    {
        return Laratables::recordsOf(Member::class, TopReferrerLaratables::class);
    }
}
