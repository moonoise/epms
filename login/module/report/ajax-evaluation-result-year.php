<?php 
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "../../module/report/class-report.php";
include_once "../module_profile/class.profile.php";
include_once "../../includes/class.permission.php";

$per_cardno ="";
$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
// $r = array("success" => null,
//                     "result" => "",
//                     "msg" => "");
$cpcTypeKey = array(1,2,3);

if(!isset($_SESSION[__USER_ID__]) ){ 
    header("location:login-dpis.php");
  }
  
      if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
          $per_cardno = $_SESSION[__USER_ID__];
          $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
          
      }else {
        header("location:login-dpis.php");
      }
  activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);

  $report = new report;

  $per_cardno = $_POST['per_cardno'];
  $part = explode("-",$_POST['years']);

  try {
    $sqlSelectYear = "SELECT * FROM `table_year` WHERE `table_year`.`table_year` LIKE :yy ORDER BY `table_year`.`table_year` ASC  ";
    $stmY = $report->conn->prepare($sqlSelectYear);
    $yy = $part[0]."%";
    $stmY->bindParam(":yy",$yy);
    $stmY->execute();
    $tableYear = $stmY->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // print_r($yy);
    // echo "</pre>";
    if (count($tableYear) === 2) {
        $tablePersonal = $tableYear[0]['per_personal']; 
        $tableCPCscore = $tableYear[0]['cpc_score'];
        $tableKPIscore = $tableYear[0]['kpi_score'];
        $startEvaluation_part1 = $tableYear[0]['start_evaluation'];  //วันเริ่มต้นช่วงที่ 1
        $endEvaluation_part1 = $tableYear[0]['end_evaluation'];
        $startEvaluation_part2 = $tableYear[1]['start_evaluation']; //วันเริ่มต้นช่วงที่ 2
        $endEvaluation_part2 = $tableYear[1]['end_evaluation'];
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $sqlSelectYear = "SELECT `through_trial` FROM $tablePersonal where per_cardno = :per_cardno  ";
    $stmY = $report->conn->prepare($sqlSelectYear);
    
    $stmY->bindParam(":per_cardno",$per_cardno);
    $stmY->execute();
    $personal = $stmY->fetchAll(PDO::FETCH_ASSOC);
 
} catch (Exception $e) {
    echo $e->getMessage();
}

$AA = 0;
$AverageKPI = 0 ;
$AverageCPC = 0;
$k = 0;
$c = 0;

$kpiError = "";
$cpcError = "";
$kpi_score_result = "";
$cpc_score_result_head = "";

  (!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$_POST['years'],$tableKPIscore) : $kpiResult);
  $kpi = $report->reportKPI1($kpiResult);
  
  (!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$_POST['years'],$cpcTypeKey,$tablePersonal,$tableCPCscore) : $cpcResult);
  $cpc = $report->reportCPC1($cpcResult);



//   echo "<pre>";
//   print_r($cpcResult);
// echo "</pre>";
  if ($personal[0]['through_trial'] == 1) {
    $AverageKPI = 70;
    $AverageKPI2 = 0.7;
    $AverageCPC = 30; 
    $AverageCPC2 = 0.3; 
    $txt = '';
}elseif ($personal[0]['through_trial'] == 2) {
    $AverageKPI = 50;
    $AverageKPI2 = 0.5;
    $AverageCPC = 50; 
    $AverageCPC2 = 0.5;
    $txt = '<b class="text-danger text-center">อยู่ในช่วงทดลองงาน</b>';
}else{
    $AverageKPI = 70;
    $AverageKPI2 = 0.7;
    $AverageCPC = 30; 
    $AverageCPC2 = 0.3; 
    $txt = '';
}

//   echo "<pre>";
//   print_r($cpc);
// echo "</pre>";

if ( $kpi['kpiSum2']  != "-" ) {
    $k = $kpi['kpiSum2'] * $AverageKPI2;

}else {
    $kpiError = "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
                </button>
                <strong>ไม่พบข้อมูล ตัวชี้วัด </strong>  อาจเป็นเพราะไม่มีการประเมิน  ในปีงบประมาณ  ".($part[0]+543)."
            </div>";

    $k = "-";
    $kpi_score_result = "-";
    $AverageKPI2 = "-";
    $AverageKPI = "-";

}

if ($cpc['cpcSum2'] != "-") {
    $c = $cpc['cpcSum2'] * $AverageCPC2 ;
}else {
    $cpcError = "<div class='alert alert-warning alert-dismissible fade in' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
            </button>
            <strong>ไม่พบข้อมูล สมรรถนะ </strong>  อาจเป็นเพราะไม่มีการประเมิน  ในปีงบประมาณ  ".($part[0]+543)."
        </div>";
    $c = "-";
    $cpc_score_result_head = "-";
    $AverageCPC2 = "-";
    $AverageCPC = "-";
}


    if($k != "-" && $c != "-"){
        $kc = $k + $c;
        $g = $report->cutGrade(round($kc));
    }else {
        $g = "-";
        $kc = "-";
    }

    $AA = $AverageKPI+$AverageCPC;

    if($g != "-"){
        $gradeResult = $grade[$g];
    }else { 
        $gradeResult = "";
    }


?>

    <?php echo $kpiError ;?>
    <a class="date-title">
        <small class="date-title-text">ประเมินรอบที่ <?php echo $part[1];?> ประจำปีงบประมาณ <?php echo $part[0]+543;?></small>
    </a>
    <table class="table table-bordered">
        <thead class="thead-for-user">
            <tr>
                <th colspan='2' rowspan='2' style="width: 75%" class="text-center">ดัชนีชี้วัดผลสัมฤทธิ์ (KPIs)</th>
                <th colspan='2' style="width: 15%" class="text-center">ผลการประเมิน</th>
                <th rowspan='2' style="width: 10%" class="text-center"><small>คะแนนรวม<br>(<u>คxนx20</u>)<br>100</small></th>
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
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td colspan='3' class='text-center text-primary'>ผลรวม</td>";
                    echo "<td class='text-center'>".$kpi['kpiWeightSum']."%</td>";
                    echo "<td class='text-center text-success'>".$kpi['kpiSum2']."</td>";
                echo "</tr>";
            }
            
            
        ?>
        </tbody>
    </table>
    <?php echo $cpcError;?>
    <table class="table table-bordered">
        <thead class="thead-for-user">
            <tr>
                <th colspan='2' rowspan='2' style="width: 75%" class="text-center">สมรรถนะ (Competency)</th>
                <th colspan='2' style="width: 15%" class="text-center">ผลการประเมิน</th>
                <th rowspan='2' style="width: 10%" class="text-center"><small>คะแนนรวม<br>(<u>คxนx20</u>)<br>100</small></th>
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
                    echo "</tr>";
                }
                echo "<tr>";
                        echo "<td colspan='3' class='text-center text-primary'>ผลรวม</td>";
                        echo "<td class='text-center'>".$cpc['cpcSumWeight']."%</td>";
                        echo "<td class='text-center text-success'>".$cpc['cpcSum2']."</td>";
                echo "</tr>";
            }
           
            
        ?>
        </tbody>
    </table>
    <p class="head-text-user" >สรุปภาพรวมผลการประเมินทรัพยากรบุคคล (Human Resouce Evaluation)</p>

    <table class="table table-bordered">
        <thead class="thead-for-user">
            <tr>
                <th  style="width: 75%" class="text-center">มิติการประเมิน</th>
                <th  style="width: 5%" class="text-center">คะแนน</th>
                <th  style="width: 10%" class="text-center"><small>สัดส่วน (ร้อยละ)</small></th>
                <th  style="width: 10%" class="text-center"><small>คะแนน X สัดส่วน</small></th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            echo "<tr>";
            echo "<td class='text-info' >ดัชนีชี้วัด (Key Performance Indicator)</td>";
            echo "<td class='text-center text-info'>".$kpi['kpiSum2']."</td>";
            echo "<td class='text-center text-danger'>$AverageKPI2($AverageKPI)</td>";
            echo "<td class='text-center text-success'>".$k."</td>";
            echo "</tr>
                    <tr>
                    <td class='text-success'>สมรรถนะ (Competency)</td>";
            echo "<td class='text-center text-success'>".$cpc['cpcSum2']."</td>";
            echo "<td class='text-center text-danger'>$AverageCPC2($AverageCPC)</td>";
            echo "<td class='text-center text-success'>".$c."</td>";
            echo "  </tr>
        </tbody>
                <tfoot>
                    <tr>
                        <td colspan='2' class='text-primary'>รวม";
            // echo "<button type='button' class='btn btn-success btn-xs pull-right' onclick='saveScore()'><i class='fa fa-save'></i> บันทึก คะแนน</button>";
            echo "</td>";
            echo "<td class='text-center text-danger'>$AA %</td>";
            echo "<td class='text-center text-success'>".$kc."</td>";
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

