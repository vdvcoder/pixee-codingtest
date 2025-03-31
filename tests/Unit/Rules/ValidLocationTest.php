<?php

use App\Models\Device;
use App\Models\Location;
use App\Rules\ValidLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('fails when a location has no parent and is not a base location', function () {
    $rule = new ValidLocation(null);

    $data = [
        'is_base_location' => false,
        'parent_id' => null,
        'device_id' => [],
    ];

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first())->toBe(__('A location must have a parent location or be a base location!'));
});

it('fails when a base location has devices', function () {
    // Create a base location
    $location = Location::factory()->create(['is_base_location' => true, 'parent_id' => null]);
    // Create devices
    $device1 = Device::factory()->create(['location_id' => null]);
    $device2 = Device::factory()->create(['location_id' => null]);

    $rule = new ValidLocation(null);

    $data = [
        'is_base_location' => true,
        'parent_id' => null,
        'device_id' => [$device1->id, $device2->id],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first())->toBe(__('A base location cannot have a device.'));
});

it('fails when a base location has a parent', function () {
    // Create a parent location
    $parentLocation = Location::factory()->create();

    $rule = new ValidLocation(null);

    $data = [
        'is_base_location' => true,
        'parent_id' => $parentLocation->id,
        'device_id' => [],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first())->toBe(__('A base location cannot have a parent.'));
});

it('fails when a device is already assigned to another location', function () {
    // Create a location
    $otherLocation = Location::factory()->create();
    // Create a device assigned to another location
    $device = Device::factory()->create(['location_id' => $otherLocation->id]);

    $rule = new ValidLocation(1);

    $data = [
        'is_base_location' => false,
        'parent_id' => 1,
        'device_id' => [$device->id],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first())->toBe(__("The device {$device->id} is already assigned to another location."));
});

it('passes when a base location has no parent and no devices', function () {
    $rule = new ValidLocation(null);

    $data = [
        'is_base_location' => true,
        'parent_id' => null,
        'device_id' => [],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when a non-base location has a parent and no devices', function () {
    // Create a parent location
    $parentLocation = Location::factory()->create();

    $rule = new ValidLocation(null);

    $data = [
        'is_base_location' => false,
        'parent_id' => $parentLocation->id,
        'device_id' => [],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when a device is already assigned to the current location', function () {
    // Create a location
    $location = Location::factory()->create();
    // Create a device assigned to the current location
    $device = Device::factory()->create(['location_id' => $location->id]);

    $rule = new ValidLocation($location->id);

    $data = [
        'is_base_location' => false,
        'parent_id' => $location->id,
        'device_id' => [$device->id],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when a device is not assigned to any location', function () {
    // Create a device not assigned to any location
    $device = Device::factory()->create(['location_id' => null]);
    // Create a location
    $location = Location::factory()->create();

    $rule = new ValidLocation($location->id);

    $data = [
        'is_base_location' => false,
        'parent_id' => $location->id,
        'device_id' => [$device->id],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when there are no devices', function () {
    // Create a location
    $location = Location::factory()->create();
    $rule = new ValidLocation($location->id);

    $data = [
        'is_base_location' => false,
        'parent_id' => $location->id,
        'device_id' => [],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when a non-base location has a parent and devices', function () {
    // Create a device not assigned to any location
    $device = Device::factory()->create(['location_id' => null]);
    // Create a location
    $location = Location::factory()->create();
    $rule = new ValidLocation($location->id);

    $data = [
        'is_base_location' => false,
        'parent_id' => $location->id,
        'device_id' => [$device->id],
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        '*' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});
