<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
 include_once "../cpc/class-cpc.php";
 include_once "../kpi/class-kpi.php";
 include_once "../myClass.php";

$cpc = new cpc;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$year = $currentYear['data']['table_year'];
$cpc_html = "";             

$cpc_html .= '<table class="table table-striped">
                <thead>
                <tr>
                <th>
                    <div class="checkbox checkbox-warning">
                        <input id="cpcCheckAll" type="checkbox" >
                        <label for="cpcCheckAll"  onclick="cpcCheckAll()">
                        </label>
                    </div>
                </th>
                
                    <th>รหัส</th>
                    <th>รายการสมรรถนะ</th>
                    <th>ล้างคะแนน/ล้างการยืนยันผล</th>
                    <th>ล้างเฉพาะการยืนยันผล</th>
                </tr>
                </thead>
                <tbody>';

foreach ($cpcType as $key => $value) { //$cpcType  เอามาจาก config.php
    
    $dataSet = array('per_cardno' => $_POST['per_cardno'],
                    'years' => $year,
                'soft_delete' => 0,
                'question_type' => $key
                );
    $result = $cpc->cpcScoreSelect($dataSet,$cpcScoreTable );
   
    foreach ($result['result'] as $row) {
        
        $arrayScore = array($row['cpc_score1'],$row['cpc_score2'],$row['cpc_score3'],$row['cpc_score4'],$row['cpc_score5'] ); 
        $arrayAcceptScore = array($row['cpc_accept1'],$row['cpc_accept2'],$row['cpc_accept3'],$row['cpc_accept4'],$row['cpc_accept5']);

        $checkScore = count(array_filter($arrayScore,function ($item_values) {
            if ($item_values === null)
            {
                return false;
            }
                return true;
        }));
        $checkAcceptScore = count(array_filter($arrayAcceptScore,function ($item_values) {
            if ($item_values === null)
            {
                return false;
            }
                return true;
        }));

        $cpc_html .= "<tr>";
        $cpc_html .= '<td>
                        <div class="checkbox checkbox-warning">
                            <input id="cpc-'.$row['cpc_score_id'].'" type="checkbox"  class="cpcSelectCheckbox" onclick="cpcList(`'.$row['cpc_score_id'].'`,`cpc-'.$row['cpc_score_id'].'`)">
                            <label for="cpc-'.$row['cpc_score_id'].'">
                            </label>
                        </div>
                       
                      </td>';
        $cpc_html .= "<td>".$row['question_no']."</td>";
        $cpc_html .= "<td>".$row['question_title']."</td>";
        $cpc_html .= "<td>
                <div class='input-group' id='clearCPC_score-accept-".$row['cpc_score_id']."'>
                <button type='button' class='btn ".($checkScore > 0 ? "btn-success":"btn-default")." btn-xs confirm-clearCPCscore-accept' 
                onclick='clearCPCscoreAceept(`".$row['cpc_score_id']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." ".($checkScore > 0 ? "":"disabled").">
                <i class='fa fa-refresh '></i> คะแนน/ยืนยันผล</button>
                </div>
                </td>";
        $cpc_html .= "<td>
                <div class='input-group' id='clearCPC_accept-".$row['cpc_score_id']."'>
                <button type='button' class='btn ".($checkAcceptScore > 0 ? "btn-success":"btn-default")." btn-xs confirm-clearCPC-accept' 
                onclick='clearCPCaceept(`".$row['cpc_score_id']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." ".($checkAcceptScore > 0 ? "":"disabled").">
                <i class='fa fa-refresh'></i> ยืนยันผล</button>
                </div>
                </td>";
        $cpc_html .= "</tr>";
        
    }
}
        $cpc_html .= '
                            <tr> 
                                <td colspan="3" > 
                                    <div class="input-group" >
                                        <button type="button" class="btn btn-warning btn-xs confirm-clearCPCscore-accept" 
                                        onclick="cpcScoreAcceptSunmit()" '.$_SESSION[__EVALUATION_ON_OFF__].'>
                                        <i class="fa fa-refresh red"></i>คะแนน/ยืนยัน</button>
                                   
                                        <button type="button" class="btn btn-warning btn-xs confirm-clearCPC-accept" 
                                        onclick="cpcAcceptSunmit()" '.$_SESSION[__EVALUATION_ON_OFF__].'>
                                        <i class="fa fa-refresh red"></i>ยืนยัน</button>
                                    </div>
                                </td>
                                
                                <td> </td> 
                            </tr>';

$cpc_html .= '  </tbody>
            </table>';


$kpi_html = '';
$kpi = new kpi;
$result = $kpi->KpiScoreSelect($_POST['per_cardno'],$kpiScoreTable,$year);
// echo "<pre>";
// print_r($result);
// echo "</pre>";
if ($result['success'] == true) {
    $kpi_html .= '<table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        <div class="checkbox checkbox-warning">
                            <input id="kpiCheckAll" type="checkbox" >
                            <label for="kpiCheckAll"  onclick="kpiCheckAll()">
                            </label>
                        </div>
                    </th>
                    <th>รหัส</th>
                    <th>ตัวชี้วัด</th>
                    <th>ล้างคะแนน/ล้างการยืนยันผล</th>
                    <th>ล้างเฉพาะการยืนยันผล</th>
                </tr>
                </thead>
                <tbody>';

    foreach ($result['result'] as $row) {
        $kpi_html .= "<tr>";
        $kpi_html .= '<td>
                        <div class="checkbox checkbox-warning">
                            <input id="kpi-'.$row['kpi_score_id'].'" type="checkbox"  class="kpiSelectCheckbox" onclick="kpiList(`'.$row['kpi_score_id'].'`,`kpi-'.$row['kpi_score_id'].'`)">
                            <label for="kpi-'.$row['kpi_score_id'].'">
                            </label>
                        </div>
                    </td>';
        $kpi_html .= "<td>".$row['kpi_code_org']."</td>";
        $kpi_html .= "<td>".$row['kpi_title']."</td>";
        $kpi_html .= "<td>
                <div class='input-group' id='clearKPI_score-accept-".$row['kpi_score_id']."'>
                <button type='button' class='btn ".($row['kpi_score'] == null ? "btn-default":"btn-success")." btn-xs confirm-clearKPIscore-accept' 
                onclick='clearKPIscoreAceept(`".$row['kpi_score_id']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." ".($row['kpi_score'] == null ?"disabled":"").">
                <i class='fa fa-refresh'></i> คะแนน/ยืนยันผล</button>
                </div>
                </td>";
        $kpi_html .= "<td>
                <div class='input-group' id='clearKPI_accept-".$row['kpi_score_id']."'>
                <button type='button' class='btn ".($row['kpi_accept'] == 1 ? "btn-success":"btn-default")." btn-xs confirm-clearKPI-accept' 
                onclick='clearKPIaceept(`".$row['kpi_score_id']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]." ".($row['kpi_accept'] == 1 ?"":"disabled").">
                <i class='fa fa-refresh'></i> ยืนยันผล</button>
                </div>
                </td>";

        $kpi_html .= "</tr>";
    }
        $kpi_html .= '
                    <tr> 
                        <td colspan="3" > 
                            <div class="input-group" >
                                <button type="button" class="btn btn-warning btn-xs confirm-clearKPIscore-accept" 
                                onclick="kpiScoreAcceptSunmit()" '.$_SESSION[__EVALUATION_ON_OFF__].'>
                                <i class="fa fa-refresh red"></i>คะแนน/ยืนยัน</button>
                           
                                <button type="button" class="btn btn-warning btn-xs confirm-clearKPI-accept" 
                                onclick="kpiAcceptSunmit()" '.$_SESSION[__EVALUATION_ON_OFF__].'>
                                <i class="fa fa-refresh red"></i>ยืนยัน</button>
                            </div>
                        </td>
                        
                        <td> </td> 
                    </tr>';
    $kpi_html .= '  </tbody>
            </table>';

}

echo '
<div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" id="tab1" class="active"><a href="#tab_content1-cpc" id="cpc-tab" role="tab" data-toggle="tab" aria-expanded="true">CPC</a>
            </li>
            <li role="presentation" id="tab2" class=""><a href="#tab_content2-kpi" role="tab" id="kpi-tab" data-toggle="tab" aria-expanded="false">KPI</a>
        </ul>
    <div id="myTabContent-clear-score" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1-cpc" aria-labelledby="cpc-tab">
        '.$cpc_html.'

        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content2-kpi" aria-labelledby="kpi-tab">
        '.$kpi_html.'
        </div>
    </div>
</div>'



?>

<script>
var per_cardno = '<?php echo $_POST["per_cardno"];?>';
$(".confirm-clearKPIscore-accept ,.confirm-clearCPCscore-accept ").popConfirm({
        title: "ล้างคะแนน", // The title of the confirm
        content: "คุณต้องการล้าง <b class='text-danger'>คะแนน</b> จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
        });

$(".confirm-clearCPC-accept , .confirm-clearKPI-accept").popConfirm({
    title: "ล้างคะแนน", // The title of the confirm
    content: "คุณต้องการล้าง<b class='text-danger'>การยืนยันคะแนนของผู้บังคับบัญชา</b> จริงๆ หรือใหม่ ?", // The message of the confirm
    placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
    container: "body", // The html container
    yesBtn: "ใช่",
    noBtn: "ไม่"
});


var arrCPC = []
var arrCPCindex 

function cpcCheckAll() {
    if ( $("#cpcCheckAll").prop("checked") == false) {
        //  console.log($("#cpcCheckAll").prop("checked"))
        $(".cpcSelectCheckbox").each(function(){
            id = $(this).attr("id")
            if ($("#"+id).prop("checked") == false ) {
                $("#"+id).trigger("click")
            }
        })
    }else if ( $("#cpcCheckAll").prop("checked") == true) {
        $(".cpcSelectCheckbox").each(function(){
            id = $(this).attr("id")
            if ($("#"+id).prop("checked") == true ) {
                $("#"+id).trigger("click")
            }
        })
    } 
}

function cpcList(list,id){

    if ( $("#"+id).prop("checked") == true) {
        arrCPC.push(list) 
    }else if ( $("#"+id).prop("checked") == false) {
        arrCPCindex = arrCPC.indexOf(list)
        delete arrCPC[arrCPCindex]
    }
    // console.log(arrCPC)
}



var arrKPI = []
var arrKPIindex 

function kpiCheckAll() {
    if ( $("#kpiCheckAll").prop("checked") == false) {
        //  console.log($("#kpiCheckAll").prop("checked"))
        $(".kpiSelectCheckbox").each(function(){
            id = $(this).attr("id")
            if ($("#"+id).prop("checked") == false ) {
                $("#"+id).trigger("click")
            }
        })
    }else if ( $("#kpiCheckAll").prop("checked") == true) {
        $(".kpiSelectCheckbox").each(function(){
            id = $(this).attr("id")
            if ($("#"+id).prop("checked") == true ) {
                $("#"+id).trigger("click")
            }
        })
    } 
}


function kpiList(list,id){

    if ( $("#"+id).prop("checked") == true) {
        arrKPI.push(list) 
    }else if ( $("#"+id).prop("checked") == false) {
        arrKPIindex = arrKPI.indexOf(list)
        delete arrKPI[arrKPIindex]
    }
    // console.log(arrKPI)
    }

function clearCPCscoreAceept(scoreID){
    var a = [] 
    a.push(scoreID)
    clearCPC(a,1)
}
function clearCPCaceept(scoreID){
    var a = [] 
    a.push(scoreID) 
    clearCPC(a,2)
}

function clearKPIscoreAceept(scoreID){
    var a = [] 
    a.push(scoreID)
    clearKPI(a,1)
}
function clearKPIaceept(scoreID){
    var a = [] 
    a.push(scoreID)
    clearKPI(a,2)
}

function cpcScoreAcceptSunmit(){
    clearCPC(arrCPC,1)
}

function cpcAcceptSunmit() {
    clearCPC(arrCPC,2)
}

function kpiScoreAcceptSunmit() {
    clearKPI(arrKPI,1)
}

function kpiAcceptSunmit() {
    clearKPI(arrKPI,2)
}

function clearCPC(arrList,typeClear){
    $.ajax({
        url:"module/module_person/ajax-modal-clear_score-cpc.php",
        type: "POST",
        dataType: "JSON",
        data:{"cpc_score_id":arrList,"typeClear":typeClear},
        success: function (result) {
            if (result.success==true) {
                notify('การล้างคะแนน','สำเร็จ','success')
                clearScoreRefresh(per_cardno,"tab1")
            }else if(result.success == false){
                notify('การล้างคะแนน','ไม่สำเร็จ','danger')
            }
            // console.log(result.success)
        }
    })
}

function clearKPI(arrList,typeClear){
    $.ajax({
        url:"module/module_person/ajax-modal-clear_score-kpi.php",
        type: "POST",
        dataType: "JSON",
        data:{"kpi_score_id":arrList,"typeClear":typeClear},
        success: function (result) {
            if (result.success==true) {
                notify('การล้างคะแนน','สำเร็จ','success')
                clearScoreRefresh(per_cardno,"tab2")
            }else if(result.success == false){
                notify('การล้างคะแนน','ไม่สำเร็จ','danger')
            }
            // console.log(result.success)
        }
    })
}

function clearScoreRefresh(per_cardno,idTabs){
  $.ajax({
    url:"module/module_person/ajax-modal-clear_score.php",
    type:"POST",
    dataType:"html",
    data:{"per_cardno":per_cardno},
    success: function (result) { 
      $("#modal-per_cardno-clear-score").html(per_cardno)
      $("#modal-body-clear-score").html(result)
      if (idTabs=="tab1") {
          $('#tab1 a[href="#tab_content1-cpc"]').tab('show');
          
      }else if(idTabs == "tab2" ){
          $('#tab2 a[href="#tab_content2-kpi"]').tab('show');
      }
    }
  })
}

</script>
