<?php
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
  {
      echo '-2';
      die;
  }
  session_start();
  $childId = $_SESSION['childId'];
  $sId =-1;
  $sql = 'begin select supervisorid into :sId from children where :childId = id and rownum<=1; end;';
  $stmt = oci_parse($conn,$sql);
  oci_bind_by_name($stmt,':sId',$sId,32);
  oci_bind_by_name($stmt,':childId',$childId,32);
  oci_execute($stmt);
  if($sId == -1)
  {
      echo '-1';
  }
  else
  {
      $childUsername="";
      $sql = 'begin select username into :childUsername from children where :childId = id and rownum<=1; end;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':childUsername',$childUsername,32);
        oci_bind_by_name($stmt,':childId',$childId,32);
        oci_execute($stmt);
      $code = $_POST['code'];
      $sql = 'insert into alertmessage (id,parentid,alerttype,username) values (allertmessageid.nextval,:sId,:code,:childUsername)';
      $stmt = oci_parse($conn,$sql);
      oci_bind_by_name($stmt,':sId',$sId,32);
      oci_bind_by_name($stmt,':code',$code,32);
      oci_bind_by_name($stmt,':childUsername',$childUsername,32);
      oci_execute($stmt);
      echo '1';
  }
?>