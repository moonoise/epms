<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
  

 $db = new DbConn;
 $output = array();



 $sql2 = "select * from per_org where org_id = :org_id" ;
 $stm2 = $db->conn->prepare($sql2);
//echo $sql;
 $stm2->bindParam(':org_id',$_GET['org_id']);
 $stm2->execute();
 $result2 = $stm2->fetchAll(PDO::FETCH_ASSOC);

if(count($result2) > 0){
    $output[]['org_id'] = $result2[0]['org_id'];
    $output[]['org_name'] = $result2[0]['org_name'];
}

 $sql = "select * from per_org where org_id_ref = :org_id_ref" ;
 $stm = $db->conn->prepare($sql);
//echo $sql;
 $stm->bindParam(':org_id_ref',$_GET['org_id']);
 $stm->execute();
 $result = $stm->fetchAll(PDO::FETCH_ASSOC);

 
foreach ($result as $key => $value) {
    # code...
    $output[]['org_id'] = $value['org_id'];
    $output[]['org_name'] = $value['org_name'];
}


// foreach ($result as $row) {
//     $output[] = $row;
//     //unset($row);
// }



echo json_encode($output);

// echo "<pre>";
// print_r($output);
// echo "</pre>";

   
   