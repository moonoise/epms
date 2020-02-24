<?php 
include_once "../../config.php";
include_once "../../includes/ociConn.php";
include_once "../../includes/dbconn.php";
include_once "class-dpis.php";

if ($_POST['per_cardno'] != "") {
    $dpis = new dpis;
    $result = $dpis->queryPersonal($_POST['per_cardno']);
    // echo "<pre>";
    // print_r($result['result']);
    // echo "</pre>";
    $r = $dpis->insertPer_Personal($result['result']);
    if($r['success'] === true){
        echo json_encode($r);
    }else{
        $rr = $dpis->updatePer_Personal($result['result']);
        echo json_encode($rr);
    }
    
    
}

