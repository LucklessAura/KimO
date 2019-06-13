<?php 
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  
  $childId = $_SESSION['childId'];
  $result="";
  $query = "begin SELECT range into :result FROM dangerspots WHERE supervisorid = (select supervisorId from children where id = $childId and rownum<=1) and rownum<=1; end;";

  $statement = oci_parse($conn, $query);
  oci_bind_by_name($statement,':result',$result,32);
  oci_execute($statement);
  $result=$result.'&';
  echo $result;
  $childId = $_SESSION['childId'];
  $query = "SELECT location FROM dangerspots WHERE supervisorid = (select supervisorId from children where id = $childId and rownum<=1)";
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
  ?>