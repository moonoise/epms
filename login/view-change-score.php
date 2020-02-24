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
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

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

                    </div>
                  </div>
                </div>
            </div>
             </div>

            <div class="row">
           
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                  <div class="col-md-4 col-sm-4 col-xs-4">
                      <form  name="searchID" id="searchID">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="เลขบัตรประชาชน" name="per_cardno" id="id-per_cardno">
                              <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary"  id="submit-searchID">ค้นหา</button>
                              </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                         <p class="text text-success"> #<span id="id-search-per_cardno"></span> || ชื่อ : <span id="id-search-name"></span> </p>
                    </div>
                   <div class="col-md-12 col-sm-12 col-xs-12">
                     
                            <table id="evaluation-table" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="thead-for-user">
                                        <tr>
                                            <th rowspan="2" class="col-md-1 col-sm-1 col-xs-1 text-center">รหัส</th>
                                            <th rowspan="2" class="col-md-6 col-sm-6 col-xs-6 text-center">ตัวชี้วัด</th>
                                            <th colspan="2"  class="col-md-4 col-sm-4 col-xs-4 text-center">ผลการประเมิน</th>
                                            <th rowspan="2"  class="col-md-1 col-sm-1 col-xs-1 text-center">คะแนนรวม<br><u>(คxนx20)</u><br>100</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">คะแนน(ค)</th>
                                            <th class="text-center">น้ำหนัก(น)</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="evaluation-table-tbody">

                                    </tbody>
                            </table>
                        
                   </div>

                   <div class="col-md-12 col-sm-12 col-xs-12">
                        <form name=form_add id="form_add">
                            <input type="hidden" name="per_cardno" id="form_add_per_cardno">
                            <input type="hidden" name="kpi_code" id="form_add_kpi_code" value="rid-01">
                            <table id="add-table" class="table table-bordered" style="width:100%">
                                <tr>
                                    <td class="col-md-1 col-sm-1 col-xs-1 text-center">rid-01</td>
                                    <td class="col-md-6 col-sm-6 col-xs-6 text-left">ตัวชี้วัดกรณีพิเศษ</td>
                                    <td class="col-md-2 col-sm-2 col-xs-2 text-center"><input name="input_score" id="input_score" size="1" maxlength="1" min="1" max="5" type="number"></td>
                                    <td class="col-md-2 col-sm-2 col-xs-2 text-center"><input name="input_weight" id="input_weight" size="3" maxlength="3" min="1" max="100" type="number"></td>
                                    <td class="col-md-1 col-sm-1 col-xs-1 text-center"><button type="button" class="btn btn-info btn-xs" id="id-add-kpi"><i class="fa fa-plus-square"></i></button></td>
                                </tr>
                            </table>
                        </form>
                   </div>

                   <div class="col-md-12 col-sm-12 col-xs-12">
                      <table id="sum-table" class="table table-bordered" style="width:100%">
                              <thead>
                              <tr>
                                <td class="col-md-5 col-sm-5 col-xs-5 text-center">สูตร</td>
                                <td class="col-md-1 col-sm-1 col-xs-1 text-center">#</td>
                                <td class="col-md-1 col-sm-1 col-xs-1 text-center">อัตราส่วน</td>
                                <td class="col-md-1 col-sm-1 col-xs-1 text-center">คะแนน</td>
                                <td class="col-md-1 col-sm-1 col-xs-1 text-center">คิดเป็นอัตราส่วน</td>
                                <td class="col-md-3 col-sm-3 col-xs-3 text-center">รวม <button type="button" class="btn btn-info btn-xs" onclick="refreshSum()"><i class="fas fa-retweet"></i></button></td>
                              </tr>
                              </thead>
                              <tr>
                                <td rowspan="2" class="text-center" id="sol"></td>
                                  <td class="text-center">สมรรถนะ</td>
                                  <td class="text-center" id="cpc-ratio"></td>
                                  <td class="text-center" id="cpc-score"></td>
                                  <td  class="text-center" id="sol-cpc" ></td>
                                  <td rowspan="2" class="text-center" id="id-sumAll"></td>
                                  
                              </tr>
                              <tr>
                                  <td class=" text-center">ตัวชี้วัด</td>
                                  <td class=" text-center" id="kpi-ratio"></td>
                                  <td class=" text-center" id="kpi-score"></td>
                                  <td  class="text-center" id="sol-kpi"></td>
                              </tr>
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

      <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <script src="../vendors/parsleyjs/dist/parsley.js"></script>

    <script> 


var kpiWeight_new = 0;
var kpiScore_new = 0;
var cpcScore = 0;
var cpcRatio = 0 ;
var kpiRatio = 0 ;

$(document).ready(function () {
  var get_per_cardno = '<?php echo  (isset($_GET['per_cardno']) ? $_GET['per_cardno'] : "" )   ; ?>';

  if (get_per_cardno != '') {
    $("#id-per_cardno").val(get_per_cardno)
    $('#searchID').submit();
  }
});


  $("#searchID").submit(function (e) { 

      e.preventDefault();
      $.ajax({
        url: "module/change_score/ajax-show-kpi.php",
        type:"POST",
        dataType: "JSON",
        data: {"per_cardno":$("#id-per_cardno").val()},
        success:function (result) {
            if (result.success == true) {
              $("#evaluation-table-tbody").html(result.html)
              $("#id-search-per_cardno").text(result.per_cardno)
              $("#id-search-name").text(result.name)
              kpiWeight_new = result.kpi_weight_new
              kpiScore_new = result.kpi_score_new
              refreshSum()
              // console.log(result)
            }else{
              $("#evaluation-table-tbody").html("")
              $("#id-search-per_cardno").text("")
              $("#id-search-name").text("")
              kpiWeight_new = 0
              kpiScore_new = 0
              refreshSum()
            }
            
        }
    })

    $.ajax({
        url: "module/change_score/ajax-show-cpc.php",
        type:"POST",
        dataType: "JSON",
        data: {"per_cardno":$("#id-per_cardno").val()},
        success:function (result) {
          if (result.success == true) {
            cpcScore = result.cpcSum2
            cpcRatio = result.weight_cpc 
            kpiRatio = result.weight_kpi 
              // console.log(result)
              // refresh_score()
              refreshSum()
          }else{
             cpcScore = 0
             cpcRatio = 0 
             kpiRatio = 0 
             refreshSum()
          }
        }
    })
    

  });

//   $(document).on("click",".class-submit-weight", function (e) {
//     // console.log("TEST")
//       e.preventDefault();
//      console.log( $(this).attr('id') )


//   });

$(document).on("click",".class-submit-weight", function () {
    // console.log("test")
  //  console.log( $(this.form.change_weight).val() );
//    console.log( $(this).val() );
   $.ajax({
       type: "POST",
       url: "module/change_score/ajax-change-kpiByID.php",
       data: {"weight":$(this.form.change_weight).val() , "kpi_score_id":$(this).val()},
       dataType: "JSON",
       success: function (response) {
           if (response.success == true) {
            notify('ค่าน้ำหนัก','บันทึกสำเร็จ','success')
            refresh_score()
           }else{
            notify('ค่าน้ำหนัก','ไม่สำเร็จ','danger')
           }
       }
   });
});

$(document).on("click",".class-submit-score", function () {
    // console.log("test")
  //  console.log( $(this.form.change_weight).val() );
//    console.log( $(this).val() );
   $.ajax({
       type: "POST",
       url: "module/change_score/ajax-change-kpiScoreByID.php",
       data: {"score":$(this.form.change_score).val() , "kpi_score_id":$(this).val()},
       dataType: "JSON",
       success: function (response) {
           if (response.success == true) {
            notify('คะแนน','บันทึกสำเร็จ','success')
            refresh_score()
           }else{
            notify('คะแนน','ไม่สำเร็จ','danger')
           }
       }
   });
});

function refresh_score() {
  $.ajax({
        url: "module/change_score/ajax-show-kpi.php",
        type:"POST",
        dataType: "JSON",
        data: {"per_cardno":$("#id-search-per_cardno").text()},
        success:function (result) {
            $("#evaluation-table-tbody").html(result.html)
            // console.log(result)
            kpiWeight_new = result.kpi_weight_new;
            kpiScore_new = result.kpi_score_new;
            
        }
    });

  $.ajax({
        url: "module/change_score/ajax-show-cpc.php",
        type:"POST",
        dataType: "JSON",
        data: {"per_cardno":$("#id-per_cardno").val()},
        success:function (result) {
          refreshSum()
            // console.log(result)
            cpcScore = result.cpcSum2
          cpcRatio = result.weight_cpc 
          kpiRatio = result.weight_kpi 
        }
    });
    
}

function refresh_sum_score(cpcScore,kpiScore,kpiWeight_new,cpcRatio,kpiRatio) {
 var c = 0;
 var k = 0; 
 $("#cpc-ratio").text(cpcRatio);
$("#kpi-ratio").text(kpiRatio);

  $("#cpc-score").text(cpcScore.toFixed(2));
  $("#kpi-score").text(kpiScore.toFixed(2));

  c = cpcScore * (cpcRatio /100);
  k = kpiScore * (kpiRatio / 100);
  ckResult = c + k ;

  $("#sol").html("( "+cpcScore+" x ( "+ cpcRatio +" / 100 ) ) + ( "+ kpiScore +" x ( "+ kpiRatio +" / 100 ) )"); 
  $("#sol-cpc").html(c.toFixed(2));
  $("#sol-kpi").html(k.toFixed(2));
  $("#id-sumAll").text(ckResult.toFixed(2));


}

function updateKPI() {
  var p =  $("#id-per_cardno").val()
  $.ajax({
    type: "POST",
    url: "module/report_admin/update-kpi-score.php",
    data: {"per_cardno":p,"kpi_score":kpiScore_new },
    dataType: "JSON",
    success: function (response) {
      console.log(response)
    }
  });
}


function refreshSum() {
  refresh_sum_score(cpcScore,kpiScore_new,kpiWeight_new,cpcRatio,kpiRatio)
  updateKPI()
}

$("#id-add-kpi").on("click", function () {
    if ($("#id-search-per_cardno").text() != "") {
      $("#form_add_per_cardno").val($("#id-search-per_cardno").text() );
        $.ajax({
          type: "POST",
          url: "module/change_score/ajax-add-kpi-specialCase.php",
          data: $("#form_add").serialize(),
          dataType: "JSON",
          success: function (response) {
            if (response.success == true) {
              notify('เพิ่มตัวชี้วัดพิเศษ','สำเร็จ','success')
              refresh_score()
            }else {
              notify('ERROR',response.msg,'danger')
            }
          }
        });
    }else{
      notify('ERROR','ไม่พบรายชื่อผู้ที่ต้องการเพิ่ม','danger')
    }
    
});

$("#id-add-kpi").popConfirm({
        title: "เพิ่มตัวขี้วัดพิเศษ", // The title of the confirm
        content: "คุณต้องการเพิ่มตัวขี้วัดพิเศษ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "bottom", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
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


       