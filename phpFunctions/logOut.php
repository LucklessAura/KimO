<?php
if(isset($_COOKIE['sessionId']) && isset($_COOKIE['token'])  )
{
    unset($_COOKIE['sessionId']);
    unset($_COOKIE['token']);
    setcookie('sessionId', null, time()-3600);
    setcookie('token', null, time()-3600);
}
session_start();
session_destroy();
?>