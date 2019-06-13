<?php
$conn = oci_connect('STUDENT','STUDENT','localhost/XE');
if(!$conn)
{
    echo '-2';
    die;
}
$username=$_POST['username'];
$link='http://' . $_SERVER['HTTP_HOST'];
if(strpos($username, '_child') == false)
{
    $sql = 'BEGIN issuerestcodesupervisors(:username,:response,:link); END;';
}
else
{
    $sql = 'BEGIN issuerestcodechild(:username,:response,:link); END;';
}
$stmt = oci_parse($conn,$sql);
oci_bind_by_name($stmt,':username',$username,32);
oci_bind_by_name($stmt,':response',$response,32);
oci_bind_by_name($stmt,':link',$link,50);
oci_execute($stmt);
if ($response==1)
{
    echo '-1';
    die;
}
if ($response==0)
{
    echo '1';
    die;
}
else
{
    echo '-3';
    die;
}
?>