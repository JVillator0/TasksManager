<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        $this->createTasks(null, 3);
        $projects->each(function ($project) {
            $this->createTasks($project->id, 3);
        });
    }

    private function createTasks(int | null $projectId, int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            Task::create([
                'name' => 'Task '.$i,
                'description' => 'Description '.$i,
                'project_id' => $projectId,
                'priority' => $i,
            ]);
        }
    }
}
