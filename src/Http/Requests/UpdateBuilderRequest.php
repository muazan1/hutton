<?php

namespace Sty\Hutton\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBuilderRequest extends FormRequest
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
            'slug' => Str::slug($this->builder_name),
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
            'builder_name' => [
                'required',
                'string',
                'max:255',
                'unique:builders,builder_name',
            ],
            // 'uuid' => ['required', 'string', 'max:255', 'unique:builders,uuid'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('builders')->ignore($this->builder),
            ],
            'email' => [
                // 'required',
                // 'string',
                // 'email',
                // 'max:255',
                // 'unique:builders,email',
                'required|email|unique:builders,email,' . $this->request()->route,
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
