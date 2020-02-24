<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db  = new DbConn;
$sql = "SELECT question_code,question_title FROM `cpc_question` WHERE question_title like :name and question_status = 1 ";
$stm =  $db->conn->prepare($sql);
$n = '%'.$_GET['name'].'%';
// echo $name;
$stm->bindParam(':name',$n,PDO::PARAM_STR);
$stm->execute();
$queryResult = $stm->fetchAll();

$output = array('aaData' => array() );
foreach ($queryResult as $row) {
    $output['aaData'][] = $row;

    
			unset($row);
    //unset($row);
}

echo json_encode($output);