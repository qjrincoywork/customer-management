<?php

namespace App\Http\Requests;

use App\Enums\SortOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerListRequest extends FormRequest
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
            'first_name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'contact_number' => [
                'nullable',
                'string',
                'max:100'
            ],
            'sort_order' => [
                'nullable',
                'string',
                Rule::in(SortOrder::getValues())
            ],
            'per_page' => [
                'nullable',
                'integer'
            ],
        ];
    }
}
