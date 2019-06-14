<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $userId = $_SESSION['userId'];
  $query = "SELECT username,location FROM children WHERE supervisorid = :userId and round((cast(current_timestamp as date) - cast(children.lastupdate as date))* 24 * 60) < :offlineTime ";
  $statement = oci_parse($conn, $query);
  oci_bind_by_name($statement,':offlineTime',$_POST['offlineTime'],32);
  oci_bind_by_name($statement,':userId',$userId,32); 
  oci_execute($statement);
  while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS))//get an array with all the children that have this supervisor as their assigned one
  {
      $result = implode(";", $row);
     print_r($result);
     echo '&';
  }
  die;
  ?>