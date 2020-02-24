<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";


if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4))) ){ 
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
            <div class="page-title">
                <div class="title_left">
                
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                        
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                        <h5>รายการตัวชี้วัด <small>..</small></h5>
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        </div> <!-- x_title -->
                        
                    <div class="x_content">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                      <button type="button" class="btn btn-success btn-sm fa fa-plus-square" id="btn-kpi_new"> เพิ่ม</button>
                      <table class="table table-bordered col-md-12 col-sm-12 col-xs-12" id="kpi-table">
                          <thead> 
                              <tr>
                                  <th class="text-center">รหัส</th>
                                  <th class="text-center">ตัวชี้วัด</th>
                                  <th class="text-center">ลักษณะงาน</th>
                                  <th class="text-center">ประเภท</th>
                                  <th class="text-center">สถานะ</th>
                                  <th class="text-center">##################</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                      </div>
                    
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


<!-- Modal  edit kpi type -->
<div class="modal fade" id="modal-kpi-update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">ตัวชี้วัด <span class="text-success">[ประเภทใส่คะแนน]</span></h4>
        </div>
        <div class="modal-body" id="modal-body-kpi-edit">
        <form  class="form-horizontal form-label-left" name="form-kpi-edit" id='form-kpi-edit'>
          <input type="hidden" name="type_form" value="update">
          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-info" for="kpi_code">รหัส <span class="required">*</span>
              </label>
              <div class="col-md-2 col-sm-4 col-xs-12">
                <input type="text" id="kpi_code"  class="form-control" name="kpi_code"  readonly>  
              </div>
              <div class="col-md-2 col-sm-4 col-xs-12">
              <input type="text" id="kpi_code_org"  class="form-control" name="kpi_code_org" > 
              </div>
              <span class="text text-danger">เช่น สบค01(61)</span>
          </div>
          <div class="form-group col-md-2 col-sm-0 col-xs-12">
          </div>
          <div class="form-group col-md-2 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info" for="kpi_type">ลักษณะงาน : </label>
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <select name="kpi_type" id="kpi_type" class="form-control">
                <option value="1">กลยุทธ์</option>
                <option value="2">ประจำ</option>
                <option value="3">พิเศษ</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info" for="kpi_type2">ประเภท : <span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <select name="kpi_type2" id="kpi_type2" class="form-control">
                <option value="3">ใส่คะแนน</option>
                <option value="2">เชิงร้อยละหรือผลสำเร็จ</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info kpi_type2_show" for="kpi_con2">แบบ :  <span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 kpi_type2_show">
              <select name="kpi_con2" id="kpi_con2" class="form-control kpi_type2_show">
                <option value="1">เชิงบวก</option>
                <option value="2">เชิงลบ</option>
              </select>
            </div>
          </div>
         
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="" class="control-label col-md-2 col-sm-2 col-xs-12" for=""></label>
            <div class="col-md-10 col-sm-10 col-xs-12">
              <textarea class="form-control" rows="3" placeholder="รายละเอียดตัวชี้วัด" id="kpi_title" name="kpi_title" required="" data-parsley-error-message="กรุณากรอกข้อมูล"></textarea>
            </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class=" col-md-8 col-sm-8 col-xs-12 text-info" for="kpi_level1">คำอธิบายระดับคะแนน <span class="required">*</span>
              </label>
              <label class=" col-md-4 col-sm-4 col-xs-12 text-info text-center " for="kpi_level1">&nbsp;<span class="kpi_type2_show required"> ค่าเป้าหมาย * </span>
              </label>
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level1">[ 1 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level1"  class="form-control" name="kpi_level1" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1">  >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank1"  class="form-control kpi_type2_show" name="kpi_rank1" data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12" >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level2">[ 2 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level2"  class="form-control" name="kpi_level2" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank2"  class="form-control kpi_type2_show" name="kpi_rank2"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level3">[ 3 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level3"  class="form-control" name="kpi_level3" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank3"  class="form-control kpi_type2_show" name="kpi_rank3"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level4">[ 4 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level4"  class="form-control" name="kpi_level4" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >=
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank4"  class="form-control kpi_type2_show" name="kpi_rank4"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level5">[ 5 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level5"  class="form-control" name="kpi_level5" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank5"  class="form-control kpi_type2_show" name="kpi_rank5"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>
            
        
    
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name='kpi-edit-submit' id='kpi-edit-submit'>บันทึก</button>
            </form>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-exit">ปิด</button>
            
        </div>

        </div>
    </div>
</div>

<!-- Modal  new kpi type -->
<div class="modal fade" id="modal-kpi-new" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">ตัวชี้วัด <span class="text-success">[ประเภทใส่คะแนน]</span></h4>
        </div>
        <div class="modal-body" id="modal-body-kpi-new">
        <form  class="form-horizontal form-label-left" name="form-kpi-new" id='form-kpi-new'>
          <input type="hidden" name="type_form" value="new">
          <input type="hidden" name="check_code" id="check_code" value="" required="">
          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-info" for="kpi_code_new">รหัส <span class="required">*</span>
              </label>
              <div class="col-md-2 col-sm-4 col-xs-12">
                <input type="text" id="kpi_code_new"  class="form-control" name="kpi_code_new"  readonly>  
              </div>
              <div class="col-md-2 col-sm-4 col-xs-12">
              <input type="text" id="kpi_code_org_new"  class="form-control" 
                name="kpi_code_org" required="" data-parsley-error-message="กรุณากรอกข้อมูล ห้ามมีช่องว่าง" 
                data-parsley-pattern="/^\S*$/" > 
              </div>
              <div class="col-md-3 col-sm-4 col-xs-12">
                <span class="text text-danger" id="massage-check_kpi_code">เช่น สบค01(61)</span>
              </div>
              
          </div>
          <div class="form-group col-md-2 col-sm-0 col-xs-12">
          </div>
          <div class="form-group col-md-2 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info" for="kpi_type">ลักษณะงาน : </label>
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <select name="kpi_type" id="kpi_type_new" class="form-control">
                <option value="1">กลยุทธ์</option>
                <option value="2">ประจำ</option>
                <option value="3">พิเศษ</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info" for="kpi_type2">ประเภท : <span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 ">
              <select name="kpi_type2" id="kpi_type2_new" class="form-control">
                <option value="2">เชิงร้อยละหรือผลสำเร็จ</option>
                <option value="3">ใส่คะแนน</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-4 col-sm-4 col-xs-12">
            <label for="" class="control-label col-md-12 col-sm-12 col-xs-12 text-info kpi_type2_show" for="kpi_con2">แบบ :  <span class="required">*</span></label>
            <div class="col-md-12 col-sm-12 col-xs-12 kpi_type2_show">
              <select name="kpi_con2" id="kpi_con2_new" class="form-control kpi_type2_show">
                <option value="1">เชิงบวก</option>
                <option value="2">เชิงลบ</option>
              </select>
            </div>
          </div>
         
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="" class="control-label col-md-2 col-sm-2 col-xs-12" for=""></label>
            <div class="col-md-10 col-sm-10 col-xs-12">
              <textarea class="form-control" rows="3" placeholder="รายละเอียดตัวชี้วัด" id="kpi_title_new" name="kpi_title" required="" data-parsley-error-message="กรุณากรอกข้อมูล"></textarea>
            </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class=" col-md-8 col-sm-8 col-xs-12 text-info" for="kpi_level1">คำอธิบายระดับคะแนน <span class="required">*</span>
              </label>
              <label class=" col-md-4 col-sm-4 col-xs-12 text-info text-center " for="kpi_level1">&nbsp;<span class="kpi_type2_show required"> ค่าเป้าหมาย * </span>
              </label>
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level1">[ 1 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level1_new"  class="form-control" name="kpi_level1" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1">  >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank1_new"  class="form-control kpi_type2_show" name="kpi_rank1" data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12" >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level2">[ 2 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level2_new"  class="form-control" name="kpi_level2" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank2_new"  class="form-control kpi_type2_show" name="kpi_rank2"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level3">[ 3 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level3_new"  class="form-control" name="kpi_level3" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank3_new"  class="form-control kpi_type2_show" name="kpi_rank3"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12"  >
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level4">[ 4 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level4_new"  class="form-control" name="kpi_level4" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >=
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank4_new"  class="form-control kpi_type2_show" name="kpi_rank4"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>

          <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label class="control-label col-md-2 col-sm-2 col-xs-12 text-danger" for="kpi_level5">[ 5 ]
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="kpi_level5_new"  class="form-control" name="kpi_level5" required="" data-parsley-error-message="กรุณากรอกข้อมูล">  
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger kpi_type2_show" for="kpi_level1"> >= 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 kpi_type2_show">
                  <input type="text" id="kpi_rank5_new"  class="form-control kpi_type2_show" name="kpi_rank5"  data-parsley-error-message="ใส่ตัวเลข 0-100" data-parsley-type="number"> 
                </div>
              </div>
          </div>
            
        
    
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name='kpi-new-submit' id='kpi-new-submit'>บันทึก</button>
            </form>
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="modal-exit-new">ปิด</button>
            
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
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

    <!-- <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script> -->

    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>

    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>

    <script>
      var kpiConfrim = function () {
        $(".confirm-change-kpi_status").popConfirm({
        title: "เปลี่ยนสถานะ KPI", // The title of the confirm
        content: "คุณต้องการเปลี่ยนสถานะ KPI นี้จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
        });
      };
      refresh_datatable()
    var c = [ {"kpi_code_org":"","kpi_title":"","kpi_type":"","kpi_type2":"","kpi_status":"","edit":""} ];
    var t =  $('#kpi-table').DataTable({
              drawCallback: kpiConfrim,
              "data":c,
              "deferRender": true,
              "autoWidth": false,
              "columns": [
                        {"data":"kpi_code_org"},
                        {"data":"kpi_title"},
                        {"data":"kpi_type"},
                        {"data":"kpi_type2"},
                        {"data":"kpi_status"},
                        {"data":"edit"}
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
                },
                {
                  "targets":[4],
                  "searchable":false
                }
              ],
              'pageLength': 10,
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
function refresh_datatable() {
  $.ajax({
       type: "POST",
       url: "module/kpi_manager/ajax-kpi_manager-show_all.php",
       dataType: "JSON",
       success: function (response) {
        t.clear().rows.add(response.result).draw();
       }
     });
}

     function kpi_edit(kpi_code,kpi_type2) {
      var kpi
          $.ajax({
          type: "POST",
          url: "module/kpi_manager/ajax-kpi_manager-show_id.php",
          data: {"kpi_code":kpi_code},
          dataType: "JSON",
          success: function (response) {
              $("#modal-kpi-update").modal({
                show:true,
                keyboard:false,
                backdrop:'static'
              });
              // console.log(response.result[0])
           
            $("#kpi_code").val(response.result[0]['kpi_code']);
            $("#kpi_code_org").val(response.result[0]['kpi_code_org']).prop('readonly',true);
            $("#kpi_type").val(response.result[0]['kpi_type']);
            $("#kpi_type2").val(response.result[0]['kpi_type2']); //ประเภท
            if (response.result[0]['kpi_type2'] == 2) {
              kpi_type2_show()
            } else if(response.result[0]['kpi_type2'] == 3) {
              kpi_type2_hide()
            } 
            $("#kpi_con2").val(response.result[0]['kpi_con2']);
            $("#kpi_rank1").val(response.result[0]['kpi_rank1']);
            $("#kpi_rank2").val(response.result[0]['kpi_rank2']);
            $("#kpi_rank3").val(response.result[0]['kpi_rank3']);
            $("#kpi_rank4").val(response.result[0]['kpi_rank4']);
            $("#kpi_rank5").val(response.result[0]['kpi_rank5']);

            $("#kpi_title").val(response.result[0]['kpi_title']);
            $("#kpi_level1").val(response.result[0]['kpi_level1']);
            $("#kpi_level2").val(response.result[0]['kpi_level2']);
            $("#kpi_level3").val(response.result[0]['kpi_level3']);
            $("#kpi_level4").val(response.result[0]['kpi_level4']);
            $("#kpi_level5").val(response.result[0]['kpi_level5']);
            // $('#inputId').prop('readonly', true);
            
            }
          });
     }
     
     $("#kpi_type2").on("change",function () {
      if ($("#kpi_type2").val() == 2) {
        kpi_type2_show();
      }else if($("#kpi_type2").val() == 3){
        kpi_type2_hide();
      }
     });

     function kpi_type2_show(){
        $(".kpi_type2_show").show();
        $(".kpi_type2_show").show();
        $(".kpi_type2_show").show();
        $(".kpi_type2_show").show();
        $(".kpi_type2_show").show();
        $(".kpi_type2_show").show();
     }
     
     function kpi_type2_hide() {
        $(".kpi_type2_show").hide();
        $(".kpi_type2_show").hide();
        $(".kpi_type2_show").hide();
        $(".kpi_type2_show").hide();
        $(".kpi_type2_show").hide();
        $(".kpi_type2_show").hide();
     }

  
        

      $("#form-kpi-edit").submit(function (e) {  
      if ($("#kpi_type2").val() == 2) {
      // var c = $("#kpi_rank1").parsley('validate');
      $("#kpi_rank1").attr('required','required').parsley();
      $("#kpi_rank2").attr('required','required').parsley();
      $("#kpi_rank3").attr('required','required').parsley();
      $("#kpi_rank4").attr('required','required').parsley();
      $("#kpi_rank5").attr('required','required').parsley();
      // console.log("test")

      }else{
        $("#kpi_rank1").removeAttr('required').parsley();
        $("#kpi_rank2").removeAttr('required').parsley();
        $("#kpi_rank3").removeAttr('required').parsley();
        $("#kpi_rank4").removeAttr('required').parsley();
        $("#kpi_rank5").removeAttr('required').parsley();
      }
      e.preventDefault();
      if ($(this).parsley().isValid() ) {
        $.ajax({
          type: "POST",
          url: "module/kpi_manager/ajax-kpi_manager-update.php",
          data: $("#form-kpi-edit").serialize(),
          dataType: "JSON",
          success: function (response) {
            if (response.success === true) {
                $("#form-kpi-edit").parsley().reset();
                $("#form-kpi-edit")[0].reset();
                refresh_datatable()
                notify('การบันทึก','สำเร็จ','success')
                $("#modal-kpi-update").modal("hide");
              }else if(response.success === null){
                notify('การบันทึก','ไม่สำเร็จ โปรดตรวจสอบข้อมูลที่กรอก'+response.msg,'warning')
              }
            
          }
        });
      }
      });
    

     $("#form-kpi-edit").parsley();

     $("#modal-exit").on("click",function () {
      $("#form-kpi-edit").parsley().reset();
     });


     // ------ new ------ //

     $("#form-kpi-new").parsley();

    $("#modal-exit-new").on("click",function () {
    $("#form-kpi-new").parsley().reset();
    });

     $("#btn-kpi_new").on("click",function () {
      kpi_type2_change()
      $("#modal-kpi-new").modal({
          show:true,
          keyboard:false,
          backdrop:'static'
        });
     });

  $("#kpi_code_org_new").keyup(function (e) { 
    $("#kpi_code_new").val($("#kpi_code_org_new").val());
  });

  $("#kpi_code_org_new").focusout(function (e) { 
    if ($("#kpi_code_org_new").val() != "") {
      $.ajax({
      type: "POST",
      url: "module/kpi_manager/ajax_check_kpi_code.php",
      data: {"kpi_code_new":$("#kpi_code_new").val()},
      dataType: "JSON",
      success: function (response) {

        if (response.result == true) {
          $("#check_code").val("true");
          $("#kpi_code_org_new").css("border","1px solid #ccc");
          $("#massage-check_kpi_code").removeClass("fa-remove red")
          $("#massage-check_kpi_code").css("color","#26B99A").addClass("fa fa-check green").html("รหัสไม่ซ้ำ สามารถใช้ได้")
        }else if(response.result == false){
          $("#check_code").val("");
          $("#kpi_code_org_new").css("border","1px solid red");
          $("#massage-check_kpi_code").removeClass("fa-check green")
          $("#massage-check_kpi_code").css("color","red").addClass("fa fa-remove red").html("รหัสซ้ำ กรุณาเปลี่ยนใหม่")
        }else{
        }
      }
      });
    }
  
  });

function kpi_type2_change() {
  
    if ($("#kpi_type2_new").val() == 2) {
      kpi_type2_show()
      $("#kpi_rank1_new").attr('required','required').parsley();
      $("#kpi_rank2_new").attr('required','required').parsley();
      $("#kpi_rank3_new").attr('required','required').parsley();
      $("#kpi_rank4_new").attr('required','required').parsley();
      $("#kpi_rank5_new").attr('required','required').parsley();

    }else{
      kpi_type2_hide()
      $("#kpi_rank1_new").removeAttr('required').parsley();
      $("#kpi_rank2_new").removeAttr('required').parsley();
      $("#kpi_rank3_new").removeAttr('required').parsley();
      $("#kpi_rank4_new").removeAttr('required').parsley();
      $("#kpi_rank5_new").removeAttr('required').parsley();
    }
}

$("#kpi_type2_new").change(function (e) {
  kpi_type2_change()
});


  $("#form-kpi-new").submit(function (e) {  
    
      e.preventDefault();
      console.log($("#check_code").val())
      if ($(this).parsley().isValid() && $("#check_code").val() == "true") {

        $.ajax({
          type: "POST",
          url: "module/kpi_manager/ajax-kpi_manager-update.php",
          data: $("#form-kpi-new").serialize(),
          dataType: "JSON",
          success: function (response) {
            // console.log("test")
              if (response.success === true) {
                $("#form-kpi-new").parsley().reset();
                $("#form-kpi-new")[0].reset();
                refresh_datatable()
                notify('การบันทึก','สำเร็จ','success')
              }else if(response.success === null){
                notify('การบันทึก','ไม่สำเร็จ โปรดตรวจสอบข้อมูลที่กรอก'+response.msg,'warning')
              }
            }
          
        });
      }
      
      });

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


function kpi_status_edit(kpi_code) {
  $.ajax({
    type: "POST",
    url: "module/kpi_manager/ajax-kpi_status-update.php",
    data: {"kpi_code":kpi_code},
    dataType: "JSON",
    success: function (response) {
      if (response.success == true) {
        refresh_datatable();
        notify('แก้ไขสถานหัวข้อ KPI ','สำเร็จ','success')
      }else{
        notify('แก้ไขสถานหัวข้อ KPI ','ไม่สำเร็จ'+msg,'danger')
      }
    }
  });
}

    </script>
 
  </body>
</html>
