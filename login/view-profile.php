<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-date.php";
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
include_once "module/myClass.php";

$newDate = new dateCovert;
$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();
  
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3))) ){ 
  header("location:disallow.php");
}else {
  $per_cardno = $_SESSION[__USER_ID__];
}

function checkPicture($namePicture) {
  $file1 = $namePicture;
  $file_headers1 = @get_headers($file1);
 

  if ($file_headers1[0] != 'HTTP/1.1 404 Not Found') {
      return $file1;
  }else return "../external/images_profile/user.png";
}
    
$myClass = new myClass;
$currentYear = $myClass->callYear();
$result = $myClass->detail($_SESSION[__USER_NAME__],$currentYear['data']['per_personal']);
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
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
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
                  <div class="x_title x_title-for-user">
                    <h2 class="text-primary">ข้อมูลบุคลากร<small>..</small> <span class="red-head" style="font-size: 12px;">หากข้อมูลไม่ถูกต้องโปรดติดต่อเจ้าหน้าที่</span></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-2 col-sm-2 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                           
                            <img class="img-responsive avatar-view image-border-radius" src="<?php echo checkPicture($_SESSION[__PICTURE_PROFILE__]);?>" alt="Avatar" title="Change the avatar">
                            <!-- border-radius: 10px; -->
                        </div>
                      </div>
                      <h4 class="head-text-user">คุณ<?php echo $result['per_name']." ".$result['per_surname'];?></h4>

                      <ul class="list-unstyled user_data head-text-user">
                        <!-- <li><i class="glyphicon glyphicon-credit-card"></i> <?php echo $result['per_cardno']?>
                        </li> -->

                      <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a> -->
                      <br />

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <!-- detail -->
                          <div class="col-md-6 col-sm-6 col-xs-12" >
                              <table class="table">
                              <thead>
                                <tr>
                                  
                                  <th><span class="text-info">ข้อมูลบุคลากร...</span></th>
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
                                  <td><span class="text-primary">เลขที่บัตรประชาชน </span><span class="text-success"><?php echo $result['per_cardno'];?></span></td>  
                                </tr>
                                <!-- <tr>
                                  <td><span class="text-primary">เลขที่ประจำตัวข้าราชการ  </span><span class="text-success"><?php echo "ไม่มี"; ?></span></td>  
                                </tr> -->
                                <tr>
                                  <td><span class="text-primary">วันเดือนปีเกิด  </span><span class="text-success"><?php echo $newDate->fullDateEngToThai($result['per_birthdate']);?></span></td>  
                                </tr>

                                <tr>
                                  <td><span class="text-primary">วันที่เข้ารับราชการ  </span><span class="text-success"><?php echo $newDate->fullDateEngToThai($result['per_startdate']);?></span></td>  
                                </tr>
                                <tr>
                                  <td><span class="text-primary">วันที่เกษียณราชการ  </span><span class="text-success"><?php echo $newDate->fullDateEngToThai($result['per_retiredate']);?></span></td>  
                                </tr>
                                <!-- <tr>
                                  <td><span class="text-primary">โทรศัพท์มือถือ  </span><span class="text-success"><?php echo $result['per_mobile'];?></span></td>  
                                </tr>
                                <tr>
                                  <td><span class="text-primary">อีเมลล์  </span><span class="text-success"><?php echo $result['per_email'];?></span> </td>  
                                </tr> -->
                              </tbody>
                            </table>
                          </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                            <table class="table">
                            <thead>
                            <tr>
                                    <th><span class="text-info">ข้อมูลตำแหน่ง</span></th>
                            </tr>
                              
                                <?php echo ($result['through_trial'] == 2 ? '<tr> <th><span class="text-primary">สถานะ </span><b class="text-danger" >อยู่ในช่วงทดลองงาน</b></th></tr>' : '' ); ?> 
                                
                            </thead>
                            <tbody>
                            <tr>
                                <td><span class="text-primary">ระดับตำแหน่ง </span><span class="text-success"><?php echo $result['level_name'];?></span></td>  
                              </tr>
                            <tr>
                                <td><span class="text-primary">เลขที่ตำแหน่ง </span><span class="text-success"><?php echo $result['pos_no'];?></span></td>
                              </tr>
                              <!-- <tr>
                                <td><span class="text-primary">เงินประจำตำแหน่ง </span><span class="text-success"><?php echo $result['per_mgtsalary'];?></span></td>
                              </tr>
                              <tr>
                                <td><span class="text-primary">เงินพิเศษ </span><span class="text-success"><?php echo $result['per_spsalary'];?></span></td>
                              </tr> -->
                              <tr>
                                <td><span class="text-primary">ตำแหน่งสายงาน </span><span class="text-success"><?php echo $result['pl_name'];?></span></td>  
                              </tr>
                              <tr>
                                <td><span class="text-primary">ตำแหน่งการบริหาร </span><span class="text-success"><?php echo $result['pm_name'];?></span></td>  
                              </tr>
                              <!-- <tr>
                                <td><span class="text-primary">ช่วงระดับตำแหน่ง </span><span class="text-success"></span></td>  
                              </tr>
                              <tr>
                                <td><span class="text-primary">ประเภทตำแหน่ง  </span><span class="text-success"><?php echo $result['pt_name'];?></span></td>  
                              </tr> -->
                              <tr>
                                <td><span class="text-primary">สำนัก/กอง  </span><span class="text-success"><?php echo $result['org_name'];?></span></td>  
                              </tr>

                              <tr>
                                <td><span class="text-primary">ต่ำกว่าสำนัก/กอง 1 ระดับ  </span><span class="text-success"><?php echo (!empty($result['org_name1'])?$result['org_name1']:"") ;?></span></td>  
                              </tr>
                              <tr>
                                <td><span class="text-primary">ต่ำกว่าสำนัก/กอง 2 ระดับ </span><span class="text-success"><?php echo (!empty($result['org_name1'])?$result['org_name2']:"") ;?></span> </td>  
                              </tr>
                              
                            </tbody>
                          </table>
                        </div>
                      <!-- end detail -->
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <?php 
                              if ($result['head_per_name'] != "") {
                                echo '<h4 class="text text-info"><span class="text text-primary">ผู้บังคับบัญชา :</span><span class="text text-success"> '.$result['head_pn_name'].$result['head_per_name']." ".$result['head_per_surname'].'</span> </h4>';
                              }
                            ?>
                            <button type="button" class="btn btn-info btn-sm fa fa-edit" id="btn-change-head"> กำหนดผู้บังคับบัญชา</button>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          
                        </div>    
                      </div>   
                    </div>
                  </div>
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

<!-- Modal  change head for user -->
<div class="modal fade" id="modal-change-head" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title text-info" id="myModalLabel">กำหนดผู้บังคับบัญชา</h4>
          </div>
          <div class="modal-body" id="modal-body-change-head">
          <p class="text text-danger">หมายเหตุ: ต้องค้นหาด้วยชื่อ-นามสกุลให้ถูกต้องหรือให้ Admin สำนัก/กอง ที่สังกัดเป็นคนกำหนด</p>
            <form class="form-horizontal form-label-left input_mask">
              <input type="hidden" name="per_cardno" id="change-head-per_cardno" value="<?php echo $_SESSION[__USER_ID__];?>">
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control has-feedback-left"  id="fname" name="fname" placeholder="ชื่อ">
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="นามสกุล">
                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-10">
                      <button type="button" class="btn btn-success" id="btn-head-search">ค้นหา</button>
                    </div>
                  </div>
            </form>
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12" >
                <table class="table table-hover">
                  <tbody id="head-list">
                   
                  </tbody>
                </table>
              </div>

            </div>
           
          </div>
          <div class="modal-footer">
          </div>
      </div>
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

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.min.js"></script>
  </body>
</html>

<script>
   $("#btn-change-head").on("click",function(e){

     $("#modal-change-head").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })

   })

   $("#btn-head-search").on("click",function(e){
     var fname = $("#fname").val();
     var lname = $("#lname").val();
     var per_cardno_user = $("#change-head-per_cardno").val();
    e.preventDefault()
      $.ajax({
        url:"module/module_person/ajax-modal-change_head_for_user-search.php",
        dataType: "json",
        type: "POST",
        data: {"fname":fname,"lname":lname,"per_cardno_user":per_cardno_user},
        success:function(result){
          $("#message").html("")
          $("#head-list").html("")
          if (result.success === true) {
            $.each(result['text'],function(key,value){
              $("#head-list").append(result['text']);
            });
          }else if (result.success === false) {
            $("#head-list").html("<p class='text text-danger'> ไม่พบรายชื่อ </p>")
          }
          
        },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
      });
   })

   function select_head(per_cardno_head) {
    var per_cardno_user = '<?php echo $result['per_cardno'];?>';
    $.ajax({
      type: "POST",
      url: "module/module_person/ajax-modal-change_head_for_user-change.php",
      data: {"per_cardno_user":per_cardno_user,"per_cardno_head":per_cardno_head},
      dataType: "JSON",
      success: function (response) {
        if (response.success === true) {
            $("#modal-change-head").modal("hide")
            window.setTimeout(function(){location.reload()},1000)
        }
      }
    });
   }

</script>