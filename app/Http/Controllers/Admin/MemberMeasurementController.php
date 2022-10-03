<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberMeasurementRequest;
use App\Models\Member;
use App\Models\MemberMeasurement;
use Illuminate\Http\Request;

class MemberMeasurementController extends Controller
{
    /**
     * Display a list of Measurements.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $memberMeasurements = [];
        $member = Member::with(['memberMeasurements' => function ($query) {
            $query->orderBy('measurement_date');
        }])->findOrFail($id);

        $measurementTypes = MemberMeasurement::getMeasurementTypes();

        foreach ($measurementTypes as $key => $value) {
            $memberMeasurements[$key] = $member->memberMeasurements->filter(function ($item) use ($key) {
                return $item->measurement_type == $key;
            })
            ->values();
        }

        return view(
            'admin.members.measurements',
            compact('measurementTypes', 'memberMeasurements', 'member')
        );
    }

    /**
     * Store the Member's Measurements.
     *
     * @param \App\Http\Requests\MemberMeasurementRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemberMeasurementRequest $request)
    {
        $validatedData = $request->validated();
        $memberMeasurement = MemberMeasurement::create($validatedData);

        $isLatestMeasurement = MemberMeasurement::where('member_id', $memberMeasurement->member_id)
            ->where('measurement_type', $memberMeasurement->measurement_type)
            ->where('measurement_date', '>', $memberMeasurement->measurement_date)
            ->get('measurement_value');

        return [
            'type' => 'success',
            'message' => __('Member Measurement Added successfully'),
            'data' => $memberMeasurement,
            'is_latest_measurement' => $isLatestMeasurement,
        ];
    }

    /**
     * Display The Member Specified measurement list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $input = $request->only('member_id', 'measurement_type');

        $memberMeasurement = Member::select('id')
            ->with(['memberMeasurements' => function ($query) use ($input) {
                $query->select('id', 'member_id', 'measurement_date', 'measurement_type', 'measurement_value')
                    ->where('measurement_type', $input['measurement_type'])
                ;
            }])
            ->find($input['member_id'])
        ;

        return [ 'data' => $memberMeasurement ];
    }

    /**
     * Update the Member's Measurements.
     *
     * @param \App\Http\Requests\MemberMeasurementRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MemberMeasurementRequest $request)
    {
        $isTypeChange = false;
        $oldTypeValue = 0;
        $input = $request->only(
            'id',
            'measurement_type',
            'measurement_date',
            'measurement_value'
        );

        $memberMeasurement = MemberMeasurement::findOrFail($input['id']);

        if ($memberMeasurement->measurement_type != $input['measurement_type']) {
            $isTypeChange = true;
            $oldTypeValue = $memberMeasurement->measurement_type;
        }

        $memberMeasurement->update($request->validated());

        $isLatestMeasurement = MemberMeasurement::where('member_id', $memberMeasurement->member_id)
            ->where('measurement_type', $memberMeasurement->measurement_type)
            ->where('measurement_date', '>', $memberMeasurement->measurement_date)
            ->doesntExist()
        ;

        return [
            'data' => $memberMeasurement,
            'message' => __('Measurement Updated Successfully'),
            'type' => 'success',
            'type_change' => $isTypeChange,
            'old_type_value' => $oldTypeValue,
            'is_latest_measurement' => $isLatestMeasurement,
        ];
    }

    /**
     * Deletes a member measurement.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $memberMeasurement = MemberMeasurement::findOrFail(request('id'));
        $data = $memberMeasurement;
        $memberMeasurementType = $memberMeasurement->measurement_type;
        $memberMeasurement->delete();

        return [
            'data' => $data,
            'measurement_type' => $memberMeasurementType,
            'type' => 'success',
            'message' => __('Member Measurement deleted successfully'),
        ];
    }
}
