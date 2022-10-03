<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
        $date = Carbon::now()->toDateString();
        $uniqueEmail = Rule::unique('members');
        $referredByValidation = 'nullable|exists:members,id';
        $identityProofValidation = 'required|array';

        if (Route::currentRouteName() === 'admin.members.update') {
            $uniqueEmail->ignore(Route::current()->originalParameter('member'));
            $referredByValidation .= '|not_in:'.Route::current()->parameter('member')->id;
            $identityProofValidation = 'array';
        }

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date|before_or_equal:'.$date,
            'email' => 'required|email|'.$uniqueEmail,
            'stripe_id' => "nullable|string|max:255",
            'phone' => "required|string|max:255",
            'emergency_number' => "required|string|max:255|different:phone",
            'address' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'gender' => 'required|in:1,2',
            'notes' => 'nullable|string',
            'member_since' => 'required|date|after:date_of_birth',
            'avatar' => 'file|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_proofs' => $identityProofValidation,
            'identity_proofs.*' => 'file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10000',
            'referred_by'=> $referredByValidation,
            'validity_date' => 'required|date|after:member_since',
            'height' => 'nullable|integer',
            'membership_plan_id' => 'nullable|integer|exists:membership_plans,id',
            "timings" => "nullable|array",
            "timings.*" => "required|integer",
        ];
    }
}
