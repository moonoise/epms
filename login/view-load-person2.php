<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/ociConn.php";
include_once "includes/class.permission.php";



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
}elseif ($success['success'] === false) {
    if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
        $per_cardno = $_SESSION[__USER_ID__];
        $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
        
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
            
                                   
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3><i class="fa  fa-wrench green"></i> <b style="color:red">L</b>oad Person <small> .. </small></h3>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <button type="button" class="btn btn-app" id="confirm-load-person">
                        <i class="fa fa-play green"></i> โหลดข้อมูลผู้ประเมิน
                    </button>
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
    var  per_cardno_err = [];
    var i;

    function queryPersonal(){
    
        per_cardno_err.forEach(function(per_cardno){
        // var e =  $("#id2").append("<li></li>")
            $.ajax({
                url: "module/module_dpis/ajax-insert-personal.php",
                dataType: "json",
                type: "POST",
                data: {"per_cardno":per_cardno},
                success: function (result) {
                    $("#id2").prepend("<li>"+result.msg+"</li>")
                    i = per_cardno_err.indexOf(per_cardno.toString())
                    delete per_cardno_err[i]

                },
                error: function (textStatus, errorThrown) {
                    // per_cardno_err.push(per_cardno) 
                    }
            })
        })
    }

    $("#confirm-load-person").on("click",function(){
    
    // var arrPer_cardno2 = ['3720700411664'] ;

    var arrOrg_id = [];
    var count = 0;
   $.ajax({
       url:"module/module_dpis/ajax-load-org_id.php",
       dataType: "json",
       type: "POST",
       success: function (org_id) {
           org_id.forEach(function(r){
            // arrOrg_id.push(r.org_id)
                $.ajax({
                        url: "module/module_dpis/ajax-load-per_cardno.php",
                        datatype: "json",
                        type: "POST",
                        data:{"org_id":r.org_id},
                        success: function (result) {
                             arrPer_cardno = JSON.parse(result)
                            //  console.log(result)
                            count = count + arrPer_cardno.length
                            $("#id3").html(count)
                            arrPer_cardno.forEach(function(per_cardno){
                                // var e =  $("#id2").append("<li></li>")
                                $.ajax({
                                    url: "module/module_dpis/ajax-insert-personal.php",
                                    dataType: "json",
                                    type: "POST",
                                    data: {"per_cardno":per_cardno},
                                    success: function (result) {
                                        $("#id2").prepend("<li>"+result.msg+"</li>")
                                    },
                                    error: function (textStatus, errorThrown) {
                                            per_cardno_err.push(per_cardno) 
                                        }
                                })
                                    
                            })
                        }
                    })
                
           })
           
       }
   })
   $("#id4").prepend('หลังจาก โหลดข้อมูลเสร็จข้อมูลยังไม่ครบให้คลิ๊กเพิ่มที่นี้ <a class="btn btn-warning btn-xs" onclick="queryPersonal()"> โหลดอีกครั้ง</a>')
// console.log(per_cardno_err)

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

     $(" #confirm-load-person").popConfirm({
        title: "เพิ่มรายชื่อเข้าระบบทั้งหมด", // The title of the confirm
        content: "ระบบจะโหลดข้อมูลจาก <b class='text-info'>ระบบ DPIS</b> เข้าการประเมิน<b class='text-info'> ปี รอบ </b>ตัวปัจจุบัน หากรายชื่อไหนมีอยู่ระบบแล้วจะไม่ลบออกและเข้าทำการอัพเดทแทน", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "โหลด",
        noBtn: "ไม่โหลด"
        });

</script>