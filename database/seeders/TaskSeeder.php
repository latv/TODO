<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomData = [[
                'title' => 'Buy groceries',
                'description' => 'Milk, eggs, and bread.',
                'is_completed' => false
            ],
            [
                'title' => 'Finish Laravel project',
                'description' => 'Complete the task management module.',
                'is_completed' => true
            ],
            [
                'title' => 'Read documentation',
                'description' => 'Review the Laravel Eloquent guide.',
                'is_completed' => false
            ]];

        Task::insert($randomData);
    }
}
