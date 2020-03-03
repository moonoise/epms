<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once 'module/module_person/class-person.php';
include_once 'module/cpc/class-cpc.php';
include_once 'module/kpi/class-kpi.php';
include_once "includes/class.permission.php";
include_once "module/myClass.php";


$myClass = new myClass;
$currentYear = $myClass->callYear();
$per_personal = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$detailYear = $currentYear['data']['detail'];
$year = $currentYear['data']['table_year'];

if(!isset($_SESSION[__USER_ID__]) ){ 
  header("location:login-dpis.php");
}
$success =  groupUsers($_SESSION[__USER_ID__]);
if (($success['success'] === true)   ) {
   if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
      $gOrg_id = $success['result']['org_id'];
   }else 
   {
     $gOrg_id = '77';
   }
}elseif ($success['success'] == false) {
    if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
        $per_cardno = $_SESSION[__USER_ID__];
        $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
    }
}  
activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
// $per_cardno = 5120100048111;
// $name = "test";
// $level_no ="D1";

$person =  new person;
$SelectSubordinate = "SELECT `per_id`,
                              `per_cardno`,
                              `pn_name`,
                              `per_name`,
                              `per_surname`,
                              `pos_id`,
                              `pl_name`,
                              `pl_code`,
                              `pm_code`,
                              `pm_name`,
                              `level_no`,
                              `level_name`,
                              `per_picture`,
                              `head` 
                       FROM ".$per_personal.
                      " WHERE head = :head ";
                    
$stm = $person->conn->prepare($SelectSubordinate);
$stm->bindParam(":head",$per_cardno);
$stm->execute();
$result = $stm->fetchAll();

$cpc = new cpc;
$kpi = new kpi;

function Createbar($cpcStatus,$kpiStatus,$per_cardno) {
  if ($cpcStatus['success'] === true && $kpiStatus['success'] === true) {
     $total_cpc = ($cpcStatus['total_choise']*2) ;
     $total_kpi = ($kpiStatus['total_choise'] * 2) ;

     $finished_cpc = $cpcStatus['choiseAccepted'] + $cpcStatus['choiseFinish'];
     $finished_kpi = $kpiStatus['choiseAccepted'] + $kpiStatus['choiseFinish'];
     //------------------------------------------------
     $total_cpc_kpi = $total_cpc + $total_kpi;
    $finished_cpc_kpi =   $finished_cpc + $finished_kpi;

     $r_kpi_cpc = @(100/$total_cpc_kpi) * $finished_cpc_kpi;
    $r_kpi_cpc = round($r_kpi_cpc);

    //------------------------------------------------

    // $r_cpc = @(50/$total_cpc) * $finished_cpc;
    // $r_cpc = round($r_cpc);

    // $r_kpi = @(50/$total_kpi) * $finished_kpi;
    // $r_kpi = round($r_kpi);

    // $r_kpi_cpc = $r_cpc + $r_kpi;

    if ($r_kpi_cpc == 100 ) {
      $colorBar = "progress-bar-success";
    }elseif ($r_kpi_cpc < 100 and $r_kpi_cpc >=30 ) {
      $colorBar = "progress-bar-warning";
    }elseif ($r_kpi_cpc < 30  ) {
      $colorBar = "progress-bar-danger";
    }else{
      $colorBar = "progress-bar-danger";
    }
    
     $id = "id".$per_cardno;
     $txt = "txt".$per_cardno;
     $bar = "<div class='progress' data-toggle='popover' data-id='".$txt."' data-placement='right'>
              <div id='".$id."'  class='progress-bar $colorBar progress-bar-striped active' 
                role='progressbar' aria-pause='".$r_kpi_cpc."' 
                aria-valuenow='0' aria-valuemin='0' 
                aria-valuemax='100' style='width: 0%'>
                <span id='current-progress'></span>
              </div>
            </div>
            <div style='display:none' id='".$txt."'>
              <div class='media'>
                <div class='media-body'>
                    <h4 class='media-heading blue'>สมรรถนะ</h4>
                    <p><small class='text-success'>สมรรถนะทั้งหมด <span class='red'>".$cpcStatus['total_choise']."</span> ข้อ<br>ประเมินแล้ว <span class='red'>".$cpcStatus['choiseFinish']."</span> ข้อ<br>ยืนยันแล้ว <span class='red'>".$cpcStatus['choiseAccepted']."</span> ข้อ </small></p>
                    <h4 class='media-heading blue'>ตัวชี้วัด	</h4>
                    <p><small class='text-success'>ตัวชี้วัดทั้งหมด <span class='red'>".$kpiStatus['total_choise']."</span> ข้อ<br>ประเมินแล้ว <span class='red'>".$kpiStatus['choiseFinish']."</span> ข้อ<br>ยืนยันแล้ว <span class='red'>".$kpiStatus['choiseAccepted']."</span> ข้อ </small></p>
                </div>
              </div>
            </div>
            ";
  }

return $bar;  
  
}

function createButton($cpcStatus,$kpiStatus,$per_cardno,$name,$years) {
  $btn = '';
  $btn_bypass = "";
  if ($cpcStatus['success'] === true || $kpiStatus['success'] === true) {

      if($kpiStatus['total_choise'] > 0 || $cpcStatus['total_choise'] > 0){
        if(($cpcStatus['choiseAccepted'] == $cpcStatus['total_choise']) && ($kpiStatus['choiseAccepted'] == $kpiStatus['total_choise'])){
          //ยืนยันครบแล้ว
          $btn = "
                  <form method='post' action='view-evaluation-accept-show.php' target='tab_epm_accept' name='frm_epm_accept' id='frm_epm_accept'> 
                    <input type='hidden' name='per_cardno' value='".$per_cardno."'>
                    <input type='hidden' name='name' value='".$name."'>
                      <input type='submit' value='ยืนยันครบแล้ว' class='btn btn-success btn-xs'>
                      <button type='button' class='btn btn-success btn-xs confrim_bypass' onclick='confrim_bypass(`".$per_cardno."`,`".$years."`,`".$name."`)'>ดูคะแนน</button>
                  </form>";
        }else {
          //ยืนยันยังไม่ครบ
         
          if ( ($cpcStatus['total_choise'] == $cpcStatus['choiseFinish'] )  && ($kpiStatus['total_choise'] == $kpiStatus['choiseFinish'] ) ) {
            $btn_bypass = " <button type='button' class='btn btn-warning btn-xs confrim_bypass' onclick='confrim_bypass(`".$per_cardno."`,`".$years."`,`".$name."`)'>ยืนยันด่วน</button>";
          }else {
            $btn_bypass = " <button type='button' class='btn btn-warning btn-xs confrim_bypass' onclick='confrim_bypass(`".$per_cardno."`,`".$years."`,`".$name."`)'>ดูคะแนน</button>";
          }
          if(($cpcStatus['choiseFinish'] > 0 || $kpiStatus['choiseFinish'] > 0)){
            //รอยืนยันผล
            $btn = "
                    <form method='post' action='view-evaluation-accept-show.php' target='tab_epm_accept' name='frm_epm_accept' id='frm_epm_accept'> 
                      <input type='hidden' name='per_cardno' value='".$per_cardno."'>
                      <input type='hidden' name='name' value='".$name."'>
                        <input type='submit' value='ยืนยันผล' class='btn btn-info btn-xs'>
                        $btn_bypass
                    </form>";
          }else{
            //อยู่ระหว่างการประเมิน
            $btn = "
                    <form method='post' action='view-evaluation-accept-show.php' target='tab_epm_accept' name='frm_epm_accept' id='frm_epm_accept'> 
                      <input type='hidden' name='per_cardno' value='".$per_cardno."'>
                      <input type='hidden' name='name' value='".$name."'>
                        <input type='submit' value='อยู่ระหว่างการประเมิน' class='btn btn-warning btn-xs'>
                        $btn_bypass
                    </form>";
          }
        }
      
      

      }else{
        //ไม่พบการประเมิน
        $btn = "<button type='button' class='btn btn-danger btn-xs'>ไม่พบการประเมิน</button>";
      }
    return $btn;

  }

}




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



  <style>
  .progress {
    margin: 5px;
    width: 100%;
  }

.padding300{padding:300px}
.btn-pophover { position: relative;background: #fff;border: 1px solid #ccc;margin: 10px 10px 10px 50px;}
.btn-pophover:hover { background: #0054FF; color:#fff}
.btn-pophover:hover .icon{ background: #c5c92b; color:#fff;border: 1px solid #c5c92b}
.btn-pophover .icon {position: absolute;background: #fff;border: 1px solid #0054FF;border-radius: 50%;padding: 11px;font-size: 28px;text-align: center;left: -45px; top: -10px;color: #c5c92b;}


/* =Hoverbox Code
----------------------------------------------------------------------*/

/* 
.li-first a:hover img{
  -webkit-transition: all linear.5;
  -webkit-transform: scale(1.8);
  z-index: 2000;
}


.hoverbox img {
	background: #fff;
	border:1px solid #ddd;
	color: inherit;
	padding: 2px;
	vertical-align: top;
	width: 50px;
	height: 50px;
}

.hoverbox li {
	background: #eee;
	border:1px solid #ccc;
	color: inherit;
	display: inline;
	float: left;
	margin: 3px;
	padding: 5px;
	position: relative;
} */

.hoverbox:hover img {
  -webkit-transition: all linear.5;
  -webkit-transform: scale(2.0);
  z-index: 2000;
}



/* =Hoverbox Code
----------------------------------------------------------------------*/
  
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
                </div>
            </div>
            <div class="clearfix"></div>

                                    <!-- Accept Table -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title x_title-for-user">
                    <h2 class="head-text-user" >ยืนยันผลการประเมิน <small>..</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                  <!-- <ul class="hoverbox">
                      <li class="li-first">
                    <a href="#" class="user-profile">
                      <img src="http://tenderwind.narod.ru/img/2010/Shaman/mini/IMG_1597.jpg" />
                    </a>
                  </li>
                </ul> -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                          <?php
                            if (count($result) > 0) {
                              
                             echo '<a class="date-title">
                                      <small class="date-title-text">'.$detailYear.'</small>
                                  </a>';
                              echo '<table id="evaluation-table" class="table table-hover table-bordered" >
                                    <thead class="thead-for-user">
                                        <tr>
                                        <th class="col-md-4 col-sm-4 col-xs-4 text-center" >รายชื่อ</th>
                                        <th class="col-md-3 col-sm-3 col-xs-3 text-center" >ตำแหน่ง</th>
                                        <th class="col-md-2 col-sm-2 col-xs-2 text-center" >สมรรถนะ | ตัวชี้วัด</th>
                                        <th class="col-md-2 col-sm-2 col-xs-2 text-center" >สถานะ</th>
                                        <th class="col-md-1 col-sm-1 col-xs-1 text-center" >IDP</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="evaluation-table-tbody">';
                                    foreach ($result as $key => $value) {
                                      $cpcStatus3 = $cpc->cpcStatus3($value['per_cardno'],$year,$cpcScoreTable);
                                      $kpiStatus3 = $kpi->kpiStatus3($value['per_cardno'],$year,$kpiScoreTable );
                                      $name = $value['per_name']." ".$value['per_surname'];
                                      echo "<tr>";
                                      echo "<td>".
                                              "
                                                      <a class='user-profile hoverbox'>
                                                        <img src='".$person->checkPicture(__PATH_PICTURE__.$value['per_picture'])."'>".
                                                        $value['pn_name'].$value['per_name']." ".$value['per_surname']."
                                                      </a>
                                                 ".
                                      "</td>";
                                      // echo "<td>".
                                      //        $value['pn_name'].$value['per_name']." ".$value['per_surname']
                                      //       ."</td>";
                                      echo "<td>".$value['pm_name']."</td>";
                                      echo "<td>
                                             ".Createbar($cpcStatus3,$kpiStatus3,$value['per_cardno'])."
                                           
                                          </td>";
                                      echo "<td>".createButton($cpcStatus3,$kpiStatus3,$value['per_cardno'],$name,$year)."</td>";
                                      echo "<td class='text-center'>-</td>";
                                      echo "</tr>";
                                    }

                              echo '  </tbody>
                                    </table>';
                            }else {
                              echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                      <strong>เฉพาะผู้ที่มีผู้ใต้บังคัญบัญชา</strong> 
                                   </div>';
                            }
                            
                          ?>
           
                    <!-- Accept Table -->
                      </div>
                    </div>

                  </div> <!-- x_content -->
                </div>
                </div>
            </div>
                                <!-- END CPC Table -->


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

    <!-- Modal  confrim_bypass -->
    <div class="modal fade" id="modal-confrim_bypass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title text-info" id="myModalLabel_confrim_bypass">คะแนนประเมินตนเองของคุณ <span id="modal-name-confrim_bypass" class="text text-info"></span>  </h4>
            </div>
            <div class="modal-body" id="modal_body_confrim_bypass">
              <div class="row">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center;" colspan="2"><h4 class="text text-info">คะแนนประเมินตนเอง</h4></th>
                      <th style="text-align:center;" colspan="2"><h4 class="text text-info">คะแนนยืนยันโดยผู้บังคับบัญชา</h4></th>
                      
                    </tr>
                    <tr>
                      <th style="text-align:center;"><h5 class="text text-info">สมรรถนะ <span class="text text-danger cpc_percent_scoring"></span></h5></th>
                      <th style="text-align:center;"><h5 class="text text-info">ตัวชี้วัด <span class="text text-danger kpi_percent_scoring"></span></h5></th>
                      <th style="text-align:center;"><h5 class="text text-info">สมรรถนะ <span class="text text-danger cpc_percent_scoring"></span></h5></th>
                      <th style="text-align:center;"><h5 class="text text-info">ตัวชี้วัด <span class="text text-danger kpi_percent_scoring"></span></h5></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      
                      <td style="text-align:center;"><h3 class="text text-danger" id="user-cpc_score_result"> </h3>  </td>
                      <td style="text-align:center;"><h3 class="text text-danger" id="user-kpi_score_result"> </h3></td>
                    
                      <td style="text-align:center;"><h3 class="text text-success" id="head-cpc_score_result"> </h3>  </td>
                      <td style="text-align:center;"><h3 class="text text-success" id="head-kpi_score_result"> </h3> </td>
                    </tr>

                    <tr>
                      <td colspan="2" style="text-align:center;"><h2 class="text text-danger" id="user-scoreSum-cpc-kpi"> </h2> <small class="text text-info">คะแนน</small></td>
                      <td colspan="2" style="text-align:center;"><h2 class="text text-success" id="head-scoreSum-cpc-kpi"> </h2> <small class="text text-info">คะแนน</small></td>
                    </tr>

                   

                  </tbody>
                </table>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <form action="" method="post" name="frm_accept_all" id="frm_accept_all">
                      <input type="hidden" name="accept_per_cardno" id="accept_per_cardno"> 
                      <!-- <input type="hidden" name="accept_year" id="accept_year"> -->
                    </form>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4" id="div_accept_all">
                  <button type='button' class='btn btn-warning' id='btn_accept_all'  > ยืนยันด่วน</button>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
                
                <button type="button" id="btn-close-accept-all" class="btn btn-info" data-dismiss="modal" >Close</button>
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
    
    <!-- ฟังก์ชั่นกำหนดให้ cursor ไปรออยู่ท้าย text -->
    <script src="../vendors/put-cursor-at-end/put-cursor-at-end.js"></script>

    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>


      <!-- PNotify -->
      <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>


    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
 
<script>
$(".progress-bar").each(function(i){
  var idProgress = $(this).attr('id')
  progressBar("#"+idProgress)
// console.log(idProgress)
})

function progressBar(id) {
  var current_progress = 0;
  var interval = setInterval(function() {
  
  var bar_pause = $(id).attr('aria-pause')
    $(id)
    .css("width", current_progress + "%")
    .attr("aria-valuenow", current_progress)
    .text(current_progress + "%");
      if (current_progress >= bar_pause)
        clearInterval(interval);
    current_progress += 1;
  }, 10);
}

$('[data-toggle="popover"]').popover({
        trigger : 'hover',
        html : true,
        content : function () {
          var id = $(this).attr('data-id')
         content =  $("#"+id).html()
        
          return content
        }
});


function confrim_bypass(per_cardno,years,name) {
  $("#modal-confrim_bypass").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
  confrim_bypass_load(per_cardno,years,name)


}

function confrim_bypass_load(per_cardno,years,name) {
  $.ajax({
      type: "POST",
      url: "module/evaluation/accept-bypass-show.php",
      data: {"per_cardno":per_cardno,"years":years},
      dataType: "JSON",
      success: function (response) {
        $("#modal-name-confrim_bypass").html(name);
        $(".cpc_percent_scoring").html("("+response.cpc_ratio+")");
        $(".kpi_percent_scoring").html("("+response.kpi_ratio+")");
        $("#user-cpc_score_result").html(response.cpcSum2_user);
        $("#user-kpi_score_result").html(response.kpiSum2_user);
        $("#user-scoreSum-cpc-kpi").html("รวม "+response.scoreUser);
        if (response.cpcSum2_head  != null) {
          $("#head-cpc_score_result").html(response.cpcSum2_head);
        }else{
          $("#head-cpc_score_result").html("-");
        }

        if (response.kpiSum2_head  != null) {
          $("#head-kpi_score_result").html(response.kpiSum2_head);
        }else{
          $("#head-kpi_score_result").html("-");
        }

        if (response.scoreHead  != null) {
          $("#head-scoreSum-cpc-kpi").html("รวม "+response.scoreHead);
          $("#btn_accept_all").prop("disabled",true);
        }else{
          $("#head-scoreSum-cpc-kpi").html("-");
          $("#accept_per_cardno").val(per_cardno);
          // $("#accept_year").val(years);
          $("#btn_accept_all").prop("disabled",false);
        }

      }
    });
}

$("#btn_accept_all").click(function (e) { 
  // console.log("test")
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "module/evaluation/accept-bypass-save-all.php",
    data: $("#frm_accept_all").serialize(),
    dataType: "json",
    success: function (response) {
      $.ajax({
        type: "POST",
        url: "module/report_admin/ajax-query-get-table_year.php",
        data: {"years":$("#accept_year").val()},
        dataType: "JSON",
        success: function (resYear) {
          $.ajax({
                  url: "module/report_admin/ajax-query-update_score3.php",
                  dataType: "json",
                  type: "POST",
                  data: {"per_cardno":$("#accept_per_cardno").val(),
                          "per_personal":resYear.result.per_personal,
                          "cpc_score":resYear.result.cpc_score,
                          "cpc_score_result":resYear.result.cpc_score_result,
                          "kpi_score":resYear.result.kpi_score,
                          "kpi_score_result":resYear.result.kpi_score_result,
                          "kpi_comment":resYear.result.kpi_comment,
                          "idp_score":resYear.result.idp_score,
                          "start_evaluation":resYear.result.start_evaluation,
                          "end_evaluation":resYear.result.end_evaluation,
                          "table_year":resYear.result.table_year },
                  success: function (result) {
                    confrim_bypass_load($("#accept_per_cardno").val(),resYear.result.table_year,"")
                  },
                  error: function (textStatus, errorThrown) {
                          per_cardno_err.push(per_cardno) 
                          console.log(per_cardno_err)
                      }
                })
        }
      });
    }
  });
  
});

$("#btn_accept_all").popConfirm({
        title: "ยืนยันคะแนนทั้งหมด", // The title of the confirm
        content: "คุณแน่ใจที่จะยืนยันคะแนนทั้งหมดหรือไม่?", // The message of the confirm
        placement: "bottom", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ยืนยันทั้งหมด",
        noBtn: "ยกเลิก"
});

// $("#btn-close-accept-all").on("click", function () {
//   location.reload();
// });

</script>
  </body>
</html>

