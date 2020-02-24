<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();

if((in_array($_SESSION[__GROUP_ID__],array(4)) || $_SESSION[__USER_ID__] == 'fad009' ) ){ 
  
}else 
{
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
    <!-- <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href="../vendors/fontawesome-5.6.3-web/css/all.css" rel="stylesheet">

    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

  <!-- Bootstrap Checkboxes/Radios
  <link href="../vendors/checkboxes-radios/checkboxes-radios.css" rel="stylesheet"> -->
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/css-view-report.css">

  <!-- Datatables -->
  <!-- <link href="../vendors/datatables.net/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons/css/buttons.dataTables.min.css" rel="stylesheet"> -->

  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- PNotify -->
  <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
  <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
  <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  <style>
   .choise-td {
        padding: 2px;
    }
    .choise-radio {
        margin: 1px 1px 1px 1px ;
    }
    .table>tbody>tr>td {
        padding: 4px;
    }

    .hoverbox:hover img {
        -webkit-transition: all linear.5;
        -webkit-transform: scale(2.0);
        z-index: 2000;
    }

    input[type=number]{
        width: 50px;
    } 

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
            <a class="date-title">
                <small class="date-title-text">ประเมินรอบที่ <?php $part = explode("-",__year__); echo $part[1];?> ประจำปีงบประมาณ <?php echo $part[0]+543;?></small>
            </a>
            <div class="clearfix"></div>

             <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="specialCase-table" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="col-md-2 col-sm-2 col-xs-2 text-center">เลขบัตรประชาชน</th>
                                    <th rowspan="2" class="col-md-3 col-sm-3 col-xs-3 text-center">ชื่อ - สกุล</th>
                                    <th class="col-md-1 col-sm-1 col-xs-1 text-center">คะแนน</th>
                                    <th colspan="3" class="col-md-6 col-sm-6 col-xs-6 text-center">สังกัด</th>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">#</th>
                                    <th class="text-center">#</th>
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
   
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>

     <!-- Switchery -->
     <script src="../vendors/switchery/dist/switchery.min.js"></script>

    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

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

    <script> 

    var dataTables = [{"per_cardno_link":"" , "name" : "" ,"sum_CPC_KPI":"", "org_name" : "" ,"org_name1" : "" ,"org_name2" : ""}]

    var table = $("#specialCase-table").DataTable({
       
        "data":dataTables,
        "deferRender": true,
        "autoWidth": false,
        "columns": [
            {"data":"per_cardno_link"},
            {"data":"name"},
            {"data":"sum_CPC_KPI"},
            {"data":"org_name"},
            {"data":"org_name1"},
            {"data":"org_name2"},
            ],
        "columnDefs": [
            {
              "targets": ["per_cardno"],
              "searchable": true
            },
            {
              "targets": ["name"],
              "searchable": true
            },
            {
              "targets": ["sum_CPC_KPI"],
              "searchable": true
            },
            {
              "targets": ["org_name"],
              "searchable": true
            },
            {
              "targets": ["org_name1"],
              "searchable": true
            },
            {
              "targets": ["org_name2"],
              "searchable": true
            }
        ],
          'pageLength': -1,
          "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]
        ],
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
              title:'ผู้มีตัวชี้วัดพิเศษ'
            },
            {
              extend: 'excelHtml5',
              title: 'ผู้มีตัวชี้วัดพิเศษ'
            },
            {
              extend: 'pdf',
              title: 'ผู้มีตัวชี้วัดพิเศษ'
            }
            
        ]
    });

   
       
//  var dataTables = [{"per_cardno":"" , "name" : "" , "org" : "" ,"org1" : "" ,"org2" : ""}]
 $.ajax({
            type: "POST",
            url: "module/change_score/ajax-show-specialCase.php",
            dataType: "JSON",
            success: function (response) {
                if (response.data != 'NULL') {
                    // console.log(response)
                    table.clear().rows.add(response.data).draw();
                }else{
                    table.clear().rows.add(dataTables).draw();
                }
                
            }
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

 

    </script>
  </body>
</html>


       