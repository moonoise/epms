<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$success = array('success' => null ,
               'msg' => null
               );

$db = new DbConn;

if ($_POST['type_form'] == "new") {
    $sql = "INSERT INTO `kpi_question` (`kpi_code`,`kpi_code_org`,
                                      `kpi_title`,`kpi_type`,`kpi_type2`,`kpi_con2`,
                                       `kpi_level1`,`kpi_level2`,`kpi_level3`,`kpi_level4`,`kpi_level5`,
                                       `kpi_rank1`,`kpi_rank2`,`kpi_rank3`,`kpi_rank4`,`kpi_rank5`,`kpi_status`
                                        ) values (
                                            :kpi_code,:kpi_code_org ,
                                            :kpi_title,:kpi_type,:kpi_type2,:kpi_con2,
                                            :kpi_level1,:kpi_level2,:kpi_level3,:kpi_level4,:kpi_level5,
                                            :kpi_rank1,:kpi_rank2,:kpi_rank3,:kpi_rank4,:kpi_rank5,1
                                        ) "; 

    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":kpi_code" , $_POST['kpi_code_new']);
    $stm->bindParam(":kpi_code_org" , $_POST['kpi_code_org']);
    $stm->bindParam(":kpi_title" , $_POST['kpi_title']);
    $stm->bindParam(":kpi_type" , $_POST['kpi_type']);
    $stm->bindParam(":kpi_type2" , $_POST['kpi_type2']);
    $stm->bindParam(":kpi_con2" , $_POST['kpi_con2']);
    $stm->bindParam(":kpi_level1" , $_POST['kpi_level1']);
    $stm->bindParam(":kpi_level2" , $_POST['kpi_level2']);
    $stm->bindParam(":kpi_level3" , $_POST['kpi_level3']);
    $stm->bindParam(":kpi_level4" , $_POST['kpi_level4']);
    $stm->bindParam(":kpi_level5" , $_POST['kpi_level5']);
    $stm->bindParam(":kpi_rank1" , $_POST['kpi_rank1']);
    $stm->bindParam(":kpi_rank2" , $_POST['kpi_rank2']);
    $stm->bindParam(":kpi_rank3" , $_POST['kpi_rank3']);
    $stm->bindParam(":kpi_rank4" , $_POST['kpi_rank4']);
    $stm->bindParam(":kpi_rank5" , $_POST['kpi_rank5']);
    
} elseif($_POST['type_form'] == "update") {
    $sql = "UPDATE `kpi_question` SET 
                                      `kpi_title` = :kpi_title ,
                                      `kpi_type` = :kpi_type ,
                                      `kpi_type2` = :kpi_type2 ,
                                      `kpi_con2` = :kpi_con2 ,
                                      `kpi_level1` = :kpi_level1 ,
                                      `kpi_level2` = :kpi_level2 ,
                                      `kpi_level3` = :kpi_level3 ,
                                      `kpi_level4` = :kpi_level4 ,
                                      `kpi_level5` = :kpi_level5 ,
                                       `kpi_rank1` = :kpi_rank1 ,
                                       `kpi_rank2` = :kpi_rank2 ,
                                       `kpi_rank3` = :kpi_rank3 ,
                                       `kpi_rank4` = :kpi_rank4 ,
                                       `kpi_rank5` = :kpi_rank5 
            WHERE `kpi_code` = :kpi_code 
                                       ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":kpi_title" , $_POST['kpi_title']);
    $stm->bindParam(":kpi_type" , $_POST['kpi_type']);
    $stm->bindParam(":kpi_type2" , $_POST['kpi_type2']);
    $stm->bindParam(":kpi_con2" , $_POST['kpi_con2']);
    $stm->bindParam(":kpi_level1" , $_POST['kpi_level1']);
    $stm->bindParam(":kpi_level2" , $_POST['kpi_level2']);
    $stm->bindParam(":kpi_level3" , $_POST['kpi_level3']);
    $stm->bindParam(":kpi_level4" , $_POST['kpi_level4']);
    $stm->bindParam(":kpi_level5" , $_POST['kpi_level5']);
    $stm->bindParam(":kpi_rank1" , $_POST['kpi_rank1']);
    $stm->bindParam(":kpi_rank2" , $_POST['kpi_rank2']);
    $stm->bindParam(":kpi_rank3" , $_POST['kpi_rank3']);
    $stm->bindParam(":kpi_rank4" , $_POST['kpi_rank4']);
    $stm->bindParam(":kpi_rank5" , $_POST['kpi_rank5']);

    $stm->bindParam(":kpi_code" , $_POST['kpi_code']);

} 

try{
    $stm->execute();
    $success['success'] = true;
}catch(Exception $e) {
    $success['msg'] = $e->getMessage();
    $success['success'] = null;
}

echo json_encode($success);