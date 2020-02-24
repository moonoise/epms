<?php
$msg = array();
if (!empty($_GET['pl_code']) && !empty($_GET['question_no'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    $err = '';
    try{
        $db = new DbConn;
        $sql_ck = 'select pl_code from cpc_question_create where pl_code = :pl_code and question_no = :question_no';
        $c = $db->conn->prepare($sql_ck);
        $c->bindParam(":pl_code",$_GET['pl_code']);
        $c->bindParam(":question_no",$_GET['question_no']);
        $c->execute();
        $n = $c->fetch(PDO::FETCH_NUM);

        if ($n == 0) {
            $sql = "insert into cpc_question_create (question_no,pl_code) values (:question_no , :p_code)";
            $stm =   $db->conn->prepare($sql);
            $stm->bindParam(":question_no",$_GET['question_no']);
            $stm->bindParam(":p_code",$_GET['pl_code']);
            $stm->execute();
        }else {
            $err = 'ข้อมูลถูกบันทึกไปแล้ว';
        }
        
        
    }catch(PDOException $e){
        $err = $e->getMessage();
    }
    if ($err!='') {
        $msg['success'] = false;
        $msg['msg']  = $err;
    }else {
        $msg['success'] = true;
    }

}else {
    $msg['success'] = false;
    $msg['msg']  = 'error-01';
}

echo json_encode($msg);

