<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
include_once "includes/class-date.php";
include_once "module/myClass.php";

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

$myClass = new myClass;
$currentYear = $myClass->callYear();
$year = $currentYear['data']['table_year'];
$idpScoreTable = $currentYear['data']['idp_score'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$detailYear = $currentYear['data']['detail'];


// $per_cardno = 3100500699317;
// $name = "test";
// $level_no ="D1";
// echo "<pre>";
//    print_r($success);
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
    .choise-td {
        padding: 2px;
    }
    .choise-radio {
        margin: 1px 1px 1px 1px ;
    }
    .table>tbody>tr>td {
        padding: 4px;
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
            
                                    <!-- CPC Table -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title x_title-for-user">
                    <h2 class="head-text-user">แบบประเมิน <small class="text-info">สมรรถนะ (Competency)</small>
                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <a class="date-title">
                        <small class="date-title-text"><?php echo $detailYear; ?></small>
                    </a>
                    <table id="evaluation-table" class="table table-hover table-bordered" style="width:100%">
                        <thead class="thead-for-user">
                            <tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">รหัส</th>
                            <th class="col-md-8 col-sm-8 col-xs-8 text-center">สมรรถนะ</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">ค่าคาดหวัง</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">สถานะ</th> 
                            </tr>
                        </thead>
                        <tbody id="evaluation-table-tbody">

                        </tbody>
                      
                </table>

                  </div> <!-- x_content -->
                </div>
                </div>
            </div>
                                <!-- END CPC Table -->
                                <!-- KPI Table -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title x_title-for-user">
                    <h2 class="head-text-user">แบบประเมิน <small class="text-info">ตัวชี้วัด (KPI)</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <a class="date-title">
                        <small class="date-title-text"><?php echo $detailYear; ?></small>
                    </a>
                    <table id="kpi-evaluation-table" class="table table-hover table-bordered" style="width:100%">
                        <thead class="thead-for-user">
                            <tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">รหัส</th>
                            <th class="col-md-8 col-sm-8 col-xs-8 text-center">KPI</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">ค่าน้ำหนัก</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">ประเภท</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 text-center">สถานะ</th> 
                            </tr>
                        </thead>
                        <tbody id="kpi-evaluation-table-tbody">

                        </tbody>
                      
                </table>

                  </div> <!-- x_content -->
                </div>
                </div>
            </div>
                         <!-- END KPI Table -->

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
                <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังประเมินสมรรถนะของ คุณ <span class="modal-name text-success"></span> (<span id="modal-per_cardno-cpc" class="text-warning"></span>)</h4>
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
                <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังประเมินตัวชี้วัด ของ คุณ <span class="modal-name text-success"></span> (<span id="modal-per_cardno-kpi" class="text-warning"></span>)</h4>
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

  
    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
 
  </body>
</html>
<script>
var c = <?php echo (isset($per_cardno)?$per_cardno: "\"\"")?>;
var name = "<?php echo (isset($name)?$name: "\"\"")?>";
$( document ).ready(function() {
 $.ajax({
        url: "module/evaluation/ajax-eva-cpc-show.php",
        type:"GET",
        dataType: "html",
        data: "per_cardno="+ c ,
        success:function (result) {
            $("#evaluation-table-tbody").html(result)
        }
    })

$.ajax({
        url: "module/evaluation/ajax-eva-kpi-show.php",
        type: "GET",
        dataType: "html",
        data: "per_cardno="+c,
        success: function (r) {
            $("#kpi-evaluation-table-tbody").html(r)
        }
    })
});

function refreshEvaTable() {
    $.ajax({
        url: "module/evaluation/ajax-eva-cpc-show.php",
        type:"GET",
        dataType: "html",
        data: "per_cardno="+ c ,
        success:function (result) {
            $("#evaluation-table-tbody").html(result);
        }
    })
}

function refreshEvaTable_kpi() {
    $.ajax({
        url: "module/evaluation/ajax-eva-kpi-show.php",
        type: "GET",
        dataType: "html",
        data: "per_cardno="+c,
        success: function (r) {
            $("#kpi-evaluation-table-tbody").html(r)
        }
    })
}

function cpcEva(per_cardno,question_no,cpc_score_id) {
    var name = "<?php echo (isset($name)?$name: "\"\"")?>";
  $.ajax({
    url: "module/evaluation/ajax-eva-cpc-modal-show.php",
    dataType: "html",
    data: "per_cardno=" + per_cardno +"&question_no="+question_no+"&cpc_score_id="+cpc_score_id,
    success: function (data) {
      $("#modal-body-cpc-eva").html(data)
      $(".modal-name").html(name)
      $("#modal-per_cardno-cpc").html(per_cardno)
      $("#modal-cpc-eva").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
    }
  })
}


function kpiEva(per_cardno,kpi_code,kpi_score_id,kpi_type2) {
    if (kpi_type2 == 2) {
        $.ajax({
            url: "module/evaluation/ajax-eva-kpi-modal-show-type2.php",
            dataType: "html",
            data: "per_cardno="+ per_cardno + "&kpi_code="+ kpi_code + "&kpi_score_id=" + kpi_score_id,
            success :function (data) {
                $("#modal-body-kpi-eva").html(data)
                $(".modal-name").html(name)
                $("#modal-per_cardno-kpi").html(per_cardno)
      
                $("#modal-kpi-eva").modal({
                    show:true,
                    keyboard:false,
                    backdrop:'static'
                })
                setTimeout(function (){
                        // $('#modal-kpi_score-type2').focus();
                        var searchInput = $("#modal-kpi_score-type2");
                        searchInput
                        .putCursorAtEnd() // should be chainable
                        .on("focus", function() { // could be on any event
                            searchInput.putCursorAtEnd()
                        });
                }, 1000);
            } 
        })
    }if (kpi_type2 == 3) {
        $.ajax({
            url: "module/evaluation/ajax-eva-kpi-modal-show-type3.php",
            dataType: "html",
            data: "per_cardno="+ per_cardno + "&kpi_code="+ kpi_code + "&kpi_score_id=" + kpi_score_id,
            success :function (data) {
                $("#modal-body-kpi-eva").html(data)
                $(".modal-name").html(name)
                $("#modal-per_cardno-kpi").html(per_cardno)
                $("#modal-kpi-eva").modal({
                    show:true,
                    keyboard:false,
                    backdrop:'static'
                })
                setTimeout(function (){
                        // $('#modal-kpi_score-type2').focus();
                        var searchInput = $("#modal-kpi_score-type3");
                        searchInput
                        .putCursorAtEnd() // should be chainable
                        .on("focus", function() { // could be on any event
                            searchInput.putCursorAtEnd()
                        })
                }, 1000)
            } 
        })
    }
    
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


function checkAll($k){
    if( $("#cpc_score1"+$k).prop("disabled") == false){
        $("#cpc_score1"+$k).prop("checked", true);
    }
    if( $("#cpc_score2"+$k).prop("disabled") == false){
        $("#cpc_score2"+$k).prop("checked", true);
    }
    if( $("#cpc_score3"+$k).prop("disabled") == false){
        $("#cpc_score3"+$k).prop("checked", true);
    }
    if( $("#cpc_score4"+$k).prop("disabled") == false){
        $("#cpc_score4"+$k).prop("checked", true);
    }
    if( $("#cpc_score5"+$k).prop("disabled") == false){
        $("#cpc_score5"+$k).prop("checked", true);
    }
    
}




</script>