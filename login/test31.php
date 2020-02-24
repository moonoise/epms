<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once 'module/evaluation/class-evaluation.php';
// include_once "../report/class-report.php";

$kpiScoreTable  = "kpi_score_2019";
$kpiScoreComment = "kpi_comment_2019";
$year_term = "2019-1";
$per_cardno = "1809900487908";


$evaluation =  new evaluation;
$r = $evaluation->kpiJoinComment($kpiScoreTable,$kpiScoreComment,$year_term,$per_cardno);

echo "<pre>";
print_r($r);
echo "</pre>";