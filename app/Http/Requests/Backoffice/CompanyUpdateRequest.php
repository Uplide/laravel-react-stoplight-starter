<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $companyId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'email' => 'required|email|unique:companies,email,' . $companyId,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
