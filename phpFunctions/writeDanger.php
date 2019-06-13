<?php 
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
   session_start();
  $sql = 'BEGIN insert into dangerspots(id,supervisorid,range,location) values (dangerspotsid.nextval,:sId,:range,:location); END;';
  $stmt = oci_parse($conn,$sql);
  $userId = $_SESSION['userId'];
  oci_bind_by_name($stmt,':sId',$userId,32);
  oci_bind_by_name($stmt,':range',$_POST['range'],32);
  oci_bind_by_name($stmt,':location',$_POST['coords'],70);
  oci_execute($stmt);
?>