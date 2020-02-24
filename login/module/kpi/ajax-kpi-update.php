<?php
$success = array();
if(!emtpy($_GET['per_cardno']) && $_GET['kpi_code'] ){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-kpi.php";
    
    $kpi = new kpi;

    
   if ($s = $kpi->ckData($_GET['per_cardno'],$_GET['kpi_code']) == true) {
    $d = date("Y-m-d H:i:s");
    $dataSet = array("kpi_code" => $_GET['kpi_code'],
                    "per_cardno" => $_GET['per_cardno'],
                    "id_admin" => __USER_ID__,
                    "kpi_score" => null,
                    "weight" => null,
                   
                    "years" => __year__,
                    "date_key_score" => $d,
                    "kpi_accept" => null,
                    "kpi_comment" => null,
                    "who_is_accept" => null,
                    "date_who_id_accept" => null
                    ); 
    $s = $kpi->add($dataSet);
    
        $success['success'] = $s['success'];
        $success['msg'] = $s['msg'];
    
   }else {
    $success['success'] = $s['success'];
    $success['msg'] = $s['msg'];
   } 
}else {
    $success['success'] = false;
    $success['msg'] = 'เกิดข้อผิดพลาด';
}

?>