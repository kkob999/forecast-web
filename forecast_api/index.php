<?php
include 'db.php';
$conn = OpenCon();
// echo "Connected Successfully";

$sql = " SELECT * FROM current_weather";
$sql_hr = "SELECT * FROM hourly_weather where id BETWEEN 
(SELECT id FROM hourly_weather hr, current_weather cr WHERE hr.time = cr.time) 
AND (SELECT id FROM hourly_weather hr, current_weather cr WHERE hr.time = cr.time)+4";

$sql_m = "SELECT * FROM weekly_weather WHERE id BETWEEN 0 AND 4";

$sql_day = "SELECT * FROM hourly_weather WHERE id IN (6,12,18,23)";

$result = $conn->query($sql);
$result_hr = $conn->query($sql_hr);
$result_m = $conn->query($sql_m);
$result_day = $conn->query($sql_day);


//close connection
CloseCon($conn);
?>


<?php
function linkResource($rel, $href)
{
  echo "<link rel='{$rel}' href='{$href}'>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Rubik:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <?php linkResource("stylesheet", "./style.css"); ?>
  <title>Current Weather</title>
</head>

<body>
  <div class="container" style="height: 100%; overflow: overflow-x: unset;">
    <!-- Navbar -->
    <div style="width: 20%; position: fixed; height: 100%;">
      <div class="nav">
        <ul>
          <li style=" margin-top: 20%;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30%" height="30%" viewBox="0 0 1024 1024" class="icon"
              version="1.1">
              <path
                d="M729.6 626.56S666.24 481.28 536.96 490.24c-1.28 0-152.96-4.48-179.84 189.44 0-1.28-161.28-15.36-172.16 106.24 1.28 0.64-12.8 156.8 190.72 143.36l445.44 0.768s179.84-75.264 106.88-220.16-198.4-83.328-198.4-83.328z"
                fill="#FFFFFF" />
              <path
                d="M739.968 413.184c0 47.872-9.856 93.568-27.648 134.912-6.144 14.336-13.312 28.16-21.248 41.472-29.184-49.28-82.944-82.432-144.128-82.432-90.368 0-164.096 71.936-167.296 161.408-0.128 2.048-0.128 3.968-0.128 6.016v0.512c0 2.048 0 4.096 0.128 6.144 0.64 14.592-13.952 25.088-27.52 20.224-1.792-0.64-3.328-1.28-5.12-1.792h-0.256c-0.512-0.256-1.024-0.256-1.664-0.512s-1.28-0.256-1.792-0.512c-1.28-0.256-2.304-0.64-3.584-0.896-7.168-1.664-14.592-2.56-22.144-2.816-26.88-0.512-51.712 8.832-71.04 24.704-12.928-6.4-25.344-13.568-37.248-21.504C116.992 637.056 56.192 532.352 56.192 413.184c0-188.8 153.088-341.76 341.888-341.76 188.8 0 341.888 152.96 341.888 341.76z m0 0"
                fill="#FFBC00" />
              <path
                d="M787.712 598.528c-15.488 0.128-30.464 2.176-44.672 5.888-13.184 3.456-25.856 8.448-37.632 14.848-0.256 0.128-0.256 0.384-0.256 0.64 0.256 0.768 0.512 1.664 0.768 2.432 0.256 0.512 0.256 1.024 0.512 1.536 0.256 0.768 0.512 1.792 0.768 2.56 4.864 16.128 22.016 25.344 38.144 19.968 0.64-0.256 1.28-0.384 1.792-0.64 1.024-0.256 2.048-0.64 2.944-0.896 1.024-0.256 1.92-0.64 2.944-0.768 9.216-2.432 18.816-3.968 28.672-4.48 81.664-3.968 149.12 65.152 142.976 146.688-4.864 63.744-53.504 115.328-115.712 124.672-6.656 1.024-13.568 1.536-20.48 1.536h-111.872c-0.512 0-0.768 0.64-0.256 0.896 29.44 24.064 66.688 38.784 107.264 39.936 1.664 0.128 3.328 0.128 4.864 0.128 6.912 0 13.696-0.384 20.48-1.152 88.576-10.24 157.44-85.888 157.056-177.28-0.384-97.536-80.64-176.896-178.304-176.512zM335.872 912.64h-20.48c-6.912 0-13.824-0.64-20.48-1.92-51.072-9.856-89.6-55.424-88.32-109.696 0.768-32.768 16.256-61.824 39.936-81.152 19.328-15.872 44.288-25.216 71.04-24.704 7.552 0.256 14.976 1.152 22.144 2.816 1.28 0.256 2.304 0.64 3.584 0.896 0.64 0.128 1.28 0.256 1.792 0.512 0.512 0.128 1.024 0.256 1.664 0.512h0.256c16.256 4.992 32.64-7.424 32.512-24.576v-0.512c0-2.048 0-4.096 0.128-6.016-12.544-6.016-26.112-10.24-40.192-12.544-7.808-1.28-15.744-1.92-23.936-1.92-41.344 0-78.976 16.896-106.112 44.16-26.88 27.136-43.648 64.384-43.648 105.6 0 75.52 56.32 138.368 129.28 148.224 5.248 0.768 10.496 1.152 15.744 1.28h0.256c1.408 0.128 2.944 0.128 4.352 0.128 1.536 0 3.072 0 4.608-0.128 37.888-1.152 72.448-16.512 98.176-40.832h-82.304z m0 0"
                fill="#6D6D6D" />
              <path
                d="M743.04 604.416c-7.424-20.352-17.664-39.296-30.72-56.192-38.144-49.792-98.048-81.92-165.504-81.92-108.672 0-198.144 83.584-207.616 189.696-0.512 6.144-0.768 12.416-0.768 18.688 0 7.808 0.384 15.616 1.28 23.168 1.28 0.256 2.304 0.64 3.584 0.896 0.64 0.128 1.28 0.256 1.792 0.512 0.512 0.128 1.024 0.256 1.664 0.512h0.256c1.792 0.512 3.328 1.152 5.12 1.792 13.696 4.864 28.16-5.632 27.52-20.224-0.128-2.048-0.128-4.096-0.128-6.144v-0.512c0-2.048 0-4.096 0.128-6.016 3.2-89.472 77.056-161.408 167.296-161.408 61.312 0 114.944 33.024 144.128 82.432 5.504 9.472 10.24 19.328 13.952 29.824 0 0.128 0.128 0.256 0.128 0.384 0.256 0.768 0.512 1.664 0.768 2.432 0.256 0.512 0.256 1.024 0.512 1.536 0.128 0.256 0.256 0.512 0.256 0.768 5.376 17.024 23.424 26.752 40.448 21.248 1.024-0.256 2.048-0.64 2.944-0.896 1.024-0.256 1.92-0.64 2.944-0.768-2.048-13.824-5.376-27.136-9.984-39.808zM788.48 912.64c-6.912 0-13.824 1.024-20.48 0H335.872c-2.304 0.384-4.352 0.512-6.656 0.512-4.48 0-9.088-0.512-13.824-0.512-6.912 0-13.824-0.64-20.48-1.92l15.744 42.752h478.72l19.712-42.368c-6.784 1.024-13.568 1.536-20.608 1.536z m0 0"
                fill="#6D6D6D" />
            </svg>
          </li>
          <li>
            <a href="index.php">current</a>
          </li>
          <li>
            <a href="hourly.php">hourly</a>
          </li>
          <li>
            <a href="weekly.php">weekly</a>
          </li>
          <li>
            <a href="weekend.php">weekend</a>
          </li>
          <li>
            <a href="monthly.php">monthly</a>
          </li>
          <li>
            <button class="fetch-btn" onclick="handleClick()">Fetch API</button>

            <script>
              function handleClick() {
                <?php
                // include 'db.php';
                $conn = OpenCon();
                // echo "Connected Successfully";
                
                $sql = " DELETE FROM current_weather";
                $conn->query($sql);


                //fetch array data
                $curl = curl_init();

                curl_setopt_array(
                  $curl,
                  array(
                    CURLOPT_URL => 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&timezone=GMT&null=null&hourly=temperature_2m%2Crelativehumidity_2m%2Cdewpoint_2m%2Cpressure_msl%2Ccloudcover%2Cwindspeed_10m%2Cweathercode%2Cvisibility&daily=temperature_2m_max%2Ctemperature_2m_min%2Cuv_index_max%2Csunrise%2Csunset',
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
                    CURLOPT_URL => 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&timezone=GMT&null=null&current_weather=true',
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
                document.getElementById("demo").innerHTML = "Delete Data";
              }

            </script>
            <p id="demo"></p>
          </li>
        </ul>
      </div>
    </div>

    <!-- main -->

    <div style="width: 80%; margin-left: 20%;">
      <!-- Search Bar -->
      <div class="search">
        <input type="text" placeholder="Enter city name">
        <button><img style="width: 30px; height: 30px;" src="./img/search.png"></button>
        <script>
          const searchBox = document.querySelector(".search input")
          const searchBtn = document.querySelector(".search button")
          async function handleClick(city) {
            let url = 'http://api.openweathermap.org/geo/1.0/direct?q=' + city + '&appid=207b5ebcf8768062b41364ba2f183b0d';
            const res = await fetch(url)
            const json = await res.json()
            // console.log(json[0].name + " " + json[0].lat)
            document.getElementById("city").innerHTML = " in " + json[0].name;
            return [json[0].name, json[0].lat, json[0].lon]

          }
          searchBtn.addEventListener("click", async () => {

            const data = await handleClick(searchBox.value);
            console.log(data[1].toFixed(2) + " and " + data[2].toFixed(2))
            //assign varaible
            document.cookie = "lat = " + data[1].toFixed(2);
            document.cookie = "lon = " + data[2].toFixed(2);

            <?php
            $conn = OpenCon();

            $sql = " DELETE FROM current_weather";
            $conn->query($sql);

            $lat = $_COOKIE['lat'];
            $lon = $_COOKIE['lon'];


            $curl = curl_init();
            $url_hr = 'https://api.open-meteo.com/v1/forecast?latitude=' . $lat . '&longitude=' . $lon . '&timezone=GMT&null=null&hourly=temperature_2m%2Crelativehumidity_2m%2Cdewpoint_2m%2Cpressure_msl%2Ccloudcover%2Cwindspeed_10m%2Cweathercode%2Cvisibility&daily=temperature_2m_max%2Ctemperature_2m_min%2Cuv_index_max%2Csunrise%2Csunset';

            curl_setopt_array(
              $curl,
              array(
                CURLOPT_URL => $url_hr,
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


            $curl = curl_init();

            $url_curr = 'https://api.open-meteo.com/v1/forecast?latitude=' . $lat . '&longitude=' . $lon . '&timezone=GMT&null=null&current_weather=true';

            curl_setopt_array(
              $curl,
              array(
                CURLOPT_URL => $url_curr,
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


            file_put_contents("current_weather.json", $response);


            $jsondata = file_get_contents('current_weather.json');


            $data = json_decode($jsondata, true);


            $time_arr = $data['hourly']['time'];


            $index = 0;

            for ($i = 0; $i < sizeof($time_arr); $i++) {
              if ($curr_time == substr($time_arr[$i], 11)) {
                $index = $i;
                break;
              }

            }


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



            CloseCon($conn);

            ?>
          })
        </script>
      </div>
      <!-- Card Section -->
      <?php
      while ($rows = $result->fetch_assoc()) {
        ?>
        <!-- current weather card -->
        <div class="card">
          <div style="margin-left: 30px; align-items: end;" class="flex-row">
            <h1 style="margin-right: 20px">Current Weather</h1>
            <h1 id="city">in london</h1>
          </div>


          <div class="flex-row" style="margin-left: 40px; justify-content: space-between; margin-right: 200px;">

            <div>

              <h1 style="margin-top: 20px; font-size: 40px;">
                <?php echo round($rows['temperature']) . "°C"; ?>
              </h1>

              <?php
              $d = "<div style=''>";
              $im = "<img style='height: 120px; width: 120px; margin: auto; display: block;'";
              $im_ovc = "<img style='height: 100px; width: 130px; margin: auto; display: block;'";
              switch ($rows['icon']) {

                case 0:
                  # code...
                  echo "<h2 class='txt-hr'>Clear Sky</h2>";
                  break;
                case 1:
                  echo "<h2 class='txt-hr'>Mainly clear</h2>";
                  break;
                case 2:
                  echo "<h2 class='txt-hr'>Partly Cloudy</h2>";
                  break;
                case 3:
                  echo "<h2 class='txt-hr'>Overcast</h2>";
                  break;
                case 45:
                  echo "<h2 class='txt-hr'>Fog</h2>";
                  break;
                case 48:
                  echo "<h2 class='txt-hr'>Depositing Rime Fog</h2>";
                  break;
                case 51:
                  //Drizzle Light
                  echo "<h2 class='txt-hr'>Drizzle Light</h2>";
                  break;
                case 53:
                  //Drizzle Moderate
                  echo "<h2 class='txt-hr'>Drizzle Moderate</h2>";
                  break;
                case 55:
                  //Drizzle Intense
                  echo "<h2 class='txt-hr'>Drizzle Dense Intensity</h2>";
                  break;
                case 56:
                  //Freezing Drizzle: Light
                  echo "<h2 class='txt-hr'>Freezing Drizzle Light</h2>";
                  break;
                case 57:
                  //Freezing Drizzle: intensity
                  echo "<h2 class='txt-hr'>Freezing Drizzle Intensity</h2>";
                  break;
                case 61:
                  //Rain Slight
                  echo "<h2 class='txt-hr'>Rain Slight</h2>";
                  break;
                case 63:
                  //Rain Moderate
                  echo "<h2 class='txt-hr'>Rain Moderate</h2>";
                  break;
                case 65:
                  //Rain Intense
                  echo "<h2 class='txt-hr'>Rain Intense</h2>";
                  break;
                case 66:
                  //Freezing Rain Light
                  echo "<h2 class='txt-hr'>Freezing Rain Light</h2>";
                  break;
                case 67:
                  //Freezing Rain Light
                  echo "<h2 class='txt-hr'>Freezing Rain Heavy Intensity</h2>";
                  break;
                case 71:
                  //Snow fall Slight
                  echo "<h2 class='txt-hr'>Snow Fall Slight</h2>";
                  break;
                case 73:
                  //Snow fall Moderate
                  echo "<h2 class='txt-hr'>Snow Fall Moderate</h2>";
                  break;
                case 75:
                  //Freezing Rain Light
                  echo "<h2 class='txt-hr'>Snow Fall Heavy Intensity</h2>";
                  break;
                case 77:
                  //Snow grains
                  echo "<h2 class='txt-hr'>Snow Grains</h2>";
                  break;
                case 80:
                  //Rain showers Slight
                  echo "<h2 class='txt-hr'>Rain Showers Slight</h2>";
                  break;
                case 81:
                  //Rain showers Moderate
                  echo "<h2 class='txt-hr'>Rain Showers Moderate</h2>";
                  break;
                case 82:
                  //Rain showers Violent
                  echo "<h2 class='txt-hr'>Rain Showers Violent</h2>";
                  break;
                case 85:
                  //Snow Shower slight
                  echo "<h2 class='txt-hr'>Rain Showers Slight</h2>";
                  break;
                case 86:
                  //Snow Shower heavy
                  echo "<h2 class='txt-hr'>Rain Showers Heavy</h2>";
                  break;
                case 95:
                  //Thunderstorm: Slight or moderate
                  echo "<h2 class='txt-hr'>Thunderstorm Slight or moderate</h2>";
                  break;
                case 96:
                  //Thunderstorm: Slight or moderate
                  echo "<h2 class='txt-hr'>Thunderstorm with Slight Hail</h2>";
                  break;
                case 99:
                  //Thunderstorm: Slight or moderate
                  echo "<h2 class='txt-hr'>Thunderstorm with Heavy Hail</h2>";
                  break;
                default:
                  # code...
                  echo "<h2 class='txt-hr'>-</h2>";
                  break;

              }

              ?>
            </div>
            <div>
            <?php
                $d = "<div>";
                $im = "<img style='height: 120px; width: 120px; margin: auto; display: block;'";
                $im_ovc = "<img style='height: 100px; width: 130px; margin: auto; display: block;'";
                switch ($rows['icon']) {

                  case 0:
                    # code...
                    echo $d . $im . " src='./img/Sun.png'></div>";
                    break;
                  case 1:
                    echo $d . $im . " src='./img/Sun.png'></div>";
                    break;
                  case 2:
                    echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                    break;
                  case 3:
                    echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                    break;
                  case 45:
                    echo $d . $im . " src='./img/Wind.png'></div>";
                    break;
                  case 48:
                    echo $d . $im . " src='./img/Wind.png'></div>";
                    break;
                  case 51:
                    //Drizzle Light
                    echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                    break;
                  case 53:
                    //Drizzle Moderate
                    echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                    break;
                  case 55:
                    //Drizzle Intense
                    echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                    break;
                  case 56:
                    //Freezing Drizzle: Light
                    echo $d . $im . " src='./img/Snow.png'></div>";
                    break;
                  case 57:
                    //Freezing Drizzle: intensity
                    echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                    break;
                  case 61:
                    //Rain Slight
                    echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                    break;
                  case 63:
                    //Rain Moderate
                    echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                    break;
                  case 65:
                    //Rain Intense
                    echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                    break;
                  case 66:
                    //Freezing Rain Light
                    echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                    break;
                  case 67:
                    //Freezing Rain Light
                    echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                    break;
                  case 71:
                    //Snow fall Slight
                    echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                    break;
                  case 73:
                    //Snow fall Moderate
                    echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                    break;
                  case 75:
                    //Freezing Rain Light
                    echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                    break;
                  case 77:
                    //Snow grains
                    echo $d . $im . " src='./img/Snow.png'></div>";
                    break;
                  case 80:
                    //Rain showers Slight
                    echo $d . $im . " src='./img/ShowerLight.png'></div>";
                    break;
                  case 81:
                    //Rain showers Moderate
                    echo $d . $im . " src='./img/ShowerMod.png'></div>";
                    break;
                  case 82:
                    //Rain showers Violent
                    echo $d . $im . " src='./img/ShowerVio.png'></div>";
                    break;
                  case 85:
                    //Snow Shower slight
                    echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                    break;
                  case 86:
                    //Snow Shower heavy
                    echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                    break;
                  case 95:
                    //Thunderstorm: Slight or moderate
                    echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                    break;
                  case 96:
                    //Thunderstorm: Slight or moderate
                    echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                    break;
                  case 99:
                    //Thunderstorm: Slight or moderate
                    echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                    break;
                  default:
                    # code...
                    echo $d . $im . " src='./img/none.png'></div>";
                    break;

                }

                ?>
            </div>

          </div>

          <div class="flex-row" style="margin-left: 40px; position: relative;">
            <h2 style="margin-right: 20px">Day
              <?php echo $rows['high_temp'] . "°C"; ?>
            </h2>
            <h2>Night
              <?php echo $rows['low_temp'] . "°C"; ?>
            </h2>
          </div>

        </div>
        <!-- Today Section -->
        <div class="card">
          <div style="margin-left: 40px;">
            <h1>Weather Today</h1>

            <div class="flex-row" style="justify-content: space-between;">

              <?php while ($row_day = $result_day->fetch_assoc()) {
                ?>
                <div class="hourly">
                  <h2>
                    <?php if ($row_day["id"] == 6) {
                      echo "Morning";
                    } elseif ($row_day["id"] == 12) {
                      echo "Afternoon";
                    } elseif ($row_day["id"] == 18) {
                      echo "Evening";
                    } else {
                      echo "Overnight";
                    } ?>
                  </h2>

                  <?php
                  $d = "<div style='height: 60%;'>";
                  $im = "<img style='height: 100px; width: 100px; margin: auto; display: block;'";
                  $im_ovc = "<img style='height: 90px; width: 120px; margin: auto; display: block;'";
                  switch ($row_day['icon']) {

                    case 0:
                      # code...
                      echo $d . $im . " src='./img/Sun.png'></div>";
                      break;
                    case 1:
                      echo $d . $im . " src='./img/Sun.png'></div>";
                      break;
                    case 2:
                      echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                      break;
                    case 3:
                      echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                      break;
                    case 45:
                      echo $d . $im . " src='./img/Wind.png'></div>";
                      break;
                    case 48:
                      echo $d . $im . " src='./img/Wind.png'></div>";
                      break;
                    case 51:
                      //Drizzle Light
                      echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                      break;
                    case 53:
                      //Drizzle Moderate
                      echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                      break;
                    case 55:
                      //Drizzle Intense
                      echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                      break;
                    case 56:
                      //Freezing Drizzle: Light
                      echo $d . $im . " src='./img/Snow.png'></div>";
                      break;
                    case 57:
                      //Freezing Drizzle: intensity
                      echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                      break;
                    case 61:
                      //Rain Slight
                      echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                      break;
                    case 63:
                      //Rain Moderate
                      echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                      break;
                    case 65:
                      //Rain Intense
                      echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                      break;
                    case 66:
                      //Freezing Rain Light
                      echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                      break;
                    case 67:
                      //Freezing Rain Light
                      echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                      break;
                    case 71:
                      //Snow fall Slight
                      echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                      break;
                    case 73:
                      //Snow fall Moderate
                      echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                      break;
                    case 75:
                      //Freezing Rain Light
                      echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                      break;
                    case 77:
                      //Snow grains
                      echo $d . $im . " src='./img/Snow.png'></div>";
                      break;
                    case 80:
                      //Rain showers Slight
                      echo $d . $im . " src='./img/ShowerLight.png'></div>";
                      break;
                    case 81:
                      //Rain showers Moderate
                      echo $d . $im . " src='./img/ShowerMod.png'></div>";
                      break;
                    case 82:
                      //Rain showers Violent
                      echo $d . $im . " src='./img/ShowerVio.png'></div>";
                      break;
                    case 85:
                      //Snow Shower slight
                      echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                      break;
                    case 86:
                      //Snow Shower heavy
                      echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                      break;
                    case 95:
                      //Thunderstorm: Slight or moderate
                      echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                      break;
                    case 96:
                      //Thunderstorm: Slight or moderate
                      echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                      break;
                    case 99:
                      //Thunderstorm: Slight or moderate
                      echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                      break;
                    default:
                      # code...
                      echo $d . $im . " src='./img/none.png'></div>";
                      break;

                  }

                  ?>

                  <div class="">

                    <h2>
                      <?php echo round($row_day['temperature']) . "°C" ?>
                    </h2>
                  </div>

                </div>
                <div class="vl"></div>

              <?php } ?>
            </div>
          </div>
        </div>




        <!-- weather today -->
        <div class="card">
          <h1 style="margin-left: 40px;">Weather Today</h1>
          <!-- top -->
          <div class="flex-row" style="margin-left: 40px;">
            <div style="width: 50%">
              <h1 style="font-size: 40px;">
                <?php echo round($rows['temperature']) . "°C" ?>
              </h1>
              <h2> Feel like</h2>
            </div>
            <div style="flex-grow: 1; margin-right: 40px;" class="txt-end">
              <svg style="margin-right: 22px; " height="60px" width="60px" version="1.1" id="Layer_1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                xml:space="preserve">
                <g>
                  <path style="fill:#B3D8F4;" d="M318.061,418.909H256h-62.061c-12.853,0-23.273,10.418-23.273,23.273
    c0,12.853,10.42,23.273,23.273,23.273H256h62.061c12.853,0,23.273-10.42,23.273-23.273
    C341.333,429.327,330.913,418.909,318.061,418.909z" />
                  <path style="fill:#B3D8F4;" d="M488.727,232.727h-54.481h-23.287h-23.327H256H124.368h-23.327H77.754H23.273
    C10.42,232.727,0,243.146,0,256c0,12.853,10.42,23.273,23.273,23.273h77.514h6.346H256h151.996h0.227h80.505
    C501.58,279.273,512,268.853,512,256C512,243.146,501.58,232.727,488.727,232.727z" />
                </g>
                <path style="fill:#FFB655;" d="M256,46.545c-98.383,0-178.424,80.04-178.424,178.424c0,2.586,0.068,5.174,0.178,7.758h23.287h23.327
  H256h131.632h23.327h23.287c0.112-2.585,0.178-5.171,0.178-7.758C434.424,126.585,354.383,46.545,256,46.545z" />
                <path style="fill:#B3D8F4;" d="M426.667,325.818H302.545c-12.853,0-23.273,10.418-23.273,23.273
  c0,12.853,10.42,23.273,23.273,23.273h124.121c12.853,0,23.273-10.42,23.273-23.273
  C449.939,336.237,439.519,325.818,426.667,325.818z" />
                <path style="fill:#EE8700;" d="M77.576,224.97c0,2.586,0.068,5.174,0.178,7.758h23.287h23.327H256V46.545
  C157.617,46.545,77.576,126.585,77.576,224.97z" />
                <g>
                  <path style="fill:#78B9EB;" d="M107.132,279.273h-6.346c1.049,0.147,2.112,0.242,3.191,0.242
    C105.019,279.515,106.074,279.417,107.132,279.273z" />
                  <path style="fill:#78B9EB;" d="M124.368,232.727h-23.327H77.754H23.273C10.42,232.727,0,243.146,0,256
    c0,12.853,10.42,23.273,23.273,23.273h77.514h6.346H256v-46.545H124.368z" />
                  <path style="fill:#78B9EB;" d="M170.667,442.182c0,12.853,10.42,23.273,23.273,23.273H256v-46.545h-62.061
    C181.087,418.909,170.667,429.327,170.667,442.182z" />
                  <path style="fill:#78B9EB;" d="M62.061,349.091c0,12.853,10.42,23.273,23.273,23.273h124.121c12.853,0,23.273-10.42,23.273-23.273
    c0-12.854-10.42-23.273-23.273-23.273H85.333C72.481,325.818,62.061,336.237,62.061,349.091z" />
                </g>
              </svg>
              <div class="flex-row txt-end" style="flex-grow: 1;">
                <p>
                  <?php echo substr($rows['sunrise'], 11) ?>
                </p>
                <p style="margin-left: 30px;">
                  <?php echo substr($rows['sunset'], 11) ?>
                </p>
              </div>
            </div>

          </div>
          <!-- bottom -->
          <div class="flex-row" style="margin-left: 40px; margin-top: 10px;">
            <!-- Left side -->
            <div style="width: 50%;">
              <!-- High/Low -->
              <div class="flex-row gap-hr" style="width: 100%; ">
                <img class="icon-hr" src="./img/temp-icon.png">
                <p>High/Low</p>
                <div style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <p>
                    <?php echo round($rows['high_temp']) . " / " . round($rows['low_temp']) . "°C" ?>
                  </p>
                </div>

              </div>
              <div class="flex-row gap-hr">
                <img class="icon-hr" src="./img/humid-icon.png">
                <p>Humidity</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo $rows['humid'] ?> %
                </p>
              </div>
              <div class="flex-row gap-hr">
                <img class="icon-hr" src="./img/pressure-icon.png">
                <p>Pressure</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo round($rows['pressure']) ?> mb
                </p>
              </div>
              <div class="flex-row gap-hr">
                <img class="icon-hr" src="./img/visibility-icon.png">
                <p>Visibility</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo round($rows['visibility']) ?> km
                </p>
              </div>

            </div>
            <!-- Right Side -->
            <div style="width: 50%;">
              <div class="flex-row gap-hr" style="width: 100%;">
                <img class="icon-hr" src="./img/wind-icon.png">
                <p class="txt-end">Wind</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo round($rows['wind_speed']) ?> km/h
                </p>
              </div>
              <div class="flex-row gap-hr">
                <img class="icon-hr" src="./img/humid-icon.png">
                <p>Dew Point</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo round($rows['dewpoint']) . " %" ?>
                </p>
              </div>
              <div class="flex-row gap-hr">
                <img class="icon-hr" src="./img/uv-icon.png">
                <p>UV Index</p>
                <p style="flex-grow: 1; margin-right: 40px;" class="txt-end">
                  <?php echo round($rows['uv']) ?> of 10
                </p>
              </div>

            </div>
          </div>

        </div>
        <?php
      }
      ?>
      <!-- hourly section -->
      <div class="card">
        <h1 style="margin-left: 40px;">Hourly Weather</h1>

        <div class="flex-row" style="justify-content: space-between;">

          <?php while ($row_hr = $result_hr->fetch_assoc()) {
            ?>
            <div class="hourly">
              <h2>
                <?php if ($row_hr["id"] == $index) {
                  echo "Now";
                } else {
                  echo substr($row_hr['time'], 11);
                } ?>
              </h2>

              <?php
              $d = "<div style='height: 60%;'>";
              $im = "<img style='height: 100px; width: 100px; margin: auto; display: block;'";
              $im_ovc = "<img style='height: 90px; width: 120px; margin: auto; display: block;'";
              switch ($row_hr['icon']) {

                case 0:
                  # code...
                  echo $d . $im . " src='./img/Sun.png'></div>";
                  break;
                case 1:
                  echo $d . $im . " src='./img/Sun.png'></div>";
                  break;
                case 2:
                  echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                  break;
                case 3:
                  echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                  break;
                case 45:
                  echo $d . $im . " src='./img/Wind.png'></div>";
                  break;
                case 48:
                  echo $d . $im . " src='./img/Wind.png'></div>";
                  break;
                case 51:
                  //Drizzle Light
                  echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                  break;
                case 53:
                  //Drizzle Moderate
                  echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                  break;
                case 55:
                  //Drizzle Intense
                  echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                  break;
                case 56:
                  //Freezing Drizzle: Light
                  echo $d . $im . " src='./img/Snow.png'></div>";
                  break;
                case 57:
                  //Freezing Drizzle: intensity
                  echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                  break;
                case 61:
                  //Rain Slight
                  echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                  break;
                case 63:
                  //Rain Moderate
                  echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                  break;
                case 65:
                  //Rain Intense
                  echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                  break;
                case 66:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 67:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 71:
                  //Snow fall Slight
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 73:
                  //Snow fall Moderate
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 75:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 77:
                  //Snow grains
                  echo $d . $im . " src='./img/Snow.png'></div>";
                  break;
                case 80:
                  //Rain showers Slight
                  echo $d . $im . " src='./img/ShowerLight.png'></div>";
                  break;
                case 81:
                  //Rain showers Moderate
                  echo $d . $im . " src='./img/ShowerMod.png'></div>";
                  break;
                case 82:
                  //Rain showers Violent
                  echo $d . $im . " src='./img/ShowerVio.png'></div>";
                  break;
                case 85:
                  //Snow Shower slight
                  echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                  break;
                case 86:
                  //Snow Shower heavy
                  echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                  break;
                case 95:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                  break;
                case 96:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                  break;
                case 99:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                  break;
                default:
                  # code...
                  echo $d . $im . " src='./img/none.png'></div>";
                  break;

              }

              ?>

              <div class="">

                <h2>
                  <?php echo round($row_hr['temperature']) . "°C" ?>
                </h2>
              </div>

            </div>
            <div class="vl"></div>

          <?php } ?>

        </div>
      </div>
      <!-- weekly section -->
      <div class="card">
        <h1 style="margin-left: 40px;">Weekly Weather</h1>
        <div class="flex-row" style="justify-content: space-between;">
          <?php while ($row_m = $result_m->fetch_assoc()) { ?>

            <div class="hourly">
              <h2>
                <?php
                $date = substr($row_m['time'], 0, 10);
                $unixTimestamp = strtotime($date);
                $dayOfWeek = date("D", $unixTimestamp);
                echo $dayOfWeek . " " . substr($row_m['time'], 8);
                ?>
              </h2>
              <?php
              $d = "<div style='height: 60%;'>";
              $im = "<img style='height: 100px; width: 100px; margin: auto; display: block; align-self: center;'";
              $im_ovc = "<img style='height: 90px; width: 120px; margin: auto; display: block;'";
              switch ($row_m['icon']) {

                case 0:
                  # code...
                  echo $d . $im . " src='./img/Sun.png'></div>";
                  break;
                case 1:
                  echo $d . $im . " src='./img/Sun.png'></div>";
                  break;
                case 2:
                  echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                  break;
                case 3:
                  echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                  break;
                case 45:
                  echo $d . $im . " src='./img/Wind.png'></div>";
                  break;
                case 48:
                  echo $d . $im . " src='./img/Wind.png'></div>";
                  break;
                case 51:
                  //Drizzle Light
                  echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                  break;
                case 53:
                  //Drizzle Moderate
                  echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                  break;
                case 55:
                  //Drizzle Intense
                  echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                  break;
                case 56:
                  //Freezing Drizzle: Light
                  echo $d . $im . " src='./img/Snow.png'></div>";
                  break;
                case 57:
                  //Freezing Drizzle: intensity
                  echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                  break;
                case 61:
                  //Rain Slight
                  echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                  break;
                case 63:
                  //Rain Moderate
                  echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                  break;
                case 65:
                  //Rain Intense
                  echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                  break;
                case 66:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 67:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 71:
                  //Snow fall Slight
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 73:
                  //Snow fall Moderate
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 75:
                  //Freezing Rain Light
                  echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                  break;
                case 77:
                  //Snow grains
                  echo $d . $im . " src='./img/Snow.png'></div>";
                  break;
                case 80:
                  //Rain showers Slight
                  echo $d . $im . " src='./img/ShowerLight.png'></div>";
                  break;
                case 81:
                  //Rain showers Moderate
                  echo $d . $im . " src='./img/ShowerMod.png'></div>";
                  break;
                case 82:
                  //Rain showers Violent
                  echo $d . $im . " src='./img/ShowerVio.png'></div>";
                  break;
                case 85:
                  //Snow Shower slight
                  echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                  break;
                case 86:
                  //Snow Shower heavy
                  echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                  break;
                case 95:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                  break;
                case 96:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                  break;
                case 99:
                  //Thunderstorm: Slight or moderate
                  echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                  break;
                default:
                  # code...
                  echo $d . $im . " src='./img/none.png'></div>";
                  break;

              }

              ?>
              <h2>
                <?php echo round($row_m['high_temp']) . "°C" ?>
              </h2>
              <h3>
                <?php echo round($row_m['low_temp']) . "°C" ?>
              </h3>
            </div>

          <?php } ?>
        </div>

      </div>

    </div>

  </div>




</body>

</html>