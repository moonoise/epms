<?php
 session_start();
 $success = array();
 
 if(!empty($_GET['kpi_score_id'])){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-kpi.php";

    $d = date("Y-m-d H:i:s");
    $dateSet = array('kpi_score_id' => $_GET['kpi_score_id'] ,
                    'soft_delete' => 1,
                    'date_key_score' => $d);
                    
    $kpi = new kpi;
  
    $result = $kpi->KpiScoreSoftDelete($dateSet);

   echo json_encode($result);
 }


