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
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
  <style>
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
              <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>รอบการประเมินที่ <?php $part = explode("-",__year__); echo $part[1];?> ประจำปีงบประมาณ <?php echo $part[0]+543;?> </strong> 
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <div class="row">
                    
                    <form class="" method="POST" id="form-select-org" >  <!-- action="setting-person.php" -->
                   
                      <div class="row">
                      
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  
                            <label for="org_id">สำนัก/กอง /ต่ำกว่าสำนัก 1 ระดับ :</label>
                            <select name="org_id" id="org_id" class="form-control">
                              <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
                              <option value="<?php echo $gOrg_id;?>" >เลือกทั้งหมด</option>
                            </select> 
                        
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                          <label for="org_id_1"><small>ต่ำกว่าสำนัก 1 ระดับ / ต่ำกว่าสำนัก 2 ระดับ :</small></label>
                          <select name="org_id_1" id="org_id_1" class="form-control">
                            <option value="" selected="" >เลือก สังกัด</option>
                          </select> 
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12 form-group ">
                      
                          <label for="org_id_1">ต่ำกว่าสำนัก 2 ระดับ :</label>
                          
                          <select name="org_id_2" id="org_id_2" class="form-control">
                            <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                          </select> 
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                          <!-- <input type="submit" value"เลือก" class="btn btn-primary" style="margin-top: 25px;"> -->
                          <button type="button" class="btn btn-primary" id="submit-org" style="margin-top: 25px;">เลือก</button>
                        </div>  
                
                      </div>
                    </form>

                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4">
                        <form  name="searchName" id="searchName">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="ค้นหาจาก ชื่อ-สกุล" name='per_name' id="search-per_name">
                              <input type="hidden" value="<?php echo $gOrg_id;?>" name="org_id" >
                              <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary" id="submit-searchName">ค้นหา</button>
                              </span>
                          </div>
                        </form>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-4">
                      <form  name="searchID" id="searchID">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="เลขบัตรประชาชน" name="per_cardno">
                              <input type="hidden" value="<?php echo $gOrg_id;?>" name="org_id" >
                              <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary"  id="submit-searchID">ค้นหา</button>
                              </span>
                            </div>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-4">
                        
                    </div>
          
         
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                  <thead>
                      <tr class="bg-info">
                        <th class="col-md-1 col-sm-1 col-xs-1">เลขบัตรประชาชน</th>
                        <th class="col-md-3 col-sm-3 col-xs-3">ชื่อ-สกุล</th>
                        <th class="col-md-3 col-sm-3 col-xs-3">ตำแหน่ง</th>
                        <th class="col-md-5 col-sm-5 col-xs-5">#</th> 
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


 <!-- Modal  KPI -->
 <div class="modal fade" id="modal-kpi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังแก้ไขตัวชี้วัดของ คุณ <span class="modal-name text-success"></span></h4>
        </div>
        <div class="modal-body" id="modal-body-kpi">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>

 <!-- Modal  cpc -->
 <div class="modal fade" id="modal-cpc" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังแก้ไขสมรรถนะ ของ คุณ <span class="modal-name text-success"></span></h4>
        </div>
        <div class="modal-body" id="modal-body-cpc">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        </div>
        </div>
    </div>
</div>

 <!-- Modal  Change ORG -->
 <div class="modal fade" id="modal-movePerson" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังแก้ไขสังกัด ของ คุณ <span class="modal-name text-success"></span> (<span id="modal-per_cardno" class="text-warning"></span>)</h4>
        </div>
        <div class="modal-body" id="modal-body-movePerson">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
            
        </div>

        </div>
    </div>
</div>

<!-- Modal  Change Head -->
<div class="modal fade" id="modal-settingHead" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังแก้ไขผู้ใต้บังคับ บัญชา ของ คุณ <span class="modal-name text-success"></span> (<span id="modal-per_cardno-settingHead" class="text-warning"></span>)</h4>
        </div>
        <div class="modal-body" id="modal-body-settingHead">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
            
        </div>

        </div>
    </div>
</div>

<!-- Modal  Change Head 2 -->
<div class="modal fade" id="modal-settingHead-2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title text-info" id="myModalLabel">คุณกำลังกำหนดผู้บังคับบัญชาของคุณ <span class="modal-name text-success"></span> (<span id="modal-per_cardno-settingHead-2" class="text-warning"></span>)</h4>
        </div>
        <div class="modal-body" id="modal-body-settingHead-2">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
            
        </div>

        </div>
    </div>
</div>
 

<!-- Modal  Clear score -->
<div class="modal fade" id="modal-clear-score" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">คุณกำลังล้างคะแนนของ คุณ <span class="modal-name"></span> (<span id="modal-per_cardno-clear-score" class="text-warning"></span>)</h4>
        </div>
        <div class="modal-body" id="modal-body-clear-score">
            
    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
            
        </div>

        </div>
    </div>
</div>


<!-- Modal  setting profile -->
<div class="modal fade" id="modal-setting-profile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">คุณแก้ไขข้อมูลส่วนตัวของ คุณ <span class="modal-name"></span> (<span id="modal-per_cardno-setting-profile" class="text-warning"></span>)</h4>
        </div>
        <div class="modal-body" id="modal-body-setting-profile">
            
    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >ปิด</button>
            
        </div>

        </div>
    </div>
</div>

<div id="message"></div>


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
function kpiChange(per_cardno,name,org_id) {
  
  if (org_code[org_id]) {
    var org_code_name = org_code[org_id]
  }else{
    var org_code_name = ""
  }
  $.ajax({
    url: "module/kpi/ajax-modal-edit-kpi.php",
    dataType: "html",
    data:"per_cardno="+per_cardno,
    success: function (data) {  
      $("#modal-body-kpi").html(data)
      $(".modal-name").html(name)
      $("#modal-kpi").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
      $("#show-question").DataTable({
        'pageLength': 4,
        "lengthMenu": [[4,10, 25, 50, -1], [4,10, 25, 50, "All"]],
        'lengthChange': true
        
      }).search(org_code_name).draw()
      
      refreshTableKpiScore(per_cardno)
    }
  });
}

// cpc modal
function cpcChange(per_cardno,pl_code,level_no,name) {
  $.ajax({
    url: "module/cpc/ajax-modal-cpc_score.php",
    dataType: "html",
    data: "per_cardno="+per_cardno+"&pl_code="+pl_code+"&level_no="+level_no,
    success: function(data){
      $("#modal-body-cpc").html(data)
      $("#modal-cpc").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
      $("#show-cpc-question").DataTable({
        'pageLength': 4,
        "lengthMenu": [[4,10, 25, 50, -1], [4,10, 25, 50, "All"]],
        'lengthChange': true
      })
      $(".modal-name").html(name)
      refreshTableCpcScore(per_cardno)
    }
  })
}




function kpiAdd(per_cardno,kpi_code) {
  $.ajax({
    url: "module/kpi/ajax-kpi-add.php",
    dataType: "json",
    data: "per_cardno="+per_cardno+"&kpi_code="+kpi_code,
    success: function (data) {
      //console.log('test')
      if (data.success == true) {
        // $('#dialog p').html("เพิ่มข้อมูลเรียบร้อย").slideDown("slow").delay(3000).slideUp("slow")
        refreshTableKpiScore(per_cardno)
        notify('การเพิ่มหัวข้อ','สำเร็จ','success')
      }else if(data.success == false){
        // $('#dialog p').html("Error "+data.msg).slideDown("slow").delay(9000).slideUp("slow");
        notify('การเพิ่มหัวข้อ','หัวข้อนี้มีอยู่แล้ว ไม่สามารถเพิ่มได้','warning')
      }else if (data.success == null) {
        notify('การเพิ่มหัวข้อ','หัวข้อนี้มีอยู่แล้ว ไม่สามารถเพิ่มได้ '+data.msg,'warning')
      }
    }
  })
}

function refreshTableKpiScore(per_cardno){
  //console.log('test')
  $.ajax({
    url: "module/kpi/ajax-modal-kpi-score-show.php",
    dataType: "json",
    data: "per_cardno="+per_cardno,
    success: function (r) {
      //console.log(r.success)
      if (r.success == true) {
        $("#kpi-score-person").html(r.html)
        var s =  weightSum()
         $("#weightSum").html(s)
      }else if(r.success == false){
        $("#kpi-score-person").html(r.msg)
      }
    }
  })
}
//  $(".test").click(function(){
//         $(".test1").modal({
//           show:true,
//           keyboard:false,
//           backdrop:'static'
//         });
//     });

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

var org_id_default = '<?php echo $gOrg_id;?>';
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
    })



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

var c = [ ["","","",""] ]  // set default row=0 ,  Everytime datatable ajax active

var t =  $('#example').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:0},
                  {data:1},
                  {data:2},
                  {data:3}
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
        ],
        'pageLength': 10,
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]]
      })

$("#submit-org").click(function(){
  var c = [ ["","","",""] ] 
    $.ajax({
      url:"module/module_person/ajax-query-person2.php",
      dataType: "json",
      type: "POST",
      data: $("#form-select-org").serialize(),
      success: function (result) {
        $("#message").html("");
        if (result.success == true) {
          t.clear().rows.add(result.data).draw();
        }else  if (result.success == false){
          t.clear().rows.add(c).draw();
        }
      },
        beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
    })
})

$("#searchName").submit(function(event){
  var c = [ ["","","",""] ] 
    $.ajax({
      url:"module/module_person/ajax-query-person-name.php",
      dataType: "json",
      type: "POST",
      data: $("#searchName").serialize(),
      success: function (result) {
        $("#message").html("");
        if (result.success == true) {
        t.clear().rows.add(result.data).draw();
        }else  if (result.success == false){
          t.clear().rows.add(c).draw();
        }
      },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
    });
    event.preventDefault();
});

$("#searchID").submit(function(event){
  var c = [ ["","","",""] ] 
    $.ajax({
      url:"module/module_person/ajax-query-person-id.php",
      dataType: "json",
      type: "POST",
      data: $("#searchID").serialize(),
      success: function (result) {
        $("#message").html("");
        if (result.success == true) {
          t.clear().rows.add(result.data).draw();
        }else  if (result.success == false){
          t.clear().rows.add(c).draw();
        }
      },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
    });
    event.preventDefault();
});



//การ save weight 
function saveWeight(getID,kpi_score_id,per_cardno) {
  var w = $('input[name="'+getID+'"]').val()
 // var we =  $(".class-weight").attr('id')
  //console.log(w)
  //w = Number(w)
  $.ajax({
      url: "module/kpi/ajax-kpi-weight-update.php",
      dataType: "json",
      data: "kpi_score_id="+kpi_score_id+"&weight="+w+"&per_cardno="+per_cardno,
      success: function (result) {
        refreshTableKpiScore(per_cardno)
        if (result.success == true) {
          if (w == 0) {
            notify('กำหนดค่าน้ำหนัก',' คุณยังไม่ได้กำหนดค่าน้ำหนัก!!','warning')
            $("#weight-"+kpi_score_id).removeClass("bg-success")
            $("#weight-"+kpi_score_id).addClass("bg-danger")
          }else{
            notify('กำหนดค่าน้ำหนัก','สำเร็จ','success')
            $("#weight-"+kpi_score_id).removeClass("bg-danger")
            $("#weight-"+kpi_score_id).addClass("bg-success")
          }
        }else if (result.success == false) {
          notify('กำหนดค่าน้ำหนัก',result.msg,'danger',8000)
          $("#weight-"+kpi_score_id).removeClass("bg-success")
          $("#weight-"+kpi_score_id).addClass("bg-danger")
        }else if(result.success == null){
          notify('กำหนดค่าน้ำหนัก',' เกิดข้อผิดพลาดค่าน้ำหนักต้องเป็นตัวเลขเท่านั้น!!'+result.msg,'danger',4000)
          $("#weight-"+kpi_score_id).removeClass("bg-success")
          $("#weight-"+kpi_score_id).addClass("bg-danger")
          
        }
      }
  })
  
}

//delQuestionScore() ลบ CPC  แบบ ไม่ลบจริงใส่ค่าเป็น 0 แทน
function delQuestionScore(kpi_score_id,per_cardno) {
  $.ajax({
    url: "module/kpi/ajax-kpi-weight-softDelete.php",
    dataType: "json",
    data: "kpi_score_id="+kpi_score_id,
    success: function (result) {
        refreshTableKpiScore(per_cardno)
       
      }
  })
}

function weightSum() {
  var sum = 0
  var idArray = []
    $('.class-weight').each(function () {
      
      sum += parseInt ($('input[name="weight['+idArray.push(this.id)+']"]').val()   )
    })
    // console.log(sum)
    return sum
}

//ส่วนของ CPC SCORE  -----------------------------------------------------------------------------



function cpcDefault(per_cardno,pl_code,level_no) {

  $.ajax({
        url: "module/cpc/cpc_score_default_delete.php",
        dataType: "json",
        data: "per_cardno="+per_cardno+"&pl_code="+pl_code+"&level_no="+level_no,
        success: function (result){
          $("#message").html("");
          if (result.success === true) {
            $("#cpc-score-person").html("")
            refreshTableCpcScore(per_cardno)
            notify('การตั้งค่า','สำเร็จ ','success')
          }else if(result.success === false){
            $("#cpc-score-person").html("")
            refreshTableCpcScore(per_cardno)
            notify('การตั้งค่า','ไม่สำเร็จ '+ result.msg,'warning')
          }else if(result.success === null){
            notify('การตั้งค่า','ไม่สำเร็จ '+ result.msg,'danger')
          }
        },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
        }
      })
}

function refreshTableCpcScore(per_cardno) {
  $.ajax({
    url: "module/cpc/ajax-modal-cpc_score-show.php",
    dataType: "html",
    data: "per_cardno="+per_cardno,
    success: function (result) {
      $("#cpc-score-person").html(result)
    }
  })
}

function cpcAdd(per_cardno,question_no,pl_code,level_no) {
  $.ajax({
    url: "module/cpc/ajax-modal-cpc_score-add.php",
    dataType: "json",
    data: "per_cardno="+per_cardno+"&question_no="+question_no+"&pl_code="+pl_code+"&level_no="+level_no,
    success: function (result) {
      console.log(result)
      if (result.success === null) {
        refreshTableCpcScore(per_cardno)
        notify('การเพิ่มหัวข้อ','เกิดข้อผิดพลาด กรุณาแจ้งเจ้าหน้าที่','danger')
      }else if(result.success === true){
        refreshTableCpcScore(per_cardno)
        notify('การเพิ่มหัวข้อ','สำเร็จ','success')
      }else if(result.success === false){
        refreshTableCpcScore(per_cardno)
        notify('การเพิ่มหัวข้อ','ไม่สำเร็จ มีหัวข้อนี้อยู่แล้ว','warning')
      }
    }
  })
}

// ลบ cpc_score ทีละ record
function delCpcScore(cpc_score_id,per_cardno) {
  $.ajax({
    url: "module/cpc/ajax-modal-cpc_score-del.php",
    dataType: "json",
    data: "cpc_score_id="+cpc_score_id,
    success: function (result) {
      if (result.success === true) {
        refreshTableCpcScore(per_cardno)
        notify('การลบหัวข้อ','สำเร็จ','warning')
      }else if(result.success === false){
        refreshTableCpcScore(per_cardno)
        notify('การลบหัวข้อ','ไม่สำเร็จ','danger')
      }else if (result.success === null) {
        refreshTableCpcScore(per_cardno)
        notify('การลบหัวข้อ','ไม่สำเร็จ '+ result.msg,'danger')
      }
    }
  })
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

 
 function movePerson(per_cardno,name) {
  $.ajax({
    url: "module/module_person/ajax-modal-move_person.php",
    dataType: "html",
    data:"per_cardno="+per_cardno,
    success: function (data) {
      
      $("#modal-body-movePerson").html(data)
      $(".modal-name").html(name)
      $("#modal-per_cardno").html(per_cardno)
      $("#modal-movePerson").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
      $("#message").html("");  
    },
      beforeSend: function () {
            $("#message").html("<div class='loading'>Loading&#8230;</div>");
    }
  });
 }

function settingHead(per_cardno,name) { //กำหนดผู้ใต้บังคับ บัญชา 
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head.php",
    dataType: "html",
    data: "per_cardno=" + per_cardno,
    success: function (data) {
      $("#modal-body-settingHead").html(data)
      $(".modal-name").html(name)
      load_head_1(per_cardno)
      $("#modal-per_cardno-settingHead").html(per_cardno)
      $("#modal-per_cardno-settingHead-input").val(per_cardno)
      $("#modal-settingHead").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
      
    }
  })
}

function subordinateShow(head) {
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head-subordinate-show.php",
    type: "GET",
    dataType: "html",
    data: "head="+head,
    success: function (result) {
      $("#table-setting-head-subordinate").html(result)
    }
  })
}
// เป็น public เพื่อเอาไว้  refresh เวลาเปลี่ยนผู้บังคัญบัญชา
var v_org_id = "";
var v_org_id_1 = "";
var v_org_id_2 = "";
var v_head = "";
function personHead_show(org_id,org_id_1,org_id_2,head) {
v_org_id = org_id;
v_org_id_1 = org_id_1;
v_org_id_2 = org_id_2;
v_head = head;
  $.ajax({
    url:"module/module_person/ajax-modal-setting_head-subordinate.php",
    type: "POST",
    dataType:"json",
    data:{"org_id-head": org_id,"org_id_1-head":org_id_1,"org_id_2-head":org_id_2,"modal-per_cardno-settingHead-input":head},
    success:function(result){
      datatable.clear().rows.add(result.data).draw();
      //  datatable.drow();
      //  return result.data
      
      subordinateShow(head)
      $(".confirm-change-head").popConfirm({
        title: "เพ่ิมรายชื่อ", // The title of the confirm
        content: "คุณต้องการเพิ่มรายชื่อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
        });
    }
  });
}



function delSubordinate(per_cardno) {
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head-subordinate-del.php",
    type: "GET",
    dataType: "json",
    data: "per_cardno="+per_cardno,
    success: function (result) {
      if (result.success==true) {
        notify('การลบผู้ใต้บังคัญ บัญชา','สำเร็จ','warning')
      }else if(result.success == false){
        notify('การลบผู้ใต้บังคัญ บัญชา','ไม่สำเร็จ '+result.msg,'danger')
      }else if(result.success == null){
        notify('การลบผู้ใต้บังคัญ บัญชา','ไม่สำเร็จ '+result.msg,'danger')
      }
      subordinateShow($("#modal-per_cardno-settingHead").text())
      refresh_h()
    }
  })
}

function changeHead(per_cardno) {
  var head = $("#modal-per_cardno-settingHead").text();
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head-subordinate-add.php",
    type: "GET",
    dataType: "json",
    data: "per_cardno="+per_cardno + "&head="+ head,
    success: function (result) {
      
      if (result.success==true) {
        notify('การเพิ่มรายชื่อ','สำเร็จ','success')
      }else if(result.success == false){
        notify('การเพิ่มรายชื่อ','ไม่สำเร็จ','danger')
      }
      subordinateShow(head)
      refresh_h()
    }
  })
}



function clearScore(per_cardno,per_name){
  $.ajax({
    url:"module/module_person/ajax-modal-clear_score.php",
    type:"POST",
    dataType:"html",
    data:{"per_cardno":per_cardno},
    success: function (result) {
      $(".modal-name").html(per_name)
      $("#modal-per_cardno-clear-score").html(per_cardno)
      $("#modal-body-clear-score").html(result)
      $("#modal-clear-score").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
    }
  })
}


function lock_login(per_cardno,id) {

  $.ajax({
      url:"module/module_person/ajax-lock-login.php",
      type: "POST",
      dataType:"json",
      data:{"per_cardno":per_cardno},
      success: function (result) {
        if(result.success == true){
          if (result.result  == 1) {
            $("#"+id).removeClass("btn-danger")
            $("#"+id).attr("data-original-title","ใช้งานได้ปกติ")
            $("#"+id).addClass("btn-default")
            $("#"+id+" span").addClass("green")

            notify('การใช้งาน','ปกติ','success')

          }else if (result.result  == 0){
            $("#"+id).addClass("btn-danger")
            $("#"+id).attr("data-original-title","ระงับการใช้งาน")
            $("#"+id).removeClass("btn-default")
            $("#"+id+" span").removeClass("green")

            notify('การใช้งาน','ถูกระงับเรียบร้อย','warning')
          }
        }else if(result.success == false ){
          notify('เกิดข้อผิดพลาด',result.msg,'danger')
        }else if (result.success == null ){
          notify('เกิดข้อผิดพลาด',result.msg,'danger')
        }
          
      }
  })
}

function divisor(cpc_score_id) {
  var val_d = $("#divisor-"+cpc_score_id).val();
    if(val_d != "" && $.isNumeric(val_d) == true && val_d > -1 && val_d <= 5 ) {
      $.ajax({
        url: "module/cpc/ajax-modal-cpc_score-divisor-save.php",
        type: "POST",
        dataType:"json",
        data:{"cpc_score_id":cpc_score_id,"val_divisor":val_d},
        success: function (result) {
          if(result.success == true){
            notify('ค่าคาดหวัง','บันทึกสำเร็จ','success')
            $("#divisor-"+cpc_score_id).removeClass("bg-danger")
            $("#divisor-"+cpc_score_id).addClass("bg-success")
          }else {
            notify('ค่าคาดหวัง','เกิดข้อผิดพลาด'+result.msg,'warning')
            $("#divisor-"+cpc_score_id).removeClass("bg-success")
            $("#divisor-"+cpc_score_id).addClass("bg-danger")
          }
        }
      });
    }else {
      notify('ค่าคาดหวัง','กรุณาใส่ค่าคาดหวัง และต้องไม่เกิน 1-5','warning')
      $("#divisor-"+cpc_score_id).addClass("bg-danger")
      $("#divisor-"+cpc_score_id).val("")
    }
}

//แก้ไขข้อมูลส่วนตัว  เปลี่ยนสถานะ การผ่อนทดลองงาน
function through_trial(per_cardno) {
  $.ajax({
      url:"module/module_person/ajax-through_trial-status.php",
      type: "POST",
      dataType:"json",
      data:{"per_cardno":per_cardno},
      success: function (result) {
        if(result.success == true){
          if (result.result  == 1) {
            $("#tr-"+per_cardno).removeClass("btn-danger")
            $("#tr-"+per_cardno).attr("data-original-title","สถานะ ผ่านทดลองงานแล้ว")
            $("#tr-"+per_cardno).addClass("btn-default")
            $("#tr-"+per_cardno+" span").addClass("blue")

            $("#tr2-"+per_cardno).text("")

            notify('การทดลองงาน','ผ่านช่วงทดลองงานแล้ว','success')

          }else if (result.result  == 2){
            $("#tr-"+per_cardno).removeClass("btn-default")
            $("#tr-"+per_cardno).addClass("btn-danger")
            $("#tr-"+per_cardno).attr("data-original-title","สถานะ ยังไม่ผ่านทดลองงาน")
            $("#tr-"+per_cardno+" span").removeClass("blue")
            $("#tr2-"+per_cardno).text("ยังไม่ผ่านทดลองงาน")
            notify('การทดลองงาน','ยังไม่ผ่านช่วงทดลองงาน','warning')

          }
        }else if(result.success == false ){
          notify('เกิดข้อผิดพลาด',result.msg,'danger')
        }else if (result.success == null ){
          notify('เกิดข้อผิดพลาด',result.msg,'danger')
        }
          
      }
  })
}

function settingHead2(per_cardno,name) { //กำหนดผู้ใต้บังคับ บัญชา 
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head2.php",
    dataType: "html",
    data: "per_cardno=" + per_cardno,
    success: function (data) {
      $(".modal-name").html(name)
      $("#modal-body-settingHead-2").html(data)
      $("#modal-per_cardno-settingHead-2").html(per_cardno)
      $("#modal-per_cardno-settingHead-input-2").val(per_cardno)
      load_head(per_cardno)
      $("#modal-settingHead-2").modal({
        show:true,
        keyboard:false,
        backdrop:'static'
      })
      
    }
  })
}

function personHead_show2(org_id,org_id_1,org_id_2,head) {
  $.ajax({
    url:"module/module_person/ajax-modal-setting_head2-subordinate.php",
    type: "POST",
    dataType:"json",
    data:{"org_id-head": org_id,"org_id_1-head":org_id_1,"org_id_2-head":org_id_2,"modal-per_cardno-settingHead-input-2":head},
    success:function(result){
      datatable.clear().rows.add(result.data).draw();
      //  datatable.drow();
      //  return result.data
     
      $(".confirm-change-head").popConfirm({
        title: "เปลี่ยนผู้บังคับบัญชา", // The title of the confirm
        content: "คุณต้องการเปลี่ยนผู้บังคับบัญชา จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
        });
    }
  });
}

function changeHead2(per_cardno) {
  var per_cardno_user = $("#modal-per_cardno-settingHead-2").text();
  $.ajax({
    url: "module/module_person/ajax-modal-setting_head2-change.php",
    type: "POST",
    dataType: "json",
    data: {"per_cardno":per_cardno_user,"head":per_cardno},
    success: function (result) {
      load_head(per_cardno_user)
      if (result.success==true) {
        notify('การเพิ่มรายชื่อ','สำเร็จ','success')
      }else if(result.success == false){
        notify('การเพิ่มรายชื่อ','ไม่สำเร็จ','danger')
      }
      // subordinateShow(head)
    }
  });
}
    </script>
  </body>
</html>


       