## Tables

### Date Table
- **id (Primary Key):** Unique identifier for each date.
- **date:** The date.
- **name:** The name of the day (ex.: Mon, Tue, Wes).
- **data_id (Foreign Key):** Weather data for this date.

### WeatherData Table
- **id (Primary Key):** Unique identifier for each weather data entry.
- **temperature_celsius:** The average temperature data in degrees Celsius.
- **precipitation_millimeter:** The average amount of precipitation in millimeters.
- **humidity_percent:** The average humidity data as a percentage.
- **wind_speed:** The average wind speed in km/h.
