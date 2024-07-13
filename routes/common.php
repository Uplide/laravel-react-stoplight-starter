<?php

use App\Http\Controllers\Common\CityController;
use App\Http\Controllers\Common\CountryController;
use App\Http\Controllers\Common\TownController;
use Illuminate\Support\Facades\Route;

Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{countryId}/cities', [CityController::class, 'index']);
Route::get('cities/{cityId}/towns', [TownController::class, 'index']);
