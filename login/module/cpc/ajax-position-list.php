<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db  = new DbConn;
$sql = "SELECT pl_code,pl_name FROM `per_line` WHERE pl_name like :name and pl_active = 1 ";
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