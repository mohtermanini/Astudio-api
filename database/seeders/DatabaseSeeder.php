<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Department;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProjectStatusSeeder::class,
            UserSeeder::class,
        ]);

        if (app()->environment(['local', 'staging'])) {
            $user_1 = User::factory()->create();
            $user_2 = User::factory()->create();

            $department_1 = Department::factory()
                ->has(Project::factory()->created()
                    ->hasAttached([$user_1, $user_2]))
                ->create();

            $department_2 = Department::factory()
                ->has(Project::factory()->inProgress()
                    ->hasAttached($user_1))
                ->create();

            $project_1 = $department_1->projects->first();
            $project_2 = $department_2->projects->first();

            Timesheet::factory()->count(3)
                ->state(['date' => fake()->dateTimeBetween($project_1->start_date, $project_1->end_date),])
                ->create([
                    'user_id' => $user_1->id,
                    'project_id' => $project_1->id,
                ]);

            Timesheet::factory()->count(2)
                ->state(['date' => fake()->dateTimeBetween($project_2->start_date, $project_1->end_date),])
                ->create([
                    'user_id' => $user_1->id,
                    'project_id' => $project_2->id,
                ]);

            Timesheet::factory()->count(1)
                ->state(['date' => fake()->dateTimeBetween($project_1->start_date, $project_1->end_date),])
                ->create([
                    'user_id' => $user_2->id,
                    'project_id' => $project_1->id,
                ]);
        }
    }
}
