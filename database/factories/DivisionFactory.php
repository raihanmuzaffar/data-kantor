<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivisionFactory extends Factory
{
    protected $model = Division::class;

    public function definition(): array
    {
        $divisions = [
            ['name' => 'Information Technology', 'code' => 'IT'],
            ['name' => 'Human Resources', 'code' => 'HR'],
            ['name' => 'Finance', 'code' => 'FIN'],
            ['name' => 'Marketing', 'code' => 'MKT'],
            ['name' => 'Operations', 'code' => 'OPS'],
            ['name' => 'General Affairs', 'code' => 'GA'],
        ];

        $division = fake()->unique()->randomElement($divisions);

        return [
            'name' => $division['name'],
            'code' => $division['code'],
            'description' => fake()->sentence(10),
            'head_user_id' => null,
            'is_active' => true,
        ];
    }
}
