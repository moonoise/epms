<?php
include_once "config.php";
include_once "ociConn.php";

//$pwMd5 = md5($mypassword);
$myusername = '1430900092313';
$ociSQL = "SELECT USERNAME,PASSWORD FROM USER_DETAIL where USERNAME = :username ";
$stid = oci_parse($ociConn,$ociSQL);

oci_bind_by_name($stid,':username',$myusername);
oci_execute($stid);
$nrows = oci_fetch_all($stid,$res);


   echo "<pre>";
   echo var_dump($res);
   echo "</pre>";



