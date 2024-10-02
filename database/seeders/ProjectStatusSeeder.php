<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date_now = Carbon::now();

        ProjectStatus::insert([
            ['name' => 'Created', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'In-Progress', 'created_at' => $date_now, 'updated_at' => $date_now],
            ['name' => 'Done', 'created_at' => $date_now, 'updated_at' => $date_now],
        ]);
    }
}
