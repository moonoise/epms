<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";

$db = new DbConn;
$report =  new report;
$errYears = "";
$errScore = "";
$errUpdate = "";
$c = 0;
$log = array();
$log_ = array();

// $years_id = $_POST['selectYears'];
$years_id = 9;

$cpcTypeKey = array(1,2,3);

try {
    $sqlYear  = "SELECT  * FROM `table_year` WHERE table_id = :selectYears " ;
    $stmYear = $db->conn->prepare($sqlYear);
    $stmYear->bindParam(":selectYears" , $years_id);
    $stmYear->execute();
    $resultYear = $stmYear->fetchAll(PDO::FETCH_ASSOC);
    
} catch (\Exception $e) {
    $errYears = $e->getMessage();
    // echo $errYears;
}

if ($errYears == "") {

    $per_personal = $resultYear[0]['per_personal'];
    $cpc_score = $resultYear[0]['cpc_score'];
    $kpi_score = $resultYear[0]['kpi_score'];
    $years = $resultYear[0]['table_year'];
    $cpc_score_result = $resultYear[0]['cpc_score_result'];
    $kpi_score_result = $resultYear[0]['kpi_score_result'];

    try {
        
        $sqlPersonal = "SELECT per_cardno FROM $per_personal WHERE login_status = 1  "; // limit 1,300
        // $sqlPersonal = "SELECT per_cardno FROM $per_personal WHERE per_cardno = '3300101825228'";
        $stmPersonal = $db->conn->prepare($sqlPersonal);
        $stmPersonal->execute();
        $stmResult = $stmPersonal->fetchAll(PDO::FETCH_ASSOC);
        $countRow = $stmPersonal->RowCount();

    } catch (\Exception $e) {
        $errScore = $e->getMessage();
    }

    foreach ($stmResult as $key => $value) {
        $cpcResult = $report->tableCPC($value['per_cardno'],$years,$cpcTypeKey,$per_personal,$cpc_score);
        $cpc = $report->reportCPC1($cpcResult);
     
        $kpiResult = $report->tableKPI($value['per_cardno'],$years,$kpi_score);
        $kpi = $report->reportKPI1($kpiResult);
        // echo var_dump($kpi);
        if ( array_key_exists('text' , $cpc ) ) {
            
            foreach ($cpc['text'] as $cpc_key => $cpc_value) {
                // echo var_dump($cpc_value['sum1_']);
                try {
                    $sqlUpdate = "UPDATE $cpc_score SET `total_head` = :total , 
                                                        `sum_head` = :sum_head 
                                                    WHERE `cpc_score_id` = :cpc_score_id ";
                    $stmUpdateCPC = $db->conn->prepare($sqlUpdate);
    
                    $stmUpdateCPC->bindParam(":total",$cpc_value['total_']);
                    $stmUpdateCPC->bindParam(":sum_head",$cpc_value['sum1_']);
    
                    $stmUpdateCPC->bindParam(":cpc_score_id",$cpc_value['cpc_score_id']);
    
                    $stmUpdateCPC->execute();
    
                } catch (\Exception $e) {
                    $errUpdate = $e->getMessage();
                    print htmlentities($e->getMessage());
                    print "\n\n";
                    
                    $log_['per_cardno'] = $value['per_cardno'];
                    $log_['id'] = $cpc_value['cpc_score_id'];
                    $log_['error'] = $cpc_score ." ".$errUpdate;
                    $log[] = $log_;
                    $log_ = [];
                }
     
            } // end foreach

            try {
                $sqlScoreResultUpdate = "UPDATE $cpc_score_result SET `cpc_sum_weight` = :cpc_sum_weight 
                                                                     WHERE  per_cardno = :per_cardno";
                $stmScoreUpdate = $db->conn->prepare($sqlScoreResultUpdate);
                $stmScoreUpdate->bindParam(":cpc_sum_weight",$cpc['cpcSumWeight_']);
    
                $stmScoreUpdate->bindParam(":per_cardno",$value['per_cardno']);
    
                $stmScoreUpdate->execute();
    
            } catch (\Exception $e) {
                $errUpdate = $e->getMessage();
                print htmlentities($e->getMessage());
                print "\n\n";

                $log_['per_cardno'] = $value['per_cardno'];
                $log_['id'] = NULL;
                $log_['error'] = $cpc_score_result ." ".$errUpdate;
                $log[] = $log_;
                $log_ = [];
            }

        }  //end if 
    

        if (array_key_exists('text', $kpi) ) {
            
            foreach ($kpi['text'] as $keyKPI => $valueKPI) {
                try {
                    $sqlKPIUpdate = "UPDATE $kpi_score SET `kpi_sum_head` = :kpi_sum_head 
                                        WHERE  kpi_score_id = :kpi_score_id ";
                    $stmKPIUpdate = $db->conn->prepare($sqlKPIUpdate);
                    $stmKPIUpdate->bindParam(":kpi_sum_head",$valueKPI['kpiSum_']);
                    $stmKPIUpdate->bindParam(":kpi_score_id",$valueKPI['kpi_score_id']);
                
                    $stmKPIUpdate->execute();
    
                } catch (\Exception $e) {
                    $errUpdate = $e->getMessage();
                    print htmlentities($e->getMessage());
                    print "\n\n";
                    
                    $log_['per_cardno'] = $value['per_cardno'];
                    $log_['id'] = $value['kpi_score_id'];
                    $log_['error'] = $kpi_score ." ".$errUpdate;
                    $log[] = $log_;
                    $log_ = [];

                }
            }
    
            try {
                $sqlKPIResultUpdate = "UPDATE $kpi_score_result SET kpi_weight_sum = :kpi_weight_sum WHERE per_cardno = :per_cardno ";
                $stmKPIResultUpdate = $db->conn->prepare($sqlKPIResultUpdate);
                $stmKPIResultUpdate->bindParam(":kpi_weight_sum",$kpi['kpiWeightSum_']);
                $stmKPIResultUpdate->bindParam(":per_cardno",$value['per_cardno']);
    
                $stmKPIResultUpdate->execute();
    
            } catch (\Exception $e) {
                $errUpdate = $e->getMessage();
                print htmlentities($e->getMessage());
                print "\n\n";

                $log_['per_cardno'] = $value['per_cardno'];
                $log_['id'] = NULL;
                $log_['error'] = $kpi_score_result ." ".$errUpdate;
                $log[] = $log_;
                $log_ = [];
            }
        } //end if
       
        if ($errUpdate == "") {
            // $c = $key+1;
            $c++;
            $s = ( ($c) / $countRow ) * 100  ;
            echo  "Complete :". round($s,2) . "% \r";
        } else {
            echo "Error : id = ".$value['per_cardno']."\r";
            $errUpdate="";
        }
        
    }
    echo  "Completed :". $s . "% \n\n";
    echo var_dump($log);
    // foreach ($log as $keyLog => $valueLog) {
    //     print htmlentities($valueLog['per_cardno']);
    //     print "\n";
    //     print htmlentities($valueLog['id']);
    //     print "\n";
    //     print htmlentities($valueLog['error']);
    //     print "\n\n";
    // }
    


}