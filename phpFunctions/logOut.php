<?php
if(isset($_COOKIE['sessionId']) && isset($_COOKIE['token'])  )
{
    setcookie('sessionId', '', time()-3600);
    setcookie('token', '', time()-3600);
}
session_start();
session_destroy();
?>