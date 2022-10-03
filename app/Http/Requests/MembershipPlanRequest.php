<?php

namespace App\Http\Requests;

use App\Models\MembershipPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MembershipPlanRequest extends FormRequest
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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $planOptionKeys = implode(',', array_keys(MembershipPlan::getPlanOptions()));

        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'plan' => 'required|numeric|in:'.$planOptionKeys,
        ];
    }
}
