<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobTypes = [
            "Full-Time",
            "Part-Time",
            "Contract",
            // "Temporary",
            "Internship",
            "Freelance",
            "Remote",
            // "Seasonal",
            // "Permanent",
            // "Volunteer"
        ];

        JobType::truncate();
        foreach ($jobTypes as $type) {
            $jobType = new JobType();
            $jobType->name = $type;
            $jobType->save();
        }
    }
}
