<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class.permission.php";


if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5))) ){ 
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
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
     <!-- jQuery custom content scroller -->
     <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

      <!-- NProgress -->
      <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

      <!-- iCheck -->
      <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">


    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <link href="../vendors/bootstrap-wysiwyg/css/style.css" rel="stylesheet" />

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
        <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ประชาสัมพันธ์ <small>...</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>

                    <table id="datatable_news" class="table table-striped table-bordered dataTable no-footer">
                      <thead>
                      <tr>
                        <th >#</th>
                        <th >หัวข้อ</th>
                        <th > #
                        </th>
                      </tr>
                      </thead>

                      <tbody>
                    
                      </tbody>

                  </table>

                  </div>
                </div>
              </div>
            </div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ข่าวสารหน้าแรก<small>..</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="container">
        
                         
                          <button type="button" class="btn btn-info btn-sm"
                            onclick="News()" 
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="" 
                            data-original-title="สร้างใหม่">
                            <span class="fa fa-file-text text-default setting-icon" aria-hidden="true"></span>
                            <span class="text-default">News </span> <span class="red">*</span>
                          </button>
                          
                        <form  method="post" enctype="multipart/form-data" id='submitForm'>
                        <label for="new_title">หัวข้อข่าว * :</label>
                        <input type="text" id="new_title" class="form-control" name="new_title">
                        <div class="btn-toolbar" data-role="editor-toolbar"
                          data-target="#editor">
                          <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                              <li><a data-edit="fontSize 5" class="fs-Five">Huge</a></li>
                              <li><a data-edit="fontSize 3" class="fs-Three">Normal</a></li>
                              <li><a data-edit="fontSize 2" class="fs-Two">Normal-2</a></li>
                              <li><a data-edit="fontSize 1" class="fs-One">Small</a></li>
                              
                            </ul>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                            <a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                            <a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                            <a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                            <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                            <a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-outdent"></i></a>
                            <a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                            <a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                            <a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                            <a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                          </div>
                          <!--  <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                            <div class="dropdown-menu input-append">
                              <input placeholder="URL" type="text" data-edit="createLink" />
                              <button class="btn" type="button">Add</button>
                            </div>
                          </div> -->
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
                            <span class="btn btn-default" title="Insert picture (or just drag & drop)" id="pictureBtn"> <i class="fa fa-picture-o"></i>
                              <input class="imgUpload" type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                            </span>
                          </div> -->
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                            <a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                            <a class="btn btn-default" data-edit="html" title="Clear Formatting"><i class='glyphicon glyphicon-pencil'></i></a>
                          </div>
                        </div>
                        <div id="editorPreview"></div>
                        
                        
                            <div id="editor" class="lead" data-placeholder="This is a basic example with a simple toolbar."></div>
                            <a class="btn btn-large btn-info jumbo" href="#!" onClick="$('#mySubmission').val($('#editor').cleanHtml(true));$('#submitForm').submit();">บันทึก</a>
                          <input type='hidden' name='formSubmission' id='mySubmission'/>
                          <input type='hidden' name='id_news' id='id_news'/>
                        </form>
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

   <!-- PNotify -->
   <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

 <!-- Datatables -->
 <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

 <!-- bootstrap-wysiwyg -->
     <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

<!-- PopConfirm -->
    <script src="../vendors/Simple-Action-Confirmation-Plugin-With-jQuery-Bootstrap-PopConfirm/jquery.popconfirm.js"></script>

  </body>
</html>

<script>

  loadNews();
$('#editor').wysiwyg(
  {
    'form':
    {
      'text-field': 'mySubmission',
      'seperate-binary': false
    }
  }
);
		
$(".dropdown-menu > input").click(function (e) {
      e.stopPropagation();
});




  $("#submitForm").submit(function(event){
    
    if( $("#mySubmission").val() != ""  && $("#new_title").val() != ""){
      $.ajax({
          url: "module/news/ajax-news-update.php",
          dataType: "json",
          type: "POST",
          data: $("#submitForm").serialize(),
          success: function (result) {
            console.log(result.success)
            if(result.success == true){
              notify("เพิ่มข่าว","สำเร็จ","success");
              loadNews()
              $("#submitForm")[0].reset()
              $("#editor").html("")
            }else{
              notify("เพิ่มข่าว","เกิดข้อผิดพลาด"+result.msg,"danger");
            }
          }
        })
        
    }else{
      notify("เพิ่มข่าว","กรุณากรอกข้อมูลให้ครบถ้วน","danger");
    }
    event.preventDefault();
  });

  var c = [ ["","",""] ]  // set default row=0 ,  Everytime datatable ajax active
var t =  $('#datatable_news').DataTable({
        "data":c,
        "deferRender": true,
        "autoWidth": true,
        columns: [
                  {width: '5%' , data:0},
                  {width: '75%' , data:1},
                  {width: '20%' , data:2}
                ],
        "fixedColumns": true,
        'pageLength': 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      })

function loadNews(){
  $.ajax({
              url: "module/news/ajax-news-datatable-show.php",
              dataType:"json",
              type: "POST",
              success: function (result) {
                t.clear().rows.add(result.data).draw();
                // console.log(result.data)
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



function editNewShow(new_id) {
  $.ajax({
    url: "module/news/ajax-edit-news-show.php",
    dataType: "json",
    type: "POST",
    data: "id_new="+new_id,
    success: function (result) { 
      // console.log(result.result.new_content) 
      $("#editor").html(result.result.new_content)
      $("#new_title").val(result.result.new_title)
      $("#id_news").val(result.result.new_id)
    }
  });
}

function deleteNew(new_id){
  $.ajax({
    url: "module/news/ajax-news-delete.php",
    dataType:"json",
    type: "POST",
    data: "id_new="+new_id,
    success: function (result) {
      loadNews()
    }
  });
}

function News(){
  $("#editor").html("")
  $("#new_title").val("")
  $("#id_news").val("")
}

function newPublic(new_id){
  $.ajax({
    url: "module/news/ajax-news-public-update.php",
    dataType:"json",
    type: "POST",
    data: "new_id="+new_id,
    success: function (result) {
      loadNews()
    }
  });
}
</script>
