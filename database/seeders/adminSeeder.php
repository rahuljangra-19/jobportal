<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $user = new User();
        $user->token = Str::random(15);
        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->user_name = 'admin admin';
        $user->role = 'admin';
        $user->email =  'admin@admin.com';
        $user->password = Hash::make('123456');
        $user->save();
    }
}
