<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'password' => 'nullable|string|min:3',
            'confirmation_password' => 'nullable|string|min:3',
            'image' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'name' => 'required|string|max:255',
            'photo_ktp' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'number_phone' => 'required|string|max:15',
            'origin' => 'required|string|max:50',
            'place_of_birth' => 'required|string|max:50',
            'date_of_birth' => 'required|string',
            'gender' => 'required|string|max:10',
            'address' => 'required|string',
        ];
    }
}
