
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
    // show navbar depending on who is connected
    require 'phpFunctions/isLogged.php';
    $result = isLogged();
    if($result > 0)
    {
        if($result == 1)
        {
             require 'phpFunctions/loggedSupervisorNavbar.php';
        }
        else
        {
            require 'phpFunctions/loggedChildNavbar.php';
        }
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
<script src="javascriptFunctions/newChild.js"></script>
<script src="javascriptFunctions/accountManagement.js"></script>

<br><br>
<button type="button" value="" id="logOut" onclick="logOut()">Log Out</button>
<button type="button" value="" id="changePass" onclick="ResetPass()">Change Password</button>
</section>

</main>

</body>


</html>