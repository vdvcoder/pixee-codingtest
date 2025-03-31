<?php

namespace App\Rules;

use App\Models\Location;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LocationIsEndNode implements ValidationRule
{
    /**
     * Run the validation rule.
     * Check that the selected location is an end node (it cannot have child locations).
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;  // No location ID means no validation needed.
        }

        $location = Location::find($value);

        if (! $location) {
            $fail(__('A device can only be linked to an end node! Not a base location.'));

            return;
        }

        if ($location->is_base_location) {
            $fail(__('A device can only be linked to an end node! Not a base location.'));

            return;
        }

        if (! $location->isEndNode()) {
            $fail(__('A device can only be linked to an end node! Not a base location.'));

            return;
        }
    }
}
