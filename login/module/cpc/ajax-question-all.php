<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db  = new DbConn;
$sql = "SELECT question_code,question_title FROM `cpc_question` WHERE  question_status = 1 ";
$stm =  $db->conn->prepare($sql);

$stm->execute();
$queryResult = $stm->fetchAll();

$output = array('aaData' => array() );
foreach ($queryResult as $row) {
    $output['aaData'][] = $row;
	unset($row);
    
}

echo json_encode($output);