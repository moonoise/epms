<?php 
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";


// $per_cardno ="3110102173544";
// $arr_per_cardno = ["3100901392956","3100902678390","3101500618385","3860700453854","3101700229102","3101900398242","3100500699317","3101600894881","3309900962666","3102002435263","3120600081978","3341500171176","3179900023432","3730500635399","3179900070708","3100603036329","3660100337103","3800101343687","3800400831527","3321001154641","3570500915610","5320100137189","5302100120202","1130600055016","3100700320842","1100500028998","3300200551924","3939900052087","3102001368741","1101900001699","3450600664890","1559900125821","1320300008282","1709900006790","1189800031101","3730300039920","1102000271844","1120600027551","3640800225227","1120600027675","3760500761602","3729900097244","1101400163061","1339900072842","1770400039291","1901100015850","1100200554082","1409900331367","5330990009236","1809900105533","3450500145254","3540200151380","3120100285132","3190600187741","3179900024722","3140100013779","3470101546344","3101900516687","3100601883687","3309901601187","3720100721930","3100501319950","3102201728988","3101900121798","3349900649305","3100100518382","3102101334791","3240900028532","3101200983975","3100502546861","3820800328491","3130700100371","3100201335984","3102400811605","3101201203086","3102200333548","3420100194797","3140200107236","3100400114465","3350100122711","3102400303731","5301690011414","3100905194814","3801600064164","3100200600901","3102001517428","3960800024962","3100503110535","3640100643638","1349900157236","3100200140250","4120100032526","3102300447669","1809900111991","1719900084723","1601100177712","1570400003841","1801400029491","1720900048001","1350100147769","1101500065550","3501000038386","1500900016462","1619900108259","1101400025211","1101800263781","3770200327885","1549900246962","1809900239424","1102000769940","1349900321427","3520400161036","1809900487908","3720900708385","1349900393665","1129800068519","1100800461271","1459900378070","1101401986380","2640700018213","3120600786254","3101800996113","3920500014015","3620100017524","3779800106985","5120100006710","3110102173544","3240600105051","3720800487875","3102401205709","3101702317084","3509900879732","3120600319991","3101800605581","3120100952899","3730100752860","5120100048111","3600300394755","3120600320409"] ;

$report =  new report;
$r = $report->percent_complete($_POST['arr_per_cardno'],$_POST['cpc_score_result'],$_POST['kpi_score_result'],$_POST['table_year']);


echo json_encode($r);
// echo "<pre>";
// print_r($r);
// echo "</pre>";