<?php
    if(array_key_exists('submit', $_GET)){

        if ($_GET['city']) {
            $apiData = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".
            $_GET['city']."&appid=7cb1990af10b895c9a918e010a818534");
              $weatherArray = json_decode($apiData, true);
              if($weatherArray['cod'] == 200){
                #Extraccion De Datos
                $cityName = $weatherArray['sys']['country'];
                $tempCelsius = $weatherArray['main']['temp'] - 273;
                $tempMax = $weatherArray['main']['temp_max'] - 273;
                $tempMin = $weatherArray['main']['temp_min'] - 273;
                $presAtmos = $weatherArray['main']['pressure'];
                $windSpeed = $weatherArray['wind']['speed'];
                $cloudAll = $weatherArray['clouds']['all'];

                #Ingles-Español
                $weather_desc = $weatherArray['weather']['0']['description'];
                if ($weather_desc == "overcast clouds") $weather_desc = "Cielo Nublado";
                if ($weather_desc == "clear sky") $weather_desc = "Cielo Despejado";
                if ($weather_desc == "scattered clouds") $weather_desc = "Cielo Disperso";
                if ($weather_desc == "light rain") $weather_desc = "lluvia ligera";
                if ($weather_desc == "few clouds") $weather_desc = "pocas nubes";
                if ($weather_desc == "broken clouds") $weather_desc = "nubes rotas";

                #Impresion De Datos
                $weather ="<b>".$weatherArray['name'].", " .$cityName.": ".intval($tempCelsius).
                "&deg;C</b> <br>";
                $weather .="<b>Condicion del clima: </b><p>".$weather_desc. "</b></p><br>";
                $weather .="<b>Temperatura Min: </b><p>".intval($tempMin). "&deg;C</p><br>";
                $weather .="<b>Temperatura Max: </b><p>".intval($tempMax). "&deg;C</p><br>";
                $weather .="<b>Presion Atmosferica: </b><p>".$presAtmos ."hPa</p><br> ";
                $weather .="<b>Velocidad del viento: </b><p>" .$windSpeed."M/S</p><br> ";
                $weather .="<b>Nubosidad: </b><p>" .$cloudAll." %</p><br>";
              } else{
                $error = "No se pudo procesar, el nombre de tu ciudad no es válido.";
              }
        }
        elseif (!$_GET['city']) {
          $error = "Su campo de entrada está vacío";
        }
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplicacion del clima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Aplicacion del clima</title>
  </head>
  <body>
  <video autoplay="autoplay" loop="loop" id="video_background" preload="auto" volume="50">
  <source src="ciudad-atardecer.mp4" type="video/mp4" />
  </video>
  <div class="container">
        <h1>Buscador Global del Clima</h1>
        <form action="" method="GET">
            <div class=op><label for="city">Ingrese el nombre de la ciudad</label>
            <input type="text" name="city" id="city" placeholder="Nombre de Ciudad"></div>
            <button type="submit" name="submit" class="btn btn-success">Buscar</button>
        </form>
        <div class="output">
            <?php 
              if ($weather){
                echo '<div class="impresion" ">
                '. $weather.' </div>';
              }
              elseif ($error) {
                echo '<div class="alert alert-danger" role="alert">
                '. $error.' </div>';
              }

            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>