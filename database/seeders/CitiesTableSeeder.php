<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/data/cities.json'));
        $cities = json_decode($json, true);

        Schema::disableForeignKeyConstraints();
        City::truncate();
        
        foreach ($cities as $city) {
            $con = new City();
            $con->id = $city['id'];
            $con->country_id =  $city['country_id'];
            $con->state_id =  $city['state_id'];
            $con->name =  $city['name'];
            $con->latitude =  $city['latitude'];
            $con->longitude = $city['longitude'];
            $con->save();
        }
        Schema::enableForeignKeyConstraints();
    }
}
