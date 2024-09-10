<?php

namespace Database\Seeders;

use App\Models\JobIndustry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobIndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobIndustries = [
            "Technology",
            "Healthcare",
            "Education",
            "Finance",
            "Engineering",
            "Marketing and Advertising",
            "Hospitality",
            "Manufacturing",
            "Retail",
            "Human Resources",
            "Agriculture",
            "Automotive",
            "Construction",
            "Energy and Utilities",
            "Entertainment and Media",
            "Government and Public Administration",
            "Law and Legal Services",
            "Real Estate",
            "Transportation and Logistics",
            "Telecommunications"
        ];

        JobIndustry::truncate();
        foreach ($jobIndustries as $jobIndustry) {
            $JobIndustry = new JobIndustry();
            $JobIndustry->name = $jobIndustry;
            $JobIndustry->save();
        }
    }
}
