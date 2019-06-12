<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $childId = $_SESSION['childId'];
  $query = " SELECT username,location,maxdist FROM supervisors WHERE id = (select supervisorid from children where children.id = $childId and rownum<=1) ";
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