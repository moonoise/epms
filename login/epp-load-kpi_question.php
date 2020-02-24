<?php 
include_once "config.php";
include_once "includes/ociConn.php";
include_once "includes/dbconn.php";
include_once "epp-connect.php";
include_once "epp-function.php";
include_once "module/kpi/class-kpi.php";

    $dpis = new dpis;
    $db = new Dbconn;
    $db_epp = new DbConnEpp;
    $kpi = new kpi;
    $success = array();
    $success['msg'] = '';
    $sql= "SELECT *  FROM  `ep_kpi_indicate` ";
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll();

    foreach ($result as $key => $value) {
        # code...
    }
    
    

    
   