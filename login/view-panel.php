<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";

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

    <!-- Bootstrap Checkboxes/Radios -->
    <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet">

  <!-- PNotify -->
  <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
    <!-- Bootstrap Checkboxes/Radios -->
    <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet">

    <link href="../vendors/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
   
    
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
            
                                    <!-- CPC Table -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa  fa-wrench green"></i> <b style="color:red">T</b>ools Panel <small> .. </small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <h3 class="prod_title"><span class="text-success"> เปิด </span> / <span class="text-danger"> ปิด </span> ระบบการประเมิน</h3>
                 <div class="form-inline"> 
                    <div class="radio radio-danger choise-radio">    
                        <input id="system-on"   class="cpc_score1" name="system_on_off"  type="radio" onclick="system_on_off()"> 
                        <label for="system-on" class="text-success">
                         เปิด     
                        </label>  
                    </div>
                    <div class="radio radio-danger choise-radio">    
                        <input id="system-off"   class="cpc_score1" name="system_on_off"  type="radio" onclick="system_on_off()"> 
                        <label for="system-off" class="text-danger">  
                        ปิด    
                        </label>  
                    </div>
                </div>

                    <h3 class="prod_title">สำหรับผู้ดูแลระบบ</h3>
                    <a class="btn btn-app" href="view-user.php">
                      <i class="fa fa-user blue"></i> <b class="royalblue">จัดการผู้ดูแลระบบ</b>
                    </a>

                    <a class="btn btn-app" href="group.php">
                      <i class="fa fa-group text-info"></i><b class="royalblue">จัดการกลุ่มผู้ดูแลระบบ</b>
                    </a>
                    
                    <h3 class="prod_title">ข่าว</h3>
                    <a class="btn btn-app" href="view-news.php">
                      <i class="fa fa-wechat green"></i><b class="royalblue">ข่าวประชาสัมพันธ์</b>
                    </a>
                    <h3 class="prod_title">การจัดการสมรรถนะ</h3>
                     <a class="btn btn-app" href="view-cpc.php">
                      <i class="fa  fa-check-square-o red"> <i class="fa  fa-ellipsis-v green"></i></i><b class="royalblue">ข้อมูลสมรรถนะ </b>
                    </a>
                    <a class="btn btn-app" href="view-distribute-cpc.php">
                      <i class="fa  fa-caret-square-o-right red"> <i class="fa  fa-ellipsis-v green"></i></i><b class="royalblue">กระจายสมรรถนะ </b>
                    </a>
                    <h3 class="prod_title">การจัดการตัวชี้วัด</h3>
                    <a class="btn btn-app" href="view-kpi.php">
                    <i class="fa fa-line-chart blue"> <i class="fa  fa-ellipsis-v green"></i></i><b class="royalblue">ข้อมูลตัวชี้วัด </b>
                    </a>
                    <h3 class="prod_title">การจัดการข้อมูลบุคลากร</h3>
                    <a class="btn btn-app" href="view-load-person1.php">
                      <i class="fa fa-cloud-download blue"><i class="fa  fa-child blue"></i></i><b class="royalblue">เพิ่มข้อมูลบุคลากร<span class="red">รายบุคคล</span> </b>
                    </a>
                    <a class="btn btn-app" href="view-load-person2.php">
                      <i class="fa fa-cloud-download blue"><i class="fa  fa-child blue"></i><i class="fa  fa-child blue"></i><i class="fa  fa-child blue"></i></i><b class="royalblue">เพิ่มข้อมูลบุคลากร<span class="red">ทั้งหมด</span></b>
                    </a>
                    <a class="btn btn-app" href="view-load-per_actinghis.php">
                      <i class="fa fa-cloud-download blue"><i class="fa  fa-child text-warning"></i></i><b class="royalblue">อัพเดท<span class="text-warning">ผู้ยังไม่ผ่านทดลองงาน</span></b>
                    </a>

                    

                  </div> <!-- x_content -->
                </div>
                </div>
            </div>
                                <!-- END CPC Table -->
   

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

    <!-- Modal  CPC Evaluation -->
    <div class="modal fade" id="modal-cpc-eva" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">คุณกำลังประเมินสมรรถนะของ คุณ <span class="modal-name"></span> (<span id="modal-per_cardno-cpc" class="text-warning"></span>)</h4>
            </div>
            <div class="modal-body" id="modal-body-cpc-eva">
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

    <!-- Modal  KPI Evaluation -->
<div class="modal fade" id="modal-kpi-eva" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">คุณกำลังประเมินตัวชี้วัด ของ คุณ <span class="modal-name"></span> (<span id="modal-per_cardno-kpi" class="text-warning"></span>)</h4>
            </div>
            <div class="modal-body" id="modal-body-kpi-eva">
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button> -->
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

       <!-- PNotify -->
       <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

 <!-- Switchery -->
 <script src="../vendors/switchery/dist/switchery.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
 
  </body>
</html>

<script>


function system_on_off(){
  var system = $("#system-on-off").val()
  
  $.ajax({
    url:"module/system/ajax-system-on-off.php",
    dataType: "JSON",
    type : "POST",
    data: {"system_on_off":system},
    success: function (result) {
      if (result.success == true) {
        check_on_off()
        
        $.ajax({
              url:"module/system/ajax-system-on-off-check.php",
              dataType: "JSON",
              type : "POST",
              success: function (result) {
                result.result
                if (result.result == 1) {
                  notify('เปิด ปิด ระบบการประเมิน','<b class="text-sucess">เปิดระบบแล้ว </b>','success')
                
                }else if(result.result == 0 ){
                  notify('เปิด ปิด ระบบการประเมิน','<b class="text-danger">ปิดระบบแล้ว </b>','danger')
                }
              }
            });
      }else if(result.result == null){
        notify('เปิด ปิด ระบบการประเมิน','<b class="text-warning">Error.0001 </b>','warning')
      }
    }
  });
}


check_on_off()

function check_on_off() {
  
  $.ajax({
    url:"module/system/ajax-system-on-off-check.php",
    dataType: "JSON",
    type : "POST",
    success: function (result) {
      result.result
      if (result.result == 1) {
        $('#system-on').prop('checked',true);
        $('#system-off').prop('checked',false);
      
      }else if(result.result == 0 ){
        $('#system-off').prop('checked',true);
        $('#system-on').prop('checked',false);
      }
    }
  });
}


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
