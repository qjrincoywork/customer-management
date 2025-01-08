<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
            'id' => [
                'required',
                'integer',
                Rule::exists(Customer::class, 'id')->whereNull('deleted_at')
            ],
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255'
            ],
            'contact_number' => [
                'required',
                'string',
                'max:100'
            ],
            'email' => [
                'required',
                'string',
                Rule::unique(Customer::class, 'email')->ignore($this['id']),
                'max:100'
            ],
        ];
    }
}
