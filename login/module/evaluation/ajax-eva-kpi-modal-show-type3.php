<?php
 if (!empty($_GET['kpi_code']) && !empty($_GET['per_cardno']) && !empty($_GET['kpi_score_id'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../kpi/class-kpi.php";
    include_once "../myClass.php";

    $t = "";
    $kpi = new kpi;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();

    $kpiScoreTable = $currentYear['data']['kpi_score'];
    $kpiComment = $currentYear['data']['kpi_comment'];
    $per_personalTable = $currentYear['data']['per_personal'];

    $checkAccept = $kpi->kpiBtnStatus1($_GET['kpi_score_id'],$kpiScoreTable);
    if ($checkAccept['success'] === true) {
        $kpiScoreDisabled = 'readonly';
        $kpiAcceptDisabled = 'readonly';
        $kpiAccept = $kpi->kpiBtnStatus2($_GET['kpi_score_id'],$kpiScoreTable);
        if ($kpiAccept['result']==2) {
            $kpiScoreDisabled = '';
            $kpiAcceptDisabled = 'readonly';
        }
       
    }elseif ($checkAccept['success'] === false) {
        $kpiScoreDisabled = '';
        $kpiAcceptDisabled = 'readonly';
    }

    $sqlKpiQuestion = "SELECT * FROM kpi_question
                      WHERE kpi_code = :kpi_code";
    $stm = $kpi->conn->prepare($sqlKpiQuestion);
    $stm->bindParam(":kpi_code",$_GET['kpi_code']);
    $stm->execute();
    
    $result = $stm->fetchAll();

    $sqlKpiScore = "SELECT `weight`,
                        `kpi_score`,
                        `works_name`
                    FROM $kpiScoreTable
                    WHERE `kpi_score_id` = :kpi_score_id ";
    $stm2 = $kpi->conn->prepare($sqlKpiScore);
    $stm2->bindParam(":kpi_score_id",$_GET['kpi_score_id']);
    $stm2->execute();
    $r = $stm2->fetchAll();

    $sqlComment = "SELECT * FROM $kpiComment WHERE  `kpi_score_id` = :kpi_score_id ";
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
                $t .=  "<label class='control-label text text-info '>ชื่อผลงาน:</label> ";
                $t .= "<div class='col-md-12 col-sm-12 col-xs-12'>";
                $t .= "<textarea type='text' name='works_name' id='works_name' class='form-control col-md-12 col-sm-12 col-xs-12'>".$r[0]['works_name']."</textarea>";
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
                <tr>
                <td colspan='5' class='text-right'><span class='text text-info'>ตัวเลขระดับผลการดําเนินงานท่ีทําได้จริง (ระดับ <b class='text-danger'>1 – 5</b>)</span></td>
                </tr>";
        foreach ($result as $key => $value) {
            if ($result[0]['kpi_type2'] != "") {
                $kpiCon1 = $kpi_type_text[$result[0]['kpi_type2']];
            }else{
                $kpiCon1 = 'ไม่ระบุ';
            }
            $t .= "<tr>";
            $t .= "<td class='text-center'>".$result[0]['kpi_code_org']."</td>";
            $t .= "<td>".$result[0]['kpi_title']."</td>";
            $t .= "<td class='text-center'>".$kpiCon1."</td>";
            $t .= "<td><input type='text' class='bg-info col-md-12 col-sm-12 col-xs-12' required=''
                        name='modal_kpi_score' id='modal-kpi_score-type3' maxlength='3' placeholder='' 
                        value='".(strlen($r[0]['kpi_score']) > 0 ?$r[0]['kpi_score']:"")."' ".$kpiScoreDisabled."></td>";
            $t .= "<td class='text-center'>".(strlen($r[0]['weight']) > 0?$r[0]['weight']:"ยังไม่ได้ระบุน้ำหนัก")."</td>";
           
            $t .= "</tr>";     
        }
        $t .= "
        <tr>
            <td colspan='5'>
            <ol class='text-warning'>
                <li>".$result[0]['kpi_level1']."</li>
                <li>".$result[0]['kpi_level2']."</li>
                <li>".$result[0]['kpi_level3']."</li>
                <li>".$result[0]['kpi_level4']."</li>
                <li>".$result[0]['kpi_level5']."</li>
            </ol>
            </td>
        </tr>";
        if ($cComment > 0 ) {
            $t .= "<tr><td colspan='6'><label> <h5 class='text text-info'>ความเห็นของผู้บังคับบัญชา </h5></lable></td></tr>";
            foreach ($rComment as $key => $value) {
                $h = $kpi->WhoIsHead($value['kpi_score_id'],$per_personalTable,$kpiScoreTable);
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

    $t .= "</tbody>              
        </table>";
    $t .= "</div>
        </div>";
    $t .= " <button type='button' class='btn btn-primary' id='submit_kpiScore' >บันทึก</button>
        <button type='button' class='btn btn-default' data-dismiss='modal' >ยกเลิก</button>";
    $t .= "</form>";
    echo $t ;


 }    
?>
 <script>
   
   $("#submit_kpiScore").click(function () {
            $.ajax({
                url: "module/evaluation/ajax-eva-kpi-modal-show-type3-add.php",
                dataType:"json",
                type: "POST",
                data:$("#frm_kpi_score").serializeArray(),
                success: function (data) {
                    if (data.success_score === true) {
                        // console.log('test')
                        notify('การบันทึกคะแนน',data.msg_score,'success')
                        $("#modal-kpi-eva").modal('hide')
                        refreshEvaTable_kpi()
                    }else if(data.success_score === false &&  data.msg_score != ""){
                        notify('การบันทึกคะแนน','ไม่สำเร็จ '+ data.msg_score,'danger')
                    }else if(data.success_score === false &&  data.msg_score == ""){
                        $("#modal-kpi-eva").modal('hide')
                        refreshEvaTable_kpi()
                    }

                    if (data.success_workName === true) {
                        // console.log('test')
                        notify('การบันทึกชื่อผลงาน',data.msg_workName,'success')
                        $("#modal-kpi-eva").modal('hide')
                        refreshEvaTable_kpi()
                    }else if(data.success_workName === false &&  data.msg_workName == ""){
                        
                    }
                    
                    if(data.success === null){
                        notify('การบันทึกชื่อผลงาน','ไม่สำเร็จ '+ data.msg,'danger')
                    }
                    
                }
            });
 
            
    });

    // $("#submit_kpiScore").click(function () {
    //     var kpi_score_type3 = $("#modal-kpi_score-type3").val()
    //     if (kpi_score_type3 != '') {
    //             if (kpi_score_type3 <= 5 && kpi_score_type3 >= 0 ) {
    //                 $.ajax({
    //                     url: "module/evaluation/ajax-eva-kpi-modal-show-type3-add.php",
    //                     dataType:"json",
    //                     type: "POST",
    //                     data:$("#frm_kpi_score").serializeArray(),
    //                     success: function (data) {
    //                         if (data.success_score === true) {
    //                             // console.log('test')
    //                             notify('การบันทึกคะแนน',data.msg_score,'success')
    //                         }else if(data.success_score === false &&  data.msg_score != ""){
    //                             notify('การบันทึกคะแนน','ไม่สำเร็จ '+ data.msg_score,'danger')
    //                         }

    //                         if (data.success_workName === true) {
    //                             // console.log('test')
    //                             notify('การบันทึกชื่อผลงาน',data.msg_workName,'success')
    //                         }
    //                          if(data.success === null){
    //                             notify('การบันทึกชื่อผลงาน','ไม่สำเร็จ '+ data.msg,'danger')
    //                         }
    //                         $("#modal-kpi-eva").modal('hide')
    //                         refreshEvaTable_kpi()
    //                     }
    //                 })
    //             }else{
    //                 notify('คำเตือน','คะแนนต้องอยู่ระหว่าง 1-5','danger')
    //             }
                
    //     }else{
    //         notify('คำเตือน','คุณยังไม่ได้ใส่ค่าประเมิน','danger')
    //     }

        
    // });

    $("#submit_kpiScore").popConfirm({
        title: "<b class=text-danger>บันทึก </b>", // The title of the confirm
        content: "<b class=text-warning>คุณต้องการบันทึกคะแนนจริงหรือไม่ ? </b>", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "บันทึก",
        noBtn: "ไม่บันทึก"
    });
</script>