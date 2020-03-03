<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-kpi.php";
include_once "../myClass.php";

 $kpi = new kpi;
 $myClass = new myClass;
 $currentYear = $myClass->callYear();

 $kpiScoreTable = $currentYear['data']['kpi_score'];
 $kpiComment = $currentYear['data']['kpi_comment'];
 $per_personalTable = $currentYear['data']['per_personal'];

$d = date("Y-m-d H:i:s");
$setData = array("kpi_code" => "1234",
                "per_cardno" => "1111",
                "id_admin" => "345678iopsadfsa",
                "level_score" => "5",
                "weight" => "100",
                "result_score" => "95",
                "years" => "2556-1",
                "date_key_score" => $d,
                "kpi_accept" => "4",
                "kpi_comment" => "test",
                "who_is_accept" => "23456u",
                "date_who_id_accept" => $d
                 );

$n = $kpi->kpiScoreAdd($setData,$kpiScoreTable);

if ($n['success'] != true ) {
    echo $n['success'] ."<br>". $n['msg'];
}

// $result = $kpi->ckData('1111','1234');

// echo $result['success'];