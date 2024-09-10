<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/data/states.json'));
        $states = json_decode($json, true);
        Schema::disableForeignKeyConstraints();
        State::truncate();
        Schema::enableForeignKeyConstraints();


        foreach($states as $state){
            $con = new State();
            $con->id = $state['id'];
            $con->country_id =  $state['country_id']; 
            $con->name =  $state['name']; 
            $con->country_code =  $state['country_code']; 
            $con->state_code =  $state['state_code']; 
            $con->latitude =  $state['latitude']; 
            $con->longitude = $state['longitude']; 
            $con->save();
        }
    }
}
