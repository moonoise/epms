<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
$db = new DbConn;

$years = $_POST['years'];
$orgSelect = $_POST['org_id'];

$errYears = "";
$errPer_cardno = "";

$per_cardnoResult = array("success" => "",
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


try {
    if ($orgSelect == "77") {
        $sql = "select per_cardno from ".$resultYears[0]['per_personal'];
        $stm = $db->conn->prepare($sql);
        $stm->execute();
    }else {

        $sql2 = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id_2 = :org_id ";
        $stm2 = $db->conn->prepare($sql2);
        $stm2->bindParam(':org_id',$orgSelect);
        $stm2->execute();
        $result2 = $stm2->fetchAll(PDO::FETCH_COLUMN);

        if (count($result2) > 0) {
            $per_cardnoResult['result'] = $result2;
        }else {
            $sql1 = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id_1 = :org_id and org_id_2 is null";
            $stm1 = $db->conn->prepare($sql1);
            $stm1->bindParam(':org_id',$orgSelect);
            $stm1->execute();
            $result1 = $stm1->fetchAll(PDO::FETCH_COLUMN);
            if (count($result1) > 0 ) {
                $per_cardnoResult['result'] = $result1;
            }else {
                $sql = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id = :org_id  and org_id_1 is null and org_id_2 is null";
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(':org_id',$orgSelect);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_COLUMN);
                if (count($result) > 0) {
                    $per_cardnoResult['result'] = $result;
                }
            }
        }

    }

} catch (\Exception $e) {
    $errPer_cardno = $e->getMessage();
}

if ($errPer_cardno == "" && $errYears == "") {
    $per_cardnoResult['table_year'] = $resultYears[0];
    $per_cardnoResult['success'] = true;

}else {
    $per_cardnoResult['msg'] =$errYears.$errPer_cardno;

}

echo json_encode($per_cardnoResult);