<?php

function isLogged()
{
    session_start();
    if(isset($_COOKIE['sessionId']) && isset($_COOKIE['token']))
    {
        setcookie('sessionId', '', time()-3600);
        setcookie('token', '', time()-3600);
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