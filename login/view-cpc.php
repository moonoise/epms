<?php 
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";

session_start();
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
   

    <style>
  .ui-autocomplete-loading {
    background: white url("images/ajax-loader.gif") right center no-repeat;
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
            <div class="page-title">
              <div class="title_left">
              <a class="btn btn-app" href="?page=cpc_list">
                      <i class="fa fa-list green"></i> รายการสรรถณะ
                    </a>
                    <a class="btn btn-app" href="?page=position_list">
                      <i class="fa fa-list-alt text-warning "></i> ตำแหน่ง
                    </a>
                <a class="btn btn-app" href="?page=add_cpc">
                      <i class="fa fa-plus-circle blue"></i> เพิ่มหัวสมรรถนะ
                    </a>
              </div>
            </div>
            <div class="clearfix"></div>
            <?php 
                if (isset($_GET['page'])) {
                    switch ($_GET['page']) {
                        case "cpc_list":
                            @require_once "module/cpc/cpc_list.php";
                            break;
                        case "position_list":
                            @require_once "module/cpc/position_list.php";
                            break;
                        case "add_cpc":
                            @require_once "module/cpc/add_cpc.php";
                            break;
                        default:
                            @require_once "module/cpc/cpc_list.php";
                            break;
                    }
                }else {
                    @require_once "module/cpc/cpc_list.php";
                }
            ?>   

          </div><!--  right_col -->
        </div> <!--  .. -->
        

 
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

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>




    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>

 <?php 
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case "cpc_list":
                    echo   "<script>;";
                    echo   "$('#datatable').DataTable();";
                    echo   "</script>";
                    break;
                case "add_cpc":
                    echo   "<script>;";
                    echo   "$('#show-question').DataTable( {
                      'pageLength': 4,
                      'lengthChange': false
                    } );";
                    
                    echo   "</script>";
                    break;
            }
        }
?> 

 
  </body>
</html>

<script>

 
    $( "#frm_position" ).autocomplete({
      source: function( request, response ) {
        var position = $("#frm_position").val();
        $.ajax( {
          url: "module/cpc/ajax-position-list.php",
          dataType: "json",
          data: "name="+ position,
          success: function( data ) {
            response($.map(data.aaData, function (value, key) {
                return {
                    label: value.pl_name,
                    value: value.pl_name,
                    value_code:value.pl_code
                };
            }));
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        
        $("#text_position").html(ui.item.label);
         $("#text_id_position").html(ui.item.value_code);
         $("#hidden_pl_code").val(ui.item.value_code)
         refreshTable(ui.item.value_code)
        
      }
    } );


 
//  $( "#frm_question" ).autocomplete({
//    source: function( request, response ) {
//      var question = $("#frm_question").val();
//      $.ajax( {
//        url: "module/cpc/ajax-question-list.php",
//        dataType: "json",
//        data: "name="+ question,
//        success: function( data ) {
//          response($.map(data.aaData, function (value, key) {
//              return {
//                  label: value.question_title,
//                  value: value.question_title,
//                  value_code:value.question_code
//              };
//          }));
//        }
//      } );
//    },
//    minLength: 2,
//    select: function( event, ui ) {
     
//      $("#text_question").html(ui.item.label);
//       $("#text_id_question").html(ui.item.value_code);
//       $("#hidden_question_code").val(ui.item.value_code)
//    }
//  } );

// function save() {
//   var pl_code = $("#hidden_pl_code").val();
//   var question_code = $("#hidden_question_code").val();
//   if (pl_code == null && question_code == null) {
//     $( "#dialog" ).html("<p class='text text-danger'>ไม่สามารถเพิ่มได้</p>");
//   }else {
//     $.ajax({
//             url:"module/cpc/ajax-add-question.php",
//             dataType:"json",
//             data:"pl_code="+pl_code+"&question_code="+question_code,
//             success:function(data){
//               if(data.success == true){
//                  $('#dialog p').html("เพิ่มเรียบร้อย").slideDown("slow").delay(3000).slideUp("slow");
//                  refreshTable(pl_code)
//               }else {
//                 $('#dialog p').html("Error "+data.msg).slideDown("slow").delay(9000).slideUp("slow");
//               }
//             }
//           });
//   }
// }

function addQuestion(question_no) {
  var pl_code = $("#hidden_pl_code").val();
  $.ajax({
    url: 'module/cpc/ajax-add-question.php',
    dataType: 'json',
    data:'question_no='+question_no+'&pl_code='+pl_code,
    success:function (data) {
      if (data.success == true) {
        $('#dialog p').html("เพิ่มแล้ว").slideDown("slow").delay(3000).slideUp("slow");
          refreshTable(pl_code)
      }else{
        $('#dialog p').html("Error "+data.msg).slideDown("slow").delay(9000).slideUp("slow");
      }
    }
  })
}

function delQuestion(qc_id,p) {
 //console.log('test'+p)
  $.ajax({
    url: 'module/cpc/ajax-del-question.php',
    dataType: 'json',
    data:'qc_id='+qc_id,
    success:function (data) {
      if (data.success == true) {
        $('#dialog p').html("ลบข้อมูลเรียบร้อย").slideDown("slow").delay(3000).slideUp("slow");
          refreshTable(p)
          //console.log(p)
          
      }else{
        $('#dialog p').html("Error "+data.msg).slideDown("slow").delay(9000).slideUp("slow");
      }
    }
  })
}

function refreshTable(p) {
  $.ajax({
      url:'module/cpc/ajax-cpc_question_create-show.php',
      dataType: 'html',
      data:'pl_code='+p,
      success: function (data) {
        $("#show_question").html(data)
      }
  })
}




</script>