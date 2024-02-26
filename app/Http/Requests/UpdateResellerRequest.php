<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResellerRequest extends FormRequest
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
            'image' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
            'name' => 'required|string|max:255',
            'number_phone' => 'required|string|max:15',
            'photo_ktp' => 'nullable|file|image|mimes:png,jpg,jpeg,gif,webp,svg|max:2048',
        ];
    }
}
