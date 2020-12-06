<?php


include_once "../config.php";
include_once "../includes/dbconn.php";
include_once "../includes/ociConn.php";
include_once "../module/module_dpis/class-dpis.php";
include_once "../module/myClass.php";

$dpis = new dpis;
$myClass = new myClass;

$currentYear = $myClass->callYear();
$log = array();
$personalTable = $currentYear['data']['per_personal'];


$ociSql = "SELECT
            per_personal.per_cardno,
            per_line.pl_name,
            per_line.pl_code,
            per_mgt.pm_code,
            per_mgt.pm_name
            FROM
                per_personal
            LEFT JOIN per_position
                ON per_position.pos_id = per_personal.pos_id 
            LEFT JOIN per_line
                ON per_line.pl_code = per_position.pl_code
            LEFT JOIN per_mgt
                ON per_position.pm_code = per_mgt.pm_code 
            WHERE
                per_personal.per_type = 1
            AND
                per_personal.per_status = 1
            AND per_line.pl_name <> per_mgt.pm_name
                    ";
$stid = oci_parse($dpis->ociConn, $ociSql);
oci_execute($stid);
oci_fetch_all($stid, $res, null, null, OCI_ASSOC);

oci_free_statement($stid);

foreach ($res['PER_CARDNO'] as $key => $value) {
    $result = $dpis->queryPersonalType1($value);
    $r = $dpis->insertPer_PersonalType1($result['result'], $personalTable);
    if ($r['success'] === false or $r['success'] === null) {
        $log[] = $r;
    }
    printf("%s :  %s  \n", $key + 1, $r['msg']);
    printf("%s   \n", $value);
    // print_r($value);
}

print_r($log);
