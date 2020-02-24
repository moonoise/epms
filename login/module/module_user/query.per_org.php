<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../../includes/ociConn.php";


   
   
    $Oci_sql = "SELECT ORG_ID,ORG_NAME,ORG_CODE,ORG_ID_REF FROM PER_ORG WHERE ORG_ID_REF = '77'"." AND ORG_ACTIVE = '1' "; 
    //echo $Oci_sql;
 
    $stid = oci_parse($ociConn,$Oci_sql);
    //  oci_bind_by_name($stid,':search',$test);

    oci_execute($stid);

    $output = array('aaData' => array() );

    while (($aRow = oci_fetch_array ($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
        //  $row['ORG_ID'] = $aRow['ORG_ID'];
        //  $row['ORG_NAME'] = $aRow['ORG_NAME'];
        //  $row['ORG_ID_REF'] = $aRow['ORG_ID_REF'];
        $output['aaData'][] = $aRow;
        $Oci_sql2 = "SELECT ORG_ID,ORG_NAME,ORG_CODE,ORG_ID_REF FROM PER_ORG WHERE ORG_ID_REF = '".$aRow['ORG_ID']."' "." AND ORG_ACTIVE = '1' ";
//echo $Oci_sql2. "<br>";
        $stid2 = oci_parse($ociConn,$Oci_sql2);
        oci_execute($stid2);

        while (($aRow2 = oci_fetch_array ($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
           $output['aaData'][] = $aRow2;
            $Oci_sql3 = "SELECT ORG_ID,ORG_NAME,ORG_CODE,ORG_ID_REF FROM PER_ORG WHERE ORG_ID_REF = '".$aRow2['ORG_ID']."' "." AND ORG_ACTIVE = '1' ";
           // echo $Oci_sql3. "<br>";
            $stid3 = oci_parse($ociConn,$Oci_sql3);
            oci_execute($stid3);
            
            while (($aRow3 = oci_fetch_array ($stid3, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                $output['aaData'][] = $aRow3;
            }

        }
         
			//unset($row);
    }

    //oci_fetch_all($stid,$res);
    $i = 1;
    // foreach ($output['aaData'] as $a) {
    //     echo "insert into per_org (org_id,org_name,org_code,org_id_ref) values ('".$a['ORG_']."','".$a['org_name']."','".$a['org_code']."','".$a['org_id_ref']."')";
    //     //unset($a);
    // }

    foreach ($output['aaData'] as $b) {

        // $db = new DbConn;
        
      
        // $stmt = $db->conn->prepare("insert into per_org (org_id,org_name,org_code,org_id_ref) values (:per_id,:per_name,:per_code,:per_id_ref)");
        
        // $stmt->bindParam(':per_id', $b['ORG_ID']);
        // $stmt->bindParam(':per_name', $b['ORG_NAME']);
        // $stmt->bindParam(':per_code', $b['ORG_CODE']);
        // $stmt->bindParam(':per_id_ref', $b['ORG_ID_REF']);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
         echo $i++." "."insert into per_org (org_id,org_name,org_code,org_id_ref) values ('".$b['ORG_ID']."','".$b['ORG_NAME']."','".$b['ORG_CODE']."','".$b['ORG_ID_REF']."')".";<br>";
        //unset($a);
    }



    //echo json_encode($output['aaData']);

    oci_free_statement($stid);
    oci_close($ociConn);