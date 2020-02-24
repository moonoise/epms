<?php
 session_start();
 $success = array();
//  echo gettype($_GET['weight']);
//  echo "<br>".intval("test");
 if(!empty($_GET['kpi_score_id']) && (!empty($_GET['weight'])  || isset($_GET['weight']) ) && gettype(intval($_GET['weight'])) == 'integer' && intval($_GET['weight']) != 0){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-kpi.php";

    $d = date("Y-m-d H:i:s");
    $dateSet = array('per_cardno' => $_GET['per_cardno'],
                    'kpi_score_id' => $_GET['kpi_score_id'] ,
                    'weight' => $_GET['weight'] ,
                    'date_key_score' => $d  );
                    
    $kpi = new kpi;
  
    $success = $kpi->KpiScoreUpdateWeight($dateSet);



 }else {
    $success['success'] = false;
    $success['msg'] = 'เกิดข้อผิดพลาด';
 }

echo json_encode($success);


