<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
