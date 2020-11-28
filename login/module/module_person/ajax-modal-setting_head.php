<?php
include_once '../../config.php';
include_once '../../includes/dbconn.php';

?>
<?php require "../../includes/class.permission.php";

session_start();
if (!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__], array(4, 5, 6, 7)))) {
  header("location:disallow.php");
}

activeTime($login_timeout, $_SESSION[__SESSION_TIME_LIFE__]);

?>
<form class="" method="POST" id="form-setting-head" name="form-setting-head">
  <input type="hidden" id="modal-per_cardno-settingHead-input" name="modal-per_cardno-settingHead-input">
  <div class="row">

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">

      <label for="org_id">สำนัก/กอง :</label>
      <select name="org_id-head" id="org_id-head" class="form-control">
        <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
      </select>

    </div>

    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
      <label for="org_id_1">ต่ำกว่าสำนัก 1 ระดับ :</label>
      <select name="org_id_1-head" id="org_id_1-head" class="form-control">
        <option value="" disabled="" selected="" hidden="">ต่ำกว่าสำนัก 1 ระดับ</option>
      </select>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12 form-group ">
      <label for="org_id_1">ต่ำกว่าสำนัก 2 ระดับ :</label>
      <select name="org_id_2-head" id="org_id_2-head" class="form-control">
        <option value="" disabled="" selected="" hidden="">ต่ำกว่าสำนัก 2 ระดับ</option>
      </select>
    </div>

    <div class="col-md-2 col-sm-12 col-xs-12 form-group">

      <button type="button" class="btn btn-primary" style="margin-top: 25px;" id="btnOrg">เลือก</button>
    </div>
  </div>
</form>
<br>
<table id='table-setting-head' class='table table-striped table-bordered display' style='width:100%'>
  <thead>
    <tr class="info">
      <th>
        <div class="checkbox checkbox-warning">
          <input id="headCheckAll" type="checkbox">
          <label for="headCheckAll" onclick="headCheckAll()"></label>
        </div>
      </th>
      <th>เลขบัตรประชาชน</th>
      <th>ชื่อ-สกุล</th>
      <th>ตำแหน่ง</th>
      <th>#</th>
    </tr>
  </thead>
</table>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <button type="button" id="add-select-subordinate" class="btn btn-info" onclick="addSubordinateArr()">เพิ่มที่เลือก</button>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-warning fa fa-refresh" onclick="refresh_h()"></button>

  </div>
</div>

<br>
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
  <img src="" alt="" class="img-circle img-responsive center-block" style="width: 90px;" id="head-image">
  <h4 class="text-success" id="modal-name-head"></h4>
  <p class="text text-info">(ผู้บังคับบัญชา)</p>
  <span class="fa fa-arrow-down fa-3x"></span>
  <p class="text text-info">(ผู้ใต้บังคับบัญชา)</p>
</div>


<table class="table table-striped table-bordered">
  <thead>
    <tr class="danger">
      <th class="">#</th>
      <th class="col-md-1 col-sm-1 col-xs-1">เลขบัตรประชาชน</th>
      <th class="col-md-8 col-sm-6 col-xs-6">ชื่อ-สกุล</th>
      <th class="col-md-8 col-sm-6 col-xs-6">ตำแหน่ง</th>

      <th class="col-md-2"><i class="fa fa-edit"></i></th>
    </tr>
  </thead>
  <tbody id="table-setting-head-subordinate">


  </tbody>
</table>

<script>
  function add_org_head(result, idOrg, rm) {
    if (rm == true) {
      $(idOrg).children('option:not(:first)').remove();
    }
    if (result != '') {
      $.each(result, function(key, value) {
        $(idOrg).append('<option value= ' + value['org_id'] + '>' + value['org_name'] + '</option>');
      });
    }
  }


  var org_id = 77;
  $.ajax({
    url: "module/module_org/ajax.org.php",
    dataType: "json",
    data: "org_id=" + org_id,
    success: function(result) {
      add_org(result, '#org_id-head');

    }
  });

  $("#org_id-head").change(function() {
    var v = $(this).val();

    $.ajax({
      url: "module/module_user/ajax.org.php",
      dataType: "json",
      data: "org_id=" + v,
      success: function(result) {
        add_org_head(result, "#org_id_1-head", true);
        add_org_head('', "#org_id_2-head", true);

      }
    });
  });


  $("#org_id_1-head").change(function() {
    var v = $(this).val();
    $.ajax({
      url: "module/module_user/ajax.org.php",
      dataType: "json",
      data: "org_id=" + v,
      success: function(result) {
        add_org_head(result, "#org_id_2-head", true);
      }
    });
  });

  var c = [
    ["", "", "", "", ""]
  ] // set default row=0 ,  Everytime datatable ajax active

  var datatable = $('#table-setting-head').DataTable({
    "data": c,
    "deferRender": true,
    "autoWidth": false,
    "columns": [{
        data: 0,
        "width": "5%"
      },
      {
        data: 1,
        "width": "20%"
      },
      {
        data: 2,
        "width": "35%"
      },
      {
        data: 3,
        "width": "35%"
      },
      {
        data: 4,
        "width": "5%"
      }
    ],
    'pageLength': 10,
    "lengthMenu": [
      [4, 10, 25, 50, -1],
      [4, 10, 25, 50, "All"]
    ]
  })

  var b = $("#btnOrg").click(function() {
    // datatable.draw();
    $.ajax({
      url: "module/module_person/ajax-modal-setting_head-subordinate.php",
      type: "POST",
      dataType: "json",
      data: $("#form-setting-head").serialize(),
      success: function(result) {
        datatable.clear().rows.add(result.data).draw();
        //  datatable.drow();
        //  return result.data
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
  });

  function load_head_1(per_cardno) {
    $.ajax({
      url: "module/module_person/ajax-modal-setting_head-picture-json.php",
      type: "POST",
      dataType: "json",
      data: {
        "per_cardno": per_cardno
      },
      success: function(result) {
        if (result.success) {
          $("#modal-name-head").html(result.head_name)
          $("#head-image").prop("src", result.head_picname)
        }
      }

    });
  }

  function headCheckAll() {
    if ($("#headCheckAll").prop("checked") == false) {
      //  console.log($("#cpcCheckAll").prop("checked"))
      $(".headSelectCheckbox").each(function() {
        id = $(this).attr("id")
        if ($("#" + id).prop("checked") == false) {
          $("#" + id).trigger("click")
        }
      })
    } else if ($("#headCheckAll").prop("checked") == true) {
      $(".headSelectCheckbox").each(function() {
        id = $(this).attr("id")
        if ($("#" + id).prop("checked") == true) {
          $("#" + id).trigger("click")
        }
      })
    }
  }

  var arrSubordinate = []
  var SubordinateIndex;

  function subordinateList(list, id) {
    if ($("#" + id).prop("checked") == true) {
      arrSubordinate.push(list)
    } else if ($("#" + id).prop("checked") == false) {
      SubordinateIndex = arrSubordinate.indexOf(list)
      delete arrSubordinate[SubordinateIndex]
    }
    console.log(arrSubordinate)
  }

  function addSubordinateArr() {
    var per_cardno_head = $("#modal-per_cardno-settingHead-input").val() // modal-per_cardno-settingHead-input
    $.ajax({
      url: "module/module_person/ajax-modal-setting_head_multi_add.php",
      type: "POST",
      dataType: "JSON",
      data: {
        "arrList": arrSubordinate,
        "per_cardno_head": per_cardno_head
      },
      success: function(result) {
        if (result.success == true) {
          notify('เพิ่มผู้ใต้บังคับบัญชา', 'สำเร็จ', 'success')
        } else if (result.success == false) {
          notify('เพิ่มผู้ใต้บังคับบัญชา', 'ไม่สำเร็จ', 'danger')
        }
        // console.log(result.success)
        subordinateShow(per_cardno_head)
        refresh_h()
      }
    })
  }

  function refresh_h() {
    personHead_show(v_org_id, v_org_id_1, v_org_id_2, v_head)
  }

  $("#add-select-subordinate").popConfirm({
    title: "เพิ่มผู้ใต้บังคัญบัญชา", // The title of the confirm
    content: "คุณต้องเพิ่มผู้ใต้บังคัญบัญชา จริงๆ หรือใหม่ ?", // The message of the confirm
    placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
    container: "body", // The html container
    yesBtn: "ใช่",
    noBtn: "ไม่"
  });
</script>