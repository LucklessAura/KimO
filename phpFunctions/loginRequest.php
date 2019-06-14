 <?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  //if we are on the login page delete all cookies if existent just in case
    unset($_COOKIE['sessionId']);
    unset($_COOKIE['token']);
    setcookie('sessionId', null, time()-3600);
    setcookie('token', null, time()-3600);
  if(!$conn)
  {
      echo '-2';
      die;
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $id = -1;
  if(strpos($username, '_child') == false)//chec if a supervisor or child tried to connect, all children have '_child' at the end of their username
  {
      //case for when a supervisor tries to connect
       $sql = 'BEGIN LogIn(:username,:password,:id); END;';
       $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':username',$username,32);
        oci_bind_by_name($stmt,':password',$password,32);
        oci_bind_by_name($stmt,':id',$id,32);
        oci_execute($stmt);

        if($id == -1)
        {
            //on worong login delete all possible session variables
            session_start();
            session_destroy();
            echo '-1';
            oci_close($conn);
            die;
        }
        else
        {
            //password username pair is valid
            session_start();
            $remember = $_POST['remember']; // verify if the user wants to be remembered , if yes create a pair of cookies(random numbers)
            if($remember == "true")
            {
                $sessionId= mt_rand();
                $token = mt_rand();
                setcookie('sessionId', $sessionId, time() + (60*60*24*30), "/");
                setcookie('token', $token, time() + (60*60*24*30), "/");
                $sql = 'BEGIN rememberLoginSupervisors(:sessionId,:token,:id); END;';//put in database the pair of numbers, also this deletes from the database if there was another pair assiged to the user id
                $stmt = oci_parse($conn,$sql);
                oci_bind_by_name($stmt,':sessionId',$sessionId,50);
                oci_bind_by_name($stmt,':token',$token,50);
                oci_bind_by_name($stmt,':id',$id,32);
                oci_execute($stmt);
            }
            $_SESSION['userId'] = $id;//also set the user id if 
            echo '1';
            oci_close($conn);
            die;
        }
  }
  else
  {
      //same process but for child
        $sql = 'BEGIN LogInChild(:username,:password,:id); END;';
      $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':username',$username,32);
        oci_bind_by_name($stmt,':password',$password,32);
        oci_bind_by_name($stmt,':id',$id,32);
        oci_execute($stmt);

        if($id == -1)
        {
              session_start();
              session_destroy();
            echo '-1';
            oci_close($conn);
            die;
        }
        else
        {
            session_start();
            $remember = $_POST['remember'];
            if($remember == "true")
            {
                $sessionId= mt_rand();
                $token = mt_rand();
                setcookie('sessionId', $sessionId, time() + (60*60*24*30), "/");
                setcookie('token', $token, time() + (60*60*24*30), "/");
                $sql = 'BEGIN rememberLoginChildren(:sessionId,:token,:id); END;';
                $stmt = oci_parse($conn,$sql);
                oci_bind_by_name($stmt,':sessionId',$sessionId,50);
                oci_bind_by_name($stmt,':token',$token,50);
                oci_bind_by_name($stmt,':id',$id,32);
                oci_execute($stmt);
            }
            $_SESSION['childId'] = $id;
            echo '2';
            oci_close($conn);
            die;
        }
  }
 ?>