<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db  = new DbConn;
$sql = "SELECT question_no,question_code,question_title,question_type FROM `cpc_question` WHERE  question_status = 1 ";
$stm =  $db->conn->prepare($sql);

$stm->execute();
$queryResult = $stm->fetchAll();

$output = array('aaData' => array() );
foreach ($queryResult as $key => $row) {
    $r['question_code'] = $row['question_code'];
    $r['question_title'] = $row['question_title'];
    $r['button_select'] = " <button type='button' onclick='cpc_question_select(`".$row['question_no']."`,`".$row['question_title']."`,`".$row['question_type']."`)'>เลือก</button>";
    $output['aaData'][] = $r;
	unset($r);
    
}

echo json_encode($output);