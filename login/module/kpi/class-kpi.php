<?php
// @include_once "../../config.php";
// @include_once "../../includes/dbconn.php";
class kpi extends DbConn {

    function kpiScoreAdd($data) {
        $err = "";
        $success = array();
   
            try{
               
                $sql = "INSERT INTO ".$this->tbl_kpi_score." 
                    (`kpi_code`,
                    `per_cardno`,
                    `id_admin`,
                    `kpi_score`,
                    `weight`,
                   
                    `years`,
                    `date_key_score`,
                    `kpi_accept`,
                    `kpi_comment`,
                    `who_is_accept`,
                    `date_who_id_accept`)
                    VALUES (:kpi_code,
                    :per_cardno,
                    :id_admin,
                    :kpi_score,
                    :weightScore,
                    :yearScore,
                    :date_key_score,
                    :kpi_accept,
                    :kpi_comment,
                    :who_is_accept,
                    :date_who_id_accept)";
                $stm = $this->conn->prepare($sql);

                $stm->bindParam(":kpi_code",$data['kpi_code']);
                $stm->bindParam(":per_cardno",$data['per_cardno']);
                $stm->bindParam(":id_admin",$data['id_admin']);
                $stm->bindParam(":kpi_score",$data['kpi_score']);
                $stm->bindParam(":weightScore",$data['weight']);
                
                $stm->bindParam(":yearScore",$data['years']);
                $stm->bindParam(":date_key_score",$data['date_key_score']);
                $stm->bindParam(":kpi_accept",$data['kpi_accept']);
                $stm->bindParam(":kpi_comment",$data['kpi_comment']);
                $stm->bindParam(":who_is_accept",$data['who_is_accept']);
                $stm->bindParam(":date_who_id_accept",$data['date_who_id_accept']);
                
                $stm->execute();
            }catch(Exception $e){
                $err = $e->getMessage();
            }

        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
            $success['msg'] = null;
        }
        return $success;
    }

    function KpiScoreUpdateWeight($data) {
        $err = "";
        $success = array();
   
            try{
                
                $checkWeight = "SELECT sum(t1.`weight`) as result FROM  
                                    (SELECT ".$this->tbl_kpi_score.".`weight` FROM `".$this->tbl_kpi_score."`  
                                     WHERE ".$this->tbl_kpi_score.".`per_cardno` = :per_cardno 
                                     AND ".$this->tbl_kpi_score.".`soft_delete` = 0
                                     AND ".$this->tbl_kpi_score.".`kpi_score_id` <> :kpi_score_id) as t1";
                $checkStm = $this->conn->prepare($checkWeight);
                $checkStm->bindParam(":per_cardno",$data['per_cardno']);
                $checkStm->bindParam(":kpi_score_id",$data['kpi_score_id']);
                $checkStm->execute();
                $checkResult = $checkStm->fetchAll(PDO::FETCH_NUM); 

                // echo "<pre>";
                // print_r($checkResult);
                // echo "</pre>";
                if($checkResult[0][0] != ""){
                  $c =  $checkResult[0][0] + $data['weight'];
                  if ($c > 100) {
                    $success['success'] = false;
                    $success['msg'] = "ค่าน้ำหนักของท่านเกิน 100 <br> รวมค่าน้ำหนักที่ได้คือ <b class='text-danger'>$c</b> ";
                  }else {
                    $sql = "UPDATE ".$this->tbl_kpi_score." SET `weight` = :weightScore ,`date_key_score` = :date_key_score WHERE `kpi_score_id` = :kpi_score_id ";
                     $stm = $this->conn->prepare($sql);
                    $stm->bindParam(":kpi_score_id",$data['kpi_score_id']);
                    $stm->bindParam(":weightScore",$data['weight']);
                    $stm->bindParam(":date_key_score",$data['date_key_score']);
                    $stm->execute();
                    $success['success'] = true;
                  }

                }elseif ($checkResult[0][0] == "") {
                    if ($data['weight'] > 100) {
                        $success['success'] = false;
                        $success['msg'] = "ค่าน้ำหนักของท่านเกิน 100 <br> รวมค่าน้ำหนักที่ได้คือ <b class='text-danger'>".$data['weight']."</b> ";
                      }else {
                        $sql = "UPDATE ".$this->tbl_kpi_score." SET `weight` = :weightScore ,`date_key_score` = :date_key_score WHERE `kpi_score_id` = :kpi_score_id ";
                         $stm = $this->conn->prepare($sql);
                        $stm->bindParam(":kpi_score_id",$data['kpi_score_id']);
                        $stm->bindParam(":weightScore",$data['weight']);
                        $stm->bindParam(":date_key_score",$data['date_key_score']);
                        $stm->execute();
                        $success['success'] = true;
                      }
                }
                //echo $data['weight'];
            }catch(Exception $e){
                $err = $e->getMessage();
                $success['success'] = null;
                $success['msg'] = $err;
            }
        
        return $success;
    }

    function KpiScoreSoftDelete($data) {
        $err = "";
        $success = array();
   
            try{
                
                $sql = "UPDATE ".$this->tbl_kpi_score." SET `soft_delete` = :soft_delete ,`date_key_score` = :date_key_score 
                WHERE `kpi_score_id` = :kpi_score_id ";
                $stm = $this->conn->prepare($sql);
                //echo $data['weight'];
                $stm->bindParam(":soft_delete",$data['soft_delete']);
                $stm->bindParam(":date_key_score",$data['date_key_score']);
                $stm->bindParam(":kpi_score_id",$data['kpi_score_id']);
                
                
                $stm->execute();
            }catch(Exception $e){
                $err = $e->getMessage();
            }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
        }
        return $success;
    }

    function KpiScoreDelete($data) {
        $err = "";
        $success = array();
   
            try{
               
                $sql = "DELETE FROM ".$this->tbl_kpi_score." 
                WHERE `kpi_score_id` = :kpi_score_id ";
                $stm = $this->conn->prepare($sql);
                //echo $data['weight'];
                $stm->bindParam(":kpi_score_id",$data['kpi_score_id']);
                
                $stm->execute();
            }catch(Exception $e){
                $err = $e->getMessage();
            }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
        }
        return $success;
    }

    function KpiScoreSelect($per_cardno) { //ใช้ครับ ไฟล์ ajax-modal-kpi-score-show.php และ ajax-modal-clear_score.php
        $err = "";
        $success = array();
        $years = __year__;
            try{
                
                $sql = "SELECT
                ".$this->tbl_kpi_score.".`kpi_score_id`,
                ".$this->tbl_kpi_score.".`kpi_code`,
                ".$this->tbl_kpi_score.".`per_cardno`,
                ".$this->tbl_kpi_score.".`weight`,
                ".$this->tbl_kpi_score.".`works_name`,
                ".$this->tbl_kpi_score.".`kpi_score`,
                ".$this->tbl_kpi_score.".`kpi_accept`,
                `kpi_question`.`kpi_code_org`,
                `kpi_question`.`kpi_title`,
                `kpi_question`.`kpi_type`,
                `kpi_question`.`kpi_type2`
                FROM
                ".$this->tbl_kpi_score."
                RIGHT JOIN `kpi_question`
                ON ".$this->tbl_kpi_score.".`kpi_code` = `kpi_question`.`kpi_code`
                WHERE ".$this->tbl_kpi_score.".`per_cardno` = :per_cardno 
                AND ".$this->tbl_kpi_score.".`soft_delete` = 0 
                AND ".$this->tbl_kpi_score.".`years` = :years
                ORDER BY ".$this->tbl_kpi_score.".`kpi_score_id` asc";
                $stm = $this->conn->prepare($sql);
                $stm->bindParam(":per_cardno",$per_cardno);
                $stm->bindParam(":years",$years);
                $stm->execute();
                
                $result = $stm->fetchAll();
                // if (count($result) == 0){
                //     $err = 'record = 0';
                // }

            }catch(Exception $e){
                $err = $e->getMessage();
            }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
            $success['result'] = $result;
            
        }
        return $success;
    }

    function kpiQuestionSelectAll() {
        
        $err = "";
        $success = array();
   
            try{
                
                $sql = "select * from `kpi_question`  WHERE `kpi_status` = 1 ";
                $stm = $this->conn->prepare($sql);
                $stm->execute();

                $result = $stm->fetchAll();
            }catch(Exception $e){
                $err = $e->getMessage();
            }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
            $success['result'] = $result;
            
        }
        return $success;
    }

    function ckData($per_cardno,$kpi_code) {
        $success = array();
        $err = '';
        try{
            
            $sql = "SELECT kpi_score_id FROM ".$this->tbl_kpi_score." WHERE kpi_code = :kpi_code AND per_cardno = :per_cardno AND soft_delete = 0";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":per_cardno",$per_cardno);
            $stm->bindParam(":kpi_code",$kpi_code);
            $stm->execute();
            
            $n = $stm->fetch(PDO::FETCH_NUM);
            if($n == 0){
                $r = true;
            }
            elseif ($n > 0) {
                $r = false;
            }

        }catch(Exception $e){
            $err = $e->getMessage();
        }

        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = $r;
            $success['msg'] = 'Set Recorded ';
        }
        return $success;
    }


    function processScoreType2($kpi_code,$kpi_score_raw) {
        $success = array();
        $err = '';
        try
        {
            $sql = "SELECT * FROM `kpi_question`
                    WHERE `kpi_code` = :kpi_code";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":kpi_code",$kpi_code);
            $stm->execute();
            
            $result = $stm->fetchAll();
        //     echo "<pre>";
        //     print_r($result);
        //  echo "</pre>";
        if ($result[0]['kpi_con2'] == 1) {
            if ($kpi_score_raw <= $result[0]['kpi_rank5'] && $kpi_score_raw > $result[0]['kpi_rank4'] ) {
                $a = $result[0]['kpi_rank5'];
                $b = $result[0]['kpi_rank4'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($kpi_score_raw - $b)*$c;
                $success['result'] = 4 + $s;
                $success['success'] = true;
                // echo $c;

            }elseif ($kpi_score_raw <= $result[0]['kpi_rank4'] && $kpi_score_raw > $result[0]['kpi_rank3']) {
                 $a = $result[0]['kpi_rank4'];
                $b = $result[0]['kpi_rank3'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($kpi_score_raw - $b)*$c;
                $success['result'] = 3 + $s;
                $success['success'] = true;
            }elseif ($kpi_score_raw <= $result[0]['kpi_rank3'] && $kpi_score_raw > $result[0]['kpi_rank2']) {
                $a = $result[0]['kpi_rank3'];
                $b = $result[0]['kpi_rank2'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($kpi_score_raw - $b)*$c;
                $success['result'] = 2 + $s;
                $success['success'] = true;
            }elseif ($kpi_score_raw <= $result[0]['kpi_rank2'] && $kpi_score_raw > $result[0]['kpi_rank1']) {
                $a = $result[0]['kpi_rank2'];
                $b = $result[0]['kpi_rank1'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($kpi_score_raw - $b)*$c;
                $success['result'] = 1 + $s;
                $success['success'] = true;

            }elseif ($kpi_score_raw <= $result[0]['kpi_rank1'] && $kpi_score_raw > 0) {
                // $a = $result[0]['kpi_rank1'];
                // $b = 0;

                // $c = 100 / ($a - $b);
                // $c = $c / 100;

                // $s = ($kpi_score_raw - $b)*$c;
                // $success['result'] = 0 + $s;
                $success['result'] = 1;
                $success['success'] = true;
             }elseif($kpi_score_raw >= $result[0]['kpi_rank5'] ) { //&& $kpi_score_raw <= 100
                $success['result'] = 5;
                $success['success'] = true;

             }
            //  elseif ($kpi_score_raw >= 101) {
            //     $success['success'] = false;
            //     $success['result'] = null;
            //     $success['msg'] = 'คะแนนไม่ได้อยู่ในเงื่อนไขที่กำหนด คะแนนต้องไม่เกิน 100 ท่านกรอกคะแนน ' . $kpi_score_raw ;
            // }
            else {
                $success['result'] = null;
                $success['success'] = false;
                $success['msg'] = 'เกิดข้อผิดพลาด กรุณาตัวสอบคะแนนที่ท่านกรอก';
            }
        }if ($result[0]['kpi_con2'] == 2){
            if ($kpi_score_raw <= $result[0]['kpi_rank5']) {
                
                $success['result'] = 5;
                $success['success'] = true;
                // echo $c;

            }elseif ($kpi_score_raw <= $result[0]['kpi_rank4'] ) {
                 $a = $result[0]['kpi_rank4'];
                $b = $result[0]['kpi_rank5'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($b - $kpi_score_raw )*$c;
                $success['result'] = 5 + $s;
                $success['success'] = true;
            }elseif ($kpi_score_raw <= $result[0]['kpi_rank3'] ) {
                $a = $result[0]['kpi_rank3'];
                $b = $result[0]['kpi_rank4'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($b - $kpi_score_raw )*$c;
                $success['result'] = 4 + $s;
                $success['success'] = true;
            }elseif ($kpi_score_raw <= $result[0]['kpi_rank2']) {
                $a = $result[0]['kpi_rank2'];
                $b = $result[0]['kpi_rank3'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($b - $kpi_score_raw)*$c;
                $success['result'] = 3 + $s;
                $success['success'] = true;

            }elseif ($kpi_score_raw <= $result[0]['kpi_rank1']) {
                $a = $result[0]['kpi_rank1'];
                $b = $result[0]['kpi_rank2'];

                $c = 100 / ($a - $b);
                $c = $c / 100;

                $s = ($b - $kpi_score_raw)*$c;
                $success['result'] = 2 + $s;
                $success['success'] = true;
             }elseif ($kpi_score_raw > $result[0]['kpi_rank1']) {
                // $a = 100;
                // $b = $result[0]['kpi_rank1'];

                // $c = 100 / ($a - $b);
                // $c = $c / 100;

                // $s = ($b - $kpi_score_raw)*$c;
                // $success['result'] = 1 + $s;
                $success['result'] = 1;
                $success['success'] = true;
             }
            else {
                $success['result'] = null;
                $success['success'] = false;
                $success['msg'] = 'เกิดข้อผิดพลาด กรุณาตัวสอบคะแนนที่ท่านกรอก';
            }   
        }
           


        }catch(Exception $e)
        {
            $err = $e->getMessage();
            $success['success'] = null;
            $success['msg'] = $err;
        }
        return $success;
    }


    function kpiBtnStatus1($kpi_score_id) {  //รอยืนยัน
        $err = '';
        $success = array();
        try
        {
            $sql = "SELECT `kpi_score`
                    FROM ".$this->tbl_kpi_score."
                    WHERE   `kpi_score_id` = :kpi_score_id" ;
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":kpi_score_id",$kpi_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
            
        //     echo "<pre>";
        //     print_r($result[0][0]);
        //  echo "</pre>";
            if ($result[0][0] == null) {
                $success['success'] = false;  //กรอกคะแนน ยังไม่สมบูรณ์  
            }elseif ($result[0][0] != "") {
                $success['success'] = true;  //กรอกคะแนน สมบูรณ์  
            }
            // else {
            //     $success['success'] = false;
            // }
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }

        return $success;
    }

    function kpiBtnStatus2($kpi_score_id) {  //รอยืนยัน 
        $err = '';
        $success = array();
        try
        {
            $sql = "SELECT `kpi_accept`,
                           `kpi_comment`
                    FROM ".$this->tbl_kpi_score."
                    WHERE   `kpi_score_id` = :kpi_score_id" ;
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":kpi_score_id",$kpi_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
        //     echo "<pre>";
        //     print_r($result[0][0]);
        //  echo "</pre>";
            if ($result[0][0] == null) {
                $success['success'] = false;  //กรอกคะแนน ยังไม่สมบูรณ์  
                $success['result'] =  0;
            }elseif ($result[0][0] == 1) {
                $success['success'] = true;  //กรอกคะแนน สมบูรณ์  
                $success['result'] =  $result[0][0];
            }
            // else {
            //     $success['success'] = false;
            // }
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }

        return $success;
    }

    function kpiStatus3($per_cardno,$years) {   //สถานะของปุ่ม ผู้ยืนยันผล
        $err = '';
        $success = array();
        $choiseFinish = 0;
        $choiseAccepted = 0;
        try{
            $sql = "SELECT * FROM ".$this->tbl_kpi_score." 
                    WHERE `per_cardno` = :per_cardno 
                    AND years = :years 
                    AND soft_delete = 0";
             $stm = $this->conn->prepare($sql);
             $stm->bindParam(":per_cardno",$per_cardno);
             $stm->bindParam(":years",$years);
             $stm->execute();
             $result = $stm->fetchAll();
            $count = $stm->rowCount();
             foreach ($result as $key => $value) {
                if ($value['kpi_score'] != "") {
                    $choiseFinish++;
                    if ($value['kpi_accept'] == 1 || $value['kpi_accept'] == 2 ) {
                        $choiseAccepted++; 
                    }
                }
             }

             $success['success'] = true;
             $success['msg'] = 'ok';
             $success['total_choise'] = $count;
             $success['choiseFinish'] = $choiseFinish;
             $success['choiseAccepted'] = $choiseAccepted;
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }
        return $success;

    }

    function noAccept($kpi_score_id,$comment,$dateNow) {
        $err = '';
        $success = array();
        $c= '';
        try{
            $sql = "SELECT * FROM ".$this->tbl_kpi_score." 
                    WHERE `kpi_score_id` = :kpi_score_id ";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":kpi_score_id",$kpi_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
            $count = $stm->rowCount();
             $h = $this->WhoIsHead($kpi_score_id);
            if ($count == 1) {
                $c .= $result[0]['kpi_comment']."\n"; 
                $c .= "วันที่: ".$dateNow."\t ผู้บัญคับบัญชา: ".$h['per_name']." ".$h['per_surname']."\n"
                      ."เหตุผล : ".$comment."\n";

               $sqlUpdate = "UPDATE ".$this->tbl_kpi_score." SET `kpi_comment` = :c ,
                                    `kpi_score` = :kpi_score ,
                                    `kpi_score_raw` = :kpi_score_raw,
                                    `kpi_accept` = :kpi_accept
                             WHERE kpi_score_id = :kpi_score_id";
               $stmUpdate= $this->conn->prepare($sqlUpdate);
               $stmUpdate->bindParam(":c",$c);
               $stmUpdate->bindValue(":kpi_score",null);
               $stmUpdate->bindValue(":kpi_score_raw",null);
               $stmUpdate->bindValue(":kpi_accept",2);
               $stmUpdate->bindParam(":kpi_score_id",$kpi_score_id);
               $stmUpdate->execute();
               $count = $stm->rowCount();
               if ($count == 1) {
                $success['success'] = true;
                $success['msg'] = $c;
               }else {
                $success['success'] = false;
                $success['msg'] = $c;
               }       
            }
            
        }catch(Exception $e){
            $err = $e->getMessage();
        }
        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }
        return $success;

    }

    function WhoIsHead($kpi_score_id) {  //accept-ajax-eva-kpi-modal-show-type3.php ,ajax-eva-kpi-modal-show-type2.php,ajax-eva-kpi-modal-show-type3.php
        $err = '';
        $success = array();
        try{
            $sql = "SELECT * FROM ".$this->tbl_per_personal
                    ."  where per_cardno = (select per_cardno from ".$this->tbl_per_personal
                    ." where per_cardno = :head) ";


            $sql ="SELECT * FROM ".$this->tbl_per_personal." 
                    where `per_cardno` = 
                        (select `head` from ".$this->tbl_per_personal."
                        where `per_cardno` = 
                            (select `per_cardno` FROM ".$this->tbl_kpi_score." WHERE `kpi_score_id` = :kpi_score_id ))";

            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":kpi_score_id",$kpi_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
            
        }catch(Exception $e){
            $err = $e->getMessage();
        }
        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }else {
            $success['success'] = true;
            $success['msg'] = "";
            $success['result'] = $result;
        }
        return $success;
    }

}
    

