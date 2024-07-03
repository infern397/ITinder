<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP'],
            ['name' => 'JavaScript'],
            ['name' => 'TypeScript'],
            ['name' => 'Vue.js'],
            ['name' => 'Laravel'],
            ['name' => 'SQL'],
            ['name' => 'Docker'],
            ['name' => 'Kubernetes'],
            ['name' => 'Python'],
            ['name' => 'Ruby'],
            ['name' => 'Java'],
            ['name' => 'C#'],
            ['name' => 'C++'],
            ['name' => 'C'],
            ['name' => 'Swift'],
            ['name' => 'Objective-C'],
            ['name' => 'React'],
            ['name' => 'Angular'],
            ['name' => 'Node.js'],
            ['name' => 'Express'],
            ['name' => 'MongoDB'],
            ['name' => 'PostgreSQL'],
            ['name' => 'MySQL'],
            ['name' => 'SQLite'],
            ['name' => 'Redis'],
            ['name' => 'Elasticsearch'],
            ['name' => 'Nginx'],
            ['name' => 'Apache'],
            ['name' => 'Git'],
            ['name' => 'GitHub'],
            ['name' => 'GitLab'],
            ['name' => 'Bitbucket'],
            ['name' => 'WP Engine'],
            ['name' => 'SiteGround'],
            ['name' => 'Cloudflare'],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert($skill);
        }
    }
}
