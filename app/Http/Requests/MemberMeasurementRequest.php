<?php

namespace App\Http\Requests;

use App\Models\MemberMeasurement;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class MemberMeasurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request('id');
        if (! $id) {
            $id = 0;
        }
        $date = Carbon::now()->toDateString();
        $measurementTypeKeys = implode(',', array_keys(MemberMeasurement::getMeasurementTypes()));

        return [
            'member_id' => 'required|exists:members,id',
            'measurement_date' => [
                'required',
                'date',
                'before_or_equal:'.$date,
                function ($attribute, $value, $fail) use ($id) {
                    $measurement = MemberMeasurement::where('measurement_date', $value)
                        ->where('measurement_type', request('measurement_type'))
                        ->where('id', '!=', $id)
                        ->get();

                    if ($measurement->isNotEmpty()) {
                        $fail('The date already exists for this measurement type.');
                    }
                }
            ],
            'measurement_type' => 'required|in:'.$measurementTypeKeys,
            'measurement_value' => 'required|between:1,999999.99',
        ];
    }
}
