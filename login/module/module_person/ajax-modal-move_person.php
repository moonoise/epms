<div id="orgPerson-show">
</div>
<div class="">
<form action="setting-person.php" class="form-horizontal form-label-left">
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">สำนัก/กอง :</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="movePerson-org_id" id="movePerson-org_id" class="form-control">
                <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
            </select> 
        </div>
        <div class="col-md-4 col-sm-4 col-xs-0"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">ต่ำกว่าสำนัก 1 ระดับ :</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="movePerson-org_id_1" id="movePerson-org_id_1" class="form-control">
                <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
            </select> 
        </div>
        <div class="col-md-4 col-sm-4 col-xs-0"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">ต่ำกว่าสำนัก 2 ระดับ :</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="movePerson-org_id_2" id="movePerson-org_id_2" class="form-control">
                <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
            </select> 
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
    </div>
</form>
</div>

<div class="">
    
        <div id="show-orgOnSelect" class="col-md-12 col-sm-12 col-xs-12" >

        </div>
    <br>
</div>

<script>

function movePerson_add_org(result,idOrg,rm) {
    if(rm == true){
      $(idOrg).children('option:not(:first)').remove();
    }
    if(result != ''){
    $.each(result,function(key,value){
        $(idOrg).append('<option value= ' + value['org_id'] + '>' + value['org_name'] + '</option>');
    });
    }
  }


var org_id = '77';
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id="+ org_id,
    success: function(result){
        movePerson_add_org(result,'#movePerson-org_id');
        movePersonShow()
    }
  });

  $("#movePerson-org_id").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
        movePerson_add_org(result,"#movePerson-org_id_1",true);
        movePerson_add_org('',"#movePerson-org_id_2",true);
        orgOnSelect(v)
    }
  });
});


$("#movePerson-org_id_1").change(function(){
  var v = $(this).val();
  $.ajax({
    url:"module/module_org/ajax.org.php",
    dataType:"json",
    data:"org_id=" + v,
    success:function(result){
        movePerson_add_org(result,"#movePerson-org_id_2",true);
        orgOnSelect(v)
    }
  });
});

$("#movePerson-org_id_2").change(function(){
  var v = $(this).val();
  orgOnSelect(v)
});


function orgOnSelect(org_id) {
    $.ajax({
        url: "module/module_person/ajax-modal-org_on_select.php",
        dataType: 'html',
        data: "org_id=" + org_id,
        success: function (result) {
            $("#show-orgOnSelect").html(result)
        }
    })
}

function movePersonSave(org_id) {
    var per_cardno = $("#modal-per_cardno").text()
    $.ajax({
        url: "module/module_person/ajax-modal-move_person-save.php",
        dataType: "json",
        data: "org_id="+org_id + "&per_cardno=" + per_cardno,
        success: function (result) {
            if (result.success == true) {
                movePersonShow()
                notify('ย้ายสังกัด','สำเร็จ '+ result.msg,'success')
            }else if(result.success == null){
                movePersonShow()
                notify('ย้ายสังกัด','ไม่สำเร็จ '+ result.msg,'danger',5000,false)
            }
        }
    })
}

function movePersonShow() {
    var per_cardno = $("#modal-per_cardno").text()
//    console.log(per_cardno+"test")
    $.ajax({
        url: "module/module_person/ajax-modal-move_person-show.php",
        dataType: "html",
        data: "per_cardno="+per_cardno,
        success: function (result) {
            $("#orgPerson-show").html(result)
        }
    })
}

</script>
