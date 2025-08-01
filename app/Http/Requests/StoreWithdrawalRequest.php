<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:50000',
            'bank' => 'required|in:BCA,MANDIRI,BRI',
            'number' => 'required|string|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => __('request_withdraw.validation.amount.required'),
            'amount.numeric' => __('request_withdraw.validation.amount.numeric'),
            'amount.min' => __('request_withdraw.validation.amount.min'),

            'bank.required' => __('request_withdraw.validation.bank.required'),
            'bank.in' => __('request_withdraw.validation.bank.in'),

            'number.required' => __('request_withdraw.validation.number.required'),
            'number.string' => __('request_withdraw.validation.number.string'),
            'number.max' => __('request_withdraw.validation.number.max'),
        ];
    }
}
