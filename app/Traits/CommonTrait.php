<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;

trait CommonTrait
{

    function getCountry($id)
    {
        $country =   Country::find($id);
        return $country ? $country->name : '';
    }
    function getState($id)
    {
        $state = State::find($id);
        return $state ? $state->name : '';
    }
    function getCity($id)
    {
        $city =  City::find($id);
        return $city ? $city->name : '';
    }

    function getLocation($request)
    {
        if ($request->location == 'current_location') {
            $location = $this->getCity(Auth::user()->city_id) . ',' . $this->getState(Auth::user()->state_id) . ',' . $this->getCountry(Auth::user()->country_id);
        }

        if ($request->location == 'other_location') {
            $location = $this->getCity($request->city) . ',' . $this->getState($request->state) . ',' . $this->getCountry($request->country);
        }
        return trim($location, ',');
    }
}
