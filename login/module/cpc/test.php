<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-cpc.php";
include_once "../myClass.php";
$success = array();

$cpc = new cpc;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpcScoreTable = $currentYear['data']['cpc_score'];
$year = $currentYear['data']['table_year'];

$dataSet = array('per_cardno' => '3100201656560',
                 'years' => $year,
                'soft_delete' => 0
                );
$result = $cpc->cpcScoreSelect($dataSet,$cpcScoreTable);

echo "<pre>";
   print_r($result);
echo "</pre>";