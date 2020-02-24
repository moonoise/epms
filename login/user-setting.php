<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
ckeckLogin();    
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))) ){ 
  header("location:disallow.php");
}
?>
<?php 
  
  $db = new DbConn;
  $tbl_members = $db->tbl_members;

  $stmt = $db->conn->prepare("SELECT `members`.*,
                              `group_users`.*,
                              `member_groups`.*
                              FROM ".$tbl_members." LEFT JOIN `group_users`
                              ON `members`.`id` = `group_users`.`id` 
                              LEFT JOIN `member_groups`
                              ON `member_groups`.`group_id` = `group_users`.`group_id` WHERE username = :myusername");
  
  $stmt->bindParam(':myusername', $_SESSION[__USER_NAME__]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);


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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-4"></div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                  <img src="../external/images_profile/<?php echo $result['picture_profile'];?>" class="img-rounded" alt="Cinque Terre" id='picture--profile'>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4">
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-3 col-sm-3 col-xs-3"></div>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                  
                 <!-- <form  method="post" enctype="multipart/form-data"   data-parsley-validate="" id="PictureForm"> !> <!-action="ajax/ajax_changeFicture.php" data-parsley-validate="" id="PictureForm" -->
                    <!-- <label for="file">File: <small>ไฟล์ภาพ *.gif ,*.jpeg,*.png</small> 
                      <input type="file" name="file" id="file" required="" data-parsley-error-message="ท่านยังไม่ได้เลือกรูปภาพ"/> 
                    </label> -->
                   <!--   <input  value="upload" id="submitPicture" type="button" /> !> <!  id="submitPicture" type="button" -->
                  <!-- </form> -->

                  <form enctype="multipart/form-data" method="post"  data-parsley-validate="" id="PictureForm"> <!-- action="ajax/ajax_changeFicture.php" -->
                  <label for="file">File: <small>ไฟล์ภาพ *.gif ,*.jpeg,*.png</small> 
                    <input type="file" name="file" id="file" required="" data-parsley-error-message="ท่านยังไม่ได้เลือกรูปภาพ">
                    </label>
                    <input value="upload" id="submitPicture" type="button"/>
                  </form>

                  
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3"><div id="messagePic"></div></div>
                </div>
                <br/>
              <form id="editProfile" data-parsley-validate class="form-horizontal form-label-left">
             
              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">ชื่อในการ Login <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="username" name="username" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $result['username'];?>" disabled>
                  </div>
                </div>
                
               
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อ <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="fname" type="text" id="fname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $result['fname'];?>" data-parsley-error-message="กรุณากรอกชื่อ">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">นามสกุล <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="lname" name="lname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $result['lname']; ?>" data-parsley-error-message="กรุณากรอกนามสกุล">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" >ที่อยู่ <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="address" id="address" cols="10" rows="3" required="required" data-parsley-error-message="กรุณากรอกที่อยู่" ><?php echo $result['address'];?></textarea>
                    
                  </div>
                </div>
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">เพศ *:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                        ชาย:
                        <input type="radio" class="flat" name="sex" id="sex" value="male" <?php if($result['sex']=='male') { echo 'checked="checked"'; }?> required="" /> 
                        หญิง:
                        <input type="radio" class="flat" name="sex" id="sex" value="female" <?php if($result['sex']=='female') { echo 'checked="checked"';} ?>/>
                    </div>
                    </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">วันเดือนปีเกิด <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class='input-group date' id='myDatepicker2'>
                            <input name="birthday" id="birthday" type='text' class="form-control" value="<?php echo $result['birthday']; ?>"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                  </div>
                </div>
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" data-parsley-trigger="change"  class="form-control col-md-7 col-xs-12" value="<?php echo $result['email']?>" required="required" data-parsley-error-message="กรุณากรอกอีเมลล์">
                        </div>
                      </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo $signin_url;?>login/index.php'">Cancel</button>
        <button class="btn btn-primary" type="reset" >Reset</button>
                    <button  class="btn btn-success" id="submitProfile" type="button">Submit</button>
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
      <!-- Custom Theme Scripts -->
      <script src="../assets/js/custom.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    
    <script>
       $('#myDatepicker2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
 
    $("#submitProfile").on('click', function() {
    
        $('#editProfile').parsley().validate();
});

$("#submitPicture").on('click', function() {
    
        $('#PictureForm').parsley().validate();
});

    $(document).ready(function(){
      $("#submitProfile").click(function(){
       //alert('test');
       //console.log('test');
       //$("#message").html("<p>บันทึกเรียบร้อย</p>");
       var fname = $("#fname").val(),lname = $("#lname").val(),birthday = $("#birthday").val(),email = $("#email").val(),address = $("#address").val();
       var sex = $("input[name='sex']:checked").val();
        $.ajax({
            type: "POST",
            url: "ajax/ajax_updateprofile.php",
            data: "fname="+fname+"&lname="+lname+"&sex="+sex+"&birthday="+birthday+"&email="+email+"&address="+address,
            dataType:'JSON',
            success:function(result){
              if (result.success == 'true') {
                $("#message").html(result.msg);
                //console.log(result.success);
              }else {
                $("#message").html(result.msg);
                //console.log(result.success);
              }
             },
            beforeSend:function(){
              $("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>")
            }
          });
      });
   
      $("#submitPicture").click(function(){
        //console.log("test");
        // var fd = new FormData(ducument.getElementById("file"));
        var file_data = $("#file").prop("files")[0];   
        var fd = new FormData();
        fd.append("file", file_data);

        if($("#file").val() != ''){
          $.ajax({
          url:"ajax/ajax_changeFicture.php",
          type:"POST",
          data:fd,
          processData:false,
          contentType:false,
          dataType:"json",
          success:function(result){
            //console.log('test');
            if (result.success === 'true') {
               $("#messagePic").html("upload success");
              refreshPic();
               //console.log(result.success);
            } else {
              $("#messagePic").html("upload unsuccess!");
               //console.log(result.success);
              // console.log('test');
            }
            
          }
        });
        }
      });
    });

      function refreshPic() {
       // console.log('test');
        $.ajax({
          url:"ajax/ajax.refresh.picture.php",
          dataType:'json',
          success:function(result){
          //  console.log(result.url);
            //$("#picture--profile").removeAttr('src');​
            $("#picture--profile").prop("src",'../external/images_profile/'+result.url)
            $("#profile_img").prop("src",'../external/images_profile/'+result.url)
            $("#picture-top-navi").prop("src",'../external/images_profile/'+result.url)
            
           
            // $("#picture--profile").attr('src','../external/images_profile/'+result.url);
            // $("#profile_img").attr('src','../external/images_profile/'+result.url);
            
          }
        });
      }

  
    </script>
  </body>
</html>