<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerRequest;
use App\Models\Trainer;
use Freshbitsweb\Laratables\Laratables;

class TrainerController extends Controller
{
    /**
     * Display the Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.trainers.index');
    }

    /**
    * Return the trainers datatables.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function datatables()
    {
        return Laratables::recordsOf(Trainer::class);
    }

    /**
     * Show the form for create the New Trainer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainer = optional();

        return view('admin.trainers.add', compact('trainer'));
    }

    /**
     * Store the New Trainer.
     *
     * @param \App\Http\Requests\TrainerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TrainerRequest $request)
    {
        $validatedData = $request->validated();

        $trainer = Trainer::create($validatedData);

        if (isset($validatedData['avatar'])) {
            $trainer->addMediaFromRequest('avatar')->toMediaCollection('trainers');
        }

        if (isset($validatedData['identity_proofs'])) {
            foreach ($validatedData['identity_proofs'] as $idProof) {
                $trainer->addMedia($idProof)
                    ->toMediaCollection('identity_proofs')
                ;
            }
        }

        return redirect()->route('admin.trainers.index')
            ->with(['type' => 'success', 'message' => __('Trainer Added successfully')])
        ;
    }

    /**
     * Show the form for edit the particular Trainer.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);

        return view('admin.trainers.edit', compact('trainer'));
    }

    /**
      * Update the particular Trainer.
      *
      * @param \App\Http\Requests\TrainerRequest $request
      * @param \App\Trainer $trainer
      * @return \Illuminate\Http\RedirectResponse
      */
    public function update(TrainerRequest $request, Trainer $trainer)
    {
        $validatedData = $request->validated();

        $trainer->update($validatedData);

        if (isset($validatedData['avatar'])) {
            $trainer->addMediaFromRequest('avatar')->toMediaCollection('trainers');
        }

        if (isset($validatedData['identity_proofs'])) {
            foreach ($validatedData['identity_proofs'] as $idProof) {
                $trainer->addMedia($idProof)
                    ->toMediaCollection('identity_proofs')
                ;
            }
        }

        return redirect()->route('admin.trainers.index')
            ->with(['type' => 'success', 'message' => __('Trainer Updated successfully')])
        ;
    }


    /**
     * Remove the Trainer's Identification Proof.
     *
     * @param int $trainerId
     * @param int $mediaId
     * @return void
     **/
    public function removeMedia($trainerId, $mediaId)
    {
        $trainer = Trainer::with('media')
            ->findOrFail($trainerId)
        ;

        $trainer->media->firstWhere('id', $mediaId)
            ->delete()
        ;
    }

    /**
     * Remove the Trainer.
     *
     * @param \App\Trainer $trainer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Trainer $trainer)
    {
        $trainer->timings()->detach();
        $trainer->delete();

        return redirect()->route('admin.trainers.index')
            ->with(['type' => 'success', 'message' => __('Trainer deleted successfully')])
        ;
    }

    /**
     * Display the Timings of the Trainer.
     *
     * @param int $trainerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function timings($trainerId)
    {
        $trainerTimings = Trainer::select('id', 'first_name', 'last_name')
            ->with(['timings:id,start_time,end_time'])
            ->findOrFail($trainerId)
        ;

        return [
            'data' => $trainerTimings,
        ];
    }
}
