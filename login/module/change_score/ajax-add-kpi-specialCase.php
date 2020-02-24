<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
 include_once "../kpi/class-kpi.php";
include_once "../myClass.php";

 $success = array('success' => null,
                'result' => null,
                'msg' => null );

 $d = date("Y-m-d H:i:s");
if (!empty($_POST['per_cardno']) && !empty($_POST['kpi_code']) ) {
    $kpi = new kpi;
    


    if ($_POST['input_score'] != ""  && $_POST['input_weight'] != "") {
      $kpi_score =  $_POST['input_score'];
      $kpi_weight =  $_POST['input_weight']; 
      $date_who_id_accept = $d;
      $who_is_accept = $_SESSION[__USER_ID__];
      $kpi_accept = 1;
    }else {
        $kpi_score =  ($_POST['input_score'] != "" ? $_POST['input_score'] : NULL )  ;
        $kpi_weight =  ($_POST['input_weight'] != "" ? $_POST['input_weight'] : NULL) ;
        
        $date_who_id_accept = NULL;
        $who_is_accept = NULL;
        $kpi_accept = NULL;
    }
    $s = $kpi->ckData($_POST['per_cardno'],$_POST['kpi_code']);
    if ($s['success'] == true) {
        
        $dataSet = array("kpi_code" => $_POST['kpi_code'],
                        "per_cardno" => $_POST['per_cardno'],
                        "id_admin" => $_SESSION[__USER_ID__],
                        "kpi_score" => $kpi_score,
                        "weight" => $kpi_weight,
                       
                        "years" => __year__,
                        "date_key_score" => $d,
                        "kpi_accept" => $kpi_accept,
                        "kpi_comment" => null,
                        "who_is_accept" => $who_is_accept,
                        "date_who_id_accept" => $date_who_id_accept
                        ); 


        $ss = $kpi->kpiScoreAdd($dataSet);
        
            $success['success'] = $ss['success'];
            $success['msg'] = $ss['msg'];
        
       }else {
        $success['success'] = $s['success'];
        $success['msg'] = "มีตัวชี้วัดอยู่แล้ว";
       } 
    
    

}else {
    $success['success'] = false;
    $success['msg'] = "not found variable.";
}

echo json_encode($success);