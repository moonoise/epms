<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";
$db = new DbConn;


$myClass = new myClass;
$yearById = $myClass->callYearByID($_POST['years']);


echo json_encode($yearById);

// echo "<pre>";
// print_r($resultTableYears);
// echo "</pre>";