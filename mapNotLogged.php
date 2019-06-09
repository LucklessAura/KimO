<!DOCTYPE html>

<html>


<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"  href="ol/css/ol.css">
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
    if(isLogged() == true)
    {
        require 'phpFunctions/loggedNavbar.php';
    }
    else
    {
        require 'phpFunctions/notLoggedNavbar.php';
    }
?>

<aside>
<h2>News </h2>

<h3><b>KimO just reached international level</b><br>
<b>New update:added ability to see closest relative to your child</b><br>
<b>Child rescued by firefighters using KimO</b><br>
<b>New tracking app released today</b><br>
<b>Register now and you get a month for free</b><br>
<b>Parents around the globe satisfied with KimO</b><br>
<b>New update:better performance in map section</b><br>
<b>This is our new app KimO hope you enjoy it</b><br></h3>

</aside>


<section>

<div id="map-container">

<script src="ol/build/ol.js"></script>	


<script src="javascriptFunctions/mapNotLogged.js"> </script>

</div>

</section>


</main>

</body>

</html>
