<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         \App\Models\Project::factory(5)->create()->each(function($project){
            \App\Models\Task::factory(5)->create(['project_id' => $project->id]);
        });
    }
}
