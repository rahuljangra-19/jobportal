<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/data/countries.json'));
        $countries = json_decode($json, true);
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($countries as $country) {
            $con = new Country();
            $con->id = $country['id'];
            $con->name =  $country['name'];
            $con->iso2 =  $country['iso2'];
            $con->phone_code =  $country['phone_code'];
            $con->latitude =  $country['latitude'];
            $con->longitude = $country['longitude'];
            $con->save();
        }
    }
}
