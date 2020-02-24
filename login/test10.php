<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/kpi/class-kpi.php";

$kpi = new kpi;

$result = $kpi->noAccept(48,'ชื่อผู้บังคับบัญชา3',' 3comment ;lsdkf;alskdjf;lsadkf','3วันที่วฟสห่ดสฟหกด่หก');

echo "<pre>";
print_r($result);
echo "</pre>";