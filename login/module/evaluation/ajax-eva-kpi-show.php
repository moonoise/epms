<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../kpi/class-kpi.php";
if (!empty($_GET['per_cardno'])) 
{
    $kpi = new kpi;
    $result = $kpi->KpiScoreSelect($_GET['per_cardno']);
    if ($result['success'] == true) {
    $t = "";
    $n = 1;
    foreach ($result['result'] as $row) {
    $s = $kpi->kpiBtnStatus1($row['kpi_score_id']);
    if ($s['success'] === true) {
        $msg = 'รอยืนยันผล';
        $color = 'btn-info';
        $ss = $kpi->kpiBtnStatus2($row['kpi_score_id']);
        if ($ss['success'] === true) {
            if ($ss['result'] == 1) {
            $msg = 'ยืนยันแล้ว';
            $color = 'btn-success';
            }
            elseif ($ss['result'] === null || empty($ss['result'])) {
                $msg = 'รอยืนยันผล';
                $color = 'btn-warning';
            }
        }
    }elseif ($s['success'] === false) {
            $msg = 'เปิดประเมิน';
            $color = 'btn-warning';
    }

    // echo "<pre>";
    // print_r($s);
    // echo "</pre>";

    echo  "<tr>";
    echo  "<td class='text-center text-info'>".$row['kpi_code_org']."</td>";
    echo  "<td class='text-success'>".$row['kpi_title']."</td>";
    echo  "<td class='text-center text-danger'>".$row['weight']."</td>";
    echo  "<td class='text-center text-danger'>".$kpiType[$row['kpi_type']]."</td>";
    echo "<td>
    <a href='#' class='btn ".$color." btn-xs confirm-add' data-toggle='confirmation'  id='CK-".$row['kpi_score_id']."'
    onclick='kpiEva(`".$_GET['per_cardno']."`,`".$row['kpi_code']."`,`".$row['kpi_score_id']."`,`".$row['kpi_type2']."`)' >
   ".$msg." </a>
    </td>";
    echo "</tr>";
        }
    }

}else {
    echo "Error  per_cardno not found.";
}
