<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
<title>Weather app </title>

<style>
body {
    font-family: Arial;
    font-size: 0.95em;
    color: #1467e4;
}

.report-container {
    border: #E0E0E0 1px solid;
    padding: 20px 40px 40px 40px;
    border-radius: 2px;
    width: 550px;
    margin: 0 auto;
}

.weather-icon {
    vertical-align: middle;
    margin-right: 20px;
}

.weather-forecast {
    color: #212121;
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0px;
}

span.min-temperature {
    margin-left: 15px;
    color: #929292;
}

.time {
    line-height: 25px;
}
</style>

</head>
<body>

    <div class="report-container">
        <h2><?php echo $data->name; ?> Weather  </h2>
        <div class="time">
            <div><?php echo date("l g:i a",time()); ?></div>
            <div><?php echo date("jS F, Y",time()); ?></div>
            <div><?php echo ucwords($data->weather[0]->description); ?></div>
        </div>
        <div class="weather-forecast">
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                class="weather-icon" /> Temp Max :<?php echo ($data->main->temp_max)-273.15; ?>&deg;C<br><span
                class="min-temperature"> Temp Min : <?php echo ($data->main->temp_min)-273.15; ?>&deg;C</span>
        </div>
        <div class="time">
            <div>Humidity: <?php echo $data->main->humidity; ?> %</div>
            <div>Wind: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
        
    </div>


</body>
</html>

