<?php

use App\Models\Device;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class); // Voeg deze regel toe om de database te verversen

it('belongs to a location', function () {
    // Arrange
    $location = Location::factory()->create();
    $device = Device::factory()->create([
        'location_id' => $location->id,
    ]);

    // Act
    $retrievedLocation = $device->location;

    // Assert
    expect($retrievedLocation)->toBeInstanceOf(Location::class);
    expect($retrievedLocation->id)->toBe($location->id);
});

it('can be created with valid data', function () {
    // Arrange
    $location = Location::factory()->create();

    $data = [
        'name' => $this->faker->name(),
        'device_type' => $this->faker->word(),
        'mac_address' => $this->faker->macAddress(),
        'ip_address' => $this->faker->ipv4(),
        'rotation' => $this->faker->word(),
        'last_ping' => $this->faker->datetime(),
        'width' => $this->faker->randomNumber(),
        'height' => $this->faker->randomNumber(),
        'location_id' => $location->id,
    ];

    // Act
    $device = Device::create($data);

    // Assert
    $this->assertDatabaseHas('devices', $data);
    expect($device)->toBeInstanceOf(Device::class);
    expect($device->name)->toBe($data['name']);

});

it('casts last_ping to datetime', function () {
    // Arrange
    $device = Device::factory()->create(['last_ping' => now()]);

    // Act
    $lastPing = $device->last_ping;

    // Assert
    expect($lastPing)->toBeInstanceOf(DateTime::class);
});

it('returns red status when last ping is null', function () {
    // Arrange
    $device = Device::factory()->create(['last_ping' => null]);

    // Act
    $status = $device->status;

    // Assert
    expect($status)->toBe('red');
});

it('returns green status when last ping is less than 10 minutes ago', function () {
    // Arrange
    $device = Device::factory()->create([
        'last_ping' => Carbon::now()->subMinutes(5)->toDateTimeString(),
    ]);

    // Act
    $status = $device->status;

    // Assert
    expect($status)->toBe('green');
});

it('returns yellow status when last ping is between 10 and 30 minutes ago', function () {
    // Arrange
    $device = Device::factory()->create([
        'last_ping' => Carbon::now()->subMinutes(20)->toDateTimeString(),
    ]);

    // Act
    $status = $device->status;

    // Assert
    expect($status)->toBe('yellow');
});

it('returns red status when last ping is more than 30 minutes ago', function () {
    // Arrange
    $device = Device::factory()->create([
        'last_ping' => Carbon::now()->subMinutes(40)->toDateTimeString(),
    ]);

    // Act
    $status = $device->status;

    // Assert
    expect($status)->toBe('red');
});
