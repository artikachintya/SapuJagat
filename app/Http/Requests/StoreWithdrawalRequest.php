<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or add role checks here
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
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'amount.numeric'  => 'Nominal harus berupa angka.',
            'amount.min'      => 'Nominal minimal penarikan adalah Rp50.000.',

            'bank.required'   => 'Nama bank wajib diisi.',
            'bank.in' => 'Bank harus salah satu dari: BCA, MANDIRI, atau BRI.',

            'number.required' => 'Nomor rekening wajib diisi.',
            'number.string'   => 'Nomor rekening harus berupa teks.',
            'number.max'      => 'Nomor rekening maksimal 30 karakter.',
        ];
    }
}