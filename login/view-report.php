<?php 
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
include_once 'module/myClass.php';

session_start();

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
$idpScoreTable = $currentYear['data']['idp_score'];
$year = $currentYear['data']['table_year'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$table_id = $currentYear['data']['table_id'];

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
.btn.btn-app.btn-print {
    position: relative;
    padding: 15px 5px;
    margin: 0 0 10px 10px;
    height: 60px;
    min-width: 60px;
    box-shadow: none;
    border-radius: 0;
    text-align: center;
    color: #666;
    border: 1px solid #ddd;
    background-color: #fafafa;
    font-size: 12px;
}
.btn.btn-app.btn-print:hover {
    background: #f4f4f4;
    color: #5bc0de;
    border-color: #5bc0de
}
.btn.btn-app.btn-print:active,
.btn.btn-app.btn-print:focus {
    box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
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
                            <h3 class="head-text-user">แบบรายงาน<small class="text text-danger"> (รอบปัจจุบัน)</small></h3>
                            <!-- <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </ul> -->
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-for-user">
                                <tr>
                                    <th style="width: 10%"> # </th>
                                    <th  style="width: 90%">ชป.</th>
                                    
                                </tr>
                               
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                       
                                        <form action="module/report_admin/export-rid135-all-new.php" method="post" target="rid135">
                                            <input type="hidden" name="per_cardno" value="<?php echo  $_SESSION[__USER_ID__];?>">
                                            <input type="hidden" name="years" value="<?php echo  $table_id ;?>">
                                            <button  class="btn btn-app" type="submit"><i class="fa fa-print text-success"></i> พิมพ์</button>
                                        </form>
                                        
                                    </td>
                                    <td>
                                        <span class="text-success">แบบสรุปการประเมินผลการปฏิบัติราชการของข้าราชการ (ชป.135)</span>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <form action="module/report_admin/export-kpi135-1-new.php" method="post" target="kpi135">
                                            <input type="hidden" name="per_cardno" value="<?php echo  $_SESSION[__USER_ID__];?>">
                                            <input type="hidden" name="years" value="<?php echo  $table_id;?>">
                                            <button  class="btn btn-app" type="submit"><i class="fa fa-print text-success"></i> พิมพ์</button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="text-success">แบบกำหนดและประเมินผลสัมฤทธิ์ของงาน (ชป.135/1)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <form action="module/report_admin/export-rid135-2-1-new.php" method="post" target="rid135-2">
                                                <input type="hidden" name="per_cardno" value="<?php echo  $_SESSION[__USER_ID__];?>">
                                                <input type="hidden" name="years" value="<?php echo  $table_id;?>">
                                                <button  class="btn btn-app" type="submit"><i class="fa fa-print text-success"></i> พิมพ์</button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="text-success">แบบกำหนดและประเมินสมรรถนะสำหรับข้าราชการ (ชป.135/2-1)</span>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- <thead>
                                <tr>
                                    <th style="width: 10%"> # </th>
                                    <th  style="width: 90%">IDP.</th>
                                    
                                </tr>
                               
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="btn btn-app btn-print">
                                        <i class="fa fa-print"></i>พิมพ์
                                        </a>
                                    </td>
                                    <td>
                                        <span>ตารางสรุปผลการประเมินความรู้ความสามารถ ทักษะ และสมรรถนะ หน้า 1</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="btn btn-app btn-print">
                                        <i class="fa fa-print"></i>พิมพ์
                                        </a>
                                    </td>
                                    <td>
                                        <span>ตารางสรุปผลการประเมินความรู้ความสามารถ ทักษะ และสมรรถนะ (ต่อ) หน้า 2</span>
                                    </td>
                                </tr>
                            </tbody> -->
                        </table>
                            
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


</script>