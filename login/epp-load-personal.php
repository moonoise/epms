<?php 
include_once "config.php";
include_once "includes/ociConn.php";
include_once "includes/dbconn.php";
include_once "epp-function.php";
include_once "module/myClass.php";

    $dpis = new dpis;
    $db = new Dbconn;
    $myClass = new myClass;

    $currentYear = $myClass->callYear();

$personalTable = $currentYear['data']['per_personal'];

    $sql= "SELECT per_cardno FROM per_cardno ";
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll();
    

    foreach ($result as $key => $value) {
        $resultDPIS = $dpis->queryPersonal($value['per_cardno']);
        // echo "<pre>";
        // print_r($result['result']);
        // echo "</pre>";
        $r = $dpis->insertPer_Personal($resultDPIS['result'],$personalTable);
        if($r['success'] === true){
            echo $value['per_cardno']." insert <br>";
        }else{
            $rr = $dpis->updatePer_Personal($resultDPIS['result'],$personalTable);
            echo $value['per_cardno']." update <br>";
        }
    }


    
    
    
