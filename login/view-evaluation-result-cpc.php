<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "includes/class.permission.php";
include_once "module/myClass.php";
$per_cardno ="";

$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");

$cpcTypeKey = array(1,2,3,4,5,6);


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
// $per_cardno = 3100500699317;
// $name = "test";
// $level_no ="D1";
// echo "<pre>";
//    print_r($success);
// echo "</pre>";

$report = new report;

$myClass = new myClass;
$currentYear = $myClass->callYear();
$idpScoreTable = $currentYear['data']['idp_score'];
$year = $currentYear['data']['table_year'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$detailYear = $currentYear['data']['detail'];

(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$year,$cpcTypeKey,$personalTable,$cpcScoreTable) : $cpcResult);
$r = $report->cal_gap_chart($cpcResult);
$gap = $report->cal_gap($r,$idpScoreTable);
$idp = $report->cal_idp($per_cardno,$year,$idpScoreTable);

// $gapUpdate = array();

// foreach ($r as $keyGapUpdate => $valueGapUpdate) {

//     $gapUpdate[] = $report->gapUpdateByid($valueGapUpdate['pointEqual_OverGap'],$valueGapUpdate['gap_status'],$valueGapUpdate['cpc_score_id'],$currentYear['data']['cpc_score']);

// }

// echo "<pre>";
//    print_r($r);
// echo "</pre>";

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
#modal-idp {
	margin-top:200px;
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
   
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <a class="date-title">
                        <small class="date-title-text"><?php echo $detailYear ;?></small>
                    </a>
                        <table class="table table-bordered">
                            <thead class="thead-for-user"> 
                                <tr>
                                    <th colspan='2' style="width: 80%" class="text-center">รายชื่อสมรรถนะ</th>
                                    <th style="width:  5%" class="text-center">ระดับที่คาดหวัง</th>
                                    <th  style="width: 5%" class="text-center">ระดับที่ได้</th>
                                    <th  style="width: 5%" class="text-center">น้ำหนัก</th>
                                    <th  style="width: 5%" class="text-center">ส่วนต่าง</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                               
                               if ($cpcResult['success'] === true) {
                                    $cpcSum2 = 0;
                                    
                                    // echo "<pre>";
                                    // print_r($cpcResult);
                                    // echo "</pre>";
                                foreach ($r as $key => $value) {
            
                                    echo "<tr>";
                                        echo "<td class='text-center text-info'>".$value['question_code']."</td>";
                                        echo "<td class='text-success'>".$value['question_title']."</td>";
                                        echo "<td class='text-center text-danger'>".$value['cpc_divisor']."</td>";
                                        $pp = $value['point'];
                                        if($pp > 0 ){
                                            echo "<td class='text-center text-primary'> $pp </td>";
                                        }else if($pp === 0 ){
                                            echo "<td class='text-center text-primary'> $pp </td>";
                                        }
                                        elseif($pp ===  null ) {
                                            echo "<td class='text-center text-danger'> - </td>";
                                        }
                                        echo "<td class='text-center'>".$value['cpc_weight']."</td>";
                                        $ss = $value['result_minus'];
                                            if($ss > 0 ){
                                                echo "<td class='text-center text-info'> +$ss </td>";
                                            }elseif($ss < 0 ) {
                                                echo "<td class='text-center text-danger'> $ss </td>";
                                            }elseif($ss ==  0 ) {
                                                echo "<td class='text-center'> $ss </td>";
                                            }
                                            elseif($ss ===  null ) {
                                                echo "<td class='text-center'> - </td>";
                                            }
                                    echo "</tr>";
                                }
                               }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
        </div>  <!-- row 1 -->
        <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                        <h5 class="head-text-user">รายการสมรรถนะที่ต้องพัฒนา /  เพิ่มจุดแข็ง<small></small></h5>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        
                        <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th rowspan="2" class="text-center" style="width: 10%">ประเภท</th>
                          <th rowspan="2" class="text-center"style="width: 25%" >สมรรถนะที่ต้องพัฒนา /
                          <br> ความรู้/ทักษะ/สมรรถนะ ที่ต้องการพัฒนาเพื่อเพิ่มจุดแข็ง</th>
                          <th rowspan="2" class="text-center" style="width: 35%">หลักสูตร / วิธีการพัฒนา</th>
                          <th colspan="2" class="text-center" style="width: 20%">ระยะเวลาในการพัฒนา</th>
                          <th rowspan="2" class="text-center" style="width: 10%">#</th>
                        </tr>
                        <tr>
                          <th class="text-center">ตามแผน (ช.ม)</th>
                          <th class="text-center">ตามจริง (ช.ม)</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        foreach ($gap['gap'] as $key => $value) {
                            if ($value['idp_id'] != false || $value['idp_id'] != null) {
                                echo "<tr>
                                        <td class='text-center'>ปิดจุดอ่อน</td>
                                        <td>".($value['question_code']!=""?"[".$value['question_code']."]":"")." ".$value['question_title']." </td>
                                        <td>[".$value['idp_title']."] <br>".$value['idp_training_method']."</td>
                                        <td class='text-center'>".($value['idp_training_hour']!="" ? $value['idp_training_hour']." ชม." : "" )." </td>
                                        <td class='text-center'>".($value['idp_training_hour_success']!= "" ? $value['idp_training_hour_success']." ชม." : "-" )." </td>
                                        <td class='text-center'> 
                                        <button type='button' class='btn btn-info btn-xs fa fa-edit' onclick='assign_gap(`".json_encode($gap['gap'][$key])."`)'></button>";

                                echo    ($value['idp_id']!=''?"<button type='button' class='btn btn-danger btn-xs fa fa-eraser idp-confrim-delete' onclick='idp_delete(".$value['idp_id'].")'> </button>":"");
                                echo    "</td>
                                        
                                    </tr>";
                                }
                            else {
                                echo "<tr>
                                        <td class='text-center'>ปิดจุดอ่อน</td>
                                        <td>[".$value['question_code']."] ".$value['question_title']." </td>
                                        <td class='text-center'> - </td>
                                        <td class='text-center'> - </td>
                                        <td class='text-center'> - </td>
                                        <td class='text-center'> 
                                        <button type='button' class='btn btn-info btn-xs fa fa-edit' onclick='assign_gap(`".json_encode($gap['gap'][$key])."`)'></button> ";
                                       
                                        echo         ($value['idp_id']!=''?"<button type='button' class='btn btn-danger btn-xs fa fa-eraser idp-confrim-delete' onclick='idp_delete(".$value['idp_id'].")'> </button>":"");
                                        echo    "</td>
                                                
                                            </tr>";
                            }
                        }
                      ?>

                      <?php 
                      if (isset($idp['idp']) && count($idp['idp']) > 0 ) {
                        foreach ($idp['idp'] as $key => $value) {
                            echo "<tr>
                            <td class='text-center'>เพิ่มจุดแข็ง</td>
                            <td>[".$value['question_code']."] ".$value['question_title']." </td>
                            <td>[".$value['idp_title']."] <br>".$value['idp_training_method']."</td>
                            <td class='text-center'>".$value['idp_training_hour']." ชม.</td>
                            <td class='text-center'>".($value['idp_training_hour_success'] != "" ? $value['idp_training_hour_success']." ชม." :"-" ) ." </td>
                            <td class='text-center'> 
                            <button type='button' class='btn btn-info btn-xs fa fa-edit' onclick='assign_idp(`".json_encode($idp['idp'][$key])."`)'></button> 
                            <button type='button' class='btn btn-danger btn-xs fa fa-eraser idp-confrim-delete' onclick='idp_delete(".$value['idp_id'].")'> </button>
                            </td>
                            </tr>";
                        }
                      }
                        
                      ?>
                      
                      </tbody>
                    </table>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" class="btn btn-info" id="btn-new-idp">เพิ่ม</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                    <div class="x_title">
                    <h5 class="head-text-user">ตารางเปรียบเทียบผลประเมินสมรรถนะ<small></small></h5>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <canvas id="mybarChart"></canvas>
                    
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


 <!-- Modal  GAP -->
 <div class="modal fade" id="modal-gap" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-info" id="my-gap">แผนพัฒนาบุคลากรรายบุคคล (Individual Development Plan: IDP)</h4>
            </div>
            <div class="modal-body" id="modal-body-gap">
            <form method="POST" id="frm-gap" name="frm_gap" data-parsley-validate="">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p> 
                            <label class="text text-info">ประเภทสมรรถนะ : </label> 
                            <span class="text text-primary" id="modal-idp-type" >สมรรถนะหลัก (Core Competency)</span>
                        </p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <label class="text text-info">ชื่อ : </label> 
                            <span  class="text text-primary" id="modal-question-code-title" >[Rid1-02] การบริการที่ดี (Service Mind) </span>
                        </p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <label class="text text-info">หลักสูตร / หัวข้อ / เรื่อง: </label>
                            <input type="text" id="idp-title" class="form-control" name="idp_title" required="" data-parsley-error-message="กรุณาใส่ชื่อหลักสูตร">
                        </p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                        <label for="idp-training-method" class="text text-info">รายละอียดวิธีการพัฒนา (อย่างน้อย 5 ตัวอักษร, แต่ไม่เกิน 255 ตัวอักษร) :</label>
                        <textarea id="idp-training-method" required="required" class="form-control" 
                            name="idp_training_method" data-parsley-trigger="keyup" data-parsley-minlength="5" 
                            data-parsley-maxlength="255" data-parsley-minlength-message="ใส่รายละเอียดอย่างน้อย 5 ตัวอักษร แต่ไม่เกิน 255 ตัวอักษร" 
                            data-parsley-validation-threshold="10" data-parsley-error-message="กรุณาใส่รายละเอียดอย่างน้อย 5 ตัวอักษร"></textarea>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                            <label for="idp-training-hour" class="control-label con-md-3 text text-info">จำนวนชั่วโมง<span class="required">*</span> : </label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                        <input type="text" id="idp-training-hour" name="idp_training_hour" required="" class="form-group" size="2" data-parsley-error-message="กรุณาใส่จำนวนชั่วโมงที่จะพัฒนาตัวเอง" data-parsley-type="number">
                        <span class="text text-info"> ชม.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="hiden_idp_id" id="hiden_idp_id">
            <input type="hidden" name="hiden_per_cardno" id="hiden_per_cardno">
            <input type="hidden" name="hiden_idp_type" id="hiden_idp_type">
            <input type="hidden" name="hiden_question_no" id="hiden_question_no">
            <input type="hidden" name="hiden_cpc_score_id" id="hiden_cpc_score_id">
            <input type="hidden" name="hiden_years" id="hiden_years"> 
            <button type="submit" class="btn btn-info"  id="btn-submit-gap">บันทึก</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
            </div>
            </form>
        </div>
    </div>
</div>

 <!-- Modal  IDP NEW AND EDIT -->
 <div class="modal  fade" id="modal-idp" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-info" id="my-gap">แผนพัฒนาบุคลากรรายบุคคล (Individual Development Plan: IDP)</h4>
            </div>
            <div class="modal-body" id="modal-body-idp">
            <form method="POST" id="frm_idp" name="frm_idp" data-parsley-validate="">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                         
                            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                            <label class="text text-info">ประเภทสมรรถนะ : </label>
                            </div> 
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select name="new_idp_cpcType" id="new_idp_cpcType" class="form-control" >
                                <option value="">เลือก..</option>
                                <option value="">ไม่ระบุ</option>
                                <?php 
                                    foreach ($cpcType as $key => $value) {
                                        echo "<option value=\"$key\" class=\"text text-info\">$value</option>";
                                    }
                                ?>
                            </select>
                            </div>
                            
                        
                    </div>
                
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                            <label class="text text-info">ชื่อ (ความรู้ / ทักษะ / สมรรถนะ) : </label> 
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12 form-group">
                            <input type="text" name="new_idp_type_detail" id="new_idp_type_detail" class="form-control" placeholder="กรอกเอง หรือระบุตามสมรรถนะที่มีอยู่ในระบบก็ได้">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                            <button id="btn-select-cpc"  class="btn btn-info btn-xs" type="button">เลือก..</button>
                            <button id="btn-select-cpc-clear"  class="btn btn-warning btn-xs" type="button">ล้าง..</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <label class="text text-info">หลักสูตร / หัวข้อ / เรื่อง: </label>
                            <input type="text" id="new_idp_title" class="form-control" name="new_idp_title" required="" data-parsley-error-message="กรุณาใส่ชื่อหลักสูตร"> 
                            
                        </p>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                        <label for="idp-training-method" class="text text-info">รายละอียดวิธีการพัฒนา (อย่างน้อย 5 ตัวอักษร, แต่ไม่เกิน 255 ตัวอักษร) :</label>
                        <textarea id="new_idp_training_method" required="required" class="form-control" 
                            name="new_idp_training_method" data-parsley-trigger="keyup" data-parsley-minlength="5" 
                            data-parsley-maxlength="255" data-parsley-minlength-message="ใส่รายละเอียดอย่างน้อย 5 ตัวอักษร แต่ไม่เกิน 255 ตัวอักษร" 
                            data-parsley-validation-threshold="10" data-parsley-error-message="กรุณาใส่รายละเอียดอย่างน้อย 5 ตัวอักษร"></textarea>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                            <label for="idp-training-hour" class="control-label con-md-3 text text-info">จำนวนชั่วโมง<span class="required">*</span> : </label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                        <input type="text" id="new_idp_training_hour" name="new_idp_training_hour" required="" class="form-group" size="2" data-parsley-error-message="กรุณาใส่จำนวนชั่วโมงที่จะพัฒนาตัวเอง" data-parsley-type="number">
                        <span class="text text-info"> ชม.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="new_idp_id" id="new_idp_id">
            <input type="hidden" name="new_per_cardno" id="new_per_cardno" value="<?php echo $_SESSION[__USER_ID__];?>">
            <input type="hidden" name="new_question_no" id="new_question_no">
            <input type="hidden" name="hidden_new_idp_cpcType" id="hidden_new_idp_cpcType">
            <input type="hidden" name="new_years" id="new_years" value="<?php echo $year;?>"> 
            <button type="submit" class="btn btn-info"  id="btn-submit-new-gap">บันทึก</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ปิด</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-select-cpc" class="modal fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title text-info" id="my-gap">เลือกสมถรรณะ</h4>
            </div>
            <div class="modal-body" id="modal-body-idp">
                <table id="datatable-cpc_question-select" class="table table-hover table-bordered" style="width:100%">
                    <thead>
                        <tr class="bg-info">
                            <th class="col-md-3 col-sm-3 col-xs-3">รหัส</th>
                            <th class="col-md-9 col-sm-9 col-xs-9">สมรรถนะ</th>
                            <th class="col-md-9 col-sm-9 col-xs-9">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close-cpc-select" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">ปิด</button>
            </div>
        </div>
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
    
    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

    <!-- ฟังก์ชั่นกำหนดให้ cursor ไปรออยู่ท้าย text -->
    <script src="../vendors/put-cursor-at-end/put-cursor-at-end.js"></script>

      <!-- PNotify -->
      <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

<script src="../vendors/parsleyjs/dist/parsley.min.js"></script>

  <!-- Chart.js -->
  <script src="../node_modules/chart.js/dist/Chart.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <!-- Await -->
    <script src="../assets/js/await.js"></script>
 
  </body>
</html>
<script>

gap_chart('<?php echo $per_cardno;?>','<?php echo $year; ?>')
function gap_chart(per_cardno,years) {
    var loop = new Await;
    var question_code = [];
    var pointEqual = [];
    var pointEqual_OverGap = [];
    $.ajax({
        type: "POST",
        url: "module/report/ajax-gap_chart-json.php",
        data: {"per_cardno":per_cardno,"years":years},
        dataType: "JSON",
        success: function (response) {

            loop.each(response, function (indexInArray, valueOfElement) { 
                //  console.log(valueOfElement['question_title'])
                question_code.push(valueOfElement['question_code'])
                pointEqual.push(valueOfElement['pointEqual'])
                pointEqual_OverGap.push(valueOfElement['pointEqual_OverGap'])
            });
            // console.log(point)
            gap_chart_show(question_code,pointEqual,pointEqual_OverGap)

        }
    });
}

function gap_chart_show(question_code,pointEqual,pointEqual_OverGap){
    if ($('#mybarChart').length ){ 
        var ctx = document.getElementById("mybarChart");
        var mybarChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: question_code,
            datasets: [{
                label: 'ค่าคาดหวัง',
                backgroundColor: "rgba(3, 88, 106, 0.6)",
                borderColor: "rgba(3, 88, 106, 0.80)",
                borderWidth: 1,
                data: pointEqual
            }, {
                label: 'คะแนนที่ได้',
                backgroundColor: "rgba(38, 185, 154, 0.6)",
                borderColor: "rgba(38, 185, 154, 0.85)",
                borderWidth: 1,
                data: pointEqual_OverGap
            }]
            },
            options: {
            scales: {
                yAxes: [{
                ticks: {
                    beginAtZero: true
                }
                }]
            }
            }
        });
        
        }
}

function assign_gap(arrGap) {
    // console.log(arrGap)
    // var Obj = JSON.parse(arrGap.replace(/\s+/g,"")); 
    var Obj = JSON.parse(arrGap.replace(/\r\n|\n|\r/g, '<br/>')); 
    
    var cpcType = <?php echo json_encode($cpcType);?> ;
   
    // console.log(cpcType[Obj.idp_type])
    // var key = Object.keys(cpcType)[Obj.idp_type];
    // var cpcType_content = cpcType[key-1]
     
    $("#modal-idp-type").html(cpcType[Obj.idp_type]);
    $("#modal-question-code-title").html("["+Obj.question_code+"] "+Obj.question_title);
    
    $("#hiden_idp_id").val(Obj.idp_id);
    $("#idp-title").val(Obj.idp_title);
    $("#idp-training-method").val(Obj.idp_training_method);
    $("#idp-training-hour").val(Obj.idp_training_hour);
    $("#hiden_idp_type").val(Obj.idp_type);
    $("#hiden_question_no").val(Obj.question_no);
    $("#hiden_cpc_score_id").val(Obj.cpc_score_id);
    $("#hiden_years").val(Obj.years);
    $("#hiden_per_cardno").val(Obj.per_cardno);

    $("#modal-gap").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
}

$("#btn-new-idp").on("click", function () {
    

    $("#modal-idp").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
    })
});

$("#btn-select-cpc-clear").on("click", function () {
    $("#new_idp_type_detail").val("")
    $("#new_question_no").val("") 
    $("#new_idp_cpcType").val("").change();
    $("#new_idp_cpcType").prop("disabled",false)
    $("#new_idp_type_detail").prop("readonly",false)
});

$("#btn-select-cpc").on("click", function () {
    $.ajax({
        url:"module/gap/ajax-cpc-select.php",
        dataType:"json",
        type:"POST",
        success: function(result){
            t.clear().rows.add(result.aaData).draw();
        }
    });
    $("#modal-select-cpc").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
    })
    $('#modal-idp').css('opacity', .8);
  	
});
$("#modal-close-cpc-select").on("click", function () {
    $('#modal-idp').css('opacity', 1);
});

//example
// $('#modal-select-cpc').on('show', function() {
//   	$('#modal-idp').css('opacity', .5);
//   	$('#modal-idp').unbind();
// });
// $('#modal-select-cpc').on('hidden', function() {
//   	$('#modal-idp').css('opacity', 1);
//   	$('#modal-idp').removeData("modal").modal({});
// });


$("#frm-gap").submit(function (e) { 
    e.preventDefault();
    if($(this).parsley().isValid()){
            $.ajax({
            type: "POST",
            url: "module/gap/ajax-gap_edit-update.php",
            data: $("#frm-gap").serialize(),
            dataType: "JSON",
            success: function (response) {
                $("#modal-gap").modal("hide");
                if (response.success == true) {
                    notify('เพิ่มแผนพัฒนาบุคลากรรายบุคคล','สำเร็จ','success')
                    setTimeout(location.reload.bind(location), 100);
                }else if(response.success == null){
                    notify('เพิ่มแผนพัฒนาบุคลากรรายบุคคล',response.msg,'danger')
                }
            }
        });
    }
    
    
});


var c = [ {"question_code":"","question_title":"","button_select":""} ]  // set default row=0 ,  Everytime datatable ajax active

var t =  $('#datatable-cpc_question-select').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:"question_code"},
                  {data:"question_title"},
                  {data:"button_select"}
                ],
        'pageLength': 2,
        "lengthMenu": [[2,10,25, 50,100, -1], [2,10, 25, 50,100, "All"]]
      })

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

function cpc_question_select(question_no,question_title,question_type) {
    $("#new_idp_type_detail").val(question_title)
    $("#new_question_no").val(question_no)
    $("#new_idp_cpcType").val(question_type).change(); 
    $("#new_idp_cpcType").prop("disabled",true)
    $("#hidden_new_idp_cpcType").val(question_type);
    $("#new_idp_type_detail").prop("readonly",true)
    $("#modal-select-cpc").modal('hide')
    $('#modal-idp').css('opacity', 1);
}

$("#frm_idp").submit(function (e) { 
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        url: "module/gap/ajax-idp-new_update.php",
        data: $("#frm_idp").serialize(),
        dataType: "JSON",
        success: function (response) {
            if (response.success == true) {
                notify('แก้ไข','สำเร็จ','success')
                $("#modal-idp").modal("hide"); 
                setTimeout(location.reload.bind(location), 100);
            }else if(response.success == null){
                notify('แก้ไข','เกิดข้อผิดพลาด'+msg,'danger')
            }
            
        }
    });


});

function assign_idp(arrGap) {
    // var Obj = JSON.parse(arrGap.replace(/\s+/g,"")); 
    var Obj = JSON.parse(arrGap.replace(/\r\n|\n|\r/g,'<br/>')); 
    
    var cpcType = <?php echo json_encode($cpcType);?> ;
   
    // console.log(cpcType[Obj.idp_type])
    // var key = Object.keys(cpcType)[Obj.idp_type];
    // var cpcType_content = cpcType[key-1]
    if (Obj.idp_type != null) {
        $("#new_idp_cpcType").val(Obj.idp_type).change();
        $("#hidden_new_idp_cpcType").val(Obj.idp_type);
        $("#new_idp_type_detail").val(Obj.idp_type_detail);
        $("#new_idp_cpcType").prop("disabled",true)
        $("#new_idp_type_detail").prop("readonly",true)
    }else{
        $("#new_idp_type_detail").val(Obj.idp_type_detail);
        $("#new_idp_type_detail").prop("readonly",false)
    }
    $("#new_idp_title").val(Obj.idp_title);
    $("#new_idp_training_method").val(Obj.idp_training_method);
    $("#new_idp_training_hour").val(Obj.idp_training_hour);

    $("#new_idp_id").val(Obj.idp_id);
    $("#new_question_no").val(Obj.question_no);


    $("#modal-idp").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
}

$("#new_idp_cpcType").on("change", function () {
    $("#hidden_new_idp_cpcType").val( $("#new_idp_cpcType").val());  
    // console.log( $("#hidden_new_idp_cpcType").val())
});


$(".idp-confrim-delete").popConfirm({
        title: "การลบ", // The title of the confirm
        content: "คุณต้องการลบจริงหรือไม่ IDP & GAP?", // The message of the confirm
        placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
});

function idp_delete(idp_id) {
    $.ajax({
        type: "POST",
        url: "module/gap/ajax-idp-gap-delete.php",
        data: {"idp_id":idp_id},
        dataType: "JSON",
        success: function (response) {
            if (response.success == true) {
                notify('การลบ','สำเร็จ','success')
                setTimeout(location.reload.bind(location), 100);
            }
        }
    });
}
</script>
