
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

<script src="javascriptFunctions/accountManagement.js">logOut()</script>
<br><br>
<form id="changePasswordForm">
  <input type="password" value="" id="newPassword" placeholder="Password" onkeyup="seeIfValid()" required ><br><br>
  <button id ="changePassword" type="button" value="" onclick="changePasswordRequest()" disabled="true">Change Password</button>
</form>
</div>

<div class="rules">
     <p id = "validLong">Password should be at least 6 characters long and at most 20 and no other special characters(except for rule 2)</p>
     <p id = "hasSymbol">Password should have at least 1 of the following symbols '-','!','&','.','$'</p>
     <p id = "hasUpperCase">Password should have at least one uppercase letter</p>
     <p id = "hasLowerCase">Password should have at least one lowercase letter</p>
     <p id = "hasNumber">Password should have at least one number</p>
</div>

<p id="response"></p>

</section>

</main>

</body>


</html>