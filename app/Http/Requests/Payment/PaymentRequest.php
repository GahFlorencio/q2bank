<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payer'=> 'required|integer|exists:users,id',
            'receiver' => 'required|integer|exists:users,id',
            'value' => 'required|integer'
        ];
    }
}
