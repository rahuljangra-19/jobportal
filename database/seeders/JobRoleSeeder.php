<?php

namespace Database\Seeders;

use App\Models\JobRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $JobRoles  = [
            "Software Developer",
            "Registered Nurse",
            "Teacher",
            "Accountant",
            "Project Manager",
            "Sales Representative",
            "Marketing Manager",
            "Customer Service Representative",
            "Mechanical Engineer",
            "Human Resources Manager",
            "Business Analyst",
            "Graphic Designer",
            "Operations Manager",
            "Financial Analyst",
            "Data Scientist",
            "Legal Assistant",
            "Administrative Assistant",
            "Content Writer",
            "Quality Assurance Engineer",
            "Product Manager"
        ];

        JobRole::truncate();
        foreach ($JobRoles as $role) {
            $JobRole = new JobRole();
            $JobRole->name = $role;
            $JobRole->save();
        }
    }
}
