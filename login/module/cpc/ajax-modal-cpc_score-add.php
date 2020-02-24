<?php
session_start();
if(!empty($_GET['per_cardno']) && !empty($_GET['question_no']) && !empty($_GET['pl_code']) && !empty($_GET['level_no'])){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";
    $err = '';
    $success = array();

    $cpc = new cpc;
    $d = date("Y-m-d H:i:s");
    $checkCpcScore = array(   "question_no" => $_GET['question_no'],
                               "per_cardno" => $_GET['per_cardno'],
                               "years" => __year__,
                               "soft_delete" => 0
                                );

    $check = $cpc->cpcScoreCheck($checkCpcScore);
    //echo $check['success'];
    if ($check['success'] === false) {
        try
        { 
              $r = $cpc->cpc_divisor($_GET['level_no'],$_GET['question_no']);
            
               $setData = array("question_no" => $_GET['question_no'],
                                "per_cardno" => $_GET['per_cardno'],
                                "id_admin" => $_SESSION[__USER_ID__],
                                "years" => __year__ ,
                                "cpc_divisor" => $r['result'],
                                "date_key_score" => $d,
                                "soft_delete" => 0
                                );
               // echo '<pre>'; print_r($setData); echo '</pre>';
               $result =  $cpc->cpcScoreSet($setData);
               //echo '<pre>'; print_r($result); echo '</pre>';

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
            //$success['result'] = $result;
        }

    }else {
        $success['success'] = false;
        $success['msg'] = $check['msg'];
    }
    // echo '<pre>'; print_r($r); echo '</pre>';
}else $success['msg'] = 'error';

echo json_encode($success);