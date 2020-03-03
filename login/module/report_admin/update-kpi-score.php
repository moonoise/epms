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
    $myClass = new myClass;
    $tableYears = $myClass->callYear();
    $year = $tableYears['data']['table_year'];
    $cpcScoreResultTable = $tableYears['data']['cpc_score_result'];
    $kpiScoreResultTable = $tableYears['data']['kpi_score_result'];
    $personalTable = $tableYears['data']['per_personal'];

    $checkKPI = $report->kpiQueryScore($_POST['per_cardno'],$year,$kpiScoreResultTable);
 
       $countCheck =  count($checkKPI['result']);
    if ($checkKPI['success'] === true AND  $countCheck == 1) {
      
            if ($count > 0 ) {
                
                try {
                    $sqlUpdateKPI = "UPDATE $kpiScoreResultTable SET kpi_score_result = :kpi_score_result WHERE per_cardno = :per_cardno ";
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
    

            try {
                $sqlPersonal = "SELECT through_trial FROM $personalTable WHERE per_cardno = :per_cardno ";
                $stmPersonal = $db->conn->prepare($sqlPersonal);
                $stmPersonal->bindParam(":per_cardno" , $_POST['per_cardno'] );
                $resultPersonal =  $stmPersonal->fetchAll(PDO::FETCH_ASSOC);
                
                    try {
                        $sqlInsertKPI = "INSERT INTO $kpiScoreResultTable 
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