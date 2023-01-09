<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('available-cities',  ['uses' => 'forecastController@availablecities']);
  
    $router->post('add-cities', ['uses' => 'forecastController@addCitiestoForecast']);

    $router->get('show-cities', ['uses' => 'forecastController@showCitiestoForecast']);

    $router->get('specific-cities/{id}', ['uses' => 'forecastController@showCitiesSpecificForecast']);

    // To get weather forecast in human readable 
    $router->get('show-cities-simple', ['uses' => 'forecastController@human_readable_showCitiestoForecast']);

    $router->post('delete-cities', ['uses' => 'forecastController@delete']);
});