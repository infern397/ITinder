<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(50)->create();

        $skills = Skill::all();

        $users->each(function ($user) use ($skills) {
            $randomSkills = $skills->random(rand(3, 5))->pluck('id');
            $user->skills()->attach($randomSkills);

            $randomSeekingSkills = $skills->random(rand(3, 5))->pluck('id');
            $user->seekingSkills()->attach($randomSeekingSkills);
        });
    }
}
