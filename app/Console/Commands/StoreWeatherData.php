<?php

namespace App\Console\Commands;

use App\Models\Date;
use App\Models\WeatherData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StoreWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:weather:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy data from weather_data.json to the database with transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        try {
            DB::beginTransaction();

            $jsonData = File::get(__DIR__ . '/../../../storage/data/weather_data.json');
            $data = json_decode($jsonData, true);

            foreach ($data as $item) {
                $weatherData = WeatherData::create([
                    'temperature_celsius' => (float) $item['average_temperature_celsius'],
                    'precipitation_millimeter' => (float) $item['average_precipitation_millimeter'],
                    'humidity_percent' => (float) $item['average_humidity_percent'],
                    'wind_speed' => (float) $item['average_wind_speed'],
                ]);

                Date::create([
                    'date' => $item['measurement_date'],
                    'name' => date('D', strtotime($item['measurement_date'])), // Get the day name (Mon, Tue, Wed, etc.)
                    'data_id' => $weatherData->id,
                ]);
            }

            DB::commit();
            $this->info('Weather data successfully copied to the database.');
        } catch (\Exception $e){
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}



