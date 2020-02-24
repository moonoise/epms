<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";
    
    if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6))) ){ 
      header("location:disallow.php");
    }else {

      $success =  groupUsers($_SESSION[__USER_ID__]);
    if (($success['success'] === true)   ) {
        if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
          $gOrg_id = $success['result']['org_id'];
        }else 
        {
          $gOrg_id = '77';
        }

        if ($success['result']['group_id'] == 4) {
          $s = "<option value='4'>ผู้ดูแลสูงสุด(Super Admin)</option>
                <option value='5'>ผู้ดูแลระบบ (Admin)</option>
                <option value='6'>ผู้ดูแล ระดับ สำนัก/กอง (Sub Admin)</option>
                <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>";
        }elseif ($success['result']['group_id'] == 5) {
          $s = "<option value='6'>ผู้ดูแล ระดับ สำนัก/กอง (Sub Admin)</option>
                <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>";
          
        }elseif ($success['result']['group_id'] == 6) {
          $s = "
                <option value='7'>ผู้ดูแล ระดับต่ำกว่า สำนัก/กอง (Low admin)</option>";

             $admin6_Org_id = $success['result']['org_id'];
                
        }
    }
      activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
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

    <title>User</title>

      <!-- Bootstrap -->
      <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- NProgress -->
      <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
      <!-- iCheck -->
      <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
       <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>
      <!-- Datatables -->
      <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
        <!-- PNotify -->
        <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <style>
      .file {
    visibility: hidden;
    position: absolute;
    }
    </style>

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
   

          <!-- ////////////////////////////////////// -->
      <div class="right_col" role="main">

       <!-- row add user -->
      <div class="row">  
        <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>เพิ่มผู้ดูแลระบบ <small>ระบบ สำนัก / กอง ต่ำกว่า สำนัก-กอง</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content x_content_default">
                    <br>
                    <form class="form-horizontal form-label-left input_mask" data-parsley-validate="" id="form">
                        <input type="hidden" name="head_admin" value="<?php echo $_SESSION[__USER_ID__];?>">
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="user_name" name="user_name" placeholder="User Name" required="" data-parsley-required-message="กรุณาใส่ชื่อ Account">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>


                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="password" class="form-control has-feedback-left" id="password1" name="password1" placeholder="PassWord" required="" data-parsley-required-message="กรุณาใส่ password" data-parsley-minlength-message="ใส่ Password 6 ตัวขึ้นไป" data-parsley-minlength="6" >
                        <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="password" class="form-control has-feedback-left" id="password2" name="password2" data-parsley-equalto="#password1" placeholder="PassWord" required="" data-parsley-equalto-message="Password 2 ช่องไม่เหมือนกัน" data-parsley-required-message="กรุณาใส่ password">
                        <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="email" placeholder="อีเมลล์" name="email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback ui-widget"> 
                        <input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="ชื่อ" for="fname" required="" data-parsley-required-message="กรุณาใส่ชื่อ ชื่อผู้ใช้งาน">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

    
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="tel" name="tel" placeholder="โทรศัพท์">
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <select class="form-control" id="org_id"  name="org_id" required="" data-parsley-required-message="กรุณาเลือก สำนักฯ ">
                      <option value="" disabled="" selected="" hidden="">เลือก สังกัด</option>
                          </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <select class="form-control" id="org_id_1" name="org_id_1">
                            <option value="">เลือก สังกัด</option>
                            
                          </select>
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-xs-12">
                      <select class="form-control" id="org_id_2" name="org_id_2">
                            <option value="">เลือก สังกัด</option>
                            
                          </select>
                      </div>

                     <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                      <select class="form-control" id="user_group" name="user_group" required="" data-parsley-required-message="กรุณาเลือกระดับผู้ใช้งาน">
                            <option value="" disabled="" selected="" hidden="">เลือก กลุ่มผู้ใช้งาน</option>
                            <?php echo $s;?>
                          </select>
                      </div>

                       <!-- <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      
                      <input type="file" name="img" id="img" class="file">
                      <div class="input-group col-xs-12">
                        <span class="input-group-addon "><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control input-md" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                          <button class="browse btn btn-primary input-md" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                        </span>
                      </div>
  
                      </div>  -->


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary">Cancel</button>
						   
                       <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success" id="submit_adduser">Submit</button>
                        </div>
                      </div>

                    </form>

                    
                     
                      <div id="log"></div>
                   

                  </div>
                </div>
              </div>
      </div>  
        <!-- row add user -->
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Users <small>รายชื่อสมาชิกในระบบ</small></small></h3>
          </div>
          
        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>เฉพาะผู้ดูแลระบบ </h2>
                
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <p class="text-muted font-13 m-b-30">
                 ส่วนนี้เป็นหน้าสำหรับจัดการสมาชิกภายในกลุ่ม
                </p>
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                     <th>Username-Email</th>
                      <th>ชื่อ - สกุล</th>
                      <th>กลุ่มผู้ใช้งาน</th>
                      <th>สำนัก-กอง</th>
                      <th>รูป</th>
                      <th>#</th>
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
      <!-- /page content -->

      <!-- footer content -->
      <?php
        include_once('template/footer-content.php');
      ?>
      <!-- /footer content -->
    </div>
  </div>
  </body>
</html>
     <!-- jQuery -->
     <script src="../vendors/jquery/dist/jquery.min.js"></script>
     <!-- Bootstrap -->
     <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
     <!-- FastClick -->
     <script src="../vendors/fastclick/lib/fastclick.js"></script>
      <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
     <!-- NProgress -->
     <script src="../vendors/nprogress/nprogress.js"></script>
     <!-- iCheck -->
     <script src="../vendors/iCheck/icheck.min.js"></script>
     <!-- Datatables -->
     <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
     <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
     <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>


       <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
     <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>
  <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
  <script src="../vendors/jquery-ui-1.12.1/jquery-ui.min.js"></script>
   
  <script>
$('#form').parsley();

$(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});
$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});

    // function log( message ) {
    //   $( "<div>" ).text( message ).prependTo( "#log" );
    //   $( "#log" ).scrollTop( 0 );
    // }
    
    $( "#name" ).autocomplete({
      source: function( request, response ) {
        var name = $("#name").val();
        $.ajax( {
          url: "module/module_user/ajax.user.php",
          dataType: "json",
          data: "name="+ name,
          success: function( data ) {
            response( data );
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        // log( "Selected: " + ui.item.fname + "  " + ui.item.lname );
        console.log("Selected: " + ui.item.fname + "  " + ui.item.lname);
      }
    } );


  
  $(".x_content_default").css("display", "none");

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

  var org_id = '<?php echo $gOrg_id?>';
  $.ajax({
    url:"module/module_user/ajax.org.php",
    dataType:"json",
    data:"org_id="+ org_id,
    success: function(result){
      add_org(result,'#org_id');
      
    }
  });

$("#org_id").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_user/ajax.org.php",
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
    url:"module/module_user/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org(result,"#org_id_2",true);
    }
  });
});
        
        function showUser(org_id_admin6) {
          // console.log('test')
          $.ajax({
            url:"module/module_user/ajax.show-user.php",
            dataType: "json",
            type: "GET",
            data: "org_id_admin6="+org_id_admin6,
            success: function (result) {
              t.clear().rows.add(result.data).draw();
            }
          })
        }

  var org_id_admin6 = '<?php echo (!empty($admin6_Org_id) ? $admin6_Org_id : "");?>' ;
  showUser(org_id_admin6)

  var c = [ {"col_1":"","col_2":"","col_3":"","col_4":"","col_5":"","col_6":""} ];
  var t =  $('#datatable').DataTable({
              "data":c,
              "deferRender": true,
              "autoWidth": false,
              "columns": [
                        {"data":"col_1"},
                        {"data":"col_2"},
                        {"data":"col_3"},
                        {"data":"col_4"},
                        {"data":"col_5"},
                        {"data":"col_6"}
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
                }
              ],
              'pageLength': 10,
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });


        function processForm( e ){
          e.preventDefault();
            $.ajax({
                url: 'module/module_user/ajax.add-user.php',
                dataType: 'json',
                type: 'POST',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){

                    if(data.success == true){
                      $( '#form' ).each(function(){
                        this.reset();
                       });
                      $('#log').html(data.msg);
                     }
                     $('#log').html(data.msg);
                     showUser2()
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

            e.preventDefault();
        }

        $('#form').submit( processForm );
       



function user_edit(id) {
    
}

function showUser2(){
  showUser(org_id_admin6)
}

function user_del(id) {

  $.ajax({
    type: "POST",
    url: "module/module_user/ajax-user_del.php",
    data: {"id":id},
    dataType: "JSON",
    success: function (response) {
      if (response.success == true) {
        notify('การลบรายชื่อ','สำเร็จ','success')
        showUser2()
      }else if (response.success == null) {
        notify('การลบรายชื่อ','ไม่สำเร็จ','danger')
      }
     
    }
  });
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

