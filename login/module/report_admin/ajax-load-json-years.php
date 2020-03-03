<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";
$success = array('success' => null,
                'result' => null,
                'msg' => null );
try {

    $myClass = new myClass;
    $currentYear = $myClass->callYears();
    $success['success'] = true;
    $success['result'] = $currentYear['data'];
    
} catch (Exception $e) {
    $success['success'] = null;
    $success['msg'] = $e;
}
echo json_encode($success);