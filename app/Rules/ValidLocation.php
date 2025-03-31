<?php

namespace App\Rules;

use App\Models\Device;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidLocation implements ValidationRule
{
    public function __construct(?int $currentLocationId = null)
    {
        $this->currentLocationId = $currentLocationId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $isBaseLocation = request()->input('is_base_location', false);
        $deviceIds = request()->input('device_id', []);
        $parentId = request()->input('parent_id');

        // 1. A location must have a parent or be a base location.
        if (empty($parentId) && ! $isBaseLocation) {
            $fail(__('A location must have a parent location or be a base location!'));
        }

        // 2. A base location cannot have a device.
        if (! empty($deviceIds) && $isBaseLocation) {
            $fail(__('A base location cannot have a device.'));
        }

        // 3. A base location cannot have a parent.
        if (! empty($parentId) && $isBaseLocation) {
            $fail(__('A base location cannot have a parent.'));
        }

        // 4. A device cannot be assigned to multiple locations.
        if (! empty($deviceIds)) {
            $existingDevices = Device::whereIn('id', $deviceIds)->get();

            foreach ($existingDevices as $existingDevice) {
                if (
                    $existingDevice->location_id &&
                    $existingDevice->location_id !== $this->currentLocationId) {
                    $fail(__('The device :device is already assigned to another location.', [
                        'device' => $existingDevice->id,
                    ]));
                }
            }
        }
    }
}
