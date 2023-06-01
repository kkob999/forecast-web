<?php
include 'db.php';
$conn = OpenCon();

$sql = "SELECT *  FROM hourly_weather WHERE id >= (SELECT h.id FROM hourly_weather h, current_weather c WHERE c.time = h.time)";
$sql_curr = " SELECT * FROM hourly_weather WHERE id = (SELECT h.id FROM hourly_weather h, current_weather c WHERE c.time = h.time)";
$result = $conn->query($sql);
$result_curr = $conn->query($sql_curr);

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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Hourly Weather</title>
</head>

<body>
    <div class="container" style="height: 100%; overflow: overflow-x: unset;">
        <!-- Navbar -->
        <div style="width: 20%; position: fixed; height: 100%;">
            <div class="nav">
                <ul>
                    <li style=" margin-top: 20%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30%" height="30%" viewBox="0 0 1024 1024"
                            class="icon" version="1.1">
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
            <!-- Search Box -->
            
            <!-- Card Section -->
            <div class="card">
                <div style="margin: 0 40px 0 40px;">
                    <?php while ($rows_curr = $result_curr->fetch_assoc()) {
                        $date = substr($rows_curr['time'], 0, 10);
                        $unixTimestamp = strtotime($date);
                        $dayOfWeek = date("l", $unixTimestamp);
                        ?>
                        <h2>
                            <?php
                            echo $dayOfWeek . ", " . substr($date, 8) . " ";
                            $datetime = DateTime::createFromFormat('Y-m-d', $date);
                            echo $datetime->format('F');
                            ?>
                        </h2>
                        <div class="flex-row ">
                            <div style="width: 15%; align-self: center;">
                                <p class="">
                                    <?php echo substr($rows_curr['time'], 11); ?>
                                </p>
                            </div>

                            <div style="width: 10%;" class="al flex-row">
                                <img style='height: 20px; width: 20px; align-self: center;' src="./img/temp-icon.png">
                                <p style="align-self: center;">
                                    <?php echo round($rows_curr['temperature']) . "°C"; ?>
                                </p>
                            </div>

                            <div style="width: 50%; align-self: center;">
                                <div class="flex-row">

                                    <?php
                                    $d = "<div style='width: 15%; margin-right: 2px;'>";
                                    $im = "<img style='height: 40px; width: 40px; margin: auto; display: block;'";
                                    $im_ovc = "<img style='height: 35px; width: 50px; margin: auto; display: block;'";
                                    switch ($rows_curr['icon']) {

                                        case 0:
                                            # code...
                                            echo $d . $im . " src='./img/Sun.png'></div>";
                                            echo "<p class='txt-hr'>Clear Sky</p>";
                                            break;
                                        case 1:
                                            echo $d . $im . " src='./img/Sun.png'></div>";
                                            echo "<p class='txt-hr'>Mainly clear</p>";
                                            break;
                                        case 2:
                                            echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                                            echo "<p class='txt-hr'>Partly Cloudy</p>";
                                            break;
                                        case 3:
                                            echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                                            echo "<p class='txt-hr'>Overcast</p>";
                                            break;
                                        case 45:
                                            echo $d . $im . " src='./img/Wind.png'></div>";
                                            echo "<p class='txt-hr'>Fog</p>";
                                            break;
                                        case 48:
                                            echo $d . $im . " src='./img/Wind.png'></div>";
                                            echo "<p class='txt-hr'>Depositing Rime Fog</p>";
                                            break;
                                        case 51:
                                            //Drizzle Light
                                            echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Light</p>";
                                            break;
                                        case 53:
                                            //Drizzle Moderate
                                            echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Moderate</p>";
                                            break;
                                        case 55:
                                            //Drizzle Intense
                                            echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Dense Intensity</p>";
                                            break;
                                        case 56:
                                            //Freezing Drizzle: Light
                                            echo $d . $im . " src='./img/Snow.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Drizzle Light</p>";
                                            break;
                                        case 57:
                                            //Freezing Drizzle: intensity
                                            echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Drizzle Intensity</p>";
                                            break;
                                        case 61:
                                            //Rain Slight
                                            echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                                            echo "<p class='txt-hr'>Rain Slight</p>";
                                            break;
                                        case 63:
                                            //Rain Moderate
                                            echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                                            echo "<p class='txt-hr'>Rain Moderate</p>";
                                            break;
                                        case 65:
                                            //Rain Intense
                                            echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                                            echo "<p class='txt-hr'>Rain Intense</p>";
                                            break;
                                        case 66:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Rain Light</p>";
                                            break;
                                        case 67:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Rain Heavy Intensity</p>";
                                            break;
                                        case 71:
                                            //Snow fall Slight
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Slight</p>";
                                            break;
                                        case 73:
                                            //Snow fall Moderate
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Moderate</p>";
                                            break;
                                        case 75:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Heavy Intensity</p>";
                                            break;
                                        case 77:
                                            //Snow grains
                                            echo $d . $im . " src='./img/Snow.png'></div>";
                                            echo "<p class='txt-hr'>Snow Grains</p>";
                                            break;
                                        case 80:
                                            //Rain showers Slight
                                            echo $d . $im . " src='./img/ShowerLight.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Slight</p>";
                                            break;
                                        case 81:
                                            //Rain showers Moderate
                                            echo $d . $im . " src='./img/ShowerMod.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Moderate</p>";
                                            break;
                                        case 82:
                                            //Rain showers Violent
                                            echo $d . $im . " src='./img/ShowerVio.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Violent</p>";
                                            break;
                                        case 85:
                                            //Snow Shower slight
                                            echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Slight</p>";
                                            break;
                                        case 86:
                                            //Snow Shower heavy
                                            echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Heavy</p>";
                                            break;
                                        case 95:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm Slight or moderate</p>";
                                            break;
                                        case 96:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm with Slight Hail</p>";
                                            break;
                                        case 99:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm with Heavy Hail</p>";
                                            break;
                                        default:
                                            # code...
                                            echo $d . $im . " src='./img/none.png'></div>";
                                            echo "<p class='txt-hr'>-</p>";
                                            break;

                                    }

                                    ?>
                                </div>
                            </div>

                            <div style="width: 30%; align-self: center;" class="al flex-row">
                                <div style="margin-right: 5%; width: 30%;;" class="flex-row">
                                    <img class="icon-hr" src="./img/rain-icon.png">
                                    <p>
                                        <?php echo round($rows_curr['rain']) . " %"; ?>
                                    </p>
                                </div>
                                <div class="flex-row">
                                    <img class="icon-hr" src="./img/wind-icon.png">
                                    <p>
                                        <?php echo "SSE " . round($rows_curr['wind_speed']) . " km/hr"; ?>
                                    </p>
                                </div>

                            </div>

                        </div>
                        <div class="bd">
                            <div class="flex-row ">
                                <div style="width: 25%;">
                                    <div class="txt-cen">
                                        <div class="flex-row txt-cen">
                                            <img class="icon-hr" src="./img/wind-icon.png">
                                            <p>Wind</p>
                                        </div>
                                        <p class="">
                                            <?php echo round($rows_curr['wind_speed']) . " km/hr"; ?>
                                        </p>
                                    </div>
                                </div>
                                <div style="width: 25%;" class="txt-cen">
                                    <div class="flex-row txt-cen">
                                        <img class="icon-hr" src="./img/humid-icon.png">
                                        <p>Humidity</p>
                                    </div>
                                    <?php echo $rows_curr['humid'] . " %"; ?>
                                </div>
                                <div style="width: 25%;" class="txt-cen">
                                    <div class="flex-row txt-cen">
                                        <img class="icon-hr" src="./img/uv-icon.png">
                                        <p>UV Index</p>
                                    </div>
                                    <?php echo round($rows_curr['uv']) . " of 10"; ?>
                                </div>
                                <div style="width: 25%;" class="txt-cen">
                                    <div class="flex-row txt-cen">
                                        <img class="icon-hr" src="./img/cloud-icon.png">
                                        <p>Cloud Cover</p>

                                    </div>
                                    <?php echo $rows_curr['cloudcover'] . " %"; ?>

                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>


            </div>

            <div class="card">
                <div style="margin: 0 40px 0 40px;">
                    <h1 id="city">in london</h1>
                    <?php while ($rows = $result->fetch_assoc()) { ?>
                        <div>
                            <?php while ($rows_curr = $result_curr->fetch_assoc()) {
                                $date = substr($rows['time'], 0, 10);
                                $unixTimestamp = strtotime($date);
                                $dayOfWeek = date("l", $unixTimestamp);
                                echo $dayOfWeek . ", " . $date; ?>

                            <?php } ?>
                        </div>

                        <?php
                        if (substr($rows['time'], 11) == "00:00") {
                            $date = substr($rows['time'], 0, 10);
                            $unixTimestamp = strtotime($date);
                            $dayOfWeek = date("l", $unixTimestamp);

                            $datetime = DateTime::createFromFormat('Y-m-d', $date);

                            ?>
                            <h2 style="margin-top: 15px;">
                                <?php echo $dayOfWeek . ", " . substr($date, 8) . " ";
                                echo $datetime->format('F'); ?>
                            </h2>
                        <?php } ?>


                        <div class="flex-row hourly-minicard">
                            <div style="width: 15%; align-self: center;">
                                <p class="">
                                    <?php echo substr($rows['time'], 11); ?>
                                </p>
                            </div>

                            <div style="width: 10%;" class="al flex-row">
                                <img style='height: 20px; width: 20px; align-self: center;' src="./img/temp-icon.png">
                                <p style="align-self: center;">
                                    <?php echo round($rows['temperature']) . "°C"; ?>
                                </p>


                            </div>
                            <div style="width: 50%; align-self: center;">
                                <div class="flex-row">

                                    <?php
                                    $d = "<div style='width: 15%; margin-right: 2px;'>";
                                    $im = "<img style='height: 40px; width: 40px; margin: auto; display: block;'";
                                    $im_ovc = "<img style='height: 35px; width: 50px; margin: auto; display: block;'";
                                    switch ($rows['icon']) {

                                        case 0:
                                            # code...
                                            echo $d . $im . " src='./img/Sun.png'></div>";
                                            echo "<p class='txt-hr'>Clear Sky</p>";
                                            break;
                                        case 1:
                                            echo $d . $im . " src='./img/Sun.png'></div>";
                                            echo "<p class='txt-hr'>Mainly clear</p>";
                                            break;
                                        case 2:
                                            echo $d . $im . " src='./img/PartlyCloud.png'></div>";
                                            echo "<p class='txt-hr'>Partly Cloudy</p>";
                                            break;
                                        case 3:
                                            echo $d . $im_ovc . " src='./img/MidClouds.png'></div>";
                                            echo "<p class='txt-hr'>Overcast</p>";
                                            break;
                                        case 45:
                                            echo $d . $im . " src='./img/Wind.png'></div>";
                                            echo "<p class='txt-hr'>Fog</p>";
                                            break;
                                        case 48:
                                            echo $d . $im . " src='./img/Wind.png'></div>";
                                            echo "<p class='txt-hr'>Depositing Rime Fog</p>";
                                            break;
                                        case 51:
                                            //Drizzle Light
                                            echo $d . $im . " src='./img/DrizzleLight.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Light</p>";
                                            break;
                                        case 53:
                                            //Drizzle Moderate
                                            echo $d . $im . " src='./img/DrizzleMod.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Moderate</p>";
                                            break;
                                        case 55:
                                            //Drizzle Intense
                                            echo $d . $im_ovc . " src='./img/DrizzleInten.png'></div>";
                                            echo "<p class='txt-hr'>Drizzle Dense Intensity</p>";
                                            break;
                                        case 56:
                                            //Freezing Drizzle: Light
                                            echo $d . $im . " src='./img/Snow.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Drizzle Light</p>";
                                            break;
                                        case 57:
                                            //Freezing Drizzle: intensity
                                            echo $d . $im_ovc . " src='./img/FrezzyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Drizzle Intensity</p>";
                                            break;
                                        case 61:
                                            //Rain Slight
                                            echo $d . $im_ovc . " src='./img/Rain.png'></div>";
                                            echo "<p class='txt-hr'>Rain Slight</p>";
                                            break;
                                        case 63:
                                            //Rain Moderate
                                            echo $d . $im_ovc . " src='./img/RainMod.png'></div>";
                                            echo "<p class='txt-hr'>Rain Moderate</p>";
                                            break;
                                        case 65:
                                            //Rain Intense
                                            echo $d . $im_ovc . " src='./img/RainVio.png'></div>";
                                            echo "<p class='txt-hr'>Rain Intense</p>";
                                            break;
                                        case 66:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Rain Light</p>";
                                            break;
                                        case 67:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Freezing Rain Heavy Intensity</p>";
                                            break;
                                        case 71:
                                            //Snow fall Slight
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Slight</p>";
                                            break;
                                        case 73:
                                            //Snow fall Moderate
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Moderate</p>";
                                            break;
                                        case 75:
                                            //Freezing Rain Light
                                            echo $d . $im_ovc . " src='./img/FreezyRain.png'></div>";
                                            echo "<p class='txt-hr'>Snow Fall Heavy Intensity</p>";
                                            break;
                                        case 77:
                                            //Snow grains
                                            echo $d . $im . " src='./img/Snow.png'></div>";
                                            echo "<p class='txt-hr'>Snow Grains</p>";
                                            break;
                                        case 80:
                                            //Rain showers Slight
                                            echo $d . $im . " src='./img/ShowerLight.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Slight</p>";
                                            break;
                                        case 81:
                                            //Rain showers Moderate
                                            echo $d . $im . " src='./img/ShowerMod.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Moderate</p>";
                                            break;
                                        case 82:
                                            //Rain showers Violent
                                            echo $d . $im . " src='./img/ShowerVio.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Violent</p>";
                                            break;
                                        case 85:
                                            //Snow Shower slight
                                            echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Slight</p>";
                                            break;
                                        case 86:
                                            //Snow Shower heavy
                                            echo $d . $im_ovc . " src='./img/SnowShower.png'></div>";
                                            echo "<p class='txt-hr'>Rain Showers Heavy</p>";
                                            break;
                                        case 95:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/Thunderstorm.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm Slight or moderate</p>";
                                            break;
                                        case 96:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm with Slight Hail</p>";
                                            break;
                                        case 99:
                                            //Thunderstorm: Slight or moderate
                                            echo $d . $im_ovc . " src='./img/ThunderSnow.png'></div>";
                                            echo "<p class='txt-hr'>Thunderstorm with Heavy Hail</p>";
                                            break;
                                        default:
                                            # code...
                                            echo $d . $im . " src='./img/none.png'></div>";
                                            echo "<p class='txt-hr'>-</p>";
                                            break;

                                    }

                                    ?>
                                </div>
                            </div>


                            <div style="width: 30%; align-self: center;" class="al flex-row">
                                <div style="margin-right: 5%;" class="flex-row">
                                    <img class="icon-hr" src="./img/rain-icon.png">
                                    <p>
                                        <?php echo round($rows['rain']) . " %"; ?>
                                    </p>
                                </div>
                                <div class="flex-row">
                                    <img class="icon-hr" src="./img/wind-icon.png">
                                    <p>
                                        <?php echo "SSE " . round($rows['wind_speed']) . " km/hr"; ?>
                                    </p>
                                </div>

                            </div>

                        </div>

                        <hr>

                    <?php } ?>
                </div>
            </div>
        </div>

    </div>




</body>

</html>