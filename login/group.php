<?php 
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
session_start();

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5))) ){ 
  header("location:disallow.php");
}
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);  


    $db = new DbConn;
    $tbl_members = $db->tbl_members;
    $query = "SELECT
    `".$tbl_membersGroups."`.*
    FROM
    ".$tbl_membersGroups;
    //echo $query;
    $stmt = $db->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
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

    <title>Group</title>

      <!-- Bootstrap -->
      <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- NProgress -->
      <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
      <!-- iCheck -->
      <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
       <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
      <!-- Datatables -->
      <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.min.css" rel="stylesheet">
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
                    <div class="x_panel">
                        <div class="x_title">
                        <!-- <h5>.. <small>...</small></h5> -->
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        </div> <!-- x_title -->
                        
                        <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                 ส่วนนี้เป็นหน้าสำหรับจัดการสมาชิกภายในกลุ่ม
                </p>
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                     <th>ID</th>
                      <th>Name</th>
                      <th>Detail</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach ($result as $row) {
                            echo "<tr>";
                            echo "<td>".$row['group_id']."</td>";
                            echo "<td>".$row['group_name']."</td>";
                            echo "<td>".$row['group_detail']."</td>";
                            echo "</tr>";
                        }
                      ?>
                  </tbody>
                </table>
                    
                        </div>  <!--  x_content -->

                    </div> <!-- x_panel -->

                </div> <!-- col-md-12 col-sm-12 col-xs-12 -->

            </div> <!-- row -->


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
     <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
     <!-- NProgress -->
     <script src="../vendors/nprogress/nprogress.js"></script>
     <!-- iCheck -->
     <script src="../vendors/iCheck/icheck.min.js"></script>
      <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
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

  <!-- Custom Theme Scripts -->
  <script src="../assets/js/custom.min.js"></script>

  <script>

  // $(document).ready(function(){
  //   $("#submit").click(function(){
  //     // alert('test');
  //     $.ajax({
  //       type:"POST",
  //       url:"/login/includes/editprofile.php",
  //       data:"password="+password+"&fname="+fname+"&lname="+lname+"&sex="+sex+"&birthday="+birthday+"&email="+email,
  //       success: function(html){
  //         var text = $(html).text();
  //         var response = text.substr(text.length - 4);
  //         if(response == "true"){

  //         $("#message").html(html);

  //             $('#submit').hide();
  //         }
  //       else {
  //         $("#message").html(html);
  //         $('#submit').show();
  //         }
  //       },beforeSend: function()
  //     {
  //       $("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>")
  //     }
  //     });
  //   });
  // });
  </script>
</body>
</html>
