<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class weatherController extends Controller
{
    public function index(Request $request){

        $weatherResponse = [];

        if($request->isMethod("post")){
            $cityName = $request->city;

            $response = Http::withHeaders([
                "x-rapidapi-host" => "open-weather13.p.rapidapi.com",
                "x-rapidapi-key" => "6971363196msh23362389871e434p1d3108jsn7d51ae868621"
            ])->withoutVerifying()->get("https://open-weather13.p.rapidapi.com/city/{$cityName}/FR");

            $weatherResponse = $response->json();
        }

        return view("weather", [
            "data" => $weatherResponse
        ]);
    }
}
