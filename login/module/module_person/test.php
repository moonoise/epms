<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";
$success = array();

$person = new person;
// $dataSet = array('per_cardno' => '3100201656560',
//                  'orgID' => '22739'
//                 );
$result = $person->OrgArrange('21546');

$s = $person->OrgAdd('3100200325381',$result['result']);

echo "<pre>";
   print_r($result);
echo "</pre>";



echo "<pre>";
   print_r($s['result']);
echo "</pre>";

// 3100200325381   
// นางสาว
// ปุณยนุช
// ชวลิต