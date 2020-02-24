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
}else 
{
    if ($_SESSION[__ADMIN_ORG_ID_2__] != "") {
    $gOrg_id = $_SESSION[__ADMIN_ORG_ID_2__];
    }elseif ($_SESSION[__ADMIN_ORG_ID_1__] != "") {
    $gOrg_id = $_SESSION[__ADMIN_ORG_ID_1__];
    }elseif ($_SESSION[__ADMIN_ORG_ID__] != "") {
    $gOrg_id = $_SESSION[__ADMIN_ORG_ID__];
    }else {
    $gOrg_id = '77';
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

     <!-- Datatables -->

     <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>


    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
   


  <style>
  
  .padding300{padding:300px}
  .btn-pophover { position: relative;background: #fff;border: 1px solid #ccc;margin: 10px 10px 10px 50px;}
  .btn-pophover:hover { background: #0054FF; color:#fff}
  .btn-pophover:hover .icon{ background: #c5c92b; color:#fff;border: 1px solid #c5c92b}
  .btn-pophover .icon {position: absolute;background: #fff;border: 1px solid #0054FF;border-radius: 50%;padding: 11px;font-size: 28px;text-align: center;left: -45px; top: -10px;color: #c5c92b;}
  
  </style>

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

                      <table id="datatable_percent_complete" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th  class="col-md-4 col-sm-4 col-xs-4">หน่วยงาน</th>
                          <th class="col-md-2 col-sm-2 col-xs-2">จำนวนผู้ประเมิน</th>
                          <th class="col-md-2 col-sm-2 col-xs-2">ประเมินสมรรถนะเสร็จ</th>
                          <th class="col-md-2 col-sm-2 col-xs-2">ประเมินตัวชี้วัดเสร็จ</th>
                          <th class="col-md-2 col-sm-2 col-xs-2">ร้อยละการประเมินเสร็จ</th>
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
   
    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

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
  

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

      <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <script src="module/module_person/org_code.js"></script>

    <script> 

    var org_id = "<?php echo $_POST['ABorg_id']; ?>" 
    var org_id_1 = "<?php echo $_POST['ABorg_id_1']; ?>"
    var org_id_2 = "<?php echo $_POST['ABorg_id_2']; ?>" 
    var years = "<?php echo $_POST['yyears']; ?>"  

   if(empty(org_id_2) == false){
        org = org_id_2
      }else if(empty(org_id_1) == false) {
        org = org_id_1
      }else if(empty(org_id) == false){
        org = org_id
      }


    var org_id_default = org

          $.ajax({
            type: "POST",
            url: "module/report_admin/ajax-report-department.php",
            data: {"years":years,"org_id":org_id_default},
            dataType: "JSON",
            success: function (response) {
                    // console.log(response)
                    t.clear().rows.add(response).draw(); 
                    $("#message").html("");                 

            },
                    beforeSend: function () {
                          $("#message").html("<div class='loading'>Loading&#8230;</div>");
                  },
                    error: function (textStatus, errorThrown) {
                      
                        }
          });
     

    var c = [ {"org_name":"","personCount":"" ,"cpcComplete":"","kpiComplete":"","percentComplete":""}]  // set default row=0 ,  Everytime datatable ajax active
// drawCallback: kpiConfrim,
var t =  $('#datatable_percent_complete').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:"org_name"},
                  {data:"personCount"},
                  {data:"cpcComplete"},
                  {data:"kpiComplete"},
                  {data:"percentComplete"}
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
            "searchable": true
          },
          {
            "targets": [4],
            "searchable": false
          }
        ],
        'pageLength': -1,
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'Bfrtip',
        buttons: [
            "copy",
            {
               extend:"print",
               customize: function (win) {
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '12px');

                $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
              }
            },
            {
              extend:'csvHtml5',
              title:'รายงานความคืบหน้า'
            },
            {
              extend: 'excelHtml5',
              title: 'รายงานความคืบหน้า'
            },
            'pdf'
        ]
      });

  function empty(str)
      {
          if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g,"") === "")
          {
              return true;
          }
          else
          {
              return false;
          }
      }




    </script>
  </body>
</html>


       