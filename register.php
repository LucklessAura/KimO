<?php
/*error_reporting(E_ERROR | E_PARSE);
session_start(); //starts all the sessions 
    if($_SESSION['userID'] != NULL) {
        header('Location: map.html'); //take user to the map page if already logged in
        }*/
/*session_start();
session_unset();
session_destroy();*/
?>


<!DOCTYPE html>
<html>


<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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

    require 'phpFunctions/notLoggedNavbar.php';
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

<script src="javascriptFunctions/register.js"></script>

<div class="accountCreation">
<p>Register</p>
<form id="registerForm">
    <input type="text" id="registerUsername" placeholder="User Name" onkeyup="ifValid()" required ><br></br>
  <input type="text" value="" id="registerEmail" placeholder="Email" onkeyup="ifValid()" required ><br><br>
  <button id ="registerButton" type="button" value="" onclick="RegisterFunction()" disabled="true">Register</button>
</form> 

</div>

<div class="rules">
     <p id = "validLong">Username should be at least 6 characters long and at most 20</p>
     <p id = "validEmail">Email should be valid</p>
     <p id = "notChild">username should not contain '_child'</p>
</div>

<p id="querryResult"></p>

</section>

</main>

</body>


</html>