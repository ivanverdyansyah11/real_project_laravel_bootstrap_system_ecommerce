<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'categories_id' => 'required|integer',
            'image' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'unit' => 'required|string',
            'stock' => 'required|integer',
            'purchase_price' => 'required|string',
            'selling_price' => 'required|string',
        ];
    }
}
