<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "module/module_profile/class.profile.php";
include_once "includes/class.permission.php";
include_once "module/myClass.php";
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
$cpcTypeKey2 = array(1,2,3,4,5,6);

if(!isset($_SESSION[__USER_ID__]) ){ 
  header("location:login-dpis.php");
}
$success =  groupUsers($_SESSION[__USER_ID__]);
if (($success['success'] === true)   ) {
   if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
      $gOrg_id = $success['result']['org_id'];
   }else 
   {
     $gOrg_id = '77';
   }
}elseif ($success['success'] === false) {
    if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
        $per_cardno = $_SESSION[__USER_ID__];
        $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
        
    }
}  
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);


$report = new report;

$myClass = new myClass;
$currentYear = $myClass->callYear();
$year = $currentYear['data']['table_year'];
$idpScoreTable = $currentYear['data']['idp_score'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$detailYear = $currentYear['data']['detail'];

(!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$year ,$personalTable,$currentYear['data']['kpi_score']) : $kpiResult);

$kpi = $report->reportKPI1($kpiResult);
$kpiUpdateResutl =  $report->kpiResultUpdate($kpi,$currentYear['data']);
// echo "<pre>";
// print_r($kpi['through_trial']);
// echo "</pre>";
(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$year,$cpcTypeKey,$personalTable,$cpcScoreTable) : $cpcResult);
$cpc = $report->reportCPC1($cpcResult);
$updateResutl = $report->cpcResultUpdate($cpc,$currentYear['data']);
// echo "<pre>";
// print_r($kpi);
// echo "</pre>";

(!empty($per_cardno)? $cpcResult2 =  $report->tableCPC($per_cardno,$year ,$cpcTypeKey2,$personalTable,$cpcScoreTable) : $cpcResult);  // cpcTypeKey2 1,2,3,4,5,6
$r = $report->cal_gap_chart($cpcResult2);
$gap = $report->cal_gap($r,$idpScoreTable);
$idp = $report->cal_idp($per_cardno,$year,$idpScoreTable);
$gapUpdate = array();

foreach ($r as $keyGapUpdate => $valueGapUpdate) {

    $gapUpdate[] = $report->gapUpdateByid($valueGapUpdate['pointEqual_OverGap'],$valueGapUpdate['gap_status'],$valueGapUpdate['cpc_score_id'],$cpcScoreTable);

}

// echo "<pre>";
// print_r($r );
// echo "</pre>";
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


// echo $kpi['kpiSum2_user']."<br>";
// echo $cpc['cpcSum2_user']."<br>";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="../external/icon/rid.png">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $site_name;?></title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
    <!-- Bootstrap Checkboxes/Radios -->
    <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet">

    <link href="../vendors/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
   
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <style>
    .x_title h5 {
    margin: 0px 0 6px;
    float: left;
    display: block;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    padding: 3px 0px 3px 0px;
}
    </style>   
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
           <!-- Logo top left -->
           <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo (in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))?"setting-person.php":"view-profile.php" ); ?>" class="site_title"><i class="fa fa-user blue"></i> <span>ระบบ Login</span></a>
          </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- sidebar menu -->
            <?php 
              include_once('template/menu.php');
            ?>
            <!-- /sidebar menu -->
  
              
            <!-- /menu footer buttons -->
            <?php 
            include_once('template/menu-footer-buttons.php');
            
            ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php
        include_once('template/top-navigation.php');
        ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
                <div class="title_left">
                </div>
            </div>
            <div class="clearfix"></div>
            
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title x_title-for-user">
                        <h5 class="head-text-user">รายงานผลรายบุคคล : ข้อมูลผลการประเมิน <small></small></h5>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <a class="date-title">
                            <small class="date-title-text"><?php $detailYear;?></small>
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
                                        echo "<td class='text text-center text-danger bg-danger'>".$kpi['kpiSum2_user']."</td>";
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
                    </div>
                </div>
      
            
        </div>
       

          </div><!--  .. -->
        </div> <!--  right_col -->
        

 
        <!-- /page content -->

        <!-- footer content -->
        <?php
          include_once('template/footer-content.php');
        ?>
        <!-- /footer content -->
      </div>
    </div>



    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    
    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

    <!-- ฟังก์ชั่นกำหนดให้ cursor ไปรออยู่ท้าย text -->
    <script src="../vendors/put-cursor-at-end/put-cursor-at-end.js"></script>

      <!-- PNotify -->
      <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>


<!-- <script src="../vendors/parsleyjs/dist/parsley.min.js"></script> -->

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
 
  </body>
</html>
<script>
    // saveScore();

    // function saveScore() {
    //     saveScoreCPC()
    //     saveScoreKPI()
    // }

    // function saveScoreCPC() {
    //     var per_cardno = '<?php echo $per_cardno;?>'
       
    //     var AverageCPC = '<?php echo $AverageCPC;?>'
       
    //     var cpcScore = '<?php echo ($cpc['cpcSum2'] != "-"? $cpc['cpcSum2'] : "") ; ?>'
    //     var years = '<?php echo $years;?>'

    //     if (cpcScore != "" || AverageCPC != "" ) {
    //         var data = {"cpcScore" : cpcScore ,
    //                     "AverageCPC" : AverageCPC,
    //                     "per_cardno" : per_cardno,
    //                     "years" : years}
    //         $.ajax({
    //             url: "module/report/save-score-cpc.php",
    //             dataType: "json",
    //             type:"POST",
    //             data: data,
    //             success:function (result) {
    //                 if (result.success == true) {
    //                     // notify('การบันทึกคะแนน','บันทึก สมรรถนะ เรียบร้อยแล้ว','success')
    //                 }else{
    //                     // notify('การบันทึกคะแนน','คะแนนยังไม่สมบูรณ์ ไม่สามารถบันทึกได้'+result.msg,'warning')
    //                 }
    //             }
    //         })
    //     }else{
    //         // notify('การบันทึกคะแนน','คะแนนยังไม่สมบูรณ์ ไม่สามารถบันทึกได้','warning')
    //     }
    // }

    // function saveScoreKPI() {
    //     var per_cardno = '<?php echo $per_cardno;?>'
    //     var AverageKPI = '<?php echo $AverageKPI; ?>'
      
    //     var kpiScore = '<?php echo ($kpi['kpiSum2'] != "-" ? $kpi['kpiSum2'] : "" ); ?>'
       
    //     var years = '<?php echo $years;?>'

    //     if (  kpiScore != "" || AverageKPI != "") {
    //         var data = {
    //                     "kpiScore" : kpiScore,
    //                     "AverageKPI" : AverageKPI,
    //                     "per_cardno" : per_cardno,
    //                     "years" : years}
            
    //         $.ajax({
    //             url: "module/report/save-score-kpi.php",
    //             dataType: "json",
    //             type:"POST",
    //             data: data,
    //             success:function (result) {
    //                 // console.log(result.success)
    //                 if (result.success == true) {
    //                     // notify('การบันทึกคะแนน','บันทึก ดัชนีชี้วัดผลสัมฤทธิ์  เรียบร้อยแล้ว ','success')
    //                 }else{
    //                     // notify('การบันทึกคะแนน','คะแนนยังไม่สมบูรณ์ ไม่สามารถบันทึกได้ '+result.msg,'warning')

    //                 }
    //             }
    //         })
    //     }else{
    //         // notify('การบันทึกคะแนน','คะแนนยังไม่สมบูรณ์ ไม่สามารถบันทึกได้','warning')
    //     }
    // }

    function notify(nTitle,nText,nType,timeOut,nHide) {
        var h = (nHide != '' ? true : nHide);
        var t = (timeOut != '' ? 2000 : timeOut);
            // console.log(h)
            // console.log(t)
        
        PNotify.prototype.options.delay = t;
            new PNotify({
                        title: nTitle,
                        text: nText,
                        type: nType,
                        hide: h,
                        styling: 'bootstrap3'
                    });
    }

</script>