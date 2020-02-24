<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/kpi/class-kpi.php";

$kpi = new kpi;

$result = $kpi->kpiBtnStatus2('283',__year__);

if ($result['success'] === null) {
    echo "null";
}elseif ($result['success'] === false) {
    echo "false";
}


echo "<pre>";
print_r($result);
echo "</pre>";