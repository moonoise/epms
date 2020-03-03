<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-report-admin.php";
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

    $sql_table_year = "SELECT * FROM `table_year` WHERE `table_year`.`table_id` = :table_id";
    
    $stm_table_year = $db->conn->prepare($sql_table_year);
    $stm_table_year->bindParam(':table_id',$yearsId);
    $stm_table_year->execute();
    $result_table_year = $stm_table_year->fetchAll(PDO::FETCH_ASSOC);
    // $sql = "SELECT t1.*,
    //         (SELECT t2.`cpc_score_result_head` FROM ".$result_table_year[0]['cpc_score_result']." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpc_score_result_head ,
    //         (SELECT IF(t2.`cpc_score_result_head` is NULL,0,1) FROM ".$result_table_year[0]['cpc_score_result']." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpcisnotnull ,
    //         (SELECT COUNT(*)   FROM ".$result_table_year[0]['cpc_score_result']." t2 WHERE t2.`per_cardno` = t1.`per_cardno` ) as cpccoutrow,

    //         (SELECT t3.`kpi_score_result` FROM ".$result_table_year[0]['kpi_score_result']." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpi_score_result ,
    //         (SELECT IF(t3.`kpi_score_result` is NULL,0,1) FROM ".$result_table_year[0]['kpi_score_result']." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpiisnotnull ,
    //         (SELECT COUNT(*)   FROM ".$result_table_year[0]['kpi_score_result']." t3 WHERE t3.`per_cardno` = t1.`per_cardno` ) as kpicoutrow

    //         FROM ".$result_table_year[0]['per_personal']." t1 where t1.org_id = :org_id OR t1.org_id_1 = :org_id OR t1.org_id_2 = :org_id  ";

    $sql = "SELECT t1.*,per_level.position_level,
            (SELECT t2.`cpc_score_result_head` FROM ".$result_table_year[0]['cpc_score_result']." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpc_score_result_head ,
            (SELECT IF(t2.`cpc_score_result_head` is NULL,0,1) FROM ".$result_table_year[0]['cpc_score_result']." t2  WHERE t2.`per_cardno` = t1.`per_cardno`  ) as cpcisnotnull ,
            (SELECT COUNT(*)   FROM ".$result_table_year[0]['cpc_score_result']." t2 WHERE t2.`per_cardno` = t1.`per_cardno` ) as cpccoutrow,

            (SELECT t3.`kpi_score_result` FROM ".$result_table_year[0]['kpi_score_result']." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpi_score_result ,
            (SELECT IF(t3.`kpi_score_result` is NULL,0,1) FROM ".$result_table_year[0]['kpi_score_result']." t3  WHERE t3.`per_cardno` = t1.`per_cardno`  ) as kpiisnotnull ,
            (SELECT COUNT(*)   FROM ".$result_table_year[0]['kpi_score_result']." t3 WHERE t3.`per_cardno` = t1.`per_cardno` ) as kpicoutrow

            FROM ".$result_table_year[0]['per_personal']." t1 
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
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    if(count($result) > 0){
        
        $data =  $person->dataTablePersonReport($result,$years);
        $data['success'] = true;
    }else {
        $data['success'] = false;
    }
    
    echo json_encode($data);

?>
