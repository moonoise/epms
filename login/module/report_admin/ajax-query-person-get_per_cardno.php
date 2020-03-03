<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

$db = new DbConn;

$myClass = new myClass;
$yearById = $myClass->callYearByID($_POST['years']);
$cpcScoreResultTable = $yearById['data']['cpc_score_result'];
$kpiScoreResultTable = $yearById['data']['kpi_score_result'];
$personalTable = $yearById['data']['per_personal'];
$kpiScoreTable = $yearById['data']['kpi_score'];
$year = $yearById['data']['table_year'];


if (isset($_POST['org_id_2']) and $_POST['org_id_2'] != "") {
    $orgSelect = $_POST['org_id_2'];
}elseif (isset($_POST['org_id_1']) and $_POST['org_id_1'] != "") {
    $orgSelect = $_POST['org_id_1'];
}elseif (isset($_POST['org_id']) and $_POST['org_id'] != "") {
        $orgSelect = $_POST['org_id'];
}
$errYears = "";
$errPer_cardno = "";

$per_cardnoResult = array("success" => null,
                    "result" => null,
                    'login_status_0' => null,
                    'login_status_0_count' => Null,
                    "table_year" => null,
                    "msg" => null);

try {
    if ($orgSelect == "77") {
        $sql = "SELECT `per_cardno` FROM $personalTable WHERE `login_status` = 1 ";
        $stm = $db->conn->prepare($sql);
        $stm->execute();
    }else {
        $sql = "SELECT  `per_cardno` FROM $personalTable WHERE (`org_id` = :org_id OR `org_id_1` = :org_id OR `org_id_2` = :org_id) AND `login_status` = 1  ";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(':org_id',$orgSelect);
        $stm->bindParam(':org_id_1',$orgSelect);
        $stm->bindParam(':org_id_2',$orgSelect);
        $stm->execute();
    }
    
    $result = $stm->fetchAll(PDO::FETCH_COLUMN);
    


} catch (\Exception $e) {
    $errPer_cardno = $e->getMessage();
}

try {
    if ($orgSelect == "77") {

        $sqlLoginStatus = "SELECT  `per_cardno` FROM $personalTable WHERE `login_status` = 0  ";
        $stmLoginStatus = $db->conn->prepare($sqlLoginStatus);
        $stmLoginStatus->execute();
    }else {
        $sqlLoginStatus = "SELECT  `per_cardno` FROM $personalTable WHERE (`org_id` = :org_id OR `org_id_1` = :org_id OR `org_id_2` = :org_id) AND `login_status` = 0  ";
        $stmLoginStatus = $db->conn->prepare($sqlLoginStatus);
        $stmLoginStatus->bindParam(':org_id',$orgSelect);
        $stmLoginStatus->bindParam(':org_id_1',$orgSelect);
        $stmLoginStatus->bindParam(':org_id_2',$orgSelect);
        $stmLoginStatus->execute();
    }
        

        $resultLoginStatus = $stmLoginStatus->fetchAll(PDO::FETCH_COLUMN);
        $resultLoginStatusCount = $stmLoginStatus->rowCount();

} catch (\Exception $e) {
    $errPer_cardno = $e->getMessage();
}

if ($errPer_cardno == "" && $errYears == "") {
    $per_cardnoResult = array("success" => true,
                    "result" => $result,
                    'login_status_0' => $resultLoginStatus,
                    'login_status_0_count' => $resultLoginStatusCount,
                    "table_year" => $yearById['data'],
                    "msg" => "");
}else {
    $per_cardnoResult = array("success" => null,
                    "result" => null,
                    'login_status_0' => null,
                    'login_status_0_count' => NULL,
                    "table_year" => null,
                    "msg" => $errYears.$errPer_cardno);
}

echo json_encode($per_cardnoResult);