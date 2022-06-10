<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'total_free_blocks' => 'required|int',
            'need_total_blocks' => 'required|int',
            'freezing_rooms'    => 'required|array',
            'storage_period'    => 'required|int|between:1,24',
            'cost'              => 'required|int',
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
            'storage_period.between' => 'Available storage period from 1 day to 24 days.',
        ];
    }
}
