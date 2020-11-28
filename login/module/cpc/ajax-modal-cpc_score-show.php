<?php
session_start();
if (!empty($_GET['per_cardno'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";
    include_once "../myClass.php";

    $success = array();

    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];
    $year = $currentYear['data']['table_year'];

    $n = 1;
    foreach ($cpcType as $key => $value) {


        $dataSet = array(
            'per_cardno' => $_GET['per_cardno'],
            'years' => $year,
            'soft_delete' => 0,
            'question_type' => $key
        );
        $result = $cpc->cpcScoreSelect($dataSet, $cpcScoreTable);
        if (count($result['result']) > 0) {
            echo "<tr>";
            echo "<td class='success' colspan= '5'>" . $value . "</td>";
            echo "</tr>";
        }
        foreach ($result['result'] as $row) {
            echo "<tr>";
            echo "<td>" . $n . "</td>";
            echo "<td>" . $row['question_no'] . "</td>";
            echo "<td>" . $row['question_title'] . "</td>";
            echo "<td>  
                        <div class='form-group' >
                        <input type='number' class='' style='width: 6em' maxlength='5' min='1' max='5' size='5' value='" . $row['cpc_divisor'] . "' id='divisor-" . $row['cpc_score_id'] . "' " . $_SESSION[__EVALUATION_ON_OFF__] . ">
                        <button type='button' class='btn btn-info btn-xs' 
                        onclick='divisor(`" . $row['cpc_score_id'] . "`)' " . $_SESSION[__EVALUATION_ON_OFF__] . ">
                        <i class='fa fa-save'></i></button>
                        </div>
                    </td>";
            echo "<td>
                        <div class='input-group' id='delCpc_score-" . $row['cpc_score_id'] . "'>
                        <button type='button' class='btn btn-danger btn-xs confirm-delCpcScore' 
                        onclick='delCpcScore(`" . $row['cpc_score_id'] . "`,`" . $row['per_cardno'] . "`)' " . $_SESSION[__EVALUATION_ON_OFF__] . ">
                        <i class='fa fa-eraser'></i></button>
                        </div>
                     </td>";
            echo "</tr>";
            $n++;
        }
    }
} else {
    echo "Error  per_cardno not found.";
}

?>
<script>
    $(".confirm-delCpcScore").popConfirm({
        title: "การลบสมรรถนะ", // The title of the confirm
        content: "คุณต้องการลบจริงหรือไม่ ?", // The message of the confirm
        placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
    });
</script>