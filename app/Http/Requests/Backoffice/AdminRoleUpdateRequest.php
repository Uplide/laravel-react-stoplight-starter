<?php


namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\RoleTypes;

class AdminRoleUpdateRequest extends FormRequest
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
            'roles' => 'nullable|array',
            'roles.*' => [
                'string',
                Rule::in(array_column(RoleTypes::cases(), "value")),
            ],
        ];
    }
}
