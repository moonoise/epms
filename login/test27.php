<?php
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "module/module_profile/class.profile.php";
include_once "includes/class.permission.php";

$per_cardno ="1779900057416";

$cpcResult = array("success" => "",
                    "text" => "",
                    "msg" => "");
$cpcTypeKey = array(1,2,3,4,5,6);

$report = new report;

$years = __year__;
(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$years,$cpcTypeKey,$tbl_per_personal,$tbl_cpc_score) : $cpcResult);

foreach ($cpcResult['result'] as $key => $value) {
    $a =  array($value['cpc_accept1'],$value['cpc_accept2'],$value['cpc_accept3'],$value['cpc_accept4'],$value['cpc_accept5']);
    // $point = $report->getPoint($a);
    // echo "<br>".count(array_filter($a, "my_function"));
    // echo "<br>".count($a);
    // if ($point === null) {
    //     echo "<br> null";
    // }else {
    //     echo "<br>".$point;
    // }
    
    // echo "<pre>";
    // print_r($a);
    // echo "</pre>";
    
}

function my_function($item_values){
    if ($item_values === null)
    {
        return false;
    }
        return true;
}

// $point
$r = $report->cal_gap_chart($cpcResult);
$gap = $report->cal_gap($r);
$gap2 = $report->cal_idp($per_cardno,$years);


echo "<pre>";
print_r($r);
echo "</pre>";
