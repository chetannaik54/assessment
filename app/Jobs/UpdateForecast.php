<?php

namespace App\Jobs;
use App\Models\Cityforecast;

class UpdateForecast extends Job
{
    /**
     * The podcast instance.
     *
     * @var \App\Models\Podcast
     */
    public $cityforecast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cityforecast $cityforecast)
    {
        //
        $this->cityforecast = $cityforecast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Cityforecast $cityforecast)
    {
        // Update weather forecast on daily basis
        foreach($cityforecast as $cities){
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'api.openweathermap.org/data/2.5/forecast?q='.$cities->city.'&appid='.env('WEATHERAPI_KEY'));
            $forecastCities = Cityforecast::find($cities->id);
            $forecastCities->forecast_data = $response->getBody();

            $forecastCities->save();
        }
    }
}
