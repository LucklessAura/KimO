<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  if(!isset($_SESSION['userId']))
  {
      session_reset();
      session_destroy();
      echo '-1';
  }
  $supervisorId = $_SESSION['userId'];
   
  $query = "SELECT username,location,lastupdate FROM children WHERE supervisorid = :supervisorId";
  $statement = oci_parse($conn, $query);
  oci_bind_by_name($statement,':supervisorId',$supervisorId,32); 
  oci_execute($statement);
  while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
  {
     $result = implode(";", $row);
     print_r($result);
     echo '&';
  }
  die;
?>