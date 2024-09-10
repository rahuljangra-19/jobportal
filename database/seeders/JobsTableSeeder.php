<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use Faker\Factory as Faker;
use App\Models\JobCategory;
use App\Models\JobIndustry;
use App\Models\JobType;
use App\Models\JobRole;
use App\Models\Qualification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all industry and category IDs from the database
        $JobType = JobType::where('status', 1)->pluck('name')->toArray();
        $JobRole = JobRole::where('status', 1)->pluck('id')->toArray();
        $JobIndustry = JobIndustry::where('status', 1)->pluck('id')->toArray();
        $JobCategory = JobCategory::where('status', 1)->pluck('id')->toArray();
        $jobQual = Qualification::where('status', 1)->pluck('name')->toArray();

        $companies = User::where('role', 'company')->pluck('id')->toArray();

        for ($i = 0; $i < 50    ; $i++) {
            $job = new Job();
            $job->user_id = $faker->randomElement($companies);
            $job->title = $faker->jobTitle;
            $job->job_role = $faker->word;

            // Assign random industry and category from existing IDs
            $job->job_industry = $faker->randomElement($JobIndustry);
            $job->job_category = $faker->randomElement($JobCategory);
            $job->job_role = $faker->randomElement($JobRole);

            $job->vacancies = $faker->numberBetween(1, 10);
            $job->experience = $faker->numberBetween(1, 15) . ' years';
            $job->deadline = $faker->dateTimeBetween('+1 week', '+1 month');
            $job->description = $faker->paragraph;
            $job->salary_type = $faker->randomElement(['fixed', 'range']);

            if ($job->salary_type === 'range') {
                $job->salary = $faker->numberBetween(5000, 50000);
                $job->max_salary = $faker->numberBetween(30000, 100000);
            } else {
                $job->salary = $faker->numberBetween(5000, 100000);
                $job->max_salary = $job->salary;
            }

            $city = $faker->city;
            $state = $faker->state;
            $country = $faker->country;
            $job->location = "$city, $state, $country";
            $job->job_type = json_encode($faker->randomElements($JobType, 3));
            $job->qualification = json_encode($faker->randomElements($jobQual, 2));

            $job->save();
        }
    }
}
