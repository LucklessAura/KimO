<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $userId = $_SESSION['userId'];
  echo '+'.$userId.'+';
  $sql = 'BEGIN update supervisors set lastupdate = systimestamp where id = :uid; END;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':uid',$userId,32);
  oci_execute($stmt);
  echo '1';
  die;
  ?>