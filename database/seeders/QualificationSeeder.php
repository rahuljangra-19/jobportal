<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualifications = [
            "MCA - Master of Computer Applications",
            "BCA - Bachelor of Computer Applications",
            "MBA - Master of Business Administration",
            "BBA - Bachelor of Business Administration",
            "B.Tech - Bachelor of Technology",
            "M.Tech - Master of Technology",
            "PhD - Doctor of Philosophy",
            "B.Sc - Bachelor of Science",
            "M.Sc - Master of Science",
            "B.Com - Bachelor of Commerce",
            "M.Com - Master of Commerce",
            "BE - Bachelor of Engineering",
            "ME - Master of Engineering",
            "LLB - Bachelor of Laws",
            "LLM - Master of Laws",
            "MBBS - Bachelor of Medicine and Bachelor of Surgery",
            "B.Ed - Bachelor of Education",
            "M.Ed - Master of Education",
            "CA - Chartered Accountant",
            "CFA - Chartered Financial Analyst",
            "B.Arch - Bachelor of Architecture",
            "M.Arch - Master of Architecture",
            "BFA - Bachelor of Fine Arts",
            "MFA - Master of Fine Arts",
            "B.Pharm - Bachelor of Pharmacy",
            "M.Pharm - Master of Pharmacy"
        ];

        Qualification::truncate();

        foreach ($qualifications as  $value) {
            $qualification = new Qualification();
            $qualification->name = $value;
            $qualification->save();
        }
    }
}
