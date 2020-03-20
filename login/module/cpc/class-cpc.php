<?php
// @include_once "../../config.php";
// @include_once "../../includes/dbconn.php";
class cpc extends DbConn
{
   function cpcQuestionSelectAll($question_status) 
   {
        $err = '';
        $success = array();
        try
        {
            $sql = "SELECT *  FROM `cpc_question` WHERE `question_status` = :question_status";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":question_status",$question_status);
            $stm->execute();
            $result = $stm->fetchAll();


        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }

        if ($err != '') 
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }else 
        {
            $success['success'] = true;
            $success['result'] = $result;
        }
        return $success;
   }


   function cpcScoreSelect($data,$cpcScoreTable) {  // ใช้กับไฟล์ ajax-modal-cpc_score-show.php และ ajax-modal-clear_score.php
    $err = '';
    $success = array();
    try{
        $sql = "SELECT
                ".$cpcScoreTable.".`cpc_score_id`,
                ".$cpcScoreTable.".`question_no`,
                ".$cpcScoreTable.".`per_cardno`,
                ".$cpcScoreTable.".`cpc_divisor`,
                ".$cpcScoreTable.".`cpc_score1`,
                ".$cpcScoreTable.".`cpc_score2`,
                ".$cpcScoreTable.".`cpc_score3`,
                ".$cpcScoreTable.".`cpc_score4`,
                ".$cpcScoreTable.".`cpc_score5`,
                ".$cpcScoreTable.".`cpc_accept1`,
                ".$cpcScoreTable.".`cpc_accept2`,
                ".$cpcScoreTable.".`cpc_accept3`,
                ".$cpcScoreTable.".`cpc_accept4`,
                ".$cpcScoreTable.".`cpc_accept5`,
                `cpc_question`.`question_code`,
                `cpc_question`.`question_title`,
                `cpc_question`.`question_type`
                FROM
                ".$cpcScoreTable."
                RIGHT JOIN `cpc_question`
                ON ".$cpcScoreTable.".`question_no` = `cpc_question`.`question_no`
                AND `cpc_question`.`question_type` = :question_type
                WHERE ".$cpcScoreTable.".`per_cardno` = :per_cardno 
                AND ".$cpcScoreTable.".`soft_delete` = :soft_delete
                AND ".$cpcScoreTable.".`years` = :years
                ORDER BY `cpc_question`.`question_no` ASC
                ";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":question_type",$data['question_type']);
        $stm->bindParam(":per_cardno",$data['per_cardno']);
        $stm->bindParam(":years",$data['years']);
        $stm->bindParam(":soft_delete",$data['soft_delete']);
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
//มี cpc_score ว่ามี record นั้นอยู่ไหม  ว่ามีส่ง -> true  ไม่มีส่ง->false  error -> null  
   function cpcScoreCheck($data,$cpcScoreTable) {
    $err = '';
    $success = array();
    $n= '';
    try
    {
        $sql = "SELECT cpc_score_id FROM $cpcScoreTable 
                WHERE question_no = :question_no
                      AND per_cardno = :per_cardno
                      AND years = :years
                      AND soft_delete = :soft_delete";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":question_no",$data['question_no']);
        $stm->bindParam(":per_cardno",$data['per_cardno']);
        $stm->bindParam(":years",$data['years']);
        $stm->bindParam("soft_delete",$data['soft_delete']);
        $stm->execute();
        $result = $stm->fetchAll();
        $n = $stm->rowCount();
        //echo $n;    
    }catch(Exception $e)
    {
        $err = $e->getMessage();
    }
    if ($err != '') {
        $success['success'] = null;
        $success['msg'] = $err;
    }else {
        if ($n == 0) {
            $success['success'] = false;
            $success['msg'] = $n;
        }elseif ($n > 0) {
            $success['success'] = true;
            $success['msg'] = $n;
        }
    }
    return $success;
   }

   //ดึง cpc question ตามตำแหน่งของผู้ประเมิน  พร้อมค่าคาดหวัง ที่ได้จากฟังก์ชั่น cpc_divisor 
   function cpcScoreGetDefault($per_cardno,$pl_code,$level_no) {
        $err = '';
        $success = array('success' => null,
                            'result' => null,
                            'msg' => null);
        try{
            $cpc_question_create = "SELECT * FROM cpc_question_create WHERE pl_code = :pl_code";
            $cpcCreate = $this->conn->prepare($cpc_question_create);
            $cpcCreate->bindParam(":pl_code",$pl_code);
            $cpcCreate->execute();

            $resultCPC = $cpcCreate->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($resultCPC) > 0)
            {
                foreach ($resultCPC as $key => $value) {
                      //echo $value['question_no'].'-'.$level_no;
                    $d = $this->cpc_divisor($level_no,$value['question_no']);
                    $a  = array('per_cardno' =>$per_cardno ,
                          'cpc_divisor'=> $d['result'] );
                    //echo var_dump($d);
                   $value = $value + $a;
                   $success['result'][$key] = $value;
                   $success['success'] = true;
                }
            }else {
                $success['success'] = false;
                $success['msg'] = 'record = 0';
                $success['result'] = null;
            }
        }catch(Exception $e)
        {
            $err = $e->getMessage();
            $success['msg'] = 'cpcScoreGetDefault -> '.$err;
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }
        // else {
        //     $success['success'] = true;
        // }
        return $success;
   }
   // insert ข้อมูลที่ได้จาก cpcScoreGetDefault  มาใส่ใน cpc_score
   function cpcScoreSet($data,$cpcScoreTable) {
        $err = '';
        $success = array();
        try
        {
            $sqlInsert = "INSERT INTO $cpcScoreTable
                            (
                            `question_no`,
                            `per_cardno`,
                            `id_admin`,
                            `years`,
                            `cpc_divisor`,
                            `date_key_score`,
                            `soft_delete`
                            )
                           VALUES
                           (
                               :question_no,
                               :per_cardno,
                               :id_admin,
                               :years,
                               :cpc_divisor,
                               :date_key_score,
                               :soft_delete
                           )";
            $stm = $this->conn->prepare($sqlInsert);
            $stm->bindParam(":question_no",$data['question_no']);
            $stm->bindParam(":per_cardno",$data['per_cardno']);
            $stm->bindParam(":id_admin",$data['id_admin']);
            $stm->bindParam(":years",$data['years']);
            $stm->bindParam(":cpc_divisor",$data['cpc_divisor']);
            $stm->bindParam(":date_key_score",$data['date_key_score']);
            $stm->bindParam(":soft_delete",$data['soft_delete']);
            $stm->execute();
            //$result = $stm->fetchAll(PDO::FETCH_ASSOC);
           
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = 'cpcScoreSetDefault -> '.$err;
        }else {
            $success['success'] = true;
            $success['result'] = $data['per_cardno']." -> ".$data['question_no']." OK";
        }
        //echo '<pre>'; print_r($data); echo '</pre>';
        //echo $sqlInsert;
        return $success;

   }

//ค่าคาดหวัง หรือจำนวนข้อที่เอาไปหารเป็นคะแนน
   function cpc_divisor($level_no,$question_no)
   {    $err = '';
        $success = array();
        try
        {
            $sql = "SELECT question_type FROM cpc_question WHERE question_no = :question_no";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":question_no",$question_no);
            $stm->execute();
            $r = $stm->fetchAll(PDO::FETCH_NUM);
             //echo '<pre>'; print_r($r); echo '</pre>';
            if( count($r[0]) == 1 ){
               //echo $r[0][0];
                switch ($r[0][0]) {
                    case 1:
                        $sqlDivisor = "SELECT question_type_1 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    case 2:
                        $sqlDivisor = "SELECT question_type_2 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    case 3:
                        $sqlDivisor = "SELECT question_type_3 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    case 4:
                        $sqlDivisor = "SELECT question_type_4 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    case 5:
                        $sqlDivisor = "SELECT question_type_5 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    case 6:
                        $sqlDivisor = "SELECT question_type_6 FROM cpc_divisor WHERE level_no = :level_no";
                        break;
                    default:
                }
                //echo $sqlDivisor."<br>";
                $stm2 = $this->conn->prepare($sqlDivisor);
                $stm2->bindParam(":level_no",$level_no);
                $stm2->execute();
                $r2 = $stm2->fetchAll(PDO::FETCH_NUM);
                //echo '<pre>'; print_r($r2); echo '</pre>';
                if (count($r2) == 1) {
                    $success['success'] = true;
                    $success['result'] = $r2[0][0];
                }else {
                    $success['success'] = null;
                    $success['msg'] = 'Query cpc_divisor->question_type_* Error';
                }

            } else {
                $success['success'] = null;
                $success['msg'] = 'Query cpc_question->question_type Error';
            }
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }
        //echo '<pre>'; print_r($success['result']); echo '</pre>';
        return $success;

   }

   // ลบข้อมูล อัพเดท sofe_delete
   function cpcScoreSoftDeleteByPer_cardno($data,$cpcScoreTable) 
   {
    $err = '';
    $success = array();
    try
        {
            $sql = "UPDATE $cpcScoreTable 
                    SET soft_delete = :soft_delete, 
                        id_admin = :id_admin,
                        date_key_score = :date_key_score
                    WHERE per_cardno = :per_cardno
                    AND years = :years";
                          
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":soft_delete",$data['soft_delete']);
            $stm->bindParam(":id_admin",$data['id_admin']);
            $stm->bindParam(":date_key_score",$data['date_key_score']);
            $stm->bindParam(":per_cardno",$data['per_cardno']);
            $stm->bindParam(":years",$data['years']);
            $stm->execute();
           
            //$count = $stm->rowCount();
            
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }

        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = "cpcScoreSoftDeleteByPer_cardno -> ".$err;
        }else
        {
            $success['success'] = true;
        }
        //echo $sql; 
        return $success;
    }
    // update soft_delete ทีละ field
    function cpcScoreSoftDeleteByCpc_score_id($data,$cpcScoreTable) 
    {
    $err = '';
    $success = array();
    try
        {
            $sql = "UPDATE $cpcScoreTable
                    SET soft_delete = :soft_delete, 
                        id_admin = :id_admin,
                        date_key_score = :date_key_score
                    WHERE cpc_score_id = :cpc_score_id";
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":soft_delete",$data['soft_delete']);
            $stm->bindParam(":id_admin",$data['id_admin']);
            $stm->bindParam(":date_key_score",$data['date_key_score']);
            $stm->bindParam(":cpc_score_id",$data['cpc_score_id']);
            $stm->execute();
            //$stm->fetchAll();

        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }

        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = "cpcScoreSoftDeleteByCpc_score_id -> ".$err;
        }else
        {
            $success['success'] = true;
        }
        return $success;
    }

    // update delete จริง หลายๆ  field พร้อมกัน status soft_delete ตามกำหนด
    function cpcScoreDeleteByPer_cardno($data,$cpcScoreTable) 
    {
    $err = '';
    $success = array();
    try
        {
            $sql = "DELETE FROM $cpcScoreTable
                    WHERE per_cardno = :per_cardno 
                    AND soft_delete = :soft_delete
                    AND years = :years";
                    
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":soft_delete",$data['soft_delete']);
            $stm->bindParam(":per_cardno",$data['per_cardno']);
            $stm->bindParam(":years",$data['years']);
            
            $stm->execute();
            //$stm->fetchAll();

        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }

        if ($err != '')
        {
            $success['success'] = null;
            $success['msg'] = "cpcScoreDeleteByPer_cardno -> ".$err;
        }else
        {
            $success['success'] = true;
        }
        return $success;
    }

    function cpcBtnStatus1($cpc_score_id,$cpcScoreTable) {  //รอยืนยัน
        $err = '';
        $success = array();
        try
        {
            $sql = "SELECT CASE 
                    WHEN `cpc_score1` IS NULL
                    OR  `cpc_score2` IS NULL
                    OR  `cpc_score3` IS NULL
                    OR  `cpc_score4` IS NULL
                    OR  `cpc_score5` IS NULL
                    THEN 'true' ELSE 'false' 
                    END
                    FROM $cpcScoreTable
                    WHERE   `cpc_score_id` = :cpc_score_id" ;
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":cpc_score_id",$cpc_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
        //     echo "<pre>";
        //     print_r($result[0][0]);
        //  echo "</pre>";
            if ($result[0][0] === 'true') {
                $success['success'] = false;  //กรอกคะแนน ยังไม่สมบูรณ์  
            }elseif ($result[0][0] === 'false') {
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

    function cpcBtnStatus2($cpc_score_id,$cpcScoreTable) {  //เช็คว่าผู้บังคับบัญชายืนยันครบยัง
        $err = '';
        $success = array();
        try
        {
            $sql = "SELECT CASE 
                    WHEN `cpc_accept1` IS NULL
                    OR  `cpc_accept2` IS NULL
                    OR  `cpc_accept3` IS NULL
                    OR  `cpc_accept4` IS NULL
                    OR  `cpc_accept5` IS NULL
                    THEN 'true' ELSE 'false' 
                    END
                    FROM $cpcScoreTable
                    WHERE   `cpc_score_id` = :cpc_score_id" ;
            $stm = $this->conn->prepare($sql);
            $stm->bindParam(":cpc_score_id",$cpc_score_id);
            $stm->execute();
            $result = $stm->fetchAll();
            if ($result[0][0] === 'true') {
                $success['success'] = false;  //ยืนยันคะแนน ยังไม่สมบูรณ์  
            }elseif ($result[0][0] === 'false') {
                $success['success'] = true;  //ยืนยันคะแนน สมบูรณ์  
            }
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


    function cpcStatus3($per_cardno,$years,$cpcScoreTable) {  // เช็ดว่า  ผู้ประเมิน ทำประเมินครบแล้วยัง  return ออกมาเป็นจำนวนที่ประเมิน และจำนวนเป็นเสร็จแล้ว และจำนวนที่ Accept แล้ว
        $err = '';
        $success = array();
        $choiseFinish = 0;
        $choiseAccepted = 0;
        // soft_delete = 0 ;
        try{
            $sql = "SELECT * FROM $cpcScoreTable 
                    WHERE `per_cardno` = :per_cardno 
                    AND years = :years 
                    AND soft_delete = 0";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":per_cardno",$per_cardno);
        $stm->bindParam(":years",$years);
        $stm->execute();
    
        $result = $stm->fetchAll();
        $count = $stm->rowCount();
        if ($count > 0 ) {
            foreach ($result as $key => $value) {
                $cpc1 = $this->cpcBtnStatus1($value['cpc_score_id'],$cpcScoreTable);
                if ($cpc1['success'] === true) {
                    $choiseFinish++;
                    $cpc2 = $this->cpcBtnStatus2($value['cpc_score_id'],$cpcScoreTable);
                    if ($cpc2['success'] === true) {
                        $choiseAccepted++;
                    }
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

    function cpcStatus4($per_cardno,$years) { //เช็ดว่า  ผู้ประเมิน ทำประมาณครบแล้วยัง  return true / false
        $success = array();
        $result = $this->cpcStatus3($per_cardno,$years,$cpcScoreTable);

        if($result['total_choise'] == $result['choiseAccepted']){
            $success['result'] = true;
        }else {
            $success['result'] = true;
        }
        return $success;
    }


}




// if (count($resultCPC) > 0 ) {
            //     $sqlInsert = "INSERT INTO `cpc_score` 
            //     (   `cpc_score_id`, 
            //         `question_no`, 
            //         `per_cardno`, 
            //         `id_admin`, 
            //         `years`, 
            //         `date_key_score`, 
            //         `cpc_divisor`,
            //         `soft_delete`) 
            //     VALUES (NULL, 
            //             '', 
            //             NULL,
            //             NULL, 
            //             NULL, 
            //             NULL, 
            //             NULL, 
            //             NULL, 
            //             '0')";
            // }