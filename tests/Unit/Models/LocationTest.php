<?php

use App\Models\Device;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class); // Voeg deze regel toe om de database te verversen

it('has a parent location', function () {
    // Arrange
    $parentLocation = Location::factory()->create();
    $childLocation = Location::factory()->create([
        'parent_id' => $parentLocation->id,
    ]);

    // Act
    $retrievedParentLocation = $childLocation->parent;

    // Assert
    expect($retrievedParentLocation)->toBeInstanceOf(Location::class);
    expect($retrievedParentLocation->id)->toBe($parentLocation->id);
});

it('can have multiple child locations', function () {
    // Arrange
    $parentLocation = Location::factory()->create();
    $childLocation1 = Location::factory()->create([
        'parent_id' => $parentLocation->id,
    ]);
    $childLocation2 = Location::factory()->create([
        'parent_id' => $parentLocation->id,
    ]);

    // Act
    $retrievedChildLocations = $parentLocation->children;

    // Assert
    expect($retrievedChildLocations)->toBeInstanceOf(Collection::class);
    expect(count($retrievedChildLocations))->toBe(2);

    // Assert that the children are instances of Location
    expect($retrievedChildLocations->first())->toBeInstanceOf(Location::class);
    expect($retrievedChildLocations->last())->toBeInstanceOf(Location::class);

    expect($retrievedChildLocations->pluck('id')->toArray())->toContain($childLocation1->id, $childLocation2->id);

});

it('can have multiple devices', function () {
    // Arrange
    $location = Location::factory()->create();
    $device1 = Device::factory()->create([
        'location_id' => $location->id,
    ]);
    $device2 = Device::factory()->create([
        'location_id' => $location->id,
    ]);

    // Act
    $retrievedDevices = $location->devices;

    // Assert
    expect(count($retrievedDevices))->toBe(2);
    expect($retrievedDevices->pluck('id')->toArray())->toContain($device1->id, $device2->id);

});

it('is an end node when it has no child locations', function () {
    // Arrange
    $location = Location::factory()->create();

    // Act
    $isEndNode = $location->isEndNode();

    // Assert
    expect($isEndNode)->toBe(true);
});

it('is not an end node when it has child locations', function () {
    // Arrange
    $parentLocation = Location::factory()->create();
    Location::factory()->create([
        'parent_id' => $parentLocation->id,
    ]);

    // Act
    $isEndNode = $parentLocation->isEndNode();

    // Assert
    expect($isEndNode)->toBe(false);

});

it('can be created with valid data', function () {
    // Arrange
    $data = [
        'name' => $this->faker->name(),
        'parent_id' => null,
        'is_base_location' => true,

    ];

    // Act
    $location = Location::create($data);

    // Assert
    $this->assertDatabaseHas('locations', $data);
    expect($location)->toBeInstanceOf(Location::class);
    expect($location->name)->toBe($data['name']);
    expect($location->parent_id)->toBeNull();
    expect($location->is_base_location)->toBeTrue();
});
