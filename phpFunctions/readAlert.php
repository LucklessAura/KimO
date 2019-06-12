<?php
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $userId = $_SESSION['userId'];
  $query = "SELECT username,alerttype FROM alertmessage WHERE parentid = $userId";
  $statement = oci_parse($conn, $query);
  oci_execute($statement);
  $found=0;
  while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))
  {
      $found=1;
      $result = implode(";", $row);
        print_r($result);
        echo '&';
  }
  if($found==0)
  {
      echo '-1';
  }
  $query = "delete FROM alertmessage WHERE parentid = $userId";
  $statement = oci_parse($conn, $query);
  oci_execute($statement);
?>