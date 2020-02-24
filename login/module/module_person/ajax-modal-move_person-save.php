<?php
if(!empty($_GET['per_cardno']) && !empty($_GET['org_id'])){
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";

$person = new person;

$result = $person->OrgArrange($_GET['org_id']);
// echo "<pre>";
// print_r($result);
// echo "</pre>";
$s = $person->OrgAdd($_GET['per_cardno'],$result['result']);
//echo $s['result'];

echo json_encode($s);

}