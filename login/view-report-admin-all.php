<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
include_once "module/myClass.php";

$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();

$myClass = new myClass;
$currentYear = $myClass->callYear();
$idpScoreTable = $currentYear['data']['idp_score'];
$yearID = $currentYear['data']['table_id'];
$year = $currentYear['data']['table_year'];
$personalTable = $currentYear['data']['per_personal'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$detailYear = $currentYear['data']['detail'];

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))) ){ 
  header("location:disallow.php");
}else 
{
//  $success =  groupUsers($_SESSION[__USER_ID__]);
//  if (($success['success'] === true)   ) {
//     if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
//        $gOrg_id = $success['result']['org_id'];
//     }else 
//     {
//       $gOrg_id = '77';
//     }
//  }
//  echo "<pre>";
//    print_r($success);
// echo "</pre>";

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
    .progress {
        margin: 5px;
        width: 150px;
        color: crimson;
        
      }
    .progress-bar{
      color: crimson;
    }
    div .input-group{
      margin-bottom: 0px; */
    }
    .table>tbody>tr>td{
      padding: 4px;
    }
    div .checkbox {
    margin-top: 1px;
    margin-bottom: 1px;
    }
    span.fa.setting-icon {
    display: inline-block;
    }

  

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
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <a class="btn btn-app" id="btn-update-score">
                          <div class="fas-app"> <i class="fas fa-sync-alt blue"></i> </div>
                          <b class="royalblue">อัพเดทความคืบหน้า</b>
                        </a>
                        <a class="btn btn-app" id="btn-complete-report">
                          <div class="fas-app"> <i class="fas fa-chart-bar red"></i> </div>
                          <b class="green">รายงานความคืบหน้า</b>
                        </a>
                        <form method="post" name="form_update_score_all" id="form_update_score_all">
                          <input type="hidden" name="years" value="<?php echo $yearID  ;?>">
                          <input type="hidden" name="org_id" value="<?php echo $_SESSION[__ADMIN_ORG_ID__];?>">
                          <input type="hidden" name="org_id_1" value="<?php echo $_SESSION[__ADMIN_ORG_ID_1__];?>">
                          <input type="hidden" name="org_id_2" value="<?php echo $_SESSION[__ADMIN_ORG_ID_2__];?>">
                        </form>
                      </div>
                     
                    </div>
                    <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="progress" data-toggle="popover" data-id="test" data-placement='right'>
                          <div id="percent_completeID"  class='progress-bar progress-bar-success progress-bar-striped active' 
                            role='progressbar' aria-pause="" 
                            aria-valuenow='0' aria-valuemin='0' 
                            aria-valuemax='100' style='width: 0%'>
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <span id="personTotalID" class="text text-info"></span>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-2">
                        <span id="cpcTotalID" class="text text-info"></span>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-2">
                        <span id="kpiTotalID" class="text text-info"></span>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-2">
                        <span id="login_status" class="text text-info"></span>
                      </div>

                    </div>


                   
                   
                      <div class="row">
                        <form class="" method="POST" id="form-select-org" >  <!-- action="setting-person.php" -->
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                  
                            <label for="org_id">สำนัก/กอง /ต่ำกว่าสำนัก 1 ระดับ :</label>
                            <select name="org_id" id="org_id" class="form-control">
                              <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
                              <option value="<?php echo $gOrg_id;?>" >เลือกทั้งหมด</option>
                            </select> 
                        
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                          <label for="org_id_1"><small>ต่ำกว่าสำนัก 1 ระดับ / ต่ำกว่าสำนัก 2 ระดับ :</small></label>
                          <select name="org_id_1" id="org_id_1" class="form-control">
                            <option value="" selected="" >เลือก สังกัด</option>
                          </select> 
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 form-group ">
                      
                          <label for="org_id_1">ต่ำกว่าสำนัก 2 ระดับ :</label>
                          
                          <select name="org_id_2" id="org_id_2" class="form-control">
                            <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                          </select> 
                        </div>
                        
                     

                      <div class="col-md-5 col-sm-5 col-xs-5" >
                          <label for="selectYears" class="control-label col-md-3 col-sm-3 col-xs-3 form-group">ปีงบประมาณ:</label>
                        <div class="col-md-9 col-sm-9 col-xs-9 form-group">  
                          <select name="selectYears" id="selectYears" class="form-control">
                          </select>
                          </div>
                      </div>

                      <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                          <!-- <input type="submit" value"เลือก" class="btn btn-primary" style="margin-top: 25px;"> -->
                          <button type="button" class="form-control btn btn-primary" id="submit-org" >เลือก</button>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1">

                        </div> 
                        <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" id="checkbox-filter-not-complete" > ยังไม่เสร็จ
                            </label>
                          </div>
                        </div> 
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" id="checkbox-filter-complete" > เสร็จแล้ว
                            </label>
                          </div>
                        </div> 

                      </form>
                    </div>
                      <div class="row">
                        <table id="example" class="table table-hover table-bordered" style="width:100%">
                          <thead>
                              <tr class="bg-info">
                                <th class="col-md-1 col-sm-1 col-xs-1">เลขบัตรประชาชน</th>
                                <th class="col-md-3 col-sm-3 col-xs-3">ชื่อ-สกุล</th>
                                <th class="col-md-2 col-sm-2 col-xs-2">ตำแหน่ง</th>
                                <th class="col-md-2 col-sm-2 col-xs-2">สถานะ</th>
                                <th class="col-md-4 col-sm-4 col-xs-4">#</th> 
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


 <!-- Modal  update-score -->
 <div class="modal fade" id="modal-update-score" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> </button>
            
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังอัพเดทคะแนน  กรุณารอ.... <span class="modal-name text-success"></span></h4>
        </div>
        <div class="modal-body" id="modal-body-update-score">
            <div id="id1"><p>จำนวนรายชื่อทั้งหมด <b class='text-info' id="id3"></b> ราย </p></div>
            <div id="id4" ></div>
            <div class="panel-body" runat="server" style="overflow-y: scroll; height: 500px">
                <div class="mid-width wrapItems" style="background-color:#eee; height:1000px">

                    <div  runat="server" width="100%">
                    <ol id="id2" reversed>
                    </ol>
                    </div>
                    <!-- <div id="Test2" runat="server" width="100%">test2</div> -->
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>




<div id="message"></div>
<form action="module/report_admin/export-rid135-all-new.php" name="report_cpc135" id="report_cpc135" target="tab_cpc135" method="post">
  <input type="hidden" name="per_cardno" id="per_cardno">
  <input type="hidden" name="years" id="years_cpc135">
</form>

<form action="module/report_admin/export-kpi135-1-new.php" name="report_kpi135" id="report_kpi135" target="tab_kpi135" method="post">
  <input type="hidden" name="per_cardno" id="per_cardno_kpi135">
  <input type="hidden" name="years" id="years_kpi135">
</form>

<form action="module/report_admin/export-rid135-2-1-new.php" name="report_cpc135_2" id="report_rid135-2" target="tab_rid135" method="post">
  <input type="hidden" name="per_cardno" id="per_cardno_rid135-2">
  <input type="hidden" name="years" id="years_rid135-2">
</form>

<form action="view-percent_complete-department.php" name="view_percent_complete" id="view_percent_complete" target="view_percent_complete" method="post">
  <input type="hidden" name="yyears">
  <input type="hidden" name="ABorg_id">
  <input type="hidden" name="ABorg_id_1">
  <input type="hidden" name="ABorg_id_2">
</form>

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

    <script src="module/module_person/org_code.js"></script>
    <script> 

$(document).ready(function () {

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
   

  $.ajax({
    type: "POST",
    url: "module/report_admin/ajax-load-json-years.php",
    dataType: "JSON",
    success: function (response) {
      var c = "";
      $.each(response.result, function (indexInArray, valueOfElement) { 
        // var y = valueOfElement["table_year"].split("-");
        // var y543 = parseInt(y[0]) + 543
        if (valueOfElement['default_status'] == 1) {
          c = "selected"
        }else{
          c = ""
        }
         $("#selectYears").append("<option value=\""+valueOfElement['table_id']+"\" "+c+">"+valueOfElement['detail_short']+" </option>");
        // console.log(valueOfElement['cpc_score'])
      });
    }
  });

  $.ajax({
    type: "POST",
    url: "module/report_admin/ajax-query-person-get_per_cardno.php",
    data: $("#form_update_score_all").serialize(),
    dataType: "JSON",
    success: function (response) {
   
      // response.result
      // console.log(response.result)
      percent_complete_view(response.result,response.table_year.cpc_score_result,response.table_year.kpi_score_result,response.table_year.table_year,response.login_status_0_count)
     
    
    }
  });
});  //ready function

function percent_complete(org_id,org_id_1,org_id_2,years) {
  $.ajax({
    type: "POST",
    url: "module/report_admin/ajax-query-person-get_per_cardno.php",
    data: {"years":years,"org_id":org_id,"org_id_1":org_id_1,"org_id_2":org_id_2},
    dataType: "JSON",
    success: function (response) {
   
      // response.result
      // console.log(response.result)
      percent_complete_view(response.result,response.table_year.cpc_score_result,response.table_year.kpi_score_result,response.table_year.table_year,response.login_status_0_count)
     
    
    }
  });
}


function percent_complete_view(arr_per_cardno,cpc_score_result,kpi_score_result,table_year,login_status_0_count) {
  $.ajax({
        type: "POST",
        url: "module/report_admin/ajax-percent_complete.php",
        data: {
                "arr_per_cardno": arr_per_cardno,
                "cpc_score_result": cpc_score_result,
                "kpi_score_result": kpi_score_result,
                "table_year": table_year
                },
        dataType: "JSON",
        success: function (response) {
          // console.log(response)
          $("#percent_completeID").attr("aria-pause", response.percentComplete);
          $("#personTotalID").html("จำนวนรายชื่อผู้รับการประเมิน: "+response.personCount+" คน");
          $("#cpcTotalID").html("ประเมินสมรรถนะเสร็จ: "+response.cpcComplete+" คน");
          $("#kpiTotalID").html("ประเมินตัวชี้วัดเสร็จ: "+response.kpiComplete+" คน");
          $("#login_status").html("ไม่ต้องรับการประเมิน: "+login_status_0_count+" คน");
          progressBar("#percent_completeID")
          // console.log(response.msg)
        },
          error: function (textStatus, errorThrown) {
            $("#percent_completeID").attr("aria-pause", 0);
            $("#personTotalID").html("จำนวนรายชื่อผู้รับการประเมิน: "+0+" คน");
            $("#cpcTotalID").html("ประเมินสมรรถนะเสร็จ: "+0+" คน");
            $("#kpiTotalID").html("ประเมินสมรรถนะเสร็จ: "+0+" คน");
            $("#login_status").html("ไม่ต้องรับการประเมิน: "+0+" คน");
            progressBar("#percent_completeID") 
              }
      });
}

function add_org(result,idOrg,rm) {
  
    if(rm == true){
      $(idOrg).children('option:not(:first)').remove();
    }
    if(result != ''){
    $.each(result,function(key,value){
        $(idOrg).append('<option value= ' + value['org_id'] + '>' + value['org_name'] + '</option>');
    });
   
    }
  }

var org_id_default = "<?php echo $gOrg_id;?>";
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id="+ org_id_default,
    success: function(result){
      add_org(result,'#org_id');
     
    }
  });

$.ajax({
      url:"module/module_person/ajax-query-person2.php",
      dataType: "json",
      type: "POST",
      data: "org_id="+ org_id,
      success: function (result) {
        $("#message").html("");
        if (result.success == true) {
          t.clear().rows.add(result.data).draw();
        }
      },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
    });



$("#org_id").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org(result,"#org_id_1",true);
      add_org('',"#org_id_2",true);
     
    }
  });
});


$("#org_id_1").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org(result,"#org_id_2",true);
    }
  });
});

var c = [ ["","","","",""] ]  // set default row=0 ,  Everytime datatable ajax active
// drawCallback: kpiConfrim,
var t =  $('#example').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:0},
                  {data:1},
                  {data:2},
                  {data:3},
                  {data:4}
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
        'pageLength': 10,
        "lengthMenu": [[10, 25, 50,100,150,200, -1], [10, 25, 50,100,150,200, "All"]]
      })

$("#submit-org").click(function(){
 
  var org_id = $("#org_id").val();
  var org_id_1 = $("#org_id_1").val();
  var org_id_2 = $("#org_id_2").val();
  var selectYears = $("#selectYears").val();
    $.ajax({
      url:"module/report_admin/ajax-query-person-report.php",
      dataType: "json",
      type: "POST",
      data: $("#form-select-org").serialize(),
      success: function (result) {
        $("#message").html("");
        // var countData =  Object.keys(result.data).length;
        // console.log(countData)
        if (result.success == true) {
          t.clear().rows.add(result.data).draw();
          percent_complete(org_id,org_id_1,org_id_2,selectYears)
        }else {
          t.clear().rows.add(c).draw();
          percent_complete(org_id,org_id_1,org_id_2,selectYears)
        }
        
      },
        beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
    })
})


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

function cpc135(per_cardno,years) {

 $("#per_cardno").val(per_cardno)
 $("#years_cpc135").val(years)

 $("#report_cpc135").submit();
  
}

function kpi135(per_cardno,years) {
  $("#per_cardno_kpi135").val(per_cardno)
 $("#years_kpi135").val(years)

 $("#report_kpi135").submit();
}

function cpc135_2(per_cardno,years) {
  $("#per_cardno_rid135-2").val(per_cardno)
 $("#years_rid135-2").val(years)

 $("#report_rid135-2").submit();
}




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


    var  per_cardno_err = [];
    var i;
    var count = 0;
    $("#btn-update-score").on("click", function () {

      $("#modal-update-score").modal({
          show:true,
          keyboard:false,
          backdrop:'static'
        })

      $("#modal-update-score").on("shown.bs.modal", function (e) {
        // var Aorg_id = $("#org_id option:selected").val();
        // var Aorg_id_1 = $("#org_id_1 option:selected").val();
        // var Aorg_id_2 = $("#org_id_2 option:selected").val();

        var Aorg_id = $( "#form-select-org select[name$='org_id']" ).val();
        var Aorg_id_1 = $( "#form-select-org select[name$='org_id_1']" ).val();
        var Aorg_id_2 = $( "#form-select-org select[name$='org_id_2']" ).val();

        var AselectYears = $("#selectYears option:selected").val();
        if (empty(Aorg_id) && empty(Aorg_id_1)  && empty(Aorg_id_2)  ) {
          var aaa = $("#form_update_score_all").serialize()
          // console.log("test1")
        }else{
          var aaa = {"org_id":Aorg_id,"org_id_1":Aorg_id_1,"org_id_2":Aorg_id_2,"years":AselectYears}
          // console.log("test2")
        }
        // console.log(aaa)
       
        $.ajax({
          type: "POST",
          url: "module/report_admin/ajax-query-person-get_per_cardno.php",
          data: aaa,
          dataType: "JSON",
          success: function (response) {
            // console.log(response.result)
            if (response.success == true) {
              
              // arrPer_cardno = JSON.parse(response.result)
              arrPer_cardno = response.result
              count = count + arrPer_cardno.length
              // console.log(response.table_year)
              // console.log(count)
              $("#id3").html(count)
              arrPer_cardno.forEach(function(per_cardno){
                // console.log(arrPer_cardno)
                                // var e =  $("#id2").append("<li></li>")
                $.ajax({
                    url: "module/report_admin/ajax-query-update_score3.php",
                    dataType: "json",
                    type: "POST",
                    data: {"per_cardno":per_cardno,
                            "per_personal":response.table_year.per_personal,
                            "cpc_score":response.table_year.cpc_score,
                            "cpc_score_result":response.table_year.cpc_score_result,
                            "kpi_score":response.table_year.kpi_score,
                            "kpi_score_result":response.table_year.kpi_score_result,
                            "kpi_comment":response.table_year.kpi_comment,
                            "idp_score":response.table_year.idp_score,
                            "start_evaluation":response.table_year.start_evaluation,
                            "end_evaluation":response.table_year.end_evaluation,
                            "table_year":response.table_year.table_year },
                    success: function (result) {
                        $("#id2").prepend("<li>"+result.result+"</li>") 
                    },
                    error: function (textStatus, errorThrown) {
                            per_cardno_err.push(per_cardno) 
                        }
                })
              })
              count = 0
              arrPer_cardno = [];
              // console.log(arrPer_cardno)

            } // endif response.success == true
          }
        });

        // $("#id4").prepend('')
        $("#id4").html('หลังจาก โหลดข้อมูลเสร็จข้อมูลยังไม่ครบให้คลิ๊กเพิ่มที่นี้ <a class="btn btn-warning btn-xs" onclick="queryPersonal()"> โหลดอีกครั้ง</a>')
      
      });
        
    });
   
    $("#modal-update-score").on('hidden.bs.modal', function(){
      $("#id2 li").remove()
      location.reload();
      // console.log("test")
    });

    function queryPersonal(){
    // console.log($("#form_update_score_all").serialize())
      $.ajax({
        type: "POST",
        url: "module/report_admin/ajax-query-get-table_year.php",
        data: $("#form_update_score_all").serialize(),
        dataType: "JSON",
        success: function (response) {
          // console.log(response.result.per_personal)
          if (response.success == true) {
            per_cardno_err.forEach(function(per_cardno){
        
              $.ajax({
                      url: "module/report_admin/ajax-query-update_score3.php",
                      dataType: "json",
                      type: "POST",
                      data: {"per_cardno":per_cardno,
                              "per_personal":response.data.per_personal,
                              "cpc_score":response.data.cpc_score,
                              "cpc_score_result":response.data.cpc_score_result,
                              "kpi_score":response.data.kpi_score,
                              "kpi_score_result":response.data.kpi_score_result,
                              "kpi_comment":response.data.kpi_comment,
                              "idp_score":response.data.idp_score,
                              "start_evaluation":response.data.start_evaluation,
                              "end_evaluation":response.data.end_evaluation,
                              "table_year":response.data.table_year },
                      success: function (result) {
                        $("#id2").prepend("<li>"+result.result+"</li>")
                        i = per_cardno_err.indexOf(per_cardno.toString())
                        delete per_cardno_err[i]
                      },
                      error: function (textStatus, errorThrown) {
                            // per_cardno_err.push(per_cardno)  
                          }
                      })
              })
          }
        }
      });        
    }

    $("#btn-update-score").popConfirm({
      title: "อัพเดท ความคืบหน้าการประเมิน", // The title of the confirm
      content: "อัพเดทได้เฉพาะมีงบประมาณปัจจุบัน อาจใช้เวลานาน กรุณารอ...", // The message of the confirm
      placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
      container: "body", // The html container
      yesBtn: "อัพเดท",
      noBtn: "ยกเลิก"
  });



  $("#btn-complete-report").on("click", function () {
   var org = ""
   var arr_org_id = []
    var Aorg_id = $( "#form-select-org select[name$='org_id']" ).val();
    var Aorg_id_1 = $( "#form-select-org select[name$='org_id_1']" ).val();
    var Aorg_id_2 = $( "#form-select-org select[name$='org_id_2']" ).val();
    

    if (empty(Aorg_id)  && empty(Aorg_id_1)   && empty(Aorg_id_2)  ) {
      // var aaa = $("#form_update_score_all").serialize()
      $("#view_percent_complete input[name$='ABorg_id']" ).val($("#form_update_score_all input[name$='org_id']" ).val()); 
      $("#view_percent_complete input[name$='ABorg_id_1']" ).val($("#form_update_score_all input[name$='org_id_1']" ).val()); 
      $("#view_percent_complete input[name$='ABorg_id_2']" ).val($("#form_update_score_all input[name$='org_id_2']" ).val()); 
      $("#view_percent_complete input[name$='yyears']" ).val($("#form_update_score_all input[name$='years']" ).val()); 
      
      
    }else{
      $("#view_percent_complete input[name$='ABorg_id']" ).val($( "#form-select-org select[name$='org_id']" ).val()); 
      $("#view_percent_complete input[name$='ABorg_id_1']" ).val($( "#form-select-org select[name$='org_id_1']" ).val()); 
      $("#view_percent_complete input[name$='ABorg_id_2']" ).val($( "#form-select-org select[name$='org_id_2']" ).val()); 

      $("#view_percent_complete input[name$='yyears']" ).val($("#form-select-org select[name$='selectYears']" ).val()); 
    }
    // console.log(empty(Aorg_id))
    // console.log(Aorg_id)
    // console.log(Aorg_id_1)
    // console.log(Aorg_id_2)
    // console.log(AselectYears)
    // console.log(org)
    $("#view_percent_complete").submit();

  });

  $('#checkbox-filter-complete').on('ifChecked', function(event){
      // alert(event.type + ' callback');
      
      $("#checkbox-filter-not-complete").iCheck("uncheck")
      t.search("เสร็จแล้ว").draw()
      // console.log('on')
    });
  $('#checkbox-filter-complete').on('ifUnchecked', function(event){
    // alert(event.type + ' callback');
    t.search("").draw()
    // console.log('off')
  });

  $('#checkbox-filter-not-complete').on('ifChecked', function(event){
      // alert(event.type + ' callback');
      $("#checkbox-filter-complete").iCheck("uncheck")
      t.search("ยังไม่เสร็จ").draw()
      // console.log('on')
    });
  $('#checkbox-filter-not-complete').on('ifUnchecked', function(event){
    // alert(event.type + ' callback');
    t.search("").draw()
    // console.log('off')
  });

  // console.log( $("#checkbox-filter-complete").iCheck("check") )
  

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


       