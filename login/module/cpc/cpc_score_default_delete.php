<?php
session_start();
if (!empty($_GET['per_cardno']) && !empty($_GET['pl_code']) && !empty($_GET['level_no'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";
    include_once "../myClass.php";
    $err = '';
    $success = array();
    $ok = array();

    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];
    $year = $currentYear['data']['table_year'];

    $d = date("Y-m-d H:i:s");
    $setDataSoftDelete = array(
        "soft_delete" => 0,
        "per_cardno" => $_GET['per_cardno'],
        "years" => $year
    );

    $softDelete = $cpc->cpcScoreDeleteByPer_cardno($setDataSoftDelete, $cpcScoreTable);
    if ($softDelete['success'] == true) {
        try {
            $r = $cpc->cpcScoreGetDefault($_GET['per_cardno']);
            if ($r['result'] > 0) {
                foreach ($r['result'] as $key => $value) {
                    $setData = array(
                        "question_no" => $value['question_no'],
                        "per_cardno" => $value['per_cardno'],
                        "id_admin" => $_SESSION[__USER_ID__],
                        "years" => $year,
                        "cpc_divisor" => $value['cpc_divisor'],
                        "date_key_score" => $d,
                        "soft_delete" => 0
                    );
                    // echo '<pre>'; print_r($setData); echo '</pre>';
                    $result =  $cpc->cpcScoreSet($setData, $cpcScoreTable);
                    //echo '<pre>'; print_r($result); echo '</pre>';
                    $ok[] = $result;
                }
                $success['success'] = true;
                $success['result'] = $ok;
            } else {
                $success['success'] = false;
                $success['msg'] = 'ไม่พบค่าเริ่มต้นในระบบ กรุณาติดต่อเจ้าหน้าที่';
            }
        } catch (Exception $e) {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = 'เพิ่ม cpc_score -> ' . $err;
        }
    } else {
        $success['success'] = $softDelete['success'];
        $success['msg'] = $softDelete['msg'];
    }
    // echo '<pre>'; print_r($r); echo '</pre>';
} else {
    $success['success'] = null;
    $success['msg'] = 'error';
}

echo json_encode($success);
