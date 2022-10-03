<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class TrainerRequest extends FormRequest
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
        $uniqueEmail = Rule::unique('trainers');
        $identityProofValidation = 'required|array';

        if (Route::currentRouteName() === 'admin.trainers.update') {
            $uniqueEmail->ignore(Route::current()->originalParameter('trainer'));
            $identityProofValidation ='array';
        }

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|integer|in:1,2',
            'mobile_no' => "required|string|max:255",
            'phone' => "nullable|string|max:255",
            'email' =>  'required|email|'.$uniqueEmail,
            'address' => 'nullable|string|max:255',
            'avatar' => 'file|mimes:jpeg,jpg,png,gif|max:10000',
            'identity_proofs' => $identityProofValidation,
            'identity_proofs.*' => 'file|mimes:jpeg,jpg,png,gif,pdf,doc,docx|max:10000',
        ];
    }
}
