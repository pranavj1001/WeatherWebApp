<?php

  $weather = "";
  $error = "";

  if (array_key_exists('cityName', $_GET)){

    $city = str_replace(' ', '', $_GET['cityName']);

    $file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {

        $error = "That city could not be found";

    }else{

      $displayPage = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");

      $pageArray1 = explode('7 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">' ,$displayPage);

      if(sizeof($pageArray1) > 1){

        $pageArray2 = explode('</span></span></span>', $pageArray1[1]);

        if(sizeof($pageArray2) > 1){

          $weather = $pageArray2[0];

        }else{

          $error = "That city could not be found";

        }

      }else{

        $error = "That city could not be found";

      }

    }

  }

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>
      Weather App
    </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="weatherCss.css">

  </head>

  <body>

    <h1> What's the Weather?</h1>

    <div class="container">
    <form id="form" method="get">
      <div class="form-group">
        <label for="cityName">Enter the name of the city</label>
        <div id="city">
          <input type="text" class="form-control" id="cityName" name="cityName" placeholder="City Name" value="<?php if (array_key_exists('cityName', $_GET)){echo $_GET['cityName'];}?>">
        </div>
      </div>
      <button type="submit" class="btn btn-default btn btn-primary">Submit</button>
      <div id="weather">
        <?php
          if($weather){
            echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
          }else if($error){
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
          }
        ?>
      </div>
    </form>
    </div>


    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>

  </body>
</html>