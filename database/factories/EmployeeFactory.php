<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $joinDate = fake()->dateTimeBetween('-3 years', 'now');

        return [
            'user_id' => null,
            'division_id' => Division::query()->inRandomOrder()->value('id'),
            'employee_number' => 'EMP-'.strtoupper(fake()->unique()->bothify('???####')),
            'full_name' => fake()->name($gender === 'male' ? 'male' : 'female'),
            'nickname' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '08'.fake()->numerify('##########'),
            'nik' => fake()->numerify('################'),
            'npwp' => fake()->numerify('##.###.###.#-###.###'),
            'gender' => $gender,
            'birth_date' => fake()->dateTimeBetween('-50 years', '-20 years'),
            'birth_place' => fake()->city(),
            'position' => fake()->randomElement([
                'Staff', 'Senior Staff', 'Supervisor', 'Manager', 'Direktur',
            ]),
            'employment_status' => fake()->randomElement(['permanent', 'contract', 'intern', 'probation']),
            'join_date' => $joinDate,
            'end_date' => null,
            'salary' => fake()->numberBetween(4_000_000, 20_000_000),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => '08'.fake()->numerify('##########'),
            'is_active' => true,
        ];
    }
}
