<?php

namespace Sty\Hutton\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Str;
use Illuminate\Support\Str;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'uuid' => (string) Str::uuid(),
            'slug' => Str::slug($this->customer_name),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => [
                'required',
                'string',
                'max:255',
                'unique:customers,customer_name',
            ],
            'uuid' => [
                'required',
                'string',
                'max:255',
                'unique:customers,uuid',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:customers,slug',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:customers,email',
            ],
            'street_1' => ['required', 'string', 'max:255'],
            'street_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'telephone_number' => ['required', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'customer_type' => ['nullable', 'integer', 'max:255'],
            'contract_type' => ['nullable', 'integer', 'max:255'],
            'contract_expiry_date' => ['nullable', 'date'],
        ];
    }
}
