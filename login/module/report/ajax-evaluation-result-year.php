<?php 
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-report.php";
include_once "../myClass.php";
include_once "../../includes/class.permission.php";

$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");

$cpcTypeKey = array(1,2,3);
$cpcTypeKey2 = array(1,2,3,4,5,6);

if(!isset($_SESSION[__USER_ID__]) ){ 
    header("location:login-dpis.php");
  }
      if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) { 
      }else {
        header("location:login-dpis.php");
      }
  activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);

  $report = new report;
$myClass = new myClass;
$per_cardno = $_POST['per_cardno'];
$currentYear = $myClass->callYearByID($_POST['table_id']);
$year = $currentYear['data']['table_year'];
$idpScoreTable = $currentYear['data']['idp_score'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$detailYear = $currentYear['data']['detail'];



(!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$year ,$personalTable,$currentYear['data']['kpi_score']) : $kpiResult);

$kpi = $report->reportKPI1($kpiResult);

(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$year,$cpcTypeKey,$personalTable,$cpcScoreTable) : $cpcResult);
$cpc = $report->reportCPC1($cpcResult);

// echo "<pre>";
// print_r($cpc);
// echo "</pre>";

(!empty($per_cardno)? $cpcResult2 =  $report->tableCPC($per_cardno,$year ,$cpcTypeKey2,$personalTable,$cpcScoreTable) : $cpcResult);  // cpcTypeKey2 1,2,3,4,5,6
$r = $report->cal_gap_chart($cpcResult2);
$gap = $report->cal_gap($r,$idpScoreTable);
$idp = $report->cal_idp($per_cardno,$year,$idpScoreTable);

$AverageKPI = $kpi['scoring'];
$AverageKPI2 = $kpi['scoring']/100;
$AverageCPC = $cpc['scoring']; 
$AverageCPC2 =  $cpc['scoring'] / 100; 

if ($kpi['through_trial'] == 1) {
    $txt = '';
}elseif ($kpi['through_trial'] == 2) {
    $txt = '<b class="text-danger text-center">อยู่ในช่วงทดลองงาน</b>';
}else{
    $AverageKPI = 70;
    $AverageKPI2 = 0.7;
    $AverageCPC = 30; 
    $AverageCPC2 = 0.3; 
    $txt = '';
}
if ($kpi['kpiSum2'] != "-") {
    $k = round($kpi['kpiSum2'] * $AverageKPI2 ,2 );
    
}else{
    $k = "-";
    
}

if($cpc['cpcSum2'] != "-"){
    $c = round($cpc['cpcSum2'] * $AverageCPC2 , 2)  ;
    

}else{
    $c = "-";
    
}

if($k != "-" && $c != "-"){
    $kc = round($k + $c ,2);
    $g = $report->cutGrade(round($kc));
}else {
    $g = "-";
    
    $kc = "-";
    
}

$AA = $AverageKPI+$AverageCPC;

if($g != "-"){
    $gradeResult = $grade[$g];
}else { 
    $gradeResult = "อยู่ระหว่างการประเมิน";
}

// ----------- user----
if ($kpi['kpiSum2_user'] == 0) {
    $k_user = "-";
}else{
    $k_user = round($kpi['kpiSum2_user'] * $AverageKPI2,2) ;
}
if ($cpc['cpcSum2_user'] == 0) {
    $c_user = "-";
}else{
    $c_user = round($cpc['cpcSum2_user'] * $AverageCPC2,2) ;
}
if ($k_user != "-" && $c_user != "-") {
    $kc_user = round($k_user + $c_user,2);
}else{
    $kc_user = "-";
}

?>

  
<a class="date-title">
    <small class="date-title-text"><?php echo $detailYear;?></small>
</a>
<table class="table table-bordered">
    <thead class="thead-for-user">
        <tr>
            <th colspan='2' rowspan='2' style="width: 70%" class="text-center">ดัชนีชี้วัดผลสัมฤทธิ์ (KPIs)</th>
            <th colspan='2' style="width: 15%" class="text-center">ผลการประเมิน</th>
            <th rowspan='2' style="width: 10%" class="text-center"><small>คะแนนรวม<br>(<u>คxนx20</u>)<br>100</small></th>
            <th colspan='2' rowspan='2' style="width: 5%" class="bg-danger text text-danger">ประเมินตนเอง</th>
        </tr>
        <tr>
            <th class="text-center"><small>คะแนน(ค)</small></th>
            <th class="text-center"><small>น้ำหนัก(น)</small></th>
        </tr>
    </thead>
    <tbody>
    <?php
        if (isset($kpi['text']) && count($kpi['text']) > 0) {
            foreach ($kpi['text'] as $key => $value) {
                
                echo "<tr>";
                    echo "<td class='text-center text-info'>".$value['kpi_code_org']."</td>";
                    echo "<td class='text-success'>".$value['kpi_title']."</td>";
                    echo "<td class='text-center text-primary'>".$value['kpi_score']."</td>";
                    echo "<td class='text-center'>".$value['weight']."</td>";
                    echo "<td class='text-center text-success'>".$value['kpiSum']."</td>";
                    echo "<td class='text text-center text-danger bg-danger'>".$value['kpiSum_user']."</td>";
                echo "</tr>";
            }
            echo "<tr>";
                echo "<td colspan='3' class='text-center text-primary'>ผลรวม</td>";
                echo "<td class='text-center'>".$kpi['kpiWeightSum']."%</td>";
                echo "<td class='text-center text-success'>".$kpi['kpiSum2']."</td>";
                echo "<td class='text text-center text-danger bg-danger'>".$kpi['kpiSum2_user_']."</td>";
            echo "</tr>";
        }else {
            echo "<tr>";
            echo "<td class='text-center text-info col-md-2 col-sm-2 col-xs-2'> - </td>";
            echo "<td class='text-success'> - </td>";
            echo "<td class='text-center text-primary'> - </td>";
            echo "<td class='text-center'> - </td>";
            echo "<td class='text-center text-success'> - </td>";
            echo "<td class='text text-center text-danger bg-danger'></td>";
        echo "</tr>";
        }


    ?>
    </tbody>
</table>

<table class="table table-bordered">
    <thead class="thead-for-user">
        <tr>
            <th colspan='2' rowspan='2' style="width: 70%" class="text-center">สมรรถนะ (Competency)</th>
            <th colspan='2' style="width: 15%" class="text-center">ผลการประเมิน</th>
            <th rowspan='2' style="width: 10%" class="text-center"><small>คะแนนรวม<br>(<u>คxนx20</u>)<br>100</small></th>
            <th colspan='2' rowspan='2' style="width: 5%" class="bg-danger text text-danger">ประเมินตนเอง</th>
        </tr>
        <tr>
            <th class="text-center"><small>คะแนน(ค)</small></th>
            <th class="text-center"><small>น้ำหนัก(น)</small></th>
        </tr>
    </thead>
    <tbody>
    <?php 
        
        if (isset($cpc['text']) && count($cpc['text']) > 0) {
            foreach ($cpc['text'] as $key => $value) {

                echo "<tr>";
                    echo "<td class='text-center text-info'>".$value['question_code']."</td>";
                    echo "<td class='text-success'>".$value['question_title']."</td>";
                    echo "<td class='text-center text-primary'>".$value['total']."</td>";
                    echo "<td class='text-center'>".$value['cpc_weight']."</td>";
                    echo "<td class='text-center text-success'>".$value['sum1']."</td>";
                    echo "<td class='text text-center text-danger bg-danger'>".$value['sum1_user']."</td>";
                echo "</tr>";
            }
            echo "<tr>";
                    echo "<td colspan='3' class='text-center text-primary'>ผลรวม</td>";
                    echo "<td class='text-center'>".$cpc['cpcSumWeight']."%</td>";
                    echo "<td class='text-center text-success'>".$cpc['cpcSum2']."</td>";
                    echo "<td class='text text-center text-danger bg-danger'>".$cpc['cpcSum2_user']."</td>";
            echo "</tr>";
        }
    
    ?>
    </tbody>
</table>
<p class="head-text-user" >สรุปภาพรวมผลการประเมินทรัพยากรบุคคล (Human Resouce Evaluation) <?php echo $txt;?></p>

<table class="table table-bordered">
    <thead class="thead-for-user">
        <tr>
            <th  style="width: 70%" class="text-center">มิติการประเมิน</th>
            <th  style="width: 5%" class="text-center">คะแนน</th>
            <th  style="width: 10%" class="text-center"><small>สัดส่วน (ร้อยละ)</small></th>
            <th  style="width: 10%" class="text-center"><small>คะแนน X สัดส่วน</small></th>
            <th  style="width: 5%" class="bg-danger text text-danger">ประเมินตนเอง</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        echo "<tr>";
        echo "<td class='text-info' >ดัชนีชี้วัด (Key Performance Indicator)</td>";
        echo "<td class='text-center text-info'>".$kpi['kpiSum2']."</td>";
        echo "<td class='text-center text-danger'>$AverageKPI2($AverageKPI)</td>";
        echo "<td class='text-center text-success'>".$k."</td>";
        echo "<td class='text text-center text-danger bg-danger'>".$k_user."</td>";
        echo "</tr>
                <tr>
                <td class='text-success'>สมรรถนะ (Competency)</td>";
        echo "<td class='text-center text-success'>".$cpc['cpcSum2']."</td>";
        echo "<td class='text-center text-danger'>$AverageCPC2($AverageCPC)</td>";
        echo "<td class='text-center text-success'>".$c."</td>";
        echo "<td class='text text-center text-danger bg-danger'>".$c_user."</td>";
        echo "  </tr>
    </tbody>
            <tfoot>
                <tr>
                    <td colspan='2' class='text-primary'>รวม";
        // echo "<button type='button' class='btn btn-success btn-xs pull-right' onclick='saveScore()'><i class='fa fa-save'></i> บันทึก คะแนน</button>";
        echo "</td>";
        echo "<td class='text-center text-danger'>$AA %</td>";
        echo "<td class='text-center text-success'>".$kc."</td>";
        echo "<td class='text text-center text-danger bg-danger'>".$kc_user."</td>";
                echo "     
                </tr>
            </tfoot>
        ";
    
    ?>
    
</table>
<?php
    
        echo "<div class='col-md-10 col-sm-10 col-xs-10'>
        <h2 class='text-center text-info'>$gradeResult</h2>
        </div>"
        ;
?>        
    

<div class="col-md-2 col-sm-2 col-xs-2">
    <table class="table table-bordered">
        <tr>
            <td colspan='2' class="text-center text-info"><b>เกณฑ์การประเมิน</b></td>
        </tr>
        <tr>
            <td class="text-success">90 - 100</td>
            <td class="text-success">ดีเด่น</td>
        </tr>
        <tr>
            <td class="text-success">80 - 89</td>
            <td class="text-success">ดีมาก</td>
        </tr>
        <tr>
            <td class="text-success">70 - 79</td>
            <td class="text-success">ดี</td>
        </tr>
        <tr>
            <td class="text-warning">60 - 69</td>
            <td class="text-warning">พอใช้</td>
        </tr>
        <tr>
            <td class="text-danger">0 - 59</td>
            <td class="text-danger">ต้องปรับปรุง</td>
        </tr>
    </table>
</div>

</div>
