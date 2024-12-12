<?php
namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory(3)->create(); // Create 3 new tags
        $employers = Employer::factory(3)->create();

        Job::factory(5)->hasAttached($tags)->create(new Sequence([
            'featured' => false,
            'schedule' => 'Full Time',
        ], [
            'featured' => true,
            'schedule' => 'Part Time',
        ]));

        $jobTitles = [
            'Web Developer',
            'Data Analyst',
            'Project Manager',
            'Graphic Designer',
            'Financial Specialist',
            'Software Engineer',
            'Product Manager',
            'UX/UI Designer',
            'DevOps Engineer',
            'Marketing Specialist',
        ];

        foreach ($employers as $employer) {
            foreach ($jobTitles as $title) {
                Job::factory()->create([
                    'employer_id' => $employer->id,
                    'title' => $title, // Assign unique title
                    'salary' => rand(50000, 120000), // Random salary
                ])->each(function ($job) use ($tags) {
                    $job->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray()); // Attach random tags (1 to 3)
                });
            }
        }
    }
}
