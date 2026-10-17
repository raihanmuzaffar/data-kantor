<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (Division::count() === 0) {
            Division::factory()->count(6)->create();
        }

        Employee::factory()->count(20)->create();
    }
}
