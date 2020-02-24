<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
  
 $db = new DbConn;


    $sql = "select * FROM per_org WHERE org_id = :org_id";

    $stm = $db->conn->prepare($sql);
   //echo $sql;
    $stm->bindParam(':org_id',$_POST['org_id']);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);


    


echo json_encode($result);

   
   