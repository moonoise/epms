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
                    `kpi_type2`,
                    `kpi_status`
             FROM `kpi_question` "; 
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
   $result[$key]['kpi_status'] = ($value['kpi_status'] == 1 ? "<span class=\"text text-info\">เปิด</span>" : "<span  class=\"text text-danger\">ปิด</span>");
   $result[$key]['edit'] = "<button type=\"button\" class=\"btn btn-warning btn-xs\" onclick=\"kpi_edit(`".$value['kpi_code']."`,`".$value['kpi_type2']."`)\"><i class=\"fa fa-edit\"></i>แก้ไข</button>&nbsp;
                            <button type=\"button\" class=\"btn ".($value['kpi_status'] == 1?"btn-success":"btn-danger")." btn-xs confirm-change-kpi_status \" onclick=\"kpi_status_edit(`".$value['kpi_code']."`)\"><i class=\"fa fa-bell-slash-o\"></i>เปิด/ปิด</button>";
}
$success['result'] = $result; 

echo json_encode($success);