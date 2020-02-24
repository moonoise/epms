<?php 
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";

session_start();

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3))) ){ 
  header("location:login-dpis.php");
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

  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">

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
                  <div class="x_title x_title-for-user">
                    <h2 class="head-text-user">รายการ <small class="text-info">สมรรถนะ (Competency)</small>
                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                  <table id="cpcView" class="table table-hover table-bordered" style="width:100%">
                  <thead>
                      <tr class="bg-info">
                        <th class="col-md-3 col-sm-3 col-xs-3">รหัส</th>
                        <th class="col-md-9 col-sm-9 col-xs-9">สมรรถนะ</th>
                      </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                   
                </table>

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

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
 
  </body>
</html>

<script>
var c = [ ["","","",""] ]  // set default row=0 ,  Everytime datatable ajax active

var t =  $('#cpcView').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:0},
                  {data:1}
                ],
        'pageLength': 50,
        "lengthMenu": [[25, 50,100, -1], [ 25, 50,100, "All"]]
      })
$( document ).ready(function() {

    $.ajax({
        url:"module/cpc/ajax-question-all.php",
        dataType:"json",
        type:"POST",
        success: function(result){
            t.clear().rows.add(result.aaData).draw();
        }
    });
});

 
</script>