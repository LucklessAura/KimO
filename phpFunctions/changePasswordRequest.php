<?php
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;    
  }
   $response=0;
   $password = $_POST['password'];
   $code = $_POST['code'];
   $sql = 'BEGIN IsCodeValid(:code,:response); END;';
   $stmt = oci_parse($conn,$sql);
   oci_bind_by_name($stmt,':code',$code,1000);
   oci_bind_by_name($stmt,':response',$response,32);
   oci_execute($stmt);
   if($response==1)
   {
       $sql = 'BEGIN changePass(:code,:password,:response); END;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':code',$code,1000);
        oci_bind_by_name($stmt,':password',$password,32);
        oci_bind_by_name($stmt,':response',$response,32);
        oci_execute($stmt);
        if($response == 1)
        {
            echo '1';
        }
   }
   else
   {
       echo '-1';
       die;
   }
?>