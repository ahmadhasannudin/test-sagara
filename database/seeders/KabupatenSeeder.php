<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kabupaten::factory()->count(100)->create();
    }
}
