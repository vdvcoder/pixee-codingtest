<?php

namespace App\Http\Requests;

use App\Rules\LocationIsEndNode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add your authorization logic here, if needed.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_id' => [
                'required',
                'exists:locations,id', new LocationIsEndNode,
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'device_type' => [
                'required',
                'string',
                'max:255',
            ],
            'mac_address' => [
                'required',
                'unique:devices,mac_address',
                'mac_address',
            ],
            'ip_address' => [
                'nullable',
                'ip',
                Rule::unique('devices', 'ip_address')->where(function ($query) {
                    return $query->whereIn('location_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('locations')
                            ->where('parent_id', $this->input('location_id'))
                            ->orWhere('id', $this->input('location_id'));
                    });
                })->ignore($this->route('device')),
            ],
            'width' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'height' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'rotation' => [
                'nullable',
                'in:Landscape,Portrait',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mac_address' => strtoupper($this->mac_address),
        ]);
    }
}
