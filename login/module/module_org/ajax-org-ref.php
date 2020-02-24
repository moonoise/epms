<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
  
 $db = new DbConn;
 $sql = "select * FROM per_org WHERE org_id_ref = (SELECT org_id_ref FROM `per_org` WHERE org_id = :org_id) ORDER BY `org_id` ASC";

 $stm = $db->conn->prepare($sql);
//echo $sql;
 $stm->bindParam(':org_id',$_POST['org_id']);
 $stm->execute();
 $result = $stm->fetchAll();

 $output = array();
foreach ($result as $row) {
    $output[] = $row;
    //unset($row);
}

echo json_encode($output);

   
   