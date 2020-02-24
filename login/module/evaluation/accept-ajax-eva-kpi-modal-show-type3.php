<?php
 if (!empty($_GET['kpi_code']) && !empty($_GET['per_cardno']) && !empty($_GET['kpi_score_id'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../kpi/class-kpi.php";

    $t = "";
    $kpi = new kpi;

    $checkScore = $kpi->kpiBtnStatus1($_GET['kpi_score_id']);

    if ($checkScore['success'] === true) {
        $scoreDisabled  = 'Disabled';
        $acceptDisabled = '';

        $checkaccept = $kpi->kpiBtnStatus2($_GET['kpi_score_id']);
        if ($checkaccept['success'] === true) {
            $acceptDisabled = 'Disabled';
        }
    }elseif ($checkScore['success'] === false) {
        $scoreDisabled  = 'Disabled';
        $acceptDisabled = 'Disabled';

        
    }

    $sqlKpiQuestion = "SELECT * FROM kpi_question
                      WHERE kpi_code = :kpi_code";
    $stm = $kpi->conn->prepare($sqlKpiQuestion);
    $stm->bindParam(":kpi_code",$_GET['kpi_code']);
    $stm->execute();
    
    $result = $stm->fetchAll();

    $sqlKpiScore = "SELECT `weight`,
                        `kpi_score`,
                        `works_name`,
                        `kpi_accept`,
                        `kpi_comment`
                    FROM ".$kpi->tbl_kpi_score."
                    WHERE `kpi_score_id` = :kpi_score_id ";
    $stm2 = $kpi->conn->prepare($sqlKpiScore);
    $stm2->bindParam(":kpi_score_id",$_GET['kpi_score_id']);
    $stm2->execute();
    $r = $stm2->fetchAll();

    $sqlComment = "SELECT * FROM ".$kpi->tbl_kpi_comment." WHERE  `kpi_score_id` = :kpi_score_id ";
    $stm3 = $kpi->conn->prepare($sqlComment);
    $stm3->bindParam(":kpi_score_id",$_GET['kpi_score_id']);
    $stm3->execute();
    $rComment = $stm3->fetchAll();
    $cComment = $stm3->rowCount();

    $t .= "<form method='POST' name='frm_kpi_score' id='frm_kpi_score'>";
    $t .= "<input type='hidden' value='".$_GET['kpi_score_id']."' name='kpi_score_id'>";
    $t .= "<input type='hidden' value='".$result[0]['kpi_code']."' name='kpi_code'>";
    $t .= "<div class='row'>";
    $t .= "<div class='col-md-12 col-sm-12 col-xs-12'>";
        $t .= "<div class='form-group'>";
                $t .=  "<label class='control-label text text-info '>ชื่อผลงาน:</label>";
                $t .= "<div class='col-md-12 col-sm-12 col-xs-12'>";
                $t .= "<textarea type='text' name='works_name' id='works_name' class='form-control col-md-12 col-sm-12 col-xs-12' disabled>".$r[0]['works_name']."</textarea>";
                $t .= "</div>";
            $t .= "</div>";
        $t .= "</div>";

    $t .= "<div class='col-md-12 col-sm-12 col-xs-12'>";
    $t .= "<table id='table-cpc-sub' class='table table-hover table-bordered' style='width:100%'>
            <thead class='thead-for-user'>
                <tr>
                <th class='col-md-1 col-sm-1 col-xs-1 text-center' >รหัส</th>
                <th class='col-md-6 col-sm-6 col-xs-6 text-center' >ตัวชี้วัดความสำเร็จ</th>
                <th class='col-md-3 col-sm-3 col-xs-3 text-center' >ประเภท</th>
                <th class='col-md-1 col-sm-1 col-xs-1 text-center' ><small>คะแนน</small></th>
                <th class='col-md-1 col-sm-1 col-xs-1 text-center' >น้ำหนัก</th>
                </tr>
            </thead>
            <tbody id='table-tbody-cpc-sub'>
                ";
        foreach ($result as $key => $value) {
            if ($result[0]['kpi_type2'] != "") {
                $kpiCon1 = $kpi_type_text[$result[0]['kpi_type2']];
            }else{
                $kpiCon1 = 'ไม่ระบุ';
            }
            $t .= "<tr>";
            $t .= "<td>".$result[0]['kpi_code_org']."</td>";
            $t .= "<td>".$result[0]['kpi_title']."</td>";
            $t .= "<td>".$kpiCon1."</td>";
            $t .= "<td><input type='text' class='bg-info col-md-12 col-sm-12 col-xs-12' required=''
                        name='modal_kpi_score' id='modal-kpi_score-type3' maxlength='3' placeholder='' 
                        value='".(!empty($r[0]['kpi_score'])?$r[0]['kpi_score']:"")."' ".$scoreDisabled."></td>";
            $t .= "<td>".(!empty($r[0]['weight'])?$r[0]['weight']:"ยังไม่ได้ระบุน้ำหนัก")."</td>";
           
            $t .= "</tr>";     
        }
        $t .= "
        <tr>
            <td colspan='3'>
            <ol class='text-warning'>
                <li>".$result[0]['kpi_level1']."</li>
                <li>".$result[0]['kpi_level2']."</li>
                <li>".$result[0]['kpi_level3']."</li>
                <li>".$result[0]['kpi_level4']."</li>
                <li>".$result[0]['kpi_level5']."</li>
            </ol>
            </td>
            <td colspan='2'>
                <div class='radio radio-success'>
                    <input type='radio' id='Accept' ".($r[0]['kpi_accept'] == 1 && strlen($r[0]['kpi_accept'])== 1  ?"checked=''":"")." value='1' class='radioAccept' name='kpi_accept' ".$acceptDisabled."> 
                    <label for='Accept'class='text text-success'>
                    ยืนยันผล
                    </label>
                 </div>
                <div class='radio radio-warning'>
                    <input type='radio' id='unAccept' ".($r[0]['kpi_accept'] == 2 && strlen($r[0]['kpi_accept'])== 1  ?"checked=''":"")." value='2' class='radioAccept' name='kpi_accept' ".$acceptDisabled."> 
                    <label for='unAccept' class='text text-warning'>
                    ไม่ยืนยันผล
                    </label>
                </div>
            </td>
        </tr>";
        if ($cComment > 0 ) {
            $t .= "<tr><td colspan='6'><label> <h5 class='text text-info'>ความเห็นของผู้บังคับบัญชา </h5></lable></td></tr>";
            foreach ($rComment as $key => $value) {
                $h = $kpi->WhoIsHead($value['kpi_score_id']);
                // echo "<pre>";
                // print_r($h);
                // echo "</pre>";
                $t .= "<tr>";
                $t .= "<td colspan='6'><strong>คะแนนเดิม: </strong><small class='text text-danger'>"
                        .$value['kpi_score_raw']." | "
                        .$value['kpi_score']."</small><strong> เหตุผลเพราะ: <strong> <small class='text text-info'>"
                        .$value['kpi_comment']."</small>"
                        ."<small class='text text-success'> วันที่: ".$value['date_time']." </small>"
                        ."<small class='text text-warning'> ผู้บังคับบัญชา: ".$h['result'][0]['per_name']." ".$h['result'][0]['per_surname']."</small>"
                        ."</td>";
                $t .= "</tr>";
            }
        }
    $t .= "<tr id='acceptComment'></tr>";

    $t .= "</tbody>              
        </table>";
    $t .= "</div>
        </div>";
    $t .= " <button type='button' class='btn btn-primary' id='submit_kpiScore' ".$acceptDisabled.">บันทึก</button>
        <button type='button' class='btn btn-default' data-dismiss='modal' >ยกเลิก</button>";
    $t .= "</form>";
    echo $t ;


 }    
?>
 <script>
    

     $(".radioAccept").change(function () {

        var radioAccept = $("input[type=radio][name=kpi_accept]:checked").val();

        //console.log(radioAccept)
        var txt ='';
        if (radioAccept == 2) {
            txt = "<td colspan='6'>"+
                "<label for='message'>กรุณาอธิบายเหตุผล:</label>"+
                "<textarea   class='form-control' "+
                    "name='kpi_comment'></textarea>"+
                    "</td>"

            $("#acceptComment").html(txt)
        } if (radioAccept == 1) {
        $("#acceptComment").html("")
        }
    })

   

    $("#submit_kpiScore").click(function () {
        var kpi_score_type3 = $("#modal-kpi_score-type3").val()
        if (kpi_score_type3 != '') {
                if (kpi_score_type3 <= 5 && kpi_score_type3 >= 0 ) {
                    $.ajax({
                        url: "module/evaluation/accept-ajax-eva-kpi-modal-show-type3-add.php",
                        dataType:"json",
                        type: "POST",
                        data:$("#frm_kpi_score").serializeArray(),
                        success: function (data) {
                            if (data.success === true) {
                                // console.log('test')
                                notify('การประเมินตัวชี้วัด','สำเร็จ ','success')
                                $("#modal-kpi-eva").modal('hide')
                                refreshEvaTable_kpi()
                            }else if(data.success === false){
                                notify('การประเมินตัวชี้วัด','ไม่สำเร็จ '+ data.msg,'danger')
                            }else if(data.success === null){
                                notify('การประเมินตัวชี้วัด','ไม่สำเร็จ '+ data.msg,'danger')
                            }
                        }
                    })
                }else{
                    notify('คำเตือน','คะแนนต้องอยู่ระหว่าง 1-5','danger')
                }
                
        }else{
            notify('คำเตือน','คุณยังไม่ได้ใส่ค่าประเมิน','danger')
        }
    });

     $("#submit_kpiScore").popConfirm({
        title: "<b class=text-danger>ยืนยันผล </b>", // The title of the confirm
        content: "<b class=text-warning>คุณต้องการยืนยันผลจริงหรือไม่ ? </b>", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ยืนยัน",
        noBtn: "ไม่ยืนยัน"
    });
</script>