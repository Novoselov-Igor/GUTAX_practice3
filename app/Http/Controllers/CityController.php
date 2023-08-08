<?php

namespace App\Http\Controllers;

use App\Models\City;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class CityController extends Controller
{
    public function getUserLocation()
    {
        $location = geoip()->getLocation(geoip()->getClientIP());

        return $location->city;
    }

    public function checkCity(Request $request)
    {
        $api_key = 'c027ee89d6cae9c69e731d64125624fd';

        $client = new Client();
        $url = 'http://api.openweathermap.org/geo/1.0/direct?q=' . $request->input('city') . '&limit=1&appid=' . $api_key;

        $response = $client->request('get', $url);

        return response()->json(['location' => json_decode($response->getBody(), true)]);
    }

    public function addNewCity(Request $request)
    {
        $cityName = $request->input('city');

        $cities = City::all();

        $fl = false;
        foreach ($cities as $city) {
            if ($city->name === $cityName) {
                $fl = true;
            }
        }

        if (!$fl) {
            City::create([
                'name' => $cityName
            ]);
            return response()->json(['success' => 'Новый город бы успешно добавлен']);
        }
        return response()->json(['success' => 'Такой город уже существует']);
    }
}
