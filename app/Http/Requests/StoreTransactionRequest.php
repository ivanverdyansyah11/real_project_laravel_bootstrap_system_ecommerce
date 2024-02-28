<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'products_id' => 'required|integer',
            'customers_id' => 'required|integer',
            'resellers_id' => 'nullable|integer',
            'proof_of_payment' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'quantity' => 'required|integer',
            'total' => 'required|integer',
            'total_payment' => 'required|integer',
            'status' => 'nullable|integer',
        ];
    }
}
