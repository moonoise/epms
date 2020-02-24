<?php 

include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";

session_start();
  
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3))) ){ 
  header("location:disallow.php");
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

    <title>ข้อมูลส่วนตัว</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

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
        <?php
        if($permission['per_type'] == 1 || $permission['per_type'] == 2 || $permission['per_type'] == 3){
        include_once "module/module_profile/class.profile.php";
        $profile = new proFile;
        $result = $profile->detail($_SESSION[__USER_NAME__]);

        ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>ข้อมูลส่วนตัว</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ข้อมูลตำแหน่งที่ใช้ในการประเมิน<small>..</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-2 col-sm-2 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                         
                          <img class="img-responsive avatar-view" src="<?php echo $profile->urlPic($_SESSION[__USER_NAME__]);?>" alt="Avatar" title="Change the avatar">
                        
                        </div>
                      </div>
                      <h4>คุณ<?php echo $result['per_name']." ".$result['per_surname'];?></h4>

                      <ul class="list-unstyled user_data">
                        <li><i class="glyphicon glyphicon-credit-card"></i> <?php echo $result['per_cardno']?>
                        </li>

                      <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a> -->
                      <br />

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <!-- detail -->
                      <div class="col-md-6 col-sm-6 col-xs-12" >
                      <table class="table">
                      <thead>
                        <tr>
                          
                          <th><span class="text-info">ข้อมูลตำแหน่งที่ใช้ในการประเมิน</span></th>
                          <th> </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="text-primary">ชื่อ - สกุล </span><span class="text-success"><?php echo $result['per_name']." ".$result['per_surname'];?></span></td>
                        </tr>
                        <tr>
                          <td><span class="text-primary">เพศ </span><span class="text-success"><?php  echo ($result['per_gender']==1 ? "ชาย" : "หญิง" ); ?></span></td>
                        </tr>
                        <tr>
                          <td><span class="text-primary">ประเภทบุคลากร </span><span class="text-success">
                                  <?php switch ($result['per_type']) {
                                        case '1': 
                                                echo "ข้าราชการ";
                                                break;
                                        case '2': 
                                                echo "ลูกจ้างประจำ";
                                                break;
                                        case '3': 
                                                echo "พนักงานราชการ";
                                                break;
                                  }
                                  ?>
                          </span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">ระดับตำแหน่ง </span><span class="text-success"></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">เลขที่บัตรประชาชน </span><span class="text-success"><?php echo $result['per_cardno'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">เลขที่ประจำตัวข้าราชการ  </span><span class="text-success"><?php echo "ไม่มี"; ?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">วันเดือนปีเกิด  </span><span class="text-success"><?php echo $result['per_birthdate'];?></span></td>  
                        </tr>

                        <tr>
                          <td><span class="text-primary">วันที่เข้ารับราชการ  </span><span class="text-success"><?php echo $result['per_startdate'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">วันที่เข้าส่วนราชการ  </span><span class="text-success"><?php echo $result['per_retiredate']?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">โทรศัพท์มือถือ  </span><span class="text-success"><?php echo $result['per_mobile'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">อีเมลล์  </span><span class="text-success"><?php echo $result['per_email'];?></span> </td>  
                        </tr>
                      </tbody>
                    </table>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12" >
                      <table class="table">
                      <thead>
                        <tr>
                          
                          <th> .. </th>
                          <th> </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td><span class="text-primary">เลขที่ตำแหน่ง </span><span class="text-success"><?php echo $result['pos_id'];?></span></td>
                        </tr>
                        <tr>
                          <td><span class="text-primary">เงินประจำตำแหน่ง </span><span class="text-success"><?php echo $result['per_mgtsalary'];?></span></td>
                        </tr>
                        <tr>
                          <td><span class="text-primary">เงินพิเศษ </span><span class="text-success"><?php echo $result['per_spsalary'];?></span></td>
                        </tr>
                        <tr>
                          <td><span class="text-primary">ตำแหน่งสายงาน </span><span class="text-success"><?php echo $result['pl_name'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">ตำแหน่งการบริหาร </span><span class="text-success"><?php echo $result['pm_name'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">ช่วงระดับตำแหน่ง </span><span class="text-success"></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">ประเภทตำแหน่ง  </span><span class="text-success"><?php echo $result['pt_name'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">สำนัก/กอง  </span><span class="text-success"><?php echo $result['org_name'];?></span></td>  
                        </tr>

                        <tr>
                          <td><span class="text-primary">ต่ำกว่าสำนัก/กอง 1 ระดับ  </span><span class="text-success"><?php echo $result['org_name_1'];?></span></td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">ต่ำกว่าสำนัก/กอง 2 ระดับ </span><span class="text-success"><?php echo $result['org_name_2'];?></span> </td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">กระทรวง </span><span class="text-success"></span> </td>  
                        </tr>
                        <tr>
                          <td><span class="text-primary">กรม </span><span class="text-success"></span>  </td>  
                        </tr>
                      </tbody>
                    </table>
                      </div>
                      <!-- end detail -->
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
        }else{
        ?>
<!-- page content -->
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Fixed Sidebar <small> Just add class <strong>menu_fixed</strong></small></h3>

              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


<?php }?>
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

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.min.js"></script>
  </body>
</html>