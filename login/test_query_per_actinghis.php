<?php
session_start();
include_once "config.php";
include_once "includes/dbconn.php";
include_once "includes/ociConn.php";
include_once "module/myClass.php";

$err = "";
$dbConn = new DbConn;
$ociDB = new ociConn;
$ociConn = $ociDB->ociConnect();

$myClass = new myClass;
$currentYear = $myClass->callYear();
$per_personal = $currentYear['data']['per_personal'];

$id = array();
// $sqlOracle = array();
$moveCode = array();
$sqlID = array();
$i = 0;
try{
    $sql = "SELECT per_cardno FROM ".$per_personal;
   
    $stm = $dbConn->conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_NUM);

}catch(Exception $e){
    $err = $e->getMessage();
}
foreach ($result as $key => $value) {
    if($i < 999){
        array_push($id,$value[0]);
        $i++;
    }else {
        $sqlID[] = "'".implode("','",$id)."'";
        $id = array();
        $i=0;
    }
}
if (count($id) > 0 ) {
    $sqlID[] = "'".implode("','",$id)."'";
}
foreach ($sqlID as $key => $value) {
    $sqlOracle = "SELECT PER_CARDNO FROM PER_ACTINGHIS WHERE MOV_CODE = 10211 AND PER_CARDNO IN (".$value.")";
    $stid = oci_parse($ociConn,$sqlOracle);
    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        array_push($moveCode,$row) ;
     }
}

$rr = updateMovCode($moveCode);
if ($rr['success'] === null) {
    echo $rr['msg'];
}

function updateMovCode($moveCode) {
    $err = "";
    $success = array();
    $dbConn = new DbConn;
    $i = 0;
    try{
        $sqlUpdate = "UPDATE `$per_personal` SET `mov_code` = :mov_code WHERE per_cardno = :per_cardno ";
        $stm = $dbConn->conn->prepare($sqlUpdate);
        $stm->bindValue(":mov_code",10211);
        echo count($moveCode)."<br>";
        foreach ($moveCode as $key => $value) {
            $v = intval($value['PER_CARDNO']);
            $stm->bindParam(":per_cardno",$v);
            $stm->execute();
            $count = $stm->rowCount();
            $i++;
            // if($count > 0){
            //     echo $v."ok <br>";
            // }else {
            //     echo $v."error <br>";
                
            // }
            
        }
    echo $i."<br>";
        
    }catch(Exception $e)
    {
        $err = $e->getMessage();
    }
    if ($err != '') {
        $success['success'] = null;
        $success['msg'] = $err;
    }else {
        $success['success'] = true;
        $success['msg'] = "";
    }
    return $success;

}



 // echo $sqlOracle ."<br>";
// echo $sqlOracle;
// echo "<pre>";
// print_r($moveCode);
// echo "</pre>";
//  echo var_dump($moveCode);

// echo "<pre>";
// print_r($value);
// echo "</pre>";

?>