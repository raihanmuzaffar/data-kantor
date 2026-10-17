<?php

namespace Database\Seeders;

use App\Models\Announcement;
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

        if (Employee::count() === 0) {
            Employee::factory()->count(20)->create();
        }

        Announcement::factory()->count(15)->create();
    }
}
