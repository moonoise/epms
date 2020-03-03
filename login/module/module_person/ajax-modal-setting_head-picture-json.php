<?php
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-person.php";
include_once "../myClass.php";

$success = array();
$success['success'] = null;

$success['head_per_cardno'] = null;
$success['head_name'] = null;
$success['head_picname'] = null;

$person = new person;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$personalTable = $currentYear['data']['per_personal'];

$resultPerson = $person->personSelect($_POST['per_cardno'],$personalTable);
$perHead = $person->perHead($_POST['per_cardno'],$personalTable);

if ($resultPerson['success'] === true) {
    $success['success'] = true;
    $success['head_per_cardno'] = $resultPerson['result'][0]['per_cardno'];
    $success['head_name'] = $resultPerson['result'][0]['pn_name'].$resultPerson['result'][0]['per_name']." ".$resultPerson['result'][0]['per_surname'];
    $success['head_picname'] = $person->checkPicture(__PATH_PICTURE__.$resultPerson['result'][0]['per_picture']);
    
}

echo json_encode($success);