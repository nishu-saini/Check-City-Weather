<?php
    $weather = ""; $error = "";

    if(array_key_exists('city',$_GET)) {
        
        $city = str_replace(' ', '', $_GET['city']);
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        if(!$file_headers || $file_headers[0] == "HTTP/1.1 404 Not Found" || $file_headers[0] == "This site can't be reached") {
            $error = "<strong>Sorry!! This site can't be reached<br> Or This city could not be found</strong>";
            
        } else {
            $forecastPage = @file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

            $pageArray = explode('(1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',$forecastPage);
            
            if(sizeof($pageArray)>1) {
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
