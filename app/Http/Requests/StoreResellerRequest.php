<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResellerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'number_phone' => 'required|string|max:15',
            'photo_ktp' => 'required|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'email' => 'required|email:dns|unique:users,email|string',
            'password' => 'required|string|min:3',
            'image' => 'required|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'status' => 'required|integer',
            'role' => 'required|string',
        ];
    }
}
