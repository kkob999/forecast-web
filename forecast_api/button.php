<?php 
function handleClickHour()
{
    # code...
    include 'db.php';
$conn = OpenCon();


$sql = "DELETE FROM hourly_weather";
$conn->query($sql);

//fetch array data
$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&timezone=GMT&null=null&hourly=temperature_2m%2Crelativehumidity_2m%2Cdewpoint_2m%2Cpressure_msl%2Ccloudcover%2Cwindspeed_10m%2Cweathercode%2Cvisibility%2Cprecipitation_probability&forecast_days=3&daily=temperature_2m_max%2Ctemperature_2m_min%2Cuv_index_max%2Csunrise%2Csunset',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    )
);

$response = curl_exec($curl);

curl_close($curl);


//convert json object to php associative array
$data = json_decode($response, true);
//get time array
$time_arr = $data['hourly']['time'];

//compare curr_time and time_array
$j = 0;
for ($i = 0; $i < sizeof($time_arr); $i++) {
    //asign value
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $temperature = $data['hourly']['temperature_2m'][$i];
    $humid = $data['hourly']['relativehumidity_2m'][$i];
    $dewpoint = $data['hourly']['dewpoint_2m'][$i];
    $cloudcover = $data['hourly']['cloudcover'][$i];
    $pressure = $data['hourly']['pressure_msl'][$i];
    $wind_speed = $data['hourly']['windspeed_10m'][$i];
    $rain = $data['hourly']['precipitation_probability'][$i];
    $icon = $data['hourly']['weathercode'][$i];
    $visibility = $data['hourly']['visibility'][$i];
    $time = $data['hourly']['time'][$i];


    if ($i % 24 == 0) {
        $high_temp = $data['daily']['temperature_2m_max'][$j];
        $low_temp = $data['daily']['temperature_2m_min'][$j];
        $uv = $data['daily']['uv_index_max'][$j];
        $sunset = $data['daily']['sunset'][$j];
        $sunrise = $data['daily']['sunrise'][$j];
        $j++;
    }


    // insert into mysql table
    $sql = "INSERT INTO hourly_weather(id, latitude, longitude, temperature, humid, dew_point, cloudcover, pressure, wind_speed, rain, icon, visibility,high_temp,low_temp,uv,sunrise,sunset,time)
VALUES('$i','$latitude', '$longitude', '$temperature', '$humid', '$dewpoint', '$cloudcover', '$pressure', '$wind_speed', '$rain', '$icon', '$visibility', '$high_temp', '$low_temp', '$uv', '$sunrise', '$sunset', '$time')";
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT *  FROM hourly_weather WHERE id >= (SELECT h.id FROM hourly_weather h, current_weather c WHERE c.time = h.time)";
        $sql_curr = " SELECT * FROM hourly_weather WHERE id = (SELECT h.id FROM hourly_weather h, current_weather c WHERE c.time = h.time)";
        $result = $conn->query($sql);
        $result_curr = $conn->query($sql_curr);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

//close connection
CloseCon($conn);
}
?>


<?php
          $conn = OpenCon();
          // echo "Connected Successfully";
          
          $sql = " DELETE FROM current_weather";
          $conn->query($sql);
          
          $lat= $_COOKIE['lat'];
          $lon= $_COOKIE['lon'];

          //fetch array data
          $curl = curl_init();

          curl_setopt_array(
            $curl,
            array(
              CURLOPT_URL => `https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&timezone=GMT&null=null&hourly=temperature_2m%2Crelativehumidity_2m%2Cdewpoint_2m%2Cpressure_msl%2Ccloudcover%2Cwindspeed_10m%2Cweathercode%2Cvisibility&daily=temperature_2m_max%2Ctemperature_2m_min%2Cuv_index_max%2Csunrise%2Csunset`,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            )
          );

          $response = curl_exec($curl);

          curl_close($curl);

          //check current weather
          $curl = curl_init();

          curl_setopt_array(
            $curl,
            array(
              CURLOPT_URL => `https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&timezone=GMT&null=null&current_weather=true`,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            )
          );

          $result = curl_exec($curl);

          curl_close($curl);

          $curr = json_decode($result, true);
          $curr_time = substr($curr['current_weather']['time'], 11);

          //write json to file
          file_put_contents("current_weather.json", $response);

          //read the json file contents
          $jsondata = file_get_contents('current_weather.json');

          //convert json object to php associative array
          $data = json_decode($jsondata, true);

          //get time array
          $time_arr = $data['hourly']['time'];

          //compare curr_time and time_array
          $index = 0;

          for ($i = 0; $i < sizeof($time_arr); $i++) {
            if ($curr_time == substr($time_arr[$i], 11)) {
              $index = $i;
              break;
            }

          }

          //asign value
          $latitude = $data['latitude'];
          $longitude = $data['longitude'];
          $temperature = $data['hourly']['temperature_2m'][$index];
          $humid = $data['hourly']['relativehumidity_2m'][$index];
          $dewpoint = $data['hourly']['dewpoint_2m'][$index];
          $cloudcover = $data['hourly']['cloudcover'][$index];
          $pressure = $data['hourly']['pressure_msl'][$index];
          $wind_speed = $data['hourly']['windspeed_10m'][$index];
          $icon = $data['hourly']['weathercode'][$index];
          $visibility = $data['hourly']['visibility'][$index];
          $high_temp = $data['daily']['temperature_2m_max'][0];
          $low_temp = $data['daily']['temperature_2m_min'][0];
          $uv = $data['daily']['uv_index_max'][0];
          $sunset = $data['daily']['sunset'][0];
          $sunrise = $data['daily']['sunrise'][0];
          $time = $data['hourly']['time'][$index];



          // insert into mysql table
          $sql = "INSERT INTO current_weather(latitude, longitude, temperature, humid, dewpoint, cloudcover, pressure, wind_speed, icon, visibility,high_temp,low_temp,uv,sunrise,sunset, time)
VALUES('$latitude', '$longitude', '$temperature', '$humid', '$dewpoint', '$cloudcover', '$pressure', '$wind_speed', '$icon', '$visibility', '$high_temp', '$low_temp', '$uv', '$sunrise', '$sunset', '$time')";
          $conn->query($sql);

          $sql = " SELECT * FROM current_weather";
          $sql_hr = "SELECT * FROM hourly_weather where id BETWEEN 
(SELECT id FROM hourly_weather hr, current_weather cr WHERE hr.time = cr.time) 
AND (SELECT id FROM hourly_weather hr, current_weather cr WHERE hr.time = cr.time)+4";

          $sql_m = "SELECT * FROM weekly_weather WHERE id BETWEEN 0 AND 4";

          $result = $conn->query($sql);
          $result_hr = $conn->query($sql_hr);
          $result_m = $conn->query($sql_m);


          //close connection
          CloseCon($conn);
          ?>