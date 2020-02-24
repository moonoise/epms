<?php 
include_once "config.php";
include_once "includes/ociConn.php";
include_once "includes/dbconn.php";
include_once "epp-connect.php";
include_once "epp-function.php";

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
        // echo $value1['per_cardno'];

        $sqlEpp = "SELECT `ep_users`.`usr_no`, 
        `ep_users`.`usr_name`,
        `ep_cpc_answer`.`ans_answer`,
        `ep_cpc_answer`.`ans_anstop`,
        `ep_cpc_answer`.`ans_cmt_1`,
        `ep_cpc_answer`.`ans_cmt_2`,
        `ep_cpc_answer`.`ans_cmt_3`,
        `ep_cpc_answer`.`ans_cmt_4`,
        `ep_cpc_answer`.`ans_cmt_5`,
        `ep_cpc_answer`.`time_act`,
        `ep_cpc_answer`.`yea_fyear`,
        `ep_cpc_module`.`mod_code`,
        `ep_cpc_answer`.`mod_no`
        
  FROM `ep_users` 
  LEFT JOIN `ep_cpc_answer` ON `ep_users`.`usr_no` = `ep_cpc_answer`.`usr_no`
  LEFT JOIN `ep_cpc_module` ON `ep_cpc_answer`.`mod_no` = `ep_cpc_module`.`mod_no`

  WHERE `ep_users`.`usr_name` = :per_cardno 
  ORDER BY `ep_cpc_answer`.`yea_fyear`  DESC ,`ep_cpc_answer`.`time_act` ASC ,`ep_cpc_answer`.`mod_no` ASC ";

$stmEpp = $db_epp->conn->prepare($sqlEpp);
$stmEpp->bindParam(":per_cardno",$value1['per_cardno']);
$stmEpp->execute();
$result = $stmEpp->fetchAll();

foreach ($result as $key => $value) {


        $spt_set = "SELECT  `ep_cpc_assess`.`spts_set`  FROM `ep_cpc_assess` WHERE `ep_cpc_assess`.`usr_no` =  :usr_no 
                    AND   `ep_cpc_assess`.`yea_fyear` = :yea_fyear 
                    AND   `ep_cpc_assess`.`time_act` = :time_act ";

        $stm_spt_set = $db_epp->conn->prepare($spt_set);
        $stm_spt_set->bindParam(":usr_no",$value['usr_no']);
        $stm_spt_set->bindParam(":yea_fyear",$value['yea_fyear']);
        $stm_spt_set->bindParam(":time_act",$value['time_act']);
        $stm_spt_set->execute();
        $result_spt_set  = $stm_spt_set->fetchAll();




        $y = $value['yea_fyear']."-".$value['time_act'];
        $table = "cpc_score_".$value['yea_fyear'];
        $arrScore = str_split($value["ans_answer"]);
        $arrAccept = str_split($value['ans_anstop']);
        $question_no = $value['mod_code'];
        $per_cardno = $value['usr_name'];
        $id_admin = '25210959558feb84314624';
        $cpc_score1 = ($arrScore[0] != "" ? $arrScore[0] : NULL );
        $cpc_score2 = ($arrScore[1] != "" ? $arrScore[1] : NULL );
        $cpc_score3 = ($arrScore[2] != "" ? $arrScore[2] : NULL );
        $cpc_score4 = ($arrScore[3] != "" ? $arrScore[3] : NULL );
        $cpc_score5 = ($arrScore[4] != "" ? $arrScore[4] : NULL );
        $cpc_accept1 = ($arrAccept[0] != "" ? $arrAccept[0] : NULL );
        $cpc_accept2 = ($arrAccept[1] != "" ? $arrAccept[1] : NULL );
        $cpc_accept3 = ($arrAccept[2] != "" ? $arrAccept[2] : NULL );
        $cpc_accept4 = ($arrAccept[3] != "" ? $arrAccept[3] : NULL );
        $cpc_accept5 = ($arrAccept[4] != "" ? $arrAccept[4] : NULL );
        $cpc_comment1 = ($value['ans_cmt_1'] != "" ? $value['ans_cmt_1'] : NULL );
        $cpc_comment2 = ($value['ans_cmt_2'] != "" ? $value['ans_cmt_2'] : NULL );
        $cpc_comment3 = ($value['ans_cmt_3'] != "" ? $value['ans_cmt_3'] : NULL );
        $cpc_comment4 = ($value['ans_cmt_4'] != "" ? $value['ans_cmt_4'] : NULL );
        $cpc_comment5 = ($value['ans_cmt_5'] != "" ? $value['ans_cmt_5'] : NULL );
        $cpc_divisor = ($result_spt_set[0]['spts_set'] != "" ? $result_spt_set[0]['spts_set'] : NULL );

        // $sql_txt2 = "INSERT INTO $table (`question_no` , `per_cardno` , `id_admin` ,
        //                                  `cpc_score1`, `cpc_score2`, `cpc_score3`, `cpc_score4`, `cpc_score5`,
        //                                  `years`,
        //                                  `cpc_accept1`, `cpc_accept2`, `cpc_accept3`,`cpc_accept4`,`cpc_accept5`,
        //                                  `cpc_comment1`, `cpc_comment2`, `cpc_comment3`, `cpc_comment4`, `cpc_comment5`,
        //                                  `cpc_divisor`   ) 
        //                     VALUES  ($question_no , $per_cardno , $id_admin ,
        //                                 $cpc_score1 , $cpc_score2 , $cpc_score3 ,$cpc_score4 ,$cpc_score5 ,
        //                                 $y,
        //                                 $cpc_accept1 , $cpc_accept2 , $cpc_accept3 , $cpc_accept4 ,$cpc_accept5 ,
        //                                 $cpc_comment1 , $cpc_comment2 , $cpc_comment3 , $cpc_comment4 , $cpc_comment5 ,
        //                                 $cpc_divisor )";


        try{
        $sql_txt = "INSERT INTO $table (`question_no` , `per_cardno` , `id_admin` ,
                                `cpc_score1`, `cpc_score2`, `cpc_score3`, `cpc_score4`, `cpc_score5`,
                                `years`,
                                `cpc_accept1`, `cpc_accept2`, `cpc_accept3`,`cpc_accept4`,`cpc_accept5`,
                                `cpc_comment1`, `cpc_comment2`, `cpc_comment3`, `cpc_comment4`, `cpc_comment5`,
                                `cpc_divisor`   ) 
                    VALUES  (:question_no , :per_cardno , :id_admin ,
                                :cpc_score1 , :cpc_score2 , :cpc_score3 ,:cpc_score4 ,:cpc_score5 ,
                                :y,
                                :cpc_accept1 , :cpc_accept2 , :cpc_accept3 , :cpc_accept4 ,:cpc_accept5 ,
                                :cpc_comment1 , :cpc_comment2 , :cpc_comment3 , :cpc_comment4 , :cpc_comment5 ,
                                :cpc_divisor )";

        $stm = $db->conn->prepare($sql_txt);
        $stm->bindParam(":question_no",$question_no);
        $stm->bindParam(":per_cardno",$per_cardno);
        $stm->bindParam(":id_admin",$id_admin);
        $stm->bindParam(":cpc_score1",$cpc_score1);
        $stm->bindParam(":cpc_score2",$cpc_score2);
        $stm->bindParam(":cpc_score3",$cpc_score3);
        $stm->bindParam(":cpc_score4",$cpc_score4);
        $stm->bindParam(":cpc_score5",$cpc_score5);
        $stm->bindParam(":y",$y);
        $stm->bindParam(":cpc_accept1",$cpc_accept1);
        $stm->bindParam(":cpc_accept2",$cpc_accept2);
        $stm->bindParam(":cpc_accept3",$cpc_accept3);
        $stm->bindParam(":cpc_accept4",$cpc_accept4);
        $stm->bindParam(":cpc_accept5",$cpc_accept5);
        $stm->bindParam(":cpc_comment1",$cpc_comment1);
        $stm->bindParam(":cpc_comment2",$cpc_comment2);
        $stm->bindParam(":cpc_comment3",$cpc_comment3);
        $stm->bindParam(":cpc_comment4",$cpc_comment4);
        $stm->bindParam(":cpc_comment5",$cpc_comment5);
        $stm->bindParam(":cpc_divisor",$cpc_divisor);
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

    
   