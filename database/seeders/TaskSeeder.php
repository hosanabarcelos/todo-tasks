<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::query()->create([
            'title' => 'Buy groceries',
            'description' => 'Milk, Cheese, Pizza, Fruit, Tylenol',
            'done' => false,
        ]);

        Task::query()->create([
            'title' => 'Learn Laravel',
            'description' => 'Need to find a good Laravel tutorial on the Web',
            'done' => false,
        ]);
    }
}
