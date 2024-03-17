<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'email' => 'required|email:dns|string',
            'image' => 'required|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'name' => 'required|string|max:255',
            'number_phone' => 'required|string|max:15',
            'photo_ktp' => 'required|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'origin' => 'required|string|max:50',
            'place_of_birth' => 'required|string|max:50',
            'date_of_birth' => 'required|string',
            'gender' => 'required|string|max:10',
            'address' => 'required|string',
        ];
    }
}
