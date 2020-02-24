<?php
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "module/myClass.php";


$myClass = new myClass;

$r = $myClass->callYear();

echo "<pre>";
print_r($r);
echo "</pre>";