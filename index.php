
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
    require 'phpFunctions/isLogged.php';
    if(isLogged())
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
<br><br>
<img src="images/logo.png" class="logo" alt="logo">
<br><br><br><br>
<h4>
 KimO is your personal automated kid monitor that can help you supervise your kid's daily activities <br>
 KimO uses a GPS system to monitor the current position of your child with just a glance at your screen <br>
 KimO will use your personal plans of a building or street <br>
 With KimO you can set areas on your map as 'dangerous', when your child will come in the radius of those spots an allert will anounce you about it <br>
 KimO will keep tabs about your child's activity trought the day, all information beeing accesible trough the 'Details Child' page <br>
</h4>
<h1>Make child supervision easy with KimO</h1>
</section>

</main>

</body>


</html>