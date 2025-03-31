<?php

namespace App\Http\Requests;

use App\Rules\ValidLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add your authorization logic here, if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('locations', 'name')->where(function ($query) {
                    return $query->where('parent_id', $this->parent_id)
                        ->orWhereNull('parent_id');
                }),
            ],
            'parent_id' => [
                'nullable',
                'exists:locations,id',
            ],
            'is_base_location' => [
                'boolean',
            ],
            'device_id' => [
                'nullable',
                'array',

            ],
            'device_id.*' => [
                'exists:devices,id',
            ],
            '*' => new ValidLocation,

        ];
    }
}
