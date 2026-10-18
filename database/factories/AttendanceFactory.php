<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-30 days', 'now');
        $clockIn = (clone $date)->setTime(
            fake()->numberBetween(7, 10),
            fake()->numberBetween(0, 59)
        );
        $clockOut = (clone $clockIn)->modify('+'.fake()->numberBetween(6, 10).' hours');

        $status = Attendance::determineStatus(Carbon::instance($clockIn));

        return [
            'employee_id' => Employee::factory(),
            'date' => $date->format('Y-m-d'),
            'clock_in' => $clockIn,
            'clock_out' => $clockOut,
            'status' => $status,
            'notes' => fake()->optional(0.3)->sentence(),
            'ip_address' => fake()->ipv4(),
        ];
    }

    public function present(): static
    {
        return $this->state(fn () => ['status' => 'present']);
    }

    public function late(): static
    {
        return $this->state(fn () => ['status' => 'late']);
    }

    public function withoutClockOut(): static
    {
        return $this->state(fn () => [
            'clock_out' => null,
        ]);
    }
}
