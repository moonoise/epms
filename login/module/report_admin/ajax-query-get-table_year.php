<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
$db = new DbConn;

$years = $_POST['years'];
$errYears = "";

$resultTableYears = array("success" => null,
                    "result" => "",
                    "table_year" => "",
                    "msg" => "");

try {
    $sql_years = "SELECT * FROM `table_year` WHERE `table_year`.`table_year` = :years ";
    $stmYears = $db->conn->prepare($sql_years);
    $stmYears->bindParam(':years',$years);
    $stmYears->execute();
    $resultYears = $stmYears->fetchAll(PDO::FETCH_ASSOC);
    
} catch (\Exception $e) {
    $errYears = $e->getMessage();
}

if ($errYears != "") {

    $resultTableYears = array("success" => null,
                            "result" => null,
                            "msg" => $errYears);
}else {
    $resultTableYears = array("success" => true,
                            "result" => $resultYears[0],
                            "msg" => null);
}

echo json_encode($resultTableYears);

// echo "<pre>";
// print_r($resultTableYears);
// echo "</pre>";