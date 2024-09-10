<?php

namespace Database\Seeders;

use App\Models\JobIndustry;
use App\Models\Qualification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $jobQual = Qualification::where('status', 1)->pluck('name')->toArray();
        $JobIndustry = JobIndustry::where('status', 1)->pluck('id')->toArray();
        $jobProfiles = [
            'Node Developer',
            'Web Designer',
            'Welder',
            'Cook',
            'Data Analyst',
            'Project Manager',
            'Content Writer',
            'Graphic Designer',
            'Software Engineer',
            'Teacher',
            'Electrician',
            'Plumber',
            'Carpenter',
            'Driver',
            'Receptionist',
        ];

        for ($i = 0; $i < 10; $i++) {
            $employee = new User();
            $employee->role = 'employee';
            $employee->status = $faker->randomElement(['active']); // Random status
            $employee->token = Str::random(15);
            $employee->first_name = $faker->firstName;
            $employee->last_name = $faker->lastName;
            $employee->user_name = $faker->userName;
            $employee->email = $faker->unique()->safeEmail;
            $employee->phone = $faker->phoneNumber;
            $employee->profile = $faker->randomElement($jobProfiles);
            $employee->industry_id = $faker->randomElement($JobIndustry);
            $employee->exp = $faker->numberBetween(1, 15) . ' years';
            $employee->password = Hash::make('password'); // Default password for all employees, you can change it as needed
            $employee->qualifications = json_encode($faker->randomElements($jobQual, 2));

            $employee->save();
        }
    }
}
