<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-report-admin.php";
include_once "../myClass.php";
$db = new DbConn;
$person = new reportAdmin;
// foreach ($_POST as $key => $value) {
//    echo $key ."->". $value;
// }
if (isset($_POST['org_id_2']) and $_POST['org_id_2'] != "") {
    $orgSelect = $_POST['org_id_2'];
}elseif (isset($_POST['org_id_1']) and $_POST['org_id_1'] != "") {
    $orgSelect = $_POST['org_id_1'];
}elseif (isset($_POST['org_id']) and $_POST['org_id'] != "") {
    $orgSelect = $_POST['org_id'];
}
//  $years = explode("#",$_POST['selectYears']);
 $yearsId = $_POST['selectYears'];

    $myClass= new myClass;

    $yearById = $myClass->callYearByID($_POST['selectYears']);
    $tablePersonal = $yearById['data']['per_personal']; 
    $tableCPCscore = $yearById['data']['cpc_score'];
    $tableKPIscore = $yearById['data']['kpi_score'];
    $tableCpcScoreResult = $yearById['data']['cpc_score_result'];
    $tableKpiScoreResult = $yearById['data']['kpi_score_result'];

    $startEvaluation_part1 = $yearById['data']['start_evaluation'];  //วันเริ่มต้นช่วงที่ 1
    $endEvaluation_part1 = $yearById['data']['end_evaluation'];
    $startEvaluation_part2 = $yearById['data']['start_evaluation_2']; //วันเริ่มต้นช่วงที่ 2
    $endEvaluation_part2 = $yearById['data']['end_evaluation_2'];
    $tableYear = $yearById['data']['table_year'];
    $tableId = $yearById['data']['table_id'];

try {
    $sql = "SELECT t1.*,per_level.position_level,
            (SELECT t2.`cpc_score_result_head` FROM ".$tableCpcScoreResult." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpc_score_result_head ,
            (SELECT IF(t2.`cpc_score_result_head` is NULL,0,1) FROM ".$tableCpcScoreResult." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpcisnotnull ,
            (SELECT COUNT(*)   FROM ".$tableCpcScoreResult." t2 WHERE t2.`per_cardno` = t1.`per_cardno` ) as cpccoutrow,

            (SELECT t3.`kpi_score_result` FROM ".$tableKpiScoreResult." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpi_score_result ,
            (SELECT IF(t3.`kpi_score_result` is NULL,0,1) FROM ".$tableKpiScoreResult." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpiisnotnull ,
            (SELECT COUNT(*)   FROM ".$tableKpiScoreResult." t3 WHERE t3.`per_cardno` = t1.`per_cardno` ) as kpicoutrow

            FROM ".$tablePersonal." t1 
            LEFT JOIN per_level ON per_level.level_no = t1.level_no
            where (t1.org_id = :org_id OR t1.org_id_1 = :org_id OR t1.org_id_2 = :org_id ) and `login_status` = 1 ";

    // echo $sql; 
    // $sql = "select * from ".$years[1]." where org_id = :org_id OR org_id_1 = :org_id OR org_id_2 = :org_id  ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id',$orgSelect);
    $stm->bindParam(':org_id_1',$orgSelect);
    $stm->bindParam(':org_id_2',$orgSelect);
    $stm->execute();
    $result = $stm->fetchAll();

} catch (\Exception $e) {
   echo  $e->getMessage();

}



    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    if(count($result) > 0){
        
        $data =  $person->dataTablePersonReport($result,$tableId);
        $data['success'] = true;
    }else {
        $data['success'] = false;
    }
    
    echo json_encode($data);

?>
