<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-cpc.php";
$success = array();

$cpc = new cpc;
$dataSet = array('per_cardno' => '3100201656560',
                 'years' => __year__,
                'soft_delete' => 0
                );
$result = $cpc->cpcScoreSelect($dataSet);

echo "<pre>";
   print_r($result);
echo "</pre>";