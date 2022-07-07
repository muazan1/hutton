<?php

namespace Sty\Hutton\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Str;

class CreateSiteRequest extends FormRequest
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
            'slug' => Str::slug($this->site_name),
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
            'uuid' => ['required'],
            'customer_id' => ['required'],
            'site_name' => ['required'],
            'slug' => ['required'],
            'street_1' => ['required'],
            'street_2' => ['nullable'],
            'city' => ['required'],
            'postcode' => ['required'],
            'county' => ['required'],
            'telephone' => ['required'],
        ];
    }
}
