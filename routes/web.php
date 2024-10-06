<?php

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\weatherController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get("weather", [weatherController::class,"index"]);

Route::match(["get","post"],"weather", [weatherController::class, "index"])->name("weather.form");