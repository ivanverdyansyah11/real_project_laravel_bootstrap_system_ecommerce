<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email:dns|unique:users,email|string',
            'photo_ktp' => 'required|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'password' => 'required|string|min:3',
            'confirmation_password' => 'required|string|min:3',
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'number_phone' => 'required|string|max:15',
        ];
    }
}
