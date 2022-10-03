<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimingRequest;
use App\Models\Member;
use App\Models\Timing;
use App\Models\Trainer;
use Freshbitsweb\Laratables\Laratables;

class TimingController extends Controller
{
    /**
     * Display the Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.timings.index');
    }

    /**
    * Return the timings datatables.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function datatables()
    {
        return Laratables::recordsOf(Timing::class);
    }

    /**
     * Show the form for create a New Timing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $timing = optional();
        $timingOptions = Timing::getTimingOptions();
        $trainers = Trainer::select('id', 'first_name', 'last_name')->get();
        $members = Member::select('id', 'first_name', 'last_name')->get();

        return view(
            'admin.timings.add',
            compact('timingOptions', 'timing', 'trainers', 'members')
        );
    }

    /**
     * Store a New Timing.
     *
     * @param \App\Http\Requests\TimingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TimingRequest $request)
    {
        $validatedData = $request->validated();

        $timing = Timing::create($validatedData);

        if (isset($validatedData['members'])) {
            $timing->members()->attach($validatedData['members']);
        }

        if (isset($validatedData['trainers'])) {
            $timing->trainers()->attach($validatedData['trainers']);
        }

        return redirect()->route('admin.timings.index')
            ->with(
                ['type' => 'success', 'message' => __('Timing added successfully')]
            );
    }

    /**
     * Show the form for edit the particular Timing.
     *
     * @param \App\Timing $timing
     * @return \Illuminate\Http\Response
     */
    public function edit(Timing $timing)
    {
        $timingOptions = Timing::getTimingOptions();
        $trainers = Trainer::select('id', 'first_name', 'last_name')->get();
        $members = Member::select('id', 'first_name', 'last_name')->get();

        return view(
            'admin.timings.edit',
            compact('timing', 'timingOptions', 'trainers', 'members')
        );
    }

    /**
     * Update the particular Timing.
     *
     * @param \App\Http\Requests\TimingRequest $timing
     * @param \App\Timing $timing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TimingRequest $request, Timing $timing)
    {
        $validatedData = $request->validated();

        $timing->update($validatedData);

        if (isset($validatedData['members'])) {
            $timing->members()->sync($validatedData['members']);
        } else {
            $timing->members()->detach();
        }

        if (isset($validatedData['trainers'])) {
            $timing->trainers()->sync($validatedData['trainers']);
        } else {
            $timing->trainers()->detach();
        }

        return redirect()->route('admin.timings.index')
            ->with(['type' => 'success', 'message' => __('Timing updated successfully')])
        ;
    }

    /**
      * Delete the Timing.
      *
      * @param \App\Timing $timing
      * @return \Illuminate\Http\RedirectResponse
      */
    public function destroy(Timing $timing)
    {
        $timing->members()->detach();
        $timing->trainers()->detach();
        $timing->delete();

        return redirect()->route('admin.timings.index')
            ->with(['type' => 'success', 'message' => __('Timing deleted successfully')])
        ;
    }
}
