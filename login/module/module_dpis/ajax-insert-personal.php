<?php
include_once "../../config.php";
include_once "../../includes/ociConn.php";
include_once "../../includes/dbconn.php";
include_once "class-dpis.php";
include_once "../myClass.php";

if ($_POST['per_cardno'] != "") {
    $dpis = new dpis;
    $myClass = new myClass;

    $currentYear = $myClass->callYear();

    $personalTable = $currentYear['data']['per_personal'];

    $result = $dpis->queryPersonalType1($_POST['per_cardno']);
    // echo "<pre>";
    // print_r($result['result']);
    // echo "</pre>";
    $r = $dpis->queryPersonalType1($result['result'], $personalTable);
    if ($r['success'] === true) {
        echo json_encode($r);
    } else {
        $rr = $dpis->updatePer_PersonalType1($result['result'], $personalTable);
        echo json_encode($rr);
    }
}
