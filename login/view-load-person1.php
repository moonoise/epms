<?php
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/ociConn.php";
include_once "includes/class.permission.php";

if (!isset($_SESSION[__USER_ID__])) {
  header("location:login-dpis.php");
}
$success =  groupUsers($_SESSION[__USER_ID__]);
if (($success['success'] === true)) {
  if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
    $gOrg_id = $success['result']['org_id'];
  } else {
    $gOrg_id = '77';
  }
} elseif ($success['success'] === false) {
  if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
    $per_cardno = $_SESSION[__USER_ID__];
    $name = $_SESSION[__F_NAME__] . " " . $_SESSION[__L_NAME__];
  }
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
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- jQuery custom content scroller -->
  <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />


  <!-- Custom Theme Style -->
  <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
  <!-- Bootstrap Checkboxes/Radios -->
  <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet">

  <link href="../vendors/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">

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
          <div class="page-title">
            <div class="title_left">
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h3><i class="fa  fa-wrench green"></i> <b style="color:red">L</b>oad Person <small> .. </small></h3>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <h2 class="text text-primary">
                        เลือกพนักงาน เป็นผู้ใต้บังคับบัญชา
                      </h2>
                      <label for="per_cardno_type3">ใส่เลขบัตรประจำตัวประชาชน * :</label>
                      <input type="text" id="per_cardno_type3" class="" name="per_cardno_type3" size="20" autofocus>
                      <button type="button" class="btn btn-success" id="btn-search-per_cardno_type3">ค้นหา</button>
                      <div id="id1">
                        <ol id="id2">
                        </ol>
                      </div>
                      <div id="id3"></div>
                      <div id="id4"></div>
                      <hr>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <h2 class="text text-secodary">
                        เลือกข้าราชการ เป็นผู้บังคับบัญชา
                      </h2>
                      <label for="per_cardno">ใส่เลขบัตรประจำตัวประชาชน * :</label>
                      <input type="text" id="per_cardno" class="" name="per_cardno" size="20" autofocus>
                      <button type="button" class="btn btn-success" id="btn-search-per_cardno">ค้นหา</button>
                      <div id="id1-head">
                        <ol id="id2-head">
                        </ol>
                      </div>
                      <div id="id3-head"></div>
                      <div id="id4-head"></div>
                    </div>


                  </div>



                </div> <!-- x_content -->
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

  <!-- popconfirm  -->
  <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../vendors/bootstrap/dist/js/custom.js"></script>

  <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>

</body>

</html>

<script>
  $('#per_cardno').keydown(function(e) {

    var key = e.which;
    // console.log(key)
    if (key == 13) {
      // As ASCII code for ENTER key is "13"
      $('#btn-search-per_cardno').trigger("click"); // Submit form code
    }
  });

  $("#btn-search-per_cardno").on("click", function() {
    var per_cardno = $("#per_cardno").val()
    $.ajax({
      url: "module/module_dpis/ajax-search-per_cardno.php",
      dataType: "json",
      type: "POST",
      data: {
        "per_cardno": per_cardno
      },
      success: function(result) {
        $("#id1-head").html("")
        result.forEach(function(personal) {
          $("#id1-head").prepend("<li>" + personal.PER_NAME + " " + personal.PER_SURNAME + "->" + personal.ORG_NAME + " <a onclick='addPer(`" + personal.PER_CARDNO + "`)' class='btn btn-info btn-xs' >อัพเดท</a> <span id='id5-" + personal.PER_CARDNO + "' class='text-success'></span></li>")
        })
        // $("#id1").html(result.PER_NAME +" "+ result.PER_SURNAME)

      }
    });
  });

  $("#btn-search-per_cardno_type3").on("click", function() {
    var per_cardno = $("#per_cardno_type3").val()
    $.ajax({
      url: "module/module_dpis/ajax-search-per_cardno_type3.php",
      dataType: "json",
      type: "POST",
      data: {
        "per_cardno": per_cardno
      },
      success: function(result) {
        $("#id1").html("")
        result.forEach(function(personal) {
          $("#id1").prepend("<li>" + personal.PER_NAME + " " + personal.PER_SURNAME + "->" + personal.ORG_NAME + " <a onclick='addPerType3(`" + personal.PER_CARDNO + "`)' class='btn btn-info btn-xs' >อัพเดท</a> <span id='id7-" + personal.PER_CARDNO + "' class='text-success'></span></li>")
        })
        // $("#id1").html(result.PER_NAME +" "+ result.PER_SURNAME)

      }
    });
  });

  function addPer(per_cardno) {
    var id5 = "#id5-" + per_cardno;
    $.ajax({
      url: "module/module_dpis/ajax-insert-personal.php",
      dataType: "json",
      type: "POST",
      data: {
        "per_cardno": per_cardno
      },
      success: function(result) {
        $(id5).html("อัพเดทแล้ว")
      },
      error: function(textStatus, errorThrown) {
        per_cardno_err.push(per_cardno)
      }
    });
  }

  function addPerType3(per_cardno) {
    var id7 = "#id7-" + per_cardno;
    $.ajax({
      url: "module/module_dpis/ajax-insert-personal-type3.php",
      dataType: "json",
      type: "POST",
      data: {
        "per_cardno": per_cardno
      },
      success: function(result) {
        $(id7).html("อัพเดทแล้ว")
      },
      error: function(textStatus, errorThrown) {
        per_cardno_err.push(per_cardno)
      }
    });
  }

  function notify(nTitle, nText, nType, timeOut, nHide) {
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

  $(" #confirm-load-person").popConfirm({
    title: "เพิ่มรายชื่อเข้าระบบทั้งหมด", // The title of the confirm
    content: "ระบบจะโหลดข้อมูลจาก <b class='text-info'>ระบบ DPIS</b> เข้าการประเมิน<b class='text-info'> ปี รอบ </b>ตัวปัจจุบัน หากรายชื่อไหนมีอยู่ระบบแล้วจะไม่ลบออกและเข้าทำการอัพเดทแทน", // The message of the confirm
    placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
    container: "body", // The html container
    yesBtn: "โหลด",
    noBtn: "ไม่โหลด"
  });
</script>