<?php

function diffDate($date1,$date2) {
    // $diff = array();
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    $diff = array("y" => $interval->format('%y') ,
                  "m" => $interval->format('%m'),
                  "d" => $interval->format('%d') );
    return $diff;
}

$d = date("Y-m-d");
$d2 = "1987-01-16";
$diff = diffDate($d,$d2);
echo $diff['y'] ."<br>";
echo $diff['m'] ."<br>";
echo $diff['d'] ."<br>";




?>