<?php
    include_once "config.php";
    include_once "includes/dbconn.php";
    include_once "module/kpi/class-kpi.php";

    
    $kpi = new kpi;
    $result = $kpi->KpiScoreSelect('1100701108972');

    echo "<pre>";
    print_r($result);
    echo "</pre>";
