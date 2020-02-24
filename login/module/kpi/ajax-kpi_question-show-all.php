<?php
  include_once "../../config.php";
  include_once "../../includes/dbconn.php";
 
$success = array('success' => null ,
                 'msg' => null,
                'result' => null );

try{
    $db = new DbConn;
    $sql = "SELECT `kpi_code`,
                    `kpi_code_org`,
                    `kpi_title`,
                    `kpi_type`,
                    `kpi_type2`
                    
             FROM `kpi_question` WHERE `kpi_status` = 1 "; 
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    $success['success'] = true;
}catch(Exception $e){
    $success['msg'] = $e->getMessage();
    $success['success'] = null;
}

foreach ($result as $key => $value) {
    
   $result[$key]['kpi_type'] = $kpiType[$value['kpi_type']];
   $result[$key]['kpi_type2'] = $kpi_type_text[$value['kpi_type2']];
   $result[$key]['edit'] = "<button type=\"button\" class=\"btn btn-info btn-xs\" onclick=\"kpi_edit(`".$value['kpi_code']."`)\"><i class=\"fa fa-eye\"></i>ดู</button>";
}
$success['result'] = $result; 

echo json_encode($success);