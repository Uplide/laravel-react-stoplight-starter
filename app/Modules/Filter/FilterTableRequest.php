<?php

namespace App\Modules\Filter;

use Illuminate\Foundation\Http\FormRequest;

class FilterTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Yetkilendirme gerekliyse bu değeri değiştirin
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'skip' => 'sometimes|string',
            'take' => 'sometimes|string',
            'sort' => 'sometimes|string',
            'status' => 'sometimes|string',
            'group' => 'sometimes|string',
            'filter' => 'sometimes|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'skip.string' => 'Skip değeri bir string olmalıdır.',
            'take.string' => 'Take değeri bir string olmalıdır.',
            'sort.string' => 'Sort değeri bir string olmalıdır.',
            'status.string' => 'Status değeri bir string olmalıdır.',
            'group.string' => 'Group değeri bir string olmalıdır.',
            'filter.string' => 'Filter değeri bir string olmalıdır.',
        ];
    }
}
