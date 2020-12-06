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
        "soft_delete" => 1,
        "id_admin" => $_SESSION[__USER_ID__],
        "date_key_score" => $d,
        "per_cardno" => $_GET['per_cardno'],
        "years" => $year
    );

    $softDelete = $cpc->cpcScoreSoftDeleteByPer_cardno($setDataSoftDelete, $cpcScoreTable);
    if ($softDelete['success'] == true) {
        try {
            $r = $cpc->cpcScoreGetDefault($_GET['per_cardno'], $_GET['pl_code'], $_GET['level_no']);

            foreach ($r['result'] as $key => $value) {
                $setData = array(
                    "question_no" => $value['question_no'],
                    "per_cardno" => $value['per_cardno'],
                    "id_admin" => $_SESSION[__USER_ID__],
                    "years" => $year,
                    'cpc_divisor' => $d['cpc_divisor'],
                    'cpc_weight' => $d['weight_default'],
                    "date_key_score" => $d,
                    "soft_delete" => 0
                );
                // echo '<pre>'; print_r($setData); echo '</pre>';
                $result =  $cpc->cpcScoreSet($setData, $cpcScoreTable);
                //echo '<pre>'; print_r($result); echo '</pre>';
                $ok[] = $result;
            }
        } catch (Exception $e) {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = 'เพิ่ม cpc_score -> ' . $err;
        } else {
            $success['success'] = true;
            $success['result'] = $ok;
        }
    } else {
        $success['success'] = $softDelete['success'];
        $success['msg'] = $softDelete['msg'];
    }
    // echo '<pre>'; print_r($r); echo '</pre>';
} else $success['msg'] = 'error';

echo json_encode($success);
