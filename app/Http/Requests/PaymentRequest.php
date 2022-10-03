<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PaymentRequest extends FormRequest
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
        $requiredMember = "required";

        if (Route::currentRouteName() === 'admin.payments.update') {
            $requiredMember = "sometimes";
        }

        return [
            "member_id" => $requiredMember."|integer|exists:members,id",
            "amount" => "required|numeric",
            "payment_date" => "required|date",
            "status" => "nullable|in:1,2,3,4",
            "new_validity_date" => "nullable|boolean"
        ];
    }
}
