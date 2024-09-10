<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobCategories = [
            "Information Technology (IT)",
            "Healthcare",
            "Education",
            "Finance and Accounting",
            "Engineering",
            "Sales and Marketing",
            "Hospitality and Tourism",
            "Manufacturing and Production",
            "Retail",
            "Human Resources"
        ];
        JobCategory::truncate();

        foreach ($jobCategories as $val) {
            $category = new JobCategory();
            $category->name = $val;
            $category->save();
        }
    }
}
