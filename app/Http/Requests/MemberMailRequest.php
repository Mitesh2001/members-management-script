<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberMailRequest extends FormRequest
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
            "member" => "required_if:member_type,selected",
            "subject" => "required|string",
            "content" => "required|string",
            "member_type" => "required|string|in:selected,all",
        ];
    }
}
