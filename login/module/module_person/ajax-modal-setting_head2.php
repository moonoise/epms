<?php 
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-person.php";
 ?>
<?php require "../../includes/class.permission.php";

session_start();
if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))) ){ 
  header("location:disallow.php");
}

activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
   
?>
    <form  class="" method="POST" id="form-setting-head-2" name="form-setting-head-2">
    <input type="hidden" id="modal-per_cardno-settingHead-input-2" name="modal-per_cardno-settingHead-input-2">
    <div class="row">
    
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">

            <label for="org_id">สำนัก/กอง :</label>
            <select name="org_id-head2" id="org_id-head2" class="form-control">
                <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
            </select> 

        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <label for="org_id_1">ต่ำกว่าสำนัก 1 ระดับ :</label>
            <select name="org_id_1-head2" id="org_id_1-head2" class="form-control">
                <option value="" disabled="" selected="" hidden="">ต่ำกว่าสำนัก 1 ระดับ</option>
            </select> 
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12 form-group ">
        <label for="org_id_1">ต่ำกว่าสำนัก 2 ระดับ :</label>
            <select name="org_id_2-head2" id="org_id_2-head2" class="form-control">
                <option value="" disabled="" selected="" hidden="">ต่ำกว่าสำนัก 2 ระดับ</option>
            </select> 
        </div>

        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
           
            <button type="button" class="btn btn-primary" style="margin-top: 25px;" id="btnOrg2">เลือก</button>
        </div>  
</div>
</form>
<br>
<table id='table-setting-head-2' class='table table-striped table-bordered display' style='width:100%'>
  <thead>
    <tr class="info">
      <th>เลขบัตรประชาชน</th>
      <th>ชื่อ-สกุล</th>
      <th>ตำแหน่ง</th>
      <th>#</th> 
    </tr>
  </thead>
</table>


<br>
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
    <img src="" alt="" class="img-circle img-responsive center-block" style="width: 90px;" id="modal-name-head-image">

    <h4 class="text-info" id="modal-name-head2"></h4>
    <p>(ผู้บังคับบัญชา)</p>

    <span class="fa fa-arrow-down fa-3x"></span>
    <img src="" alt="" class="img-circle img-responsive center-block" style="width: 90px;" id="modal-name-subordinate-image">

    <h4 class="text-info" id="modal-name-subordinate"></h4>
    <p>(ผู้ใต้บังคับบัญชา)</p>
</div>


<script>

function add_org_head(result,idOrg,rm) {
    if(rm == true){
      $(idOrg).children('option:not(:first)').remove();
    }
    if(result != ''){
    $.each(result,function(key,value){
        $(idOrg).append('<option value= ' + value['org_id'] + '>' + value['org_name'] + '</option>');
    });
    }
  }
 

var org_id_head2 = 77;
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id="+ org_id_head2,
    success: function(result){
      add_org(result,'#org_id-head2');
     
    }
  });

$("#org_id-head2").change(function(){
  var v = $(this).val();
  
  $.ajax({
    url:"module/module_user/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org_head(result,"#org_id_1-head2",true);
      add_org_head('',"#org_id_2-head2",true);
     
    }
  });
});


$("#org_id_1-head2").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_user/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
      add_org_head(result,"#org_id_2-head2",true);
    }
  });
});

var c = [ ["","","",""] ]  // set default row=0 ,  Everytime datatable ajax active

var datatable =  $('#table-setting-head-2').DataTable({
        "data":c,
        "deferRender": true,
        "columns": [
                  {data:0},
                  {data:1},
                  {data:2},
                  {data:3}
                ],
        'pageLength': 4,
        "lengthMenu": [[4,10, 25, 50, -1], [4,10, 25, 50, "All"]]
      })

var b = $("#btnOrg2").click(function() {
  // datatable.draw();
  $.ajax({
    url:"module/module_person/ajax-modal-setting_head2-subordinate.php",
    type: "POST",
    dataType:"json",
    data:$("#form-setting-head-2").serialize(),
    success:function(result){
      datatable.clear().rows.add(result.data).draw();
      //  datatable.drow();
      //  return result.data
      $(".confirm-change-head-2").popConfirm({
        title: "เพ่ิมรายชื่อ", // The title of the confirm
        content: "คุณต้องการเพิ่มรายชื่อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
        });
    }
  });
});

function load_head(per_cardno) {
    $.ajax({
        url:"module/module_person/ajax-modal-setting_head2-picture-json.php",
        type: "POST",
        dataType:"json",
        data:{"per_cardno":per_cardno},
        success: function(result){
            if(result.success){
                $("#modal-name-head2").html(result.head_name)
                $("#modal-name-head-image").prop("src",result.head_picname)
                $("#modal-name-subordinate").html(result.name)
                $("#modal-name-subordinate-image").prop("src",result.picname)
            }
        }

    });
}

</script>


