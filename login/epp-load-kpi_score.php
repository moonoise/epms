<?php 
include_once "config.php";
include_once "includes/ociConn.php";
include_once "includes/dbconn.php";
include_once "epp-connect.php";
include_once "epp-function.php";
include_once "module/kpi/class-kpi.php";

    $dpis = new dpis;
    $db = new Dbconn;
    $db_epp = new DbConnEpp;
    $success = array();
    $success['msg'] = '';
    $sql= "SELECT per_cardno FROM per_cardno ";
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    $result_per_cardno = $stm->fetchAll();
    
    foreach ($result_per_cardno as $key => $value1) {
        // $value1['per_cardno'] = '5120600003647';

        $sqlEpp = "SELECT
        `ep_users`.`usr_no`,
        `ep_users`.`usr_name`,
        `ep_kpi_assess`.`ind_no`,
        `ep_kpi_assess`.`wei_set`,
        `ep_kpi_assess`.`ans_answer`,
        `ep_kpi_assess`.`ans_anstop`,
        `ep_kpi_assess`.`time_act`,
        `ep_kpi_assess`.`yea_fyear`,
        `ep_kpi_indicate`.`ind_code`,
        `ep_kpi_indicate`.`ind_type`
        FROM
        `ep_users`
        RIGHT JOIN `ep_kpi_assess`
        ON `ep_users`.`usr_no` = `ep_kpi_assess`.`usr_no` 
        RIGHT JOIN `ep_kpi_indicate`
        ON `ep_kpi_assess`.`ind_no` = `ep_kpi_indicate`.`ind_no`
        WHERE
        `ep_users`.`usr_name` = :per_cardno
        ORDER BY
        `ep_kpi_assess`.`yea_fyear` DESC,
        `ep_kpi_assess`.`time_act` ASC,
        `ep_kpi_assess`.`ind_no` ASC ";

$stmEpp = $db_epp->conn->prepare($sqlEpp);
$stmEpp->bindParam(":per_cardno",$value1['per_cardno']);
$stmEpp->execute();
$result = $stmEpp->fetchAll();

foreach ($result as $key => $value) {

        if ($value['ind_type'] == 3) {
            $arrScore = $value["ans_answer"];
            $arrAccept = NULL ;
        }elseif ($value['ind_type'] == 2) {
            
            $arrScore = NULL;
            $arrAccept = $value['ans_anstop'];
            // echo $arrScore."<br>";
            // echo $arrAccept."<br>";
        }

        $y = $value['yea_fyear']."-".$value['time_act'];
        $table = "kpi_score_".$value['yea_fyear'];
       
        $kpi_code = $value['ind_code'];
        $per_cardno = $value['usr_name'];
        $id_admin = '25210959558feb84314624';
        $weight = $value['wei_set'];
        $kpi_accept = 1;

        try{
        $sql_txt = "INSERT INTO $table (`kpi_code` , `per_cardno` , `id_admin` ,
                                `kpi_score`, `kpi_score_raw`,
                                `years`,`weight` , `kpi_accept` ) 
                    VALUES  (:kpi_code , :per_cardno , :id_admin ,:kpi_score , :kpi_score_raw , :years ,:weights , :kpi_accept)";
        
        $stm = $db->conn->prepare($sql_txt);
        $stm->bindParam(":kpi_code",$kpi_code);
        $stm->bindParam(":per_cardno",$per_cardno);
        $stm->bindParam(":id_admin",$id_admin);
        $stm->bindParam(":kpi_score",$arrScore);
        $stm->bindParam(":kpi_score_raw",$arrAccept);
        $stm->bindParam(":weights",$weight);
        $stm->bindParam(":kpi_accept",$kpi_accept);
        $stm->bindParam(":years",$y);
   
        $stm->execute();

        $success['success'] = true;
        }catch(Exception $e){
        $success['msg'] = $e->getMessage();
        $success['success'] = null;
        }
        if ($success['msg'] == "" ) {
        printf("table %s ,per_cardno %s . <br> \n",$table , $per_cardno);
        }else {
        printf("%s . <br> \n",$success['msg']);
        }

        }


    }

    
   