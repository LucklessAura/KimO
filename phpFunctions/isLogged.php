<?php

function isLogged()
{
    session_start();
    if(isset($_COOKIE['sessionId']) && isset($_COOKIE['token']))//verify if the cookies are null
    {
        //if cookies are not null then verify if they are valid for a supervisor in the table 
        $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
        $seriesID = $_COOKIE['sessionId'];
        $token = $_COOKIE['token'];
        $sql = 'BEGIN isLoginValidSupervisors(:seriesID,:token,:response); END;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':seriesID',$seriesID,100);
        oci_bind_by_name($stmt,':token',$token,100);
        oci_bind_by_name($stmt,':response',$response,32);
        oci_execute($stmt);
        if($response > 0)
        {
            // if they are valid change their value(randomly) and put them in the table in the database in plce of the other pair
            $_SESSION['userId']=$response;
            $sessionId= mt_rand();
            $token = mt_rand();
            setcookie('sessionId', $sessionId, time() + (60*60*24*30),"/");
            setcookie('token', $token, time() + (60*60*24*30), "/");
            $sql = 'BEGIN rememberLoginSupervisors(:sessionId,:token,:id); END;';
            $stmt = oci_parse($conn,$sql);
            oci_bind_by_name($stmt,':sessionId',$sessionId,50);
            oci_bind_by_name($stmt,':token',$token,50);
            oci_bind_by_name($stmt,':id',$response,32);
            oci_execute($stmt);
            return 1;
        }
        else
        {
            //if the cookies were not valid for any supervisor check if they are valid for a child, the same process happens, if valid change them and replace in table
            $sql = 'BEGIN isLoginValidChildren(:seriesID,:token,:response); END;';
            $stmt = oci_parse($conn,$sql);
            oci_bind_by_name($stmt,':seriesID',$seriesID,100);
            oci_bind_by_name($stmt,':token',$token,100);
            oci_bind_by_name($stmt,':response',$response,32);
            oci_execute($stmt);
            if($response > 0)
            {
                $_SESSION['childId']=$response;
                $sessionId= mt_rand();
                $token = mt_rand();
                setcookie('sessionId', $sessionId, time() + (60*60*24*30), "/");
                setcookie('token', $token, time() + (60*60*24*30), "/");
                $sql = 'BEGIN rememberLoginChildren(:sessionId,:token,:id); END;';
                $stmt = oci_parse($conn,$sql);
                oci_bind_by_name($stmt,':sessionId',$sessionId,50);
                oci_bind_by_name($stmt,':token',$token,50);
                oci_bind_by_name($stmt,':id',$response,32);
                oci_execute($stmt);
                return 2;
            }
        }
    }
    
    //if there are no cookies see if the session id is set for either a child or a supervisor
    if(isset($_SESSION['userId']) || isset($_SESSION['childId']))
    {
        if(isset($_SESSION['userId']) )
        {
            return 1;
        }
        return 2;
    }
    return 0; 
}
?>