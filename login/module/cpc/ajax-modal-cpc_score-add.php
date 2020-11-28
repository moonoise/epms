<?php
session_start();
if (!empty($_GET['per_cardno']) && !empty($_GET['question_no'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";
    include_once "../myClass.php";
    $err = '';
    $success = array();

    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];
    $year = $currentYear['data']['table_year'];

    $d = date("Y-m-d H:i:s");
    $checkCpcScore = array(
        "question_no" => $_GET['question_no'],
        "per_cardno" => $_GET['per_cardno'],
        "years" => $year,
        "soft_delete" => 0
    );

    $check = $cpc->cpcScoreCheck($checkCpcScore, $cpcScoreTable);
    //echo $check['success'];
    if ($check['success'] === false) {
        try {
            $r = $cpc->cpc_divisor($_GET['question_no']);

            $setData = array(
                "question_no" => $_GET['question_no'],
                "per_cardno" => $_GET['per_cardno'],
                "id_admin" => $_SESSION[__USER_ID__],
                "years" => $year,
                "cpc_divisor" => $r['weight_default'],
                "date_key_score" => $d,
                "soft_delete" => 0
            );
            // echo '<pre>'; print_r($setData); echo '</pre>';
            $result =  $cpc->cpcScoreSet($setData, $cpcScoreTable);
            //echo '<pre>'; print_r($result); echo '</pre>';

        } catch (Exception $e) {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = 'เพิ่ม cpc_score -> ' . $err;
        } else {
            $success['success'] = true;
            $success['result'] = $r;
        }
    } else {
        $success['success'] = false;
        $success['msg'] = $check['msg'];
    }
    // echo '<pre>'; print_r($r); echo '</pre>';
} else $success['msg'] = 'error';

echo json_encode($success);
