<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $userId = $_SESSION['userId'];
  $query = "SELECT username,location FROM children WHERE supervisorid = $userId";
  $statement = oci_parse($conn, $query);
  oci_execute($statement);
  while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
  {
      $result = implode(";", $row);
     print_r($result);
     echo '&';
  }
  die;
  ?>