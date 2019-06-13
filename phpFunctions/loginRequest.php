 <?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  setcookie('sessionId', '', time()-3600);
  setcookie('token', '', time()-3600);
  if(!$conn)
  {
      echo '-2';
      die;
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $id = -1;
  if(strpos($username, '_child') == false)
  {
       $sql = 'BEGIN LogIn(:username,:password,:id); END;';
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
                $sql = 'BEGIN rememberLoginSupervisors(:sessionId,:token,:id); END;';
                $stmt = oci_parse($conn,$sql);
                oci_bind_by_name($stmt,':sessionId',$sessionId,50);
                oci_bind_by_name($stmt,':token',$token,50);
                oci_bind_by_name($stmt,':id',$id,32);
                oci_execute($stmt);
            }
            $_SESSION['userId'] = $id;
            echo '1';
            oci_close($conn);
            die;
        }
  }
  else
  {
      $sql = 'BEGIN LogInChild(:username,:password,:id); END;';
      $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':username',$username,32);
        oci_bind_by_name($stmt,':password',$password,32);
        oci_bind_by_name($stmt,':id',$id,32);
        oci_execute($stmt);

        if($id == -1)
        {
              session_start();
              session_unset();
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