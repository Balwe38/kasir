<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_cust' => [
                'required',
                'string',
                'max:255',
            ],

            'payment_method' => [
                'required',
                'in:Cash,QRIS,Debit,E-Wallet',
            ],

            'bayar' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name_cust.required' =>
                'Nama customer wajib diisi.',

            'payment_method.required' =>
                'Metode pembayaran wajib dipilih.',

            'payment_method.in' =>
                'Metode pembayaran tidak valid.',

            'bayar.required' =>
                'Jumlah pembayaran wajib diisi.',

            'bayar.numeric' =>
                'Jumlah pembayaran harus berupa angka.',
        ];
    }
}