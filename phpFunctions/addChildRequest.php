<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $username = $_POST['username'];
  $supervisorId = $_SESSION['userId'];
  $querryResponse = 0;
  $sql =  'BEGIN registerChild(:username,:supervisorId,:querryResponse); END;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':username',$username,100);
  oci_bind_by_name($stmt,':supervisorId',$supervisorId,50);
  oci_bind_by_name($stmt,':querryResponse',$response,32);
  oci_execute($stmt);
  switch ($response)
  {
      case 2:
      {
          echo '-1';
          break;
      }
      case 1:
      {
          echo '-3';
          break;
      }
      default:
      {
          echo '1';
          break;
      }
      
  }
?>