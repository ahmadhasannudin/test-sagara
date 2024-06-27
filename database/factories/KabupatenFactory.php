<?php

namespace Database\Factories;

use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kabupaten>
 */
class KabupatenFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provinsi_id' => Provinsi::pluck('id')->random(),
            'nama' => $this->faker->city,
            'populasi' => $this->faker->numberBetween(10000, 1000000),
        ];
    }
}
