<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName().' TRMNL',
            'mac_address' => $this->faker->macAddress(),
            'default_refresh_interval' => '900',
            'friendly_id' => Str::random(6),
            'api_key' => 'tD-'.Str::random(19),
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
