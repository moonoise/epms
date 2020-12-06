<?php
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();

if ((in_array($_SESSION[__GROUP_ID__], array(4)) || $_SESSION[__USER_ID__] == 'moonoise')) {
} else {
  header("location:disallow.php");
}

activeTime($login_timeout, $_SESSION[__SESSION_TIME_LIFE__]);

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

  <title><?php echo $site_name; ?></title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <!-- <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
  <link href="../vendors/fontawesome-5.6.3-web/css/all.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- jQuery custom content scroller -->
  <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
  <!-- Custom Theme Style -->
  <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">

  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
            <a href="<?php echo (in_array($_SESSION[__GROUP_ID__], array(4, 5, 6, 7)) ? "setting-person.php" : "view-profile.php"); ?>" class="site_title"><i class="fa fa-user blue"></i> <span>ระบบ Login</span></a>
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
          <a class="date-title">
            <small class="date-title-text">ประเมินรอบที่ </small>
          </a>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h4>แบบฟอร์มรายงานผลการประเมินสมรรถนะของบุคลากร</h4>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="col-md-1 col-sm-1 col-xs-1">แบบรายงานผลประเมิน</th>
                        <th colspan="6">ครั้งที่ 1 : 1 ตั้งแต่วันที่ 1 ตุลาคม 2561 - 31 มีนาคม 2562</th>
                      </tr>
                      <tr>
                        <th>ชื่อหน่วยงาน :</th>
                        <th colspan="6">กรมชลประทาน</th>
                      </tr>
                      <tr>
                        <th>กระทรวง :</th>
                        <th colspan="6">เกษตรและสหกรณ์</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="col-md-1 col-sm-1 col-xs-1"></td>
                        <th class="col-md-7 col-sm-7 col-xs-7" colspan="2">สมรรถนะหลัก (Core Competency)</th>
                        <td class="col-md-1 col-sm-1 col-xs-1">(1)ผลคะแนนรวมการประเมินสมรรถนะแต่ละสมรรถนะของข้าราชการทุกราย</td>
                        <td class="col-md-1 col-sm-1 col-xs-1">(2)จำนวนคน</td>
                        <td class="col-md-1 col-sm-1 col-xs-1">
                          (3)
                          คะแนนเฉลี่ย
                          (1) ÷ (2)
                          (ผลคะแนนรวมการประเมิน
                          สมรรถนะ
                          แต่ละสมรรถนะของ
                          พนักงานราชการทุกราย ÷ จำนวน
                          พนักงานราชการ(คน)
                          ณ วันที่ประเมิน)</td>
                        <td class="col-md-1 col-sm-1 col-xs-1">
                          ค่าคะแนน
                          เฉลี่ย
                          สมรรถนะ
                          ของบุคลากร
                          (เต็ม 100 คะแนน)</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td class="col-md-1 col-sm-1 col-xs-1">1</td>
                        <td>การมุ่งผลสัมฤทธิ์ (Achievement Motivation)</td>
                        <td>23988.18</td>
                        <td>5569</td>
                        <td>4.31</td>
                        <td>84.10</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="4">คะแนนเฉลี่ยทุกสมรรถนะหลัก = (ผลรวมคะแนนเฉลี่ยทุกสมรรถนะหลัก ÷ จำนวนสมรรถนะหลักทั้งหมดที่มีการประเมิน 7 สมรรถนะ)</td>
                        <td>4.13</td>
                        <td>82.30</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="5">ค่าคะแนนเฉลี่ยรวมทั้งหมด 28 สมรรถนะ (คะแนนเต็ม 100 คะแนน)</td>
                        <td></td>
                      </tr>

                      <tr>
                        <td rowspan="4">(2) จำนวนข้าราชการ (คน) ณ วันที่ประเมินผล (31 มีนาคม 2562)</td>
                        <td colspan="6" style="border-top:0px ; border-bottom:0px;" class="text text-center">รวม 5570 คน</td>
                      </tr>
                      <tr>
                        <td colspan="6" style="border-top:0px ; border-bottom:0px;" class="text text-center">ประเภททั่วไป 2924 คน</td>
                      </tr>
                      <tr>
                        <td colspan="6" style="border-top:0px ; border-bottom:0px;" class="text text-center">ประเภทวิชาการ 2420 คน</td>
                      </tr>
                      <tr>
                        <td colspan="6" style="border-top:0px ; border-bottom:0px;" class="text text-center">ประเภทอำนวยการ 226 คน</td>
                      </tr>
                    </tbody>
                  </table>
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

  <div id="message"></div>

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
  <!-- Custom Theme Scripts -->
  <script src="../vendors/bootstrap/dist/js/custom.js"></script>

  <!-- Datatables -->
  <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>

  <script src="../vendors/jszip/dist/jszip.min.js"></script>
  <script src="../vendors/pdfmake/build/pdfmake.js"></script>
  <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

  <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

  <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

  <!-- PNotify -->
  <script src="../vendors/pnotify/dist/pnotify.js"></script>
  <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
  <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

  <script src="../vendors/parsleyjs/dist/parsley.js"></script>

</body>

</html>