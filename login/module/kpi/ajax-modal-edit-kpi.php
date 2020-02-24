<?php
if(!empty($_GET['per_cardno'])){
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-kpi.php";

$kpi = new kpi;

$kpiQuestion = $kpi->kpiQuestionSelectAll();

}
?>

<!-- Modal -->
<table id="show-question" class="table table-striped table-bordered">
            <thead>
            <tr class="info">
                <th class="col-md-1 col-sm-1 col-xs-1">รหัส</th>
                <th class="col-md-8 col-sm-8 col-xs-8" >รายการตัวชี้วัด <span class="text-warning">(ตัวเลือก)</span></th>
                <th class="col-md-2 col-sm-2 col-xs-2">ประเภท</th>
                <th class="col-md-1 col-sm-1 col-xs-1"><i class="fa fa-save"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php
                if ($kpiQuestion['success'] == true) {
                    foreach ($kpiQuestion['result'] as $row) {
                        echo "<tr>";
                        echo "<td class='col-md-1 col-sm-1 col-xs-1'>".$row['kpi_code_org']."</td>";
                        echo "<td class='col-md-8 col-sm-8 col-xs-8'>".$row['kpi_title']."</td>";
                        echo "<td class='col-md-2 col-sm-2 col-xs-2'>".$kpiType[$row['kpi_type']]."</td>";
                        // echo "<td class='col-md-2 col-sm-2 col-xs-2'>".$row['kpi_type']."</td>";
                        echo "<td class='col-md-1 col-sm-1 col-xs-1'><button type='button' class='btn btn-info btn-xs confirm-kpiAdd' onclick='kpiAdd(`".$_GET['per_cardno']."`,`".$row['kpi_code']."`)' ".$_SESSION[__EVALUATION_ON_OFF__]."><i class='fa fa-plus-square'></i> </button></td>";
                        echo "</tr>";
                    }
                }else echo $kpiQuestion['msg'];
                
            ?>

            </tbody>
            </table>
         <br>
         <div id="dialog" >
            <p class='text text-success'></p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center"><h4 class="modal-title text-info" id="myModalLabel">ตัวชี้วัดของ คุณ <span class="modal-name text-success"></span></h4></div>
        <table  class="table table-striped table-bordered">
            <thead>
            <tr class="danger">
                <th class="">#</th>
                <th class="col-md-1 col-sm-1 col-xs-1">รหัส</th>
                <th class="col-md-8 col-sm-7 col-xs-7">รายการตัวชี้วัด <span class="text-warning">(ที่กำหนดไว้)</span> </th>
                <th class="col-md-1 col-sm-1 col-xs-1">ประเภท</th>
                <th class="col-md-2 col-sm-3 col-xs-3">ค่าน้ำหนัก</th>
            </tr>
            </thead>
            <tbody id="kpi-score-person">
            
            </tbody>
            </table>

<script>
$(".confirm-kpiAdd").popConfirm({
        title: "เพิ่มหัวข้อ", // The title of the confirm
        content: "คุณต้องการเพิ่มหัวข้อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
});

</script>