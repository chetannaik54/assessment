<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Cityforecast;
use App\Models\State;
use App\Models\Country;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class forecastController extends Controller{

    // Available cities in our DB
    public function availablecities(){
        // Get all cities available in DB
        $countryCity = Country::latest()->with('statesWithCities')->get();
        return response()->json($countryCity,'200');
    }

    // Add cities to forecast
    public function addCitiestoForecast(Request $request){

        $this->validate($request, [ 
            'id' => 'required|numeric'
        ]);

        // Try catch block
        try{
            // Check if city is available 
            $cityData = City::findOrFail($request->id);

            if($cityData == null){
                return response()->json('oops the city doesn\'t exist');
            }else{
                // Check wether already present in DB
                $cityAlreadyPresent = Cityforecast::where('city', $cityData->name)->first();

                if($cityAlreadyPresent == null){

                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('GET', 'api.openweathermap.org/data/2.5/forecast?q='.$cityData->name.'&appid='.env('WEATHERAPI_KEY'));

                    if($response->getStatusCode() == 200){
                        $as = Cityforecast::create(
                            [
                                'city' => $cityData->name,
                                'forecast_data' => $response->getBody(),
                            ]
                        );
                    }

                    return response()->json('New city added for forecast!');
                }else{
                    return response()->json('City already present');
                }
            }
        }catch(Exception $e){
            Log::critical($e->getMessage());
            return response('Issue while adding new records, kindly check it later', 500);
        }
    }

    public function showCitiestoForecast(){
        // Get all cities weather data from DB
        $cityWithForeact = Cityforecast::all();
        $weatherCollector = array();

        // Iterate data and send response back
        foreach($cityWithForeact as $cities){
            $weatherInfo = json_decode($cities->forecast_data, true);
            $weatherInfo = $weatherInfo['list'];
            array_push($weatherCollector, $weatherInfo);
        }
        return response()->json($weatherCollector, '200');
    }

    public function showCitiesSpecificForecast(Request $request){
        $this->validate($request, [ 
            'id' => 'required|numeric'
        ]);

        // Find city details by id using orm
        $cityWithForeact = Cityforecast::findOrFail($request->id);

        // convert json to array
        $weatherInfo = json_decode($cityWithForeact->forecast_data, true);
        $weatherInfo = $weatherInfo['list'];

        // Send response back
        return response()->json($weatherInfo, '200');
    }
    
    // Show cities forecast Data in human readable format
    public function human_readable_showCitiestoForecast(){
        $cityWithForeact = Cityforecast::all();
        foreach($cityWithForeact as $cities){
            echo 'Weather report for '.$cities->city;
            echo '<br>';

            $weatherInfo = json_decode($cities->forecast_data, true);
            $weatherInfo = $weatherInfo['list'];

            $mytime = Carbon::now();
            $secondDay = $mytime->addDay()->toDateString();
            $thirdDay = $mytime->addDay()->toDateString();
            $fourthDay = $mytime->addDay()->toDateString();
            $fifthDay = $mytime->addDay()->toDateString();

            // This code can be optimized
            foreach($weatherInfo as $weatherData){
                // For today
                if(str_contains($weatherData['dt_txt'], $mytime->toDateString())){
                    echo 'Wind : '.$weatherData['wind']['deg'].' | ';
                    echo ' Weather : '.$weatherData['weather'][0]['description'].' | ';
                    echo ' Time : '.$weatherData['dt_txt'].' | ';
                    echo '<br>';
                }

                // For 2th day
                if(str_contains($weatherData['dt_txt'], $secondDay)){
                    echo 'Wind : '.$weatherData['wind']['deg'].' | ';
                    echo ' Weather : '.$weatherData['weather'][0]['description'].' | ';
                    echo ' Time : '.$weatherData['dt_txt'].' | ';
                    echo '<br>';
                }

                // For 3th Day
                if(str_contains($weatherData['dt_txt'], $thirdDay)){
                    echo 'Wind : '.$weatherData['wind']['deg'].' | ';
                    echo ' Weather : '.$weatherData['weather'][0]['description'].' | ';
                    echo ' Time : '.$weatherData['dt_txt'].' | ';
                    echo '<br>';
                }

                // For 4th Day
                if(str_contains($weatherData['dt_txt'], $fourthDay)){
                    echo 'Wind : '.$weatherData['wind']['deg'].' | ';
                    echo ' Weather : '.$weatherData['weather'][0]['description'].' | ';
                    echo ' Time : '.$weatherData['dt_txt'].' | ';
                    echo '<br>';
                }

                // For 5th Day
                if(str_contains($weatherData['dt_txt'], $fifthDay)){
                    echo 'Wind : '.$weatherData['wind']['deg'].' | ';
                    echo ' Weather : '.$weatherData['weather'][0]['description'].' | ';
                    echo ' Time : '.$weatherData['dt_txt'].' | ';
                    echo '<br>';
                }
            }

            echo '<br>';
        }
    }

    public function delete(Request $request){
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        try{
           $dContent = Cityforecast::where('id', $request->id)->first();
           $dContent->delete();
           return response('Deleted Successfully', 200);

        }catch(Exception $e){
            Log::critical($e->getMessage());
            return response('Issue while deleting records, kindly check it later', 500);
        }
    }
}