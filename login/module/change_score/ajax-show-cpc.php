<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
 include_once "../report/class-report.php";
 include_once "../myClass.php";

 $success = array();


 if(!empty($_POST['per_cardno'])){
  
    $db = new DbConn;
    $myClass = new myClass;
    $report = new report;

    $tableYears = $myClass->callYear();
    $year = $tableYears['data']['table_year'];

    $table_cpc = $report->tableCPC($_POST['per_cardno'],$year,array(1,2,3),$tableYears['data']['per_personal'],$tableYears['data']['cpc_score']);
    
    if ( count($table_cpc['result']) > 0 ) {

      $success = $report->cpcCalculate_new($table_cpc)   ;
      
      try {
         $sql = "SELECT through_trial FROM  ".$tableYears['data']['per_personal']." WHERE per_cardno = :per_cardno "; 
         $stm = $db->conn->prepare($sql);
         $stm->bindParam(":per_cardno" , $_POST['per_cardno']);
         $stm->execute();
    
         $ThroughTrial = $stm->fetchAll(PDO::FETCH_ASSOC);
    
         if($ThroughTrial[0]['through_trial'] == 1  ){
             $success['weight_cpc'] = 30 ;
             $success['weight_kpi'] = 70 ;
         }elseif ($ThroughTrial[0]['through_trial'] == 0) {
          $success['weight_cpc'] = 50 ;
          $success['weight_kpi'] = 50 ;
         }else {
          $success['weight_cpc'] = null ;
          $success['weight_kpi'] = null ;
         }
    
       } catch (\Exception $e) {
          $success['success'] = false;
          $success['msg'] = $e;
       }


    }else {
      $success['success'] = false;
      $success['msg'] = 'not found data.';
    }

 }else {
    $success['success'] = false;
    $success['msg'] = 'เกิดข้อผิดพลาด';
 }

echo json_encode($success);


