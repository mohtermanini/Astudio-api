<?php

namespace Database\Factories;

use App\Enums\ProjectStatusesEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeThisMonth();
        $end_date = fake()->dateTimeBetween($start_date, '+3 month');

        return [
            'name' => fake()->unique()->words(3, true),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    public function created()
    {
        return $this->state(['status_id' => ProjectStatusesEnum::CREATED]);
    }

    public function inProgress()
    {
        return $this->state(['status_id' => ProjectStatusesEnum::IN_PROGRESS]);
    }

    public function done()
    {
        return $this->state(['status_id' => ProjectStatusesEnum::DONE]);
    }

}
