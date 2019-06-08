<?php

function isLogged()
{
    if(isset($_SESSION['userID']))
    {
        return true;
    }
    return false;
    
}
?>