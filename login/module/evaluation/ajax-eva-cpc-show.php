<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../cpc/class-cpc.php";
if (!empty($_GET['per_cardno'])) {

    $success = array();

    $cpc = new cpc;
    
               
    foreach ($cpcType as $key => $value) {
       
        $dataSet = array('per_cardno' => $_GET['per_cardno'],
                     'years' => __year__,
                    'soft_delete' => 0,
                    'question_type' => $key
                    );
        $result = $cpc->cpcScoreSelect($dataSet);
        if (count($result['result']) > 0 ) {
            echo "<tr>";
            echo "<td class='success' colspan= '5'>".$value."</td>";
            echo "</tr>";
        }
        
        foreach ($result['result'] as $row) {
            $s = $cpc->cpcBtnStatus1($row['cpc_score_id']);
            // echo "<pre>";
            // print_r($s);
            // echo "</pre>";
            if ($s['success'] === true) {
                $msg = 'รอยืนยันผล';
                $color = 'btn-info';
                $ss = $cpc->cpcBtnStatus2($row['cpc_score_id']);
                if ($ss['success'] === true) {
                    $msg = 'ยืนยันแล้ว';
                    $color = 'btn-success';
                }
            }elseif ($s['success'] === false) {
                    $msg = 'เปิดประเมิน';
                    $color = 'btn-warning';
            }
            
            echo "<tr>";
            echo "<td class='text-center text-info'>".$row['question_code']."</td>";
            echo "<td class='text-success'>".$row['question_title']."</td>";
            echo "<td class='text-center text-danger'>".$row['cpc_divisor']."</td>";
            echo "<td>
            <a href='#' class='btn ".$color." btn-xs confirm-add' data-toggle='confirmation'  id='CK-".$row['cpc_score_id']."'
            onclick='cpcEva(`".$_GET['per_cardno']."`,`".$row['question_no']."`,`".$row['cpc_score_id']."`)' >
           ".$msg." </a>
            </td>";
            echo "</tr>";
            // $n++;
        }
    }

}else {
    echo "Error  per_cardno not found.";
}