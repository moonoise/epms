<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../../includes/ociConn.php";
     $ociDB = new ociConn;
     $ociConn = $ociDB->ociConnect();
    $str = array();
    $str = explode(' ',$_GET['name']);
    $n = count($str);
     
        if($n == 2){
            $fname = $str[0];
            $lname = $str[1];
        }elseif ($n == 1) {
            $fname = $str[0];
            $lname = $str[0];
        }
        if($n == 3){
            $fname = $str[0];
            $lname = $str[1]." ".$str[2];
        }        
    
   // echo "name: " .$fname ."<br>";
   // echo "lname: " .$lname ."<br>";
    //echo $str[2];
   
    $Oci_sql = "SELECT PER_PERSONAL.PER_ID,PER_PERSONAL.PER_NAME, PER_PERSONAL.PER_SURNAME FROM PER_PERSONAL 
                WHERE PER_STATUS = 1  AND 
                (PER_NAME LIKE '%" .$fname."%'"." OR PER_SURNAME LIKE '%".$lname."%')"; 
    //echo $Oci_sql;
 
    $stid = oci_parse($ociConn,$Oci_sql);
    //  oci_bind_by_name($stid,':search',$test);

    oci_execute($stid);

    $output = array('aaData' => array() );

    while (($aRow = oci_fetch_array ($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
         $row['fname'] = $aRow['PER_NAME'];
         $row['lname'] = $aRow['PER_SURNAME'];
         $row['label'] = $aRow['PER_NAME']." ".$aRow['PER_SURNAME']; ;

         $output['aaData'][] = $row;
			unset($row);
    }

    //oci_fetch_all($stid,$res);
    

    echo json_encode($output['aaData']);

    oci_free_statement($stid);
    oci_close($ociConn);

    

