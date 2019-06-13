<?php
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
   session_start();
   $sql = 'BEGIN delete from dangerspots where supervisorid=:sID; END;';
   $stmt = oci_parse($conn,$sql);
   $userId = $_SESSION['userId'];
   oci_bind_by_name($stmt,':sId',$userId,32);
   oci_execute($stmt);
   ?>