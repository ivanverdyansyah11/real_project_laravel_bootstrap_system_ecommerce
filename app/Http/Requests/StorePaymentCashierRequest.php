<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentCashierRequest extends FormRequest
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
            'products_id' => 'nullable|integer',
            'payments_id' => 'required|integer',
            'proof_of_payment' => 'required|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'invois' => 'nullable',
            'quantity' => 'nullable|integer',
            'shipping' => 'required|string',
            'shipping_price' => 'nullable|integer',
            'shipping_address' => 'nullable|string',
            'price_per_product' => 'nullable|integer',
            'total_per_product' => 'nullable|integer',
            'total' => 'required|integer',
            'total_payment' => 'required|integer',
            'status' => 'required|integer',
        ];
    }
}
