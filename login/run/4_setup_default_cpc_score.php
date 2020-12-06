<?php
include_once "../config.php";
include_once "../includes/dbconn.php";
include_once "../module/cpc/class-cpc.php";
include_once "../module/myClass.php";

$cpc = new cpc;
$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$per_personal = $currentYear['data']['per_personal'];
$cpcScoreTable  = $currentYear['data']['cpc_score'];
$year = $currentYear['data']['table_year'];

printf("\n/*********************************/
/*   อัพเดท นำเข้า สมรรถนะ    */
/*                               */
/*********************************/ \n");
// printf("\n ใส่ปี และ รอบ การประเมินรอบที่แล้ว \n");


$sqlPer = "SELECT * FROM $per_personal WHERE per_type = 3 ";
$stmPer = $db->conn->prepare($sqlPer);
$stmPer->execute();
$resultPer = $stmPer->fetchAll();
$ok = array();
$log = array();
$log2 = array();


foreach ($resultPer as $key => $v) {
    $err = '';
    $success = array();

    $setDataSoftDelete = array(
        "soft_delete" => 0,
        "per_cardno" => $v['per_cardno'],
        "years" => $year
    );
    $d = date("Y-m-d H:i:s");
    $softDelete = $cpc->cpcScoreDeleteByPer_cardno($setDataSoftDelete, $cpcScoreTable);

    if ($softDelete['success'] == true) {
        $r = $cpc->cpcScoreGetDefault($v['per_cardno']);

        if (!empty($r['result'])) {

            foreach ($r['result'] as $key => $value) {
                $setData = array(
                    "question_no" => $value['question_no'],
                    "per_cardno" => $value['per_cardno'],
                    "id_admin" => 'moonoise',
                    "years" => $year,
                    "cpc_weight" => $value['cpc_weight'],
                    "cpc_divisor" => $value['cpc_divisor'],
                    "date_key_score" => $d,
                    "soft_delete" => 0
                );

                // echo '<pre>'; print_r($setData); echo '</pre>';
                $result =  $cpc->cpcScoreSet($setData, $cpcScoreTable);
                //echo '<pre>'; print_r($result); echo '</pre>';
                $ok[] = $result;
            }

            array_push($ok, $v['per_cardno']);
        } else {
            array_push($log, $v['per_cardno']);
        }
    }

    printf("%s : %s \r ", $key + 1, $v['per_cardno']);
}


// print_r($r);
print_r($log);
print_r($log2);
