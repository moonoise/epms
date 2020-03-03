<?php
if(!empty($_GET['per_cardno']) && !empty($_GET['org_id'])){
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";
include_once "../myClass.php";

$person = new person;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$personalTable = $currentYear['data']['per_personal'];

$result = $person->OrgArrange($_GET['org_id']);
// echo "<pre>";
// print_r($result);
// echo "</pre>";
$s = $person->OrgAdd($_GET['per_cardno'],$result['result'],$personalTable);
//echo $s['result'];

echo json_encode($s);

}