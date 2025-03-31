<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'SAMSUNG SMART TV NEO QLED 4K 55"',
                'PHILIPS 4K UHD LED 55"',
            ]),
            'device_type' => 'TV',
            'mac_address' => fake()->macAddress(),
            'ip_address' => fake()->ipv4(),
            'last_ping' => fake()->optional()->dateTimeBetween('-30 minutes', 'now'),
            'width' => 3840,
            'height' => 2160,
            'rotation' => fake()->randomElement(['Landscape', 'Portrait']),
        ];
    }
}
