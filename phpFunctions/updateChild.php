<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $childId = $_SESSION['childId'];
  $location = $_POST['coords'];
  $sql = 'BEGIN update children set lastupdate = systimestamp,location = :location where id = :uid; END;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':uid',$childId,32);
  oci_bind_by_name($stmt,':location',$location,60);
  oci_execute($stmt);
  echo '1';
  die;
  ?>