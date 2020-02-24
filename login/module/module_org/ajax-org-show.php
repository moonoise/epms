<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
  
 $db = new DbConn;
 $sql = "select * from per_org where org_id_ref = :org_id_ref" ;
 $stm = $db->conn->prepare($sql);
//echo $sql;
 $stm->bindParam(':org_id_ref',$_POST['org_id']);
 $stm->execute();
 $result = $stm->fetchAll();

 $output = array();
foreach ($result as $row) {
    $output[] = $row;
    //unset($row);
}

echo json_encode($output);