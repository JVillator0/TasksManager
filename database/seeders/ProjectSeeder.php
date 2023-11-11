<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'name' => 'Project 1',
        ]);

        Project::create([
            'name' => 'Project 2',
        ]);

        Project::create([
            'name' => 'Project 3',
        ]);
    }
}
