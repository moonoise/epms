<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
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


if(!isset($_SESSION[__USER_ID__]) ){ 
  header("location:login-dpis.php");
}

    if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
        $per_cardno = $_SESSION[__USER_ID__];
        $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
        
    }else{
        header("location:login-dpis.php");
    }
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
$myClass = new myClass;
$callYearsOld = $myClass->callYearsOld();
// echo "<pre>";
// print_r($callYearsOld);
// echo "</pre>";

$listHTML = '<option value="">เลือกรอบการประเมิน</option>';
foreach( $callYearsOld['data'] as $key => $value){
    $listHTML .= '<option value="'.$value['table_id'].'">'.$value['detail_short'].'</option>';  
}
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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="height: auto;">
                <div class="x_title">
                    <h2>ผลคะแนนย้อนหลัง <small> .. </small></h2>
                    
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label for="heard">เลือกปีงบประมาณและรอบการประเมิน *:</label>
                                        </div>
                                        <form id="frm_report" target='_blank' method="post">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <select id="select-year" class="form-control" name="years">
                                                <?php echo $listHTML;?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <button type="button" class="btn btn-success" id='btn-select-year'>รายงาน</button>
                                        </div>
                                        <input type="hidden" name="per_cardno" id="per_cardno" value="<?php echo $_SESSION[__USER_ID__];?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                <a class="btn btn-app" id="report_old-rid-135">
                                <i class="fa fa-edit"></i> ชป.135
                                </a>
                               
                                <a class="btn btn-app" id="report_old-rid-kpi135-1">
                                <i class="fa fa-edit"></i> ชป.135/1
                                </a>
                                <a class="btn btn-app" id="report_old-rid-135-2">
                                <i class="fa fa-edit"></i> ชป.135/2
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title x_title-for-user">
                        <h5 class="text text-danger">รายงานผลรายบุคคล : ข้อมูลผลการประเมิน (ย้อนหลัง)</h5>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="content-view">
                        
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

<div id="message"></div>

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

    $("#btn-select-year").on("click",function (e) {
        var table_id = $("#select-year").val();
        var per_cardno = $("#per_cardno").val();

        if (table_id != "") {
            $.ajax({
                url:"module/report/ajax-evaluation-result-year.php",
                dataType:"html",
                type:"POST",
                data:{"table_id":table_id,"per_cardno":per_cardno},
                success: function (result){
                    $("#message").html("");
                    $("#content-view").html(result)
                }, 
                beforeSend: function () {
                    $("#message").html("<div class='loading'>Loading&#8230;</div>");
                }
            });
        }
    });

    $("#report_old-rid-135").on("click",function (e){
        // var yearS = $("#select-year").val();
        // window.open('module/report/report_old-rid-135.php?yearS='+yearS+'&per_cardno='+per_cardno,'_blank');
        $("#frm_report").prop("action","module/report_admin/export-rid135-all-new.php");
        $( "#frm_report" ).submit();


    });

     $("#report_old-rid-kpi135-1").on("click",function (e){
        // var yearS = $("#select-year").val();
        // window.open('module/report/report_old-rid-kpi135-1.php?yearS='+yearS,'_blank');

        $("#frm_report").prop("action","module/report_admin/export-kpi135-1-new.php");
        $( "#frm_report" ).submit();
    });

    $("#report_old-rid-135-2").on("click",function (e){
        // var yearS = $("#select-year").val();
        // window.open('module/report/report_old-rid-135-2.php?yearS='+yearS,'_blank');

        $("#frm_report").prop("action","module/report_admin/export-rid135-2-1-new.php");
        $( "#frm_report" ).submit();
    });

    
</script>