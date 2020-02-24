<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))) ){ 
  header("location:disallow.php");
}else {
    if ($_SESSION[__ADMIN_ORG_ID_2__] != "") {
        $orgSelect = $_SESSION[__ADMIN_ORG_ID_2__];
    }elseif ($_SESSION[__ADMIN_ORG_ID_1__] != "") {
        $orgSelect = $_SESSION[__ADMIN_ORG_ID_1__];
    }elseif ($_SESSION[__ADMIN_ORG_ID__] != "") {
        $orgSelect = $_SESSION[__ADMIN_ORG_ID__];
    }
    // else {
    //     $orgSelect = 77;
    // }

    if ($_SESSION[__GROUP_ID__] == 4) {
        $s = "<option value='6'>ผู้ดูแล ระดับ สำนัก/กอง (Sub Admin)</option>
            <option value='4'>ผู้ดูแลสูงสุด(Super Admin)</option>
            <option value='5'>ผู้ดูแลระบบ (Admin)</option>
            
            ";
            // <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>
    }elseif ($_SESSION[__GROUP_ID__] == 5) {
        $s = "<option value='6'>ผู้ดูแล ระดับ สำนัก/กอง (Sub Admin)</option>
           ";
          //  <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>
        
    }elseif ($_SESSION[__GROUP_ID__] == 6) {
        $s = "
            <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>";          
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
    <!-- <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href="../vendors/fontawesome-5.6.3-web/css/all.css" rel="stylesheet">

    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

  <!-- Bootstrap Checkboxes/Radios -->
  <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

    

    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

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
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <div class="row">
                    <button type="button" class="btn btn-info btn-sm" id="btn-modal-show-user"><i class=" fa fa-user"></i> เพิ่มผู้ดูแลระบบ</button>
                    <hr>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th class="text-center col-md-2 col-sm-2 col-xs-2">Username</th>
                            <th class="text-center col-md-3 col-sm-3 col-xs-3">ชื่อ - สกุล</th>
                            <th class="text-center col-md-4 col-sm-4 col-xs-4">สำนัก-กอง <span class="text text-danger">(ที่รับผิดชอบ)</span></th>
                            <th class="text-center col-md-3 col-sm-3 col-xs-3">#</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- footer content -->
        <?php
          include_once('template/footer-content.php');
        ?>
        <!-- /footer content -->
      </div>
    </div>

     <!-- Modal  user -->
 <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังเพิ่มผู้ดูแลระบบ</h4>
        </div>
        <div class="modal-body" id="modal-body-user">
             <form id="user-admin-form" data-parsley-validate="" class="form-horizontal form-label-left" name="form_user_admin">
                <div class="form-group">
                    <input type="hidden" name="head_admin" value="<?php echo $_SESSION[__USER_ID__];?>">
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="username_new">ชื่อสำหรับ LOGIN <small class="required text text-danger">* (ภาษาอังกฤษ เท่านั้น) </small>   
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="text" id="username_new" name="username_new"  class="form-control col-md-7 col-xs-12" data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="email">Email :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="text" id="email_new" type="email" name="email_new"  class="form-control col-md-7 col-xs-12"  data-parsley-trigger="change" data-parsley-type="email" data-parsley-type-message="ต้องเป็นอีเมลล์เท่านั้น" data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
                

                <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="password">รหัสผ่าน <small class="required text text-danger"> (ใช้ภาษาอังกฤษ และ เลข 0-9 เท่านั้น)  *</small> 
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="password" id="password" name="password"  class="form-control col-md-7 col-xs-12" data-parsley-required-message="กรุณากรอกรหัสผ่าน และยืนยันรหัสผ่าน" data-parsley-minlength="4" data-parsley-minlength-message="รหัส 4 ตัว ขึ้นไป" required>
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="password-confirm" >ยืนยันรหัสผ่าน  :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="password" id="password-confirm" name="password_confirm"  class="form-control col-md-7 col-xs-12" data-parsley-equalto="#password" data-parsley-required-message="กรุณายืนยันรหัสผ่าน" data-parsley-equalto-message="รหัสผ่านสองช่องไม่ตรงกัน" data-parsley-trigger="change" required>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ชื่อสกุล :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="first_name" class="form-control col-md-7 col-xs-12"  data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">นามสกุล :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="last-name" name="last_name"  class="form-control col-md-7 col-xs-12" data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">เบอร์โทร :
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="phone" name="phone"  class="form-control col-md-4 col-sm-4 col-xs-12"  >
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone-org">เบอร์ภายใน :
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="phone-org" name="phone_org"  class="form-control col-md-4 col-sm-4 col-xs-12" > 
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <small class="text text-warning">เช่น 2611</small>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id">สำนัก/กอง /ต่ำกว่าสำนัก 1 ระดับ :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id" id="org_id" class="form-control" data-parsley-required-message="กรุณาเลือกสังกัดที่ท่านดูแล" required>
                        <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                    </select>  
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <small class="text text-warning">สังกัดที่ต้องการดูแล</small>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id_1">ต่ำกว่าสำนัก 1 ระดับ หรือ 2 ระดับ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id_1" id="org_id_1" class="form-control">
                        <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                    </select> 
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id_2">ต่ำกว่าสำนัก 2 ระดับ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id_2" id="org_id_2" class="form-control">
                        <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                    </select>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_group">ระดับผู้ดูแลระบบ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" id="user_group" name="user_group"  data-parsley-required-message="กรุณาเลือกระดับผู้ใช้งาน" required>
                            <option value="" disabled="" selected="" hidden="">เลือก กลุ่มผู้ใช้งาน</option>
                            <?php echo $s;?>
                        </select>
                </div>
                </div>
               
                
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-warning" type="reset" id="btn-reset">ล้าง</button>
                    <button type="summit" class="btn btn-success" id="btn-summit">บันทึก</button>
                </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>

     <!-- Modal  user edit -->
  <div class="modal fade" id="modal-user-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="user-edit">คุณกำลังแก้ไขผู้ดูแลระบบ</h4>
        </div>
        <div class="modal-body" id="modal-body-user-edit">
             <form id="user_admin_form_edit" data-parsley-validate="" class="form-horizontal form-label-left" name="user_admin_form_edit">
                <div class="form-group">
                    <input type="hidden" name="id" id="id-member" >
                    <input type="hidden" name="head_admin_edit" id="head_admin_edit" value="<?php echo $_SESSION[__USER_ID__];?>">
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="username_edit">ชื่อสำหรับ LOGIN <small class="required text text-danger">* (ภาษาอังกฤษ เท่านั้น) </small>   
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="text" id="username_edit" name="username_edit"   class="form-control col-md-7 col-xs-12" data-parsley-required-message="กรุณากรอกข้อมูล" required disabled>
                </div>
                <label class="control-label col-md-2 col-sm-2 col-xs-12" for="email_edit">Email :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="text" id="email_edit" type="email" name="email_edit"  class="form-control col-md-7 col-xs-12"  data-parsley-trigger="change" data-parsley-type="email" data-parsley-type-message="ต้องเป็นอีเมลล์เท่านั้น" data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
              

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name_edit">ชื่อสกุล :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first_name_edit" name="first_name_edit" class="form-control col-md-7 col-xs-12"  data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name_edit">นามสกุล :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="last_name_edit" name="last_name_edit"  class="form-control col-md-7 col-xs-12" data-parsley-required-message="กรุณากรอกข้อมูล" required>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_edit">เบอร์โทร :
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="phone_edit" name="phone_edit"  class="form-control col-md-4 col-sm-4 col-xs-12"  >
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_org_edit">เบอร์ภายใน :
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="phone_org_edit" name="phone_org_edit"  class="form-control col-md-4 col-sm-4 col-xs-12" > 
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <small class="text text-warning">เช่น 2611</small>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id_edit">สำนัก/กอง /ต่ำกว่าสำนัก 1 ระดับ :  <span class="required text text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id_edit" id="org_id_edit" class="form-control">
                      <option value=""  selected="" >..</option>
                    </select>  
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <small class="text text-warning">สังกัดที่ต้องการดูแล</small>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id_1_edit">ต่ำกว่าสำนัก 1 ระดับ หรือ 2 ระดับ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id_1_edit" id="org_id_1_edit" class="form-control">
                    <option value=""  selected="" hidden="">..</option>
                    </select> 
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="org_id_2_edit">ต่ำกว่าสำนัก 2 ระดับ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="org_id_2_edit" id="org_id_2_edit" class="form-control">
                    <option value=""  selected="" hidden="">..</option>
                    </select>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_group_edit">สังกัด :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                        <ul id="ul-org_id-edit">
                          
                        </ul>
                </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_group_edit">ระดับผู้ดูแลระบบ :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" id="user_group_edit" name="user_group_edit"  data-parsley-required-message="กรุณาเลือกระดับผู้ใช้งาน" required>
                            <option value="" disabled="" selected="" hidden="">เลือก กลุ่มผู้ใช้งาน</option>
                            <?php echo $s;?>
                        </select>
                </div>
                </div>
                  <br>
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-warning" type="reset" id="btn-reset-edit">ล้าง</button>
                    <button type="summit" class="btn btn-success" id="btn-summit-edit">บันทึก</button>
                </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>

<!-- change password -->

<div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="user-edit">คุณกำลังแก้ไขรหัสผ่านผู้ดูแลระบบ</h4>
        </div>
        <div class="modal-body" id="modal-body-change-password">
          <form class="form-horizontal form-label-left" data-parsley-validate="" id="form-change-password" name="form_change_password">
            <input type="hidden" name="id_user_change_password" id="id-user-change_password">
            <div class="form-group">
              <label class="text text-info">รหัสผ่านใหม่</label>
              <input type="password" class="form-control" placeholder="Password" id="new-password" name="new_password" data-parsley-required-message="กรุณากรอกรหัสผ่าน และยืนยันรหัสผ่าน" data-parsley-minlength="4" data-parsley-minlength-message="รหัส 4 ตัว ขึ้นไป" required>
            </div>
            <div class="form-group">
              <label class="text text-info"><span class="text text-warning" >ยืนยัน</span>  รหัสผ่านใหม่</label>
              <input type="password" class="form-control" placeholder="Password" id="confirm-new-password" name="confirm_new_password" data-parsley-equalto="#new-password" data-parsley-required-message="กรุณายืนยันรหัสผ่าน" data-parsley-equalto-message="รหัสผ่านสองช่องไม่ตรงกัน" data-parsley-trigger="change" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="summit" class="btn btn-success">บันทึก</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </form>
        </div>
    </div>
</div>



    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

     <!-- fontawesome-5.6.3-web -->
     <script src="../vendors/fontawesome-5.6.3-web/js/all.js"></script>

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
   
   
    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>
 <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

      <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>


    <script src="../vendors/parsleyjs/dist/parsley.js"></script>
    <script src="module/module_person/org_code.js"></script>

     <!-- Await -->
     <script src="../assets/js/await.js"></script>


    <script> 
    $('#user-admin-form').parsley();

    $("#btn-reset").on("click", function () {
        $("#user-admin-form").parsley().reset();
    });

 
    $("#user-admin-form").submit(function (e) { 
        e.preventDefault();
        if($(this).parsley().isValid()){
            console.log("isValid")
            $.ajax({
                type: "POST",
                url: "module/module_user/ajax-add-user.php",
                data: $("#user-admin-form").serialize(),
                dataType: "JSON",
                success: function (response) {
                    if (response.success == true) {
                        $("#user-admin-form").parsley().reset();
                        $("#modal-user").modal("hide");
                        notify('การเพิ่มผู้ใช้งาน','สำเร็จ','success')
                        $("#user-admin-form")[0].reset();
                        load_user();
                    }else if(response.success == null){
                        notify('การเพิ่มผู้ใช้งาน','เกิดข้อผิดพลาด'+response.msg,'danger')
                    }
                    
                }
            });
        }else{
            console.log("not isValid") 
        }
    });

    $("#user_admin_form_edit").submit(function (e) { 
        e.preventDefault();
        if($(this).parsley().isValid()){
            console.log("isValid")
            $.ajax({
                type: "POST",
                url: "module/module_user/ajax-update-user.php",
                data: $("#user_admin_form_edit").serialize(),
                dataType: "JSON",
                success: function (response) {
                    if (response.success == true) {
                        $("#user_admin_form_edit").parsley().reset();
                        $("#modal-user-edit").modal("hide");
                        notify('การแก้ไขผู้ใช้งาน','สำเร็จ','success')
                        $("#user_admin_form_edit")[0].reset();
                        load_user();
                    }else if(response.success == null){
                        notify('การแก้ไขผู้ใช้งาน','เกิดข้อผิดพลาด'+response.msg,'danger')
                    }
                    
                }
            });
        }else{
            console.log("not isValid") 
        }
    });

    $("#form-change-password").submit(function (e) { 
        e.preventDefault();
        if($(this).parsley().isValid()){
            console.log("isValid")
            $.ajax({
                type: "POST",
                url: "module/module_user/new-password.php",
                data: $("#form-change-password").serialize(),
                dataType: "JSON",
                success: function (response) {
                    if (response.success == true) {
                        $("#form-change-password").parsley().reset();
                        $("#modal-change-password").modal("hide");
                        notify('การเปลี่ยนรหัส','สำเร็จ','success')
                        $("#form-change-password")[0].reset();
                        load_user();
                    }else if (response.success == false){
                      notify('การเปลี่ยนรหัส','เกิดข้อผิดพลาด'+response.message,'danger')
                    }else if(response.success == null){
                        notify('การเปลี่ยนรหัส','เกิดข้อผิดพลาด'+response.message,'danger')
                    }
                }
            });
        }else{
            console.log("not isValid") 
        }
    });
    
$("#btn-modal-show-user").on("click", function () {
    $("#modal-user").modal({
    show:true,
    keyboard:false,
    backdrop:'static'
    });
});



function add_org(result,idOrg,rm,selectKey,disabledParam) {

  var loop = new Await;

  if (disabledParam == true ) {
    optionDisable = "disabled"
  }else{
    optionDisable = ""
  }

    if(rm == true){
        $(idOrg).children('option:not(:first)').remove();
    }
    if(result != ''){
      loop.each(result,function(key,value){
          $(idOrg).append("<option value="+value['org_id']+" "+optionDisable+ " >"+ value['org_name'] +"</option>");
          
      }); 
    }
    if (disabledParam == true ) {
          $(idOrg+" option[value="+selectKey+"]").prop("disabled",false)
          }

        // if(selectKey != ''){
        //   $(idOrg+" option[value="+selectKey+"]").prop("disabled",true)
        // }

    
}

var org_id_default = '<?php echo $orgSelect;?>';
if (org_id_default == 77) {
  $.ajax({
    url:"module/module_org/ajax-org-show.php",
    dataType:"json",
    data:{"org_id":org_id_default},
    type:"POST",
    success: function(result){
      add_org(result,'#org_id',false,'',false);
     
    }
  });
}else{
  $.ajax({
    url:"module/module_org/ajax-org-id.php",
    dataType:"json",
    data:{"org_id":org_id_default},
    type:"POST",
    success: function(result){
      add_org(result,'#org_id',false,org_id_default,false);
      load_org_1(org_id_default)
    }
  });
}

$("#org_id").on("change", function () {
  v = $("#org_id").val();
  load_org_1(v)
});

$("#org_id_1").on("change", function () {
  v = $("#org_id_1").val();
  load_org_2(v)
});

function load_org_1(v) {
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org(result,"#org_id_1",true);
      add_org('',"#org_id_2",true);
    }
  });
}

function load_org_2(v) {
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org(result,"#org_id_2",true);
    }
  });
}



var c = [ {"col_1":"","col_2":"","col_3":"","col_4":""} ];
  var t =  $('#datatable').DataTable({
              "data":c,
              "deferRender": true,
              "autoWidth": false,
              "columns": [
                        {"data":"col_1"},
                        {"data":"col_2"},
                        {"data":"col_3"},
                        {"data":"col_4"}
                      ],
              "columnDefs": [
                {
                  "targets": [0],
                  "searchable": true
                },
                {
                  "targets": [1],
                  "searchable": true
                },
                {
                  "targets": [2],
                  "searchable": true
                },
                {
                  "targets": [3],
                  "searchable": false
                }
              ],
              'pageLength': 10,
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });




function notify(nTitle,nText,nType,timeOut,nHide) {
  var h = (nHide != '' ? true : nHide);
  var t = (timeOut != '' ? 2000 : timeOut);
    // console.log(h
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

function load_user() {
    $.ajax({
        type: "POST",
        url: "module/module_user/ajax-show-user2.php",
        dataType: "JSON",
        success: function (response) {
            t.clear().rows.add(response.data).draw();
            $.getScript("module/module_user/user-function.js", function (script, textStatus, jqXHR) {                
            });
        }
    });
}



$(document).ready(function () {
    load_user()
});


// modal-user-edit

function user_edit(id_admin) {

$.ajax({
    type: "POST",
    url: "module/module_user/ajax-user-edit-show.php",
    data: {"id_admin":id_admin},
    dataType: "JSON",
    success: function (response) {
// console.log(response.result[0].id)
      
      $("#id-member").val(response.result[0].id)
      $("#username_edit").val(response.result[0].username)
      $("#email_edit").val(response.result[0].email)
      $("#first_name_edit").val(response.result[0].fname)
      $("#last_name_edit").val(response.result[0].lname)
      $("#phone_edit").val(response.result[0].phone)
      $("#phone_org_edit").val(response.result[0].phone_org)
      $("#user_group_edit option[value="+response.result[0].group_id+"]").prop("selected",true)

      org_edit_select(response.result[0].group_org_id)
      // console.log(response.result[0].group_org_id)
      org_edit_show(response.result[0].org_name,response.result[0].org_name_1,response.result[0].org_name_2)
      // console.log(response.result[0].org_id)
      // org_user_edit_show(response.result[0].org_id,"#org_id_edit")
      $("#user_admin_form_edit").parsley().reset();
      $("#modal-user-edit").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
        });
    }

  });

}

// เขียน user-edit แบบเดียวกับ user-add

function org_edit_show(org_name,org_name_1,org_name_2) {
      // console.log(result)
      $("#ul-org_id-edit").html("");
      // if (org_name != null) {
        $("#ul-org_id-edit").append(" <li> <i class='fa fa-chevron-circle-right'></i> "+org_name+" <ul id='ul-org_id_1-edit'> <li> <i class='fa fa-chevron-circle-right'></i> "+org_name_1+" <ul id='ul-org_id_2-edit'> <li> <i class='fa fa-chevron-circle-right'></i> "+org_name_2+"  </li> </ul> </li> </ul> </li>");
      // }
      // if (org_name_1 != null) {
      //   $("#ul-org_id_1-edit").append(" ");
      // }
      // if (org_name_2 != null) {
      //   $("#ul-org_id_2-edit").append(" ");
      // }
     

}


// llllllllllllllllllllllllll

function org_edit_select(org_id) {
  var typeGroup = '<?php echo $_SESSION[__GROUP_ID__] ;?> '

if (typeGroup == 4 || typeGroup == 5 ) {
    org_id = 77 ;
// console.log("test")
  $.ajax({
    url:"module/module_org/ajax-org-show.php",
    dataType:"json",
    data:{"org_id":org_id},
    type:"POST",
    success: function(result){
      add_org(result,"#org_id_edit",true,'',false);
     
    }
  });

}else{
  $.ajax({
    url:"module/module_org/ajax-org-ref.php",
    dataType:"json",
    type:"POST",
    data:{"org_id":org_id},
    async: false,
    success: function(result){
      
        add_org(result,"#org_id_edit",true,org_id,true);
        add_org('',"#org_id_1_edit",true);
        add_org('',"#org_id_2_edit",true);

    }
  });
}
  

}

  $("#org_id_edit").change(function(){
  var v = $(this).val();
  var t0 = $("#org_id_edit option:selected").text()
  var t1 = $("#org_id_1_edit option:selected").text()
  var t2 = $("#org_id_2_edit option:selected").text()
// console.log(v)
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
        add_org(result,"#org_id_1_edit",true);
        add_org('',"#org_id_2_edit",true);
        org_edit_show(t0,t1,t2)
    }
  });
});


$("#org_id_1_edit").change(function(){
  var v = $(this).val();
  var t0 = $("#org_id_edit option:selected").text()
  var t1 = $("#org_id_1_edit option:selected").text()
  var t2 = $("#org_id_2_edit option:selected").text()
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
        add_org(result,"#org_id_2_edit",true);
        org_edit_show(t0,t1,t2)
    }
  });
});

$("#org_id_2_edit").change(function(){
  var v = $(this).val();
  var t0 = $("#org_id_edit option:selected").text()
  var t1 = $("#org_id_1_edit option:selected").text()
  var t2 = $("#org_id_2_edit option:selected").text()
  org_edit_show(t0,t1,t2)
 
});


// change password
function change_password(id) {
  $("#id-user-change_password").val(id) ;

  $("#modal-change-password").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
  });
}

function status_user(id_user_change_status) {
  $.ajax({
    type: "POST",
    url: "module/module_user/ajax-change-status-user.php",
    data: {"id_user_change_status":id_user_change_status},
    dataType: "JSON",
    success: function (response) {
      if (response.success == true) {
          notify('การเปลี่ยนสถานผู้้ใช้งาน','สำเร็จ','success')
          load_user();
      }else if (response.success == false){
          notify('การเปลี่ยนสถานผู้้ใช้งาน','เกิดข้อผิดพลาด'+response.message,'danger')
      }else if(response.success == null){
          notify('การเปลี่ยนสถานผู้้ใช้งาน','เกิดข้อผิดพลาด'+response.message,'danger')
      }
    }
  });
}

    </script>
  </body>
</html>


       