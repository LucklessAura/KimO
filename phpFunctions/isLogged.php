<?php

function isLogged()
{
    session_start();
    if(isset($_SESSION['userId']))
    {
        return true;
    }
    return false; 
}
?>