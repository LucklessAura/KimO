<?php 
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
   session_start();
  $sql = 'BEGIN delete from dangerspots where supervisorid=:uId and location = :location; END;';
  $stmt = oci_parse($conn,$sql);
  $userId = $_SESSION['userId'];
  oci_bind_by_name($stmt,':uId',$userId,32);
  oci_bind_by_name($stmt,':location',$_POST['coords'],70);
  echo $_POST['coords'];
  oci_execute($stmt);
?>