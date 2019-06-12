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
    require 'phpFunctions/loggedNavbar.php';
	session_start();
	if(!isset($_SESSION['userId']))
	{
		header('Location: login.php');
	}
?>

<aside>
    <br><br>
    <label for="distance">Maximim distance between you and children(in meters) :</label>
    <input type="number" id="distance" name="distance" min="0" value="500">
     <br><br>
    <label for="distance">Danger points range(in meters) :</label>
    <input type="number" id="dangerRange" name="distance" min="0" value="100">

</aside>


<section>

<div id="map-container">

    
<audio id="alert" src="alarm.mp3" preload="auto"></audio>

<script src="ol/build/ol.js"></script>	

<script src="javascriptFunctions/receveAlert.js"> </script>

<script src="javascriptFunctions/mapLoggedSupervisor.js"> </script>

</div>

</section>


</main>

</body>

</html>
