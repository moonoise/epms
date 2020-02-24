<?php 

include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
session_start();
if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))) ){ 
  header("location:disallow.php");
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
   <!-- bootstrap-daterangepicker -->
   <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="../vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
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
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>ข้อมูลส่วน <small>แก้ไขข้อมูลเบื้องต้น</small></h2>
             
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" >
              <!-- method="post" action="ajax/ajax.password.change.php" -->
              <div class="item form-group">
                <label for="password" class="control-label col-md-3">Old Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password_old" type="password" name="password_old"  class="form-control col-md-7 col-xs-12" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label for="password" class="control-label col-md-3">New Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password1" type="password" name="password1" data-validate-length="6,12" class="form-control col-md-7 col-xs-12" required="required">
                </div>
              </div>
            <div class="item form-group">
                <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password2" type="password" name="password2" data-validate-linked="password1" class="form-control col-md-7 col-xs-12" required="required">
                </div>
            </div>
                      
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="button">Cancel</button>
        <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="button" class="btn btn-success" id='submitP' >Submit</button>
                  </div>
                </div>

              </form>
              <div id="message"></div>
            </div>
          </div>
        </div>
          </div>
        </div>
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
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.min.js"></script>
    <!-- validator -->
    <script src="../vendors/validator/validator.js"></script>


    <script>
      

      $(document).ready(function(){
        $("#submitP").on('click',function(){
          //console.log("test");
          var password_old = $("#password_old").val(), password1 = $("#password1").val(), password2 = $("#password2").val();
            $.ajax({
              type:"POST",
              url:"ajax/ajax.password.change.php",
              data:'password_old='+password_old+'&password1='+password1+'&password2='+password2,
              dataType:'JSON',
              success:function(result){
                console.log(result.msg);
                if(result.msg=='true'){
                  $("#message").html(result.msg) ;
                }else{
                  $("#message").html(result.msg);
                }
              }
            });
        });
      });
    </script>

  </body>
</html>
