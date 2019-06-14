<!DOCTYPE html>

<html>


<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="ol/css/ol.css">
<link rel="stylesheet" media="(max-width: 949px)" href="css/lowRez.css">
<link rel="stylesheet" media="(min-width:950px)" href="css/styleSheet.css">
<link rel="icon" href="images/logoMic.png">
<title>KimO</title>
</head>

<body>

<main>

<input type="checkbox" id="newsButton">

<label for="newsButton">  </label>


<?php
    require 'phpFunctions/isLogged.php';
    $result = isLogged();
    if($result > 0)
    {
        if($result == 1)
        {
             header('Location: login.php');
        }
        else
        {
            require 'phpFunctions/loggedChildNavbar.php';
        }
    }
    else
    {
        header('Location: login.php');
    }
?>

<aside>
<h2>News </h2>
<script src="javascriptFunctions/sendAlert.js"></script>

<button type="button" value="" onclick="sendAlert(1)">Stranger danger</button>
<button type="button" value="" onclick="sendAlert(2)">Got hit by a car</button>
<button type="button" value="" onclick="sendAlert(3)">Hurt myself</button>
<button type="button" value="" onclick="sendAlert(4)">I'm lost</button>
<button type="button" value="" onclick="sendAlert(6)">Other SOS</button>

<p id ="alertMessage"></p>
</aside>


<section>
    
<audio id="alert" src="alarm.mp3" preload="auto"></audio>

<div id="map-container">

<script src="ol/build/ol.js"></script>	


<script src="javascriptFunctions/mapLoggedChild.js"> </script>
</div>

</section>


</main>

</body>

</html>
