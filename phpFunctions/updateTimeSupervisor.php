<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  
  $sql = 'BEGIN update dangerspots set range = :range where supervisorid=:sID; END;';
   $stmt = oci_parse($conn,$sql);
   $userId = $_SESSION['userId'];
   oci_bind_by_name($stmt,':range',$_POST['range'],32);
   oci_bind_by_name($stmt,':sId',$userId,32);
   oci_execute($stmt);
   
  $userId = $_SESSION['userId'];
  $location = $_POST['coords'];
  $distance = $_POST['distance'];
  echo '+'.$userId.'+';
  $sql = 'BEGIN update supervisors set lastupdate = systimestamp,location = :location,MAXDIST = :distance where id = :uid; END;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':uid',$userId,32);
  oci_bind_by_name($stmt,':location',$location,60);
  oci_bind_by_name($stmt,':distance',$distance,60);
  oci_execute($stmt);
  echo '1';
  die;
  ?>