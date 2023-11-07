<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\WeatherData;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    /**
     * @throws Exception
     */
    public function exportDataToExcel()
    {
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Day');
        $sheet->setCellValue('B1', 'Minimum Temperature');
        $sheet->setCellValue('C1', 'Average Wind Speed');
        $sheet->setCellValue('D1', 'Top Precipitation');
        $sheet->setCellValue('E1', 'Avg H2O per kg of Air');

        $dates = Date::all();
        $weatherData = WeatherData::all();

        // Populate data
        $row = 2;
        foreach ($dates as $date) {
            $sheet->setCellValue('A' . $row, $date->date);
            $sheet->setCellValue('B' . $row, $this->getMinimumTemperature($weatherData, $date->date));
            $sheet->setCellValue('C' . $row, $this->getAverageWindSpeed($weatherData, $date->date));
            $sheet->setCellValue('D' . $row, $this->getTopPrecipitation($weatherData, $date->date));
            // Calculate and set the average grams of H2O per kg of air
            $sheet->setCellValue('E' . $row, $this->calculateAverageH2O($weatherData, $date->date));
            $row++;
        }

        // Create a response and set headers
        $response = response('', 200);
        $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->header('Content-Disposition', 'attachment;filename="weather_data.xlsx');

        // Save the Spreadsheet to a file in memory and return it
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        $response->setContent($content);

        return $response;
    }

// Helper function to get minimum temperature for a specific date
    private function getMinimumTemperature($weatherData, $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0; // Handle the case when the date is not found
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0; // Handle the case when weather data is not found
        }

        return $weatherDataEntry->temperature_celsius;
    }

// Helper function to get average wind speed for a specific date
    private function getAverageWindSpeed($weatherData, $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0; // Handle the case when the date is not found
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0; // Handle the case when weather data is not found
        }

        return $weatherDataEntry->wind_speed;
    }

// Helper function to get top precipitation for a specific date
    private function getTopPrecipitation($weatherData, $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0; // Handle the case when the date is not found
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0; // Handle the case when weather data is not found
        }

        return $weatherDataEntry->precipitation_millimeter;
    }

// Helper function to calculate average grams of H2O per kg of air for a specific date
    private function calculateAverageH2O($weatherData, $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0; // Handle the case when the date is not found
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0; // Handle the case when weather data is not found
        }

        // Implement your calculation for average grams of H2O per kg of air
        // Example: Calculate it based on the humidity and other factors
        $humidity = $weatherDataEntry->humidity_percent;
        // Implement your calculation logic here
        return $humidity;
    }

}
