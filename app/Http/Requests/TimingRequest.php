<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimingRequest extends FormRequest
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
        return [
            "start_time" => "required|date_format:H:i:s",
            "end_time" => "required|after:start_time|date_format:H:i:s",
            "members" => "nullable|array",
            "members.*" => "required|integer",
            "trainers" => "nullable|array",
            "trainers.*" => "required|integer",
            "notes" => "nullable|string",
        ];
    }
}
