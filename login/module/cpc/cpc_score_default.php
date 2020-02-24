<?php
session_start();
if(!empty($_GET['per_cardno']) && !empty($_GET['pl_code']) && !empty($_GET['level_no'])  ){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";

    $err = '';
    $success = array();
    $ok = array();

    $cpc = new cpc;
    $d = date("Y-m-d H:i:s");
    $setDataSoftDelete = array("soft_delete" => 1,
                               "id_admin" => $_SESSION[__USER_ID__],
                               "date_key_score" => $d,
                               "per_cardno" => $_GET['per_cardno'],
                               "years" => __year__
                                );

    $softDelete = $cpc->cpcScoreSoftDeleteByPer_cardno($setDataSoftDelete);
    if ($softDelete['success'] == true) {
        try
        { 
            $r = $cpc->cpcScoreGetDefault($_GET['per_cardno'],$_GET['pl_code'],$_GET['level_no']);

            foreach ($r['result'] as $key => $value) {
               $setData = array("question_no" => $value['question_no'],
                                "per_cardno" => $value['per_cardno'],
                                "id_admin" => $_SESSION[__USER_ID__],
                                "years" => __year__ ,
                                "cpc_divisor" => $value['cpc_divisor'],
                                "date_key_score" => $d,
                                "soft_delete" => 0
                                );
               // echo '<pre>'; print_r($setData); echo '</pre>';
               $result =  $cpc->cpcScoreSet($setData);
               //echo '<pre>'; print_r($result); echo '</pre>';
               $ok[] = $result;                 
            }

        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '') 
        {
            $success['success'] = null;
            $success['msg'] = 'เพิ่ม cpc_score -> '.$err;
        }else 
        {
            $success['success'] = true;
            $success['result'] = $ok;
        }

    }else {
        $success['success'] = $softDelete['success'];
        $success['msg'] = $softDelete['msg'];
    }
    // echo '<pre>'; print_r($r); echo '</pre>';
}else $success['msg'] = 'error';

echo json_encode($success);