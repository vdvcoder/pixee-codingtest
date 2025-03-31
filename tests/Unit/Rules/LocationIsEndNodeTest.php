<?php

namespace Tests\Unit\Rules;

use App\Models\Location;
use App\Rules\LocationIsEndNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('passes when no location ID is provided', function () {
    $rule = new LocationIsEndNode;

    $data = [
        'location_id' => null,
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        'location_id' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('passes when a valid end node location ID is provided', function () {
    // Create an end node location (no children)
    $endNodeLocation = Location::factory()->create(['is_base_location' => false]);

    $rule = new LocationIsEndNode;

    $data = [
        'location_id' => $endNodeLocation->id,
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        'location_id' => [$rule],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('fails when a base location ID is provided', function () {
    // Create a base location (can have children)
    $baseLocation = Location::factory()->create(['is_base_location' => true]);

    $rule = new LocationIsEndNode;

    $data = [
        'location_id' => $baseLocation->id,
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        'location_id' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('location_id'))->toBe(__('A device can only be linked to an end node! Not a base location.'));
});

it('fails when a non-end node location ID is provided', function () {
    // Create a parent location
    $parentLocation = Location::factory()->create(['is_base_location' => false]);
    // Create a child location
    Location::factory()->create(['parent_id' => $parentLocation->id, 'is_base_location' => false]);

    $rule = new LocationIsEndNode;

    $data = [
        'location_id' => $parentLocation->id,
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        'location_id' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('location_id'))->toBe(__('A device can only be linked to an end node! Not a base location.'));
});

it('fails when an invalid location ID is provided', function () {
    $rule = new LocationIsEndNode;

    $data = [
        'location_id' => 999, // Non-existent ID
    ];

    // We need to add the data to the request
    request()->merge($data);

    $validator = Validator::make($data, [
        'location_id' => [$rule],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('location_id'))->toBe(__('A device can only be linked to an end node! Not a base location.'));
});
