<?php

namespace Database\Seeders;

use App\Models\System\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        Tax::factory()->count(5)->create();
    }
}
