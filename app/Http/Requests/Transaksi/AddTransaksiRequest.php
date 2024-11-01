<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item' => ['required', 'array'],
            'item.*.produk_id' => [
                'required',
                Rule::exists('produk', 'id')
            ],
            'item.*.qty' => [
                'required',
                'integer',
                'min:1'
            ],
            'item.*.status' => [
                'nullable',
                'in:lunas'
            ]
        ];
    }
}
