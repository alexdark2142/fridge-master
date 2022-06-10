<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
{
    /** @var null  */
    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'goods_volume'   => 'required|int',
            'temperature'    => 'required|int|between:-32,0',
            'storage_period' => 'required|int|between:1,24',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'goods_volume'   => 'volume of goods',
            'storage_period' => 'storage period',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'temperature.between'    => 'Available storage temperature from -32℃ to 0℃.',
            'storage_period.between' => 'Available storage period from 1 day to 24 days.',
        ];
    }
}
