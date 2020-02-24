<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";
$success = array('success' => null,
                'result' => null,
                'msg' => null );
    $db = new DbConn;
    $report = new report;
 
    $checkKPI = $report->kpiQueryScore($_POST['per_cardno'],__year__);
    try {
        $sqlYear  = "SELECT  * FROM `table_year` WHERE table_year = :selectYears " ;
        $stmYear = $db->conn->prepare($sqlYear);
        $y = __year__;
        $stmYear->bindParam(":selectYears" , $y );
        $stmYear->execute();
        $resultYear = $stmYear->fetchAll(PDO::FETCH_ASSOC);
        
        $count = $stmYear->rowCount();
        
        } catch (\Exception $e) {
            $success['msg'] = $e->getMessage();
            // echo $errYears;
        }
       $countCheck =  count($checkKPI['result']);
    if ($checkKPI['success'] === true AND  $countCheck == 1) {
      
            if ($count > 0 ) {
                
                $cpc_score_result = $resultYear[0]['cpc_score_result'];
                $kpi_score_result = $resultYear[0]['kpi_score_result'];

                try {
                    $sqlUpdateKPI = "UPDATE $kpi_score_result SET kpi_score_result = :kpi_score_result WHERE per_cardno = :per_cardno ";
                    $stmUpdateKPI = $db->conn->prepare($sqlUpdateKPI);
                    $stmUpdateKPI->bindParam(":kpi_score_result",$_POST['kpi_score']); 
                    $stmUpdateKPI->bindParam(":per_cardno",$_POST['per_cardno']); 
                    $stmUpdateKPI->execute();
                    $success['result'] = 'update';

                } catch (\Exception $e) {
                    $success['msg'] = "update".$e->getMessage();
                }
            }

    }elseif ($checkKPI['success'] === true AND count($checkKPI['result'])  == 0) {
        if ($count == 0 ) {
            $per_personal = $resultYear[0]['per_personal'];
            $kpi_score_result = $resultYear[0]['kpi_score_result'];
            $table_year = $resultYear[0]['table_year'];

            try {
                $sqlPersonal = "SELECT through_trial FROM $per_personal WHERE per_cardno = :per_cardno ";
                $stmPersonal = $db->conn->prepare($sqlPersonal);
                $stmPersonal->bindParam(":per_cardno" , $_POST['per_cardno'] );
                $resultPersonal =  $stmPersonal->fetchAll(PDO::FETCH_ASSOC);
                
                    try {
                        $sqlInsertKPI = "INSERT INTO $kpi_score_result 
                                        (`per_cardno`,`kpi_score_result`,`scoring`,`years` ) 
                                        VALUES (:per_cardno , :kpi_score_result , :scoring , :years ) ";
                        $stmInsert = $db->conn->prepare($sqlInsertKPI);

                        if ($resultPersonal[0]['through_trial'] == 1 || $resultPersonal[0]['through_trial'] == NULL ) {
                                $stmInsert->bindValue(":scoring",70);
                            }elseif ($resultPersonal[0]['through_trial'] == 2) {
                                $stmInsert->bindValue(":scoring",50);
                        }

                        $stmInsert->bindParam(":per_cardno",$_POST['per_cardno']);
                        $stmInsert->bindParam(":kpi_score_result",$_POST['kpi_score']);
                        $stmInsert->bindParam(":years",$_POST['table_year']);
                        $stmInsert->execute();

                        $success['result'] = 'Insert';

                    } catch (\Exception $e) {
                        $success['msg'] = $e->getMessage();
                    }
                

            } catch (\Exception $e) {
                $success['msg'] = $e->getMessage();
            }

        }

    }

echo json_encode($success);