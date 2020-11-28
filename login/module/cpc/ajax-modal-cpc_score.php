<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-cpc.php";

?>
<!-- Modal -->
<button type='button' class="btn btn-app" data-toggle="confirmation" id="confirm-cpcDefault" onclick="cpcDefault(<?php echo "`" . $_GET['per_cardno'] . "`"; ?>)" <?php echo $_SESSION[__EVALUATION_ON_OFF__]; ?>>
    <i class="fa fa-gear blue"></i>ค่าเริ่มต้น!
</button>


<table id="show-cpc-question" class="table table-striped table-bordered">
    <thead>
        <tr class="info">
            <th>รหัส</th>
            <th>รายการสมรรถนะ <span class="text-warning">(ตัวเลือก)</span></th>
            <th>ประเภท</th>
            <th><i class="fa fa-save"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php

        $cpc = new cpc;
        $question_status = 1;
        $result = $cpc->cpcQuestionSelectAll($question_status);
        if ($result['success'] == true) {
            foreach ($result['result'] as $row) {
                echo "<tr>";
                echo "<td>" . $row['question_code'] . "</td>";
                echo "<td>" . $row['question_title'] . "</td>";
                echo "<td>" . $cpcType[$row['question_type']] . "</td>";
                echo "<td>
                                    <div class='input-group'>
                                    <button type='button' class='btn btn-info btn-xs confirm-add'  data-toggle='confirmation' 
                                    onclick='cpcAdd(`" . $_GET['per_cardno'] . "`,`" . $row['question_no'] . "`)' " . $_SESSION[__EVALUATION_ON_OFF__] . " >
                                    <i class='fa fa-plus-square'></i></button>
                                    </div>
                                 </td>
                            ";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>
<br>
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
    <h4 class="modal-title text-info" id="myModalLabel">สมรรถนะของคุณ <span class="modal-name text-success"></span></h4>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr class="danger">
            <th class="col-md-1 col-sm-1 col-xs-1">#</th>
            <th class="col-md-1 col-sm-1 col-xs-1">รหัส</th>
            <th class="col-md-7 col-sm-7 col-xs-7">รายการสมรรถนะ <span class="text-warning">(ที่กำหนดไว้)</span></th>
            <th class="col-md-2 col-sm-2 col-xs-2">ค่าคาดหวัง</th>
            <th class="col-md-1 col-sm-1 col-xs-1"><i class="fa fa-edit"></i></th>
        </tr>
    </thead>
    <tbody id="cpc-score-person">


    </tbody>
</table>

<script>
    $("#confirm-cpcDefault").popConfirm({
        title: "กำหนดหัวข้อสมถรรณะ โดยใช้ค่าเริ่มต้นของระบบ ?", // The title of the confirm
        content: "ระบบจะทำการล้างหัวข้อที่ตั้งค่าไว้ออก แล้วใส่หัวข้อใหม่ลงทำ จะทำให้หัวข้อและคะแนนเดิมลบออกไปด้วย ต้องการทำต่อหรือไม่?", // The message of the confirm
        placement: "bottom", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
    });


    $(".confirm-add").popConfirm({
        title: "เพิ่มหัวข้อ", // The title of the confirm
        content: "คุณต้องการเพิ่มหัวข้อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
    });
</script>