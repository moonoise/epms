<?php
 session_start();
 $success = array();
 
 if(!empty($_GET['per_cardno'])){
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
    $year = $currentYear['data']['table_year'];

    $result = $kpi->KpiScoreSelect($_GET['per_cardno'],$kpiScoreTable,$year);
    
    if ($result['success'] == true) {
        $t = "";
        $n = 1;
        foreach ($result['result'] as $row) {
            $t .= "<tr>";
             $t .= "<td>".$n."</td>";
            $t .= "<td>".$row['kpi_code_org']."</td>";
            $t .= "<td>".$row['kpi_title']."</td>";
            $t .= "<td>".$kpiType[$row['kpi_type']]."</td>";
            $t .= "<td><div class='form-inline'>
                  <div class='form-group'>
                     <div class='input-group'>
                        <input id='weight-".$row['kpi_score_id']."' type='text' class='class-weight' maxlength='3' size='3' name='weight[".$n."]' value='".$row['weight']."'>
                     </div>
                     <div class='input-group' id='save-".$row['kpi_score_id']."'>
                     <button type='button' class='btn btn-info btn-xs confirm-saveWeight' onclick='saveWeight(`weight[".$n."]`,`".$row['kpi_score_id']."`,`".$row['per_cardno']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." >
                        <i class='fa fa-save'></i>
                        </button>
                     </div>
                     
                    <div class='input-group' id='del-".$row['kpi_score_id']."'>
                    <button type='button' class='btn btn-danger btn-xs confirm-delQuestionScore' onclick='delQuestionScore(`".$row['kpi_score_id']."`,`".$row['per_cardno']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." ><i class='fa fa-eraser'></i></button>
                    </div>
                     
                  </div>
                </div></td>";
                $n++;
        }
        $t .= "<tr><td colspan = '4' class='text text-info text-right'> รวม </td> 
                <td>
                <div class='form-inline'>
                <div class='input-group'>
                    <span id='weightSum'></span>  &nbsp;	&nbsp;	
                        <button type='button' class='btn btn-info btn-xs' onclick='refreshTableKpiScore(".$_GET['per_cardno'].")' ><i class='fa fa-refresh'></i></button>
                    </div>
                </div>
               </td></tr>";
               
        $t .= "<script>$('.confirm-delQuestionScore').popConfirm({
                    title: 'ลบหัวข้อ', // The title of the confirm
                    content: 'คุณต้องการลบหัวข้อนี้ จริงๆ หรือใหม่ ?', // The message of the confirm
                    placement: 'right', // The placement of the confirm (Top, Right, Bottom, Left)
                    container: 'body', // The html container
                    yesBtn: 'ใช่',
                    noBtn: 'ไม่'
            });</script>";
        $success['success'] = true;
        $success['msg'] = null;
        $success['html'] = $t;
       
    }

 }else {
    $success['success'] = false;
    $success['msg'] = 'เกิดข้อผิดพลาด';
 }

echo json_encode($success);


