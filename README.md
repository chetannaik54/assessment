# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Our weather api provides forecast of 5 days for majority of the cities

## Server requirement
1) PHP >= 8.0
2) OpenSSL PHP Extension
3) PDO PHP Extension
4) Mbstring PHP Extension

## How to initiate the project
Step 1 : Clone this Git repo in a folder & copy the .env.example to .env
Step 2 : Create a empty database and input the credentials in .env and generate a APP_KEY of min. 32 characters
Step 3 : Run the migration using "php artisan migrate" command
Step 4 : Serve your application using the following command "php -S localhost:8000 -t public"
Step 5 : Enjoy the weather

## Available Routes
<!-- Avaialble cities with us -->
http://localhost:8000/api/available-cities

<!-- Add cities to be forecasted -->
http://localhost:8000/api/add-cities/?id=1

<!-- Delete cities -->
http://localhost:8000/api/delete-cities?id=2

<!-- Show all cities weather forecast -->
http://localhost:8000/api/show-cities

<!-- Show Specific city weather forecast -->
http://localhost:8000/api/specific-cities

<!-- Show all cities weather forecast in human readable -->
http://localhost:8000/api/show-cities-simple

## Jobs/Queue
A "UpdateForecast" is created to update the weather data on daily basis. you can find the file in App/Jobs/UpdateForecast.php

## Security Vulnerabilities

If you discover a security vulnerability within Code, please send an e-mail to Chetan naik at reachchetanofficial@gmail.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
