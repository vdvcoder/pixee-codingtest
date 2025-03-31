<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Location;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create(
            [
                'name' => 'Olivier',
                'email' => 'olivier@laravel.com',
                'password' => bcrypt('Password'),
            ]
        );

        User::create(
            [
                'name' => 'Pixee',
                'email' => 'pixee@laravel.com',
                'password' => bcrypt('Password'),
            ]
        );

        // Seed locations
        $hotels = [
            'HOTEL ABC' => ['ONTHAAL', 'KAMER 100', 'KAMER 101'],
            'HOTEL XYZ' => ['ONTHAAL', 'KAMER 100', 'KAMER 101'],
            'CONNECTIFY' => ['KANTOOR A', 'KANTOOR B', 'MEETING ROOM 1', 'MEETING ROOM 2'],
            'PIXEE' => ['ONTHAAL', 'KANTOOR 1', 'KANTOOR 2', 'RESTAURANT'],
            'SHOP ABC' => ['INKOM', 'KASSA', 'WINKEL'],
        ];

        $locations = [];
        foreach ($hotels as $hotelName => $rooms) {
            $hotel = Location::create(['name' => $hotelName, 'is_base_location' => true]);
            $locations[$hotelName] = $hotel;

            foreach ($rooms as $room) {
                $locations[$room] = Location::create(['name' => $room, 'parent_id' => $hotel->id]);
            }
        }

        $faker = Faker::create();

        // Seed devices
        for ($i = 0; $i < 50; $i++) {
            $device = Device::create([
                'name' => $faker->randomElement([
                    'SAMSUNG SMART TV NEO QLED 4K 55"',
                    'PHILIPS 4K UHD LED 55"',
                ]),
                'device_type' => 'TV',
                'mac_address' => $faker->macAddress(),
                'ip_address' => $faker->ipv4(),
                'rotation' => $faker->randomElement([
                    'Landscape',
                    'Portrait',
                ]),
                'last_ping' => $faker->dateTimeBetween('-30 minutes', 'now'),
                'width' => 3840,
                'height' => 2160,
            ]);

            // Attach devices to random locations that are not base locations
            $nonBaseLocations = Location::where('is_base_location', false)->get();

            // Attach some devices to random locations and some to no location
            if ($nonBaseLocations->isNotEmpty() && rand(0, 1)) { // 50% chance to attach to a location
                $location = $nonBaseLocations->random();
                $device->location_id = $location->id;
                $device->save();
            }

        }
    }
}
