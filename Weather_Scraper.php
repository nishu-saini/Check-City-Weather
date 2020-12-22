<?php
    $weather = ""; $error = "";

    if(array_key_exists('city',$_GET)) {
        
        # for city name more than 1 word replacing gap..
        $city = str_replace(' ', '', $_GET['city']);
        
        # get all the headers to check site is exists or not...
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        if(!$file_headers || $file_headers[0] == "HTTP/1.1 404 Not Found" || $file_headers[0] == "This site can't be reached") {
            $error = "<strong>Sorry!! This site can't be reached<br> Or This city could not be found</strong>";
            
        } else {
            # taking content from site weather-forecast and menupulate it in page..
            $forecastPage = @file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

            # $pageArray -> split content into array of string for given separating string
            $pageArray = explode('(1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',$forecastPage);
            
            if(sizeof($pageArray)>1) {
                # secondPageArray -> Again split in strings...
                $secondPageArray = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9"><div class="b-forecast__table-description-title"><h2>',$pageArray[1]);
                
                if(sizeof($secondPageArray)>1) {
                    $weather = $secondPageArray[0];
                    
                } else {
                    $error = "This site can't be reached right now";
                    
                }
                    
            } else {
                $error = "This site can't be reached right now";
                
            }
        }
    } 

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <title>Weather Scraper</title>  
      
    <!-- CSS style script -->
    <style type="text/css">
        html { 
            background: url(https://images.pexels.com/photos/2816057/pexels-photo-2816057.jpeg?auto=compress&cs=tinysrgb&h=650&w=940) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        
        #container {
            text-align: center;
            margin-top: 160px;
            
        }
        
        body {
            background: none;
            
        }
        
        #city {
            width: 400px;
            margin: 0 auto;
        }
        
        #weather {
            width: 400px;
            margin: 0 auto;
            margin-top: 20px;
            
        }
        
    </style>      
  </head>
    
  <body>
      
    <div id="container">
        <h1>What's The Weather?</h1>
        
        <!-- Form to enter city name by user -->
        <form>
            <div class="form-group">
                <label for="city">Enter The Name of a city</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Eg. Alwar, California">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <!-- Div for Weather Report display -->
        <div id="weather">
            <?php
                if($weather) {
                    echo '<div class="alert alert-success" role="alert"><p><strong>'.ucfirst($_GET["city"]).' Weather Today (1&ndash;3 days)</strong></p>'.$weather.'</div>';
                    
                } 
                
                if($error) {
                    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                    
                }
            ?>
        </div>
    </div>
        
    <!-- Optional JavaScript; choose one of the two! -->
      
      
    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
      
  </body>
</html>