<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:admins,phone',
            'phone_code' => 'nullable|string',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
