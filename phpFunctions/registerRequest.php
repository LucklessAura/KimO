<?php
  $conn = oci_connect('STUDENT','STUDENT','localhost/XE');
  if(!$conn)
  {
      echo '-2';
      die;
  }
  $username = $_POST['username'];
  $email = $_POST['email'];
  $querryResponse = 0;
  $sql =  'BEGIN register(:username,:email,:querryResponse); END;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':username',$username,50);
  oci_bind_by_name($stmt,':email',$email,50);
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