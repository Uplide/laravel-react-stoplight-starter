<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
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
        $adminId = $this->route('id'); // Assuming the route parameter is named 'admin'
        return [
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('admins')->ignore($adminId),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('admins')->ignore($adminId),
            ],
            'phone_code' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
