<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CityController extends Controller
{
    public function getUserLocation()
    {
        $location = geoip()->getLocation(geoip()->getClientIP());

        return $location->city;
    }
}
