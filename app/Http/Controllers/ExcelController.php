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
        $sheet->setCellValue('B1', 'Temperature');
        $sheet->setCellValue('C1', 'Wind Speed');
        $sheet->setCellValue('D1', 'Precipitation');
        $sheet->setCellValue('E1', 'Humidity');

        $dates = Date::all();

        // Populate data
        $row = 2;
        foreach ($dates as $date) {
            $sheet->setCellValue('A' . $row, $date->date);
            $sheet->setCellValue('B' . $row, $this->getTemperature( $date->date));
            $sheet->setCellValue('C' . $row, $this->getAverageWindSpeed( $date->date));
            $sheet->setCellValue('D' . $row, $this->getPrecipitation( $date->date));
            $sheet->setCellValue('E' . $row, $this->getHumidity( $date->date));
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

    private function getTemperature($date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0;
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0;
        }

        return $weatherDataEntry->temperature_celsius;
    }

    private function getAverageWindSpeed( $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0;
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0;
        }

        return $weatherDataEntry->wind_speed;
    }

    private function getPrecipitation( $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0;
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0;
        }

        return $weatherDataEntry->precipitation_millimeter;
    }
    private function getHumidity( $date)
    {
        $dateEntry = Date::where('date', $date)->first();
        if (!$dateEntry) {
            return 0;
        }

        $weatherDataEntry = WeatherData::find($dateEntry->data_id);
        if (!$weatherDataEntry) {
            return 0;
        }
        $humidity = $weatherDataEntry->humidity_percent;
        return $humidity;
    }

}
