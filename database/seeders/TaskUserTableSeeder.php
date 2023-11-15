<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = \App\Models\Task::all();
        \App\Models\User::all()->each(function ($user) use ($tasks) {
            $user->tasks()->attach(
                $tasks->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
