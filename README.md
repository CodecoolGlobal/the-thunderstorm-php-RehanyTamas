# The Thunderstorm

This project involves creating a weather data application for statistical analysis, including tasks such as generating weather data, designing a normalized database schema with multiple tables, Excel file generation, and creating an endpoint for statistical data retrieval. Additionally, the application is containerized.

## Used Technologies

- Laravel
- Laravel Sail
- Docker
- PhpSpreadsheet

## Usage

1. Navigate to the project directory
2. Copy the .env.example, change the variables in it to your own, and then name it simply .env
3. Create tables
    ```sh
   php artisan migrate
    ```
4. Generate weather data
    ```sh
   php artisan make:weather:data
    ```
5. Transfer weather data to the database
    ```sh
   php artisan store:weather:data
    ```
6. Start the development server (You can host this on other technologies, i.e., Apache; you don't have to use the development server)
    ```sh
    php artisan serve
    ```
7. Get your spreadsheet
   The Excel spreadsheet with the weather data is available on the '/stat/excel' endpoint of the server.

## Addendum

The project also contains a Dockerfile, with which you can containerize the application.
