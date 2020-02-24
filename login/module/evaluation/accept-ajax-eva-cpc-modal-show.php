<?php
    session_start();
     if (!empty($_GET['question_no']) && !empty($_GET['per_cardno']) && !empty($_GET['cpc_score_id'])) {
        // && !empty($_GET['cpc_score_id'])
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../cpc/class-cpc.php";
    $t = "";
    $n = 1;
    $cpc = new cpc;
    // $years = __year__;
    $scoreC =  array( 1 => "cpc_score1",
                      2 => "cpc_score2",
                      3 => "cpc_score3",
                      4 => "cpc_score4",
                      5 => "cpc_score5" );
    $scoreH =  array( 1 => "cpc_accept1",
                        2 => "cpc_accept2",
                        3 => "cpc_accept3",
                        4 => "cpc_accept4",
                        5 => "cpc_accept5" );
    $scoreComment =  array( 1 => "cpc_comment1",
                        2 => "cpc_comment2",
                        3 => "cpc_comment3",
                        4 => "cpc_comment4",
                        5 => "cpc_comment5" );       

    $sql = "SELECT
            `cpc_question`.`question_no`,
            `cpc_question`.`question_code`,
            `cpc_question`.`question_title`,
            `cpc_question`.`question_exp`,
            `cpc_question_sub`.`qst_no`,
            `cpc_question_sub`.`qst_index`,
            `cpc_question_sub`.`qst_title`,
            `cpc_question_sub`.`qst_kbi_5`,
            `cpc_question_sub`.`qst_kbi_4`,
            `cpc_question_sub`.`qst_kbi_3`,
            `cpc_question_sub`.`qst_kbi_2`,
            `cpc_question_sub`.`qst_kbi_1`,
            `cpc_question_sub`.`qst_kbi_0`
            FROM
            `cpc_question`
            LEFT JOIN `cpc_question_sub`
            ON `cpc_question`.`question_no` = `cpc_question_sub`.`question_no`
            WHERE
            `cpc_question`.`question_no` = :question_no
            ORDER BY
            `cpc_question_sub`.`qst_index` ASC";


    $stm = $cpc->conn->prepare($sql);
    $stm->bindParam(":question_no",$_GET['question_no']);
    $stm->execute();
    $result = $stm->fetchAll();

///////////////////////////////////

        $sqlCPC_score = "SELECT
        `$tbl_cpc_score`.`cpc_score_id`,
        `$tbl_cpc_score`.`question_no`,
        `$tbl_cpc_score`.`per_cardno`,
        `$tbl_cpc_score`.`id_admin`,
        `$tbl_cpc_score`.`cpc_score1`,
        `$tbl_cpc_score`.`cpc_score2`,
        `$tbl_cpc_score`.`cpc_score3`,
        `$tbl_cpc_score`.`cpc_score4`,
        `$tbl_cpc_score`.`cpc_score5`,
        `$tbl_cpc_score`.`years`,
        `$tbl_cpc_score`.`date_key_score`,
        `$tbl_cpc_score`.`cpc_divisor`,
        `$tbl_cpc_score`.`cpc_accept1`,
        `$tbl_cpc_score`.`cpc_accept2`,
        `$tbl_cpc_score`.`cpc_accept3`,
        `$tbl_cpc_score`.`cpc_accept4`,
        `$tbl_cpc_score`.`cpc_accept5`,
        `$tbl_cpc_score`.`cpc_comment1`,
        `$tbl_cpc_score`.`cpc_comment2`,
        `$tbl_cpc_score`.`cpc_comment3`,
        `$tbl_cpc_score`.`cpc_comment4`,
        `$tbl_cpc_score`.`cpc_comment5`
        FROM
        `$tbl_cpc_score`
        WHERE `$tbl_cpc_score`.`cpc_score_id` = :cpc_score_id ";

        $stmCS = $cpc->conn->prepare($sqlCPC_score);
        $stmCS->bindParam(":cpc_score_id",$_GET['cpc_score_id']);
        $stmCS->execute();
        $r = $stmCS->fetchAll();

        $checkScore = $cpc->cpcBtnStatus1($_GET['cpc_score_id']);
        
        if ($checkScore['success'] === true) {
            $scoreDisabled  = 'Disabled';
            $acceptDisabled = '';

            $checkaccept = $cpc->cpcBtnStatus2($_GET['cpc_score_id']);
            if ($checkaccept['success'] === true) {
                $acceptDisabled = 'Disabled';
            }
        }elseif ($checkScore['success'] === false) {
            $scoreDisabled  = 'Disabled';
            $acceptDisabled = 'Disabled';

            
        }
        
        
        
        // echo "<pre>";
        // print_r($r);
        // echo "</pre>";
    $t .= "<form method='POST' name=frm_cpc_score id='frm_cpc_score'>";
    $t .= "<input type='hidden' name='cpc_score_id' value='".$_GET['cpc_score_id']."'>";
    $t .=  "<h5 class='text-success'>".$result[0]['question_title']."</h5>";
    $t .= "<small class='text-danger'>คำชี้แจง : ".$result[0]['question_exp']."</small>";
    $t .= "<div class='row'>
            <div class='col-md-12 col-sm-12 col-xs-12'>
            
            <table id='table-cpc-sub' class='table table-hover table-bordered' style='width:100%'>
                <thead class='thead-for-user'>
                    <tr>
                    
                    <th class='col-md-11 col-sm-11 col-xs-11' colspan='2' >คำถาม</th>
                    <th class='col-md-1 col-sm-1 col-xs-1' >ระดับคะแนน</th>
                    </tr>
                </thead>
                <tbody id='table-tbody-cpc-sub'>
                    <tr>
                    <td colspan='3'>
                        <button type='button' class='btn btn-info btn-xs' onclick='acceptAll(0)'>ไม่ยืนยัน</button>
                        <button type='button' class='btn btn-info btn-xs' onclick='acceptAll(1)'>ยืนยันทั้งหมด</button>
                        <button type='button' class='btn btn-primary btn-xs' id='submit_cpcScore_1' ".$acceptDisabled.">บันทึก</button>
                        <div class='pull-right'> <i class='fa fa-square' style='background-color:rgb(216, 236, 245);color:rgb(165, 198, 213);'></i> คือคำนวณข้อคำถามที่คาดหวัง</div>
                    </td>
                    </tr>";
    $t .= "<tr>";
    $t .= "<td colspan='3'>";
    $c_qst = 1;
    foreach ($result as $key => $value) {
    $str = $scoreC[$value['qst_index']];
    $strH = $scoreH[$value['qst_index']];
    $strComment = $scoreComment[$value['qst_index']];

    $t .= "<table class=' table table-bordered ".($r[0]['cpc_divisor'] >= $c_qst ? "table-blue" : "" )."'>
            <tbody>";
    $c_qst++; 
    $t .= "";
    $t .= " <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'><small>ตนเอง</small></td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'><small>ผู้บังคับบัญชา</small></td>
                <td  class='col-md-11 col-sm-11 col-xs-11 '>
                    <label>".$n.") ".$value['qst_title']."
                    </label> 
                </td>
            </tr>";

        if ($value['qst_kbi_0'] != "") {
            $t .= "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                    <div class='radio radio-danger choise-radio'>    
                        <input type='radio' id='".$str."0' ".($r[0][$str] == 0 && strlen($r[0][$str])== 1  ?"checked=''":"")." value='0'  class='".$str."' name='".$str."' ".$scoreDisabled."> 
                        <label for='".$str."0'>
                        </label>
                    </div>    
                </td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'> 
                    <input type='radio' value='0' id='".$strH."0' class='".$strH."' name='".$strH."' ".($r[0][$strH] == 0 && strlen($r[0][$strH])== 1 ?"checked=''":"")." ".$acceptDisabled.">
                <label for='".$strH."0'>
                </label>    
                </div>
                </td>
                <td class='choise-td' >
                    ".$value['qst_kbi_0']."
                    <span class='pull-right'>
                        0
                    </span>
                </td>
            </tr>
                ";
        }
        if ($value['qst_kbi_1'] != "") {
            $t .=   "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                    <div class='radio radio-danger choise-radio'>
                        <input type='radio' id='".$str."1' ".($r[0][$str]==1 ?"checked=''":"")." value='1'  class='".$str." ' name='".$str."' ".$scoreDisabled."> 
                        <label for='".$str."1'>
                        </label>
                        
                    </div>
                </td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'> 
                    <input type='radio' value='1' id='".$strH."1' class='".$strH."' name='".$strH."' ".($r[0][$strH]==1 ?"checked=''":"")." ".$acceptDisabled.">
                    <label for='".$strH."1'>
                    </label>
                </div>
                </td>
                <td class='choise-td'>
                    ".$value['qst_kbi_1']."
                    <span class='pull-right'>
                        1
                    </span>
                </td>
            </tr>
                ";
        }

        if ($value['qst_kbi_2'] != "") {
            $t .=   "
            <tr> 
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                    <div class='radio radio-danger choise-radio'>
                        <input type='radio' id='".$str."2' ".($r[0][$str]==2 ?"checked=''":"")." value='2'  class='".$str." ' name='".$str."' ".$scoreDisabled."> 
                        <label for='".$str."2'>
                           
                        </label>
                        
                    </div>
                </td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'>
                    <input type='radio' id='".$strH."2' value='2' class='".$strH."' name='".$strH."' ".($r[0][$strH]==2 ?"checked=''":"")." ".$acceptDisabled.">
                    <label for='".$strH."2'>
                    </label>
                </div>
                </td>
                <td class='choise-td'>
                    ".$value['qst_kbi_2']."
                    <span class='pull-right'>
                        2
                    </span>
                </td>
            </tr>";
        }
        if ($value['qst_kbi_3'] != "") {
            $t .=   "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                    <div class='radio radio-danger choise-radio'>
                        <input type='radio' id='".$str."3' ".($r[0][$str]==3 ?"checked=''":"")." value='3'  class='".$str." ' name='".$str."' ".$scoreDisabled."> 
                        <label for='".$str."3'>
                        
                        </label>
                        
                    </div>
                </td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'>
                    <input type='radio' id='".$strH."3' value='3' class='".$strH."' name='".$strH."' ".($r[0][$strH]==3 ?"checked=''":"")." ".$acceptDisabled.">
                    <label for='".$strH."3'>
                    </label>
                </div>
                </td>
                <td class='choise-td'>
                ".$value['qst_kbi_3']."
                <span class='pull-right'>
                    3
                </span>
                </td>
            </tr>
                ";
        }
        if ($value['qst_kbi_4'] != "") {
            $t .=   "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'>
                    <input type='radio' id='".$str."4' ".($r[0][$str]==4 ?"checked=''":"")." value='4'  class='".$str." ' name='".$str."' ".$scoreDisabled."> 
                    <label for='".$str."4'>
                    </label>
                    
                </div>
                </td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'>
                    <input type='radio' id='".$strH."4' value='4' class='".$strH."' name='".$strH."' ".($r[0][$strH]==4 ?"checked=''":"")." ".$acceptDisabled.">
                <label for='".$strH."4'>
                </label>
                </div>
                </td>
                <td class='choise-td'>
                    ".$value['qst_kbi_4']."
                    <span class='pull-right'>
                            4
                    </span>
                </td>
            </tr>
                ";
        }
        if ($value['qst_kbi_5'] != "") {
            $t .=   "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                    <div class='radio radio-danger choise-radio'>
                    
                            <input type='radio' id='".$str."5' ".($r[0][$str]==5 ?"checked=''":"")." value='5'  class='".$str."' name='".$str."' ".$scoreDisabled."> 
                            <label for='".$str."5'>
                           
                            </label>
                        
                    </div>
                </td> 
                <td class='col-md-1 col-sm-1 col-xs-1 text-center'>
                <div class='radio radio-danger choise-radio'>
                    <input type='radio' id='".$strH."5' value='5' class='".$strH."' name='".$strH."' ".($r[0][$strH]==5 ?"checked=''":"")." ".$acceptDisabled.">
                    <label for='".$strH."5'>
                    </label>
                </td>
                <td class='choise-td'>
                ".$value['qst_kbi_5']."
                    <span class='pull-right'>
                        5
                    </span>
                </td>
            <tr>
                ";
        }

        if (strlen($r[0][$strComment]) > 0) {
            $t .= "<tr>";
                $t .= "<td colspan='4'> <label for='message' style='color:#F44336;'>ความเห็นของผู้บังคับบัญชา</label><textarea style='border:1px solid #F44336;' class='form-control name='cpc_comment".$n."' Disabled>".$r[0][$strComment]."</textarea></td>";
            $t .= "</tr>";
        }
    $t .= "<tr id='add_comment".$n."'></tr>";

    $t .= "</td>";    
 
        $n++;
        
    }
    $t .= "            
            </td>
        </tr>  ";
    $t .= "        </tbody>
                      
                </table>

                </div>

            </div>";
    $t .= " <button type='button' class='btn btn-primary' id='submit_cpcScore' ".$acceptDisabled.">บันทึก</button>
            <button type='button' class='btn btn-default' data-dismiss='modal' >ยกเลิก</button>";
    $t .= "</form>";


    echo $t;
   
    }

    

?>

<script>
    
   $(".cpc_accept1").change(function () {
       //console.log("test")
       var cpc_score1 = $("input[type=radio][name=cpc_score1]:checked").val();
       var cpc_accept1 = $("input[type=radio][name=cpc_accept1]:checked").val();
       //console.log(cpc_score1)
       //console.log(cpc_accept1)
       var txt ='';
       if (cpc_score1 != cpc_accept1) {
           txt = "<td colspan='3'>"+
                  "<label for='message' style='color:#F44336;'>กรุณาอธิบายเหตุผล:</label>"+
                  "<textarea  required='required' class='form-control' style='border:1px solid #F44336;' "+
                    "name='cpc_comment1'></textarea>"+
                   "</td>"

           $("#add_comment1").html(txt)
       }else{
        $("#add_comment1").html("")
       }
   })

    $(".cpc_accept2").change(function () {

       var cpc_score2 = $("input[type=radio][name=cpc_score2]:checked").val();
       var cpc_accept2 = $("input[type=radio][name=cpc_accept2]:checked").val();
       var txt ='';
       if (cpc_score2 != cpc_accept2) {
           txt = "<td colspan='3'>"+
                  "<label for='message' style='color:#F44336;'>กรุณาอธิบายเหตุผล:</label>"+
                  "<textarea  required='required' class='form-control' style='border:1px solid #F44336;'"+
                    "name='cpc_comment2'></textarea>"+
                   "</td>"

           $("#add_comment2").html(txt)
       }else{
        $("#add_comment2").html("")
       }
   })

    $(".cpc_accept3").change(function () {

        var cpc_score3 = $("input[type=radio][name=cpc_score3]:checked").val();
        var cpc_accept3 = $("input[type=radio][name=cpc_accept3]:checked").val();
        var txt ='';
        if (cpc_score3 != cpc_accept3) {
            txt = "<td colspan='3'>"+
                "<label for='message' style='color:#F44336;'>กรุณาอธิบายเหตุผล:</label>"+
                "<textarea  required='required' class='form-control' style='border:1px solid #F44336;' "+
                    "name='cpc_comment3'></textarea>"+
                    "</td>"

            $("#add_comment3").html(txt)
        }else{
        $("#add_comment3").html("")
        }
    })

    $(".cpc_accept4").change(function () {

        var cpc_score4 = $("input[type=radio][name=cpc_score4]:checked").val();
        var cpc_accept4 = $("input[type=radio][name=cpc_accept4]:checked").val();
        var txt ='';
        if (cpc_score4 != cpc_accept4) {
            txt = "<td colspan='3'>"+
                "<label for='message' style='color:#F44336;'>กรุณาอธิบายเหตุผล:</label>"+
                "<textarea  required='required' class='form-control' style='border:1px solid #F44336;'"+
                    "name='cpc_comment4'></textarea>"+
                    "</td>"
            $("#add_comment4").html(txt)
        }else{
        $("#add_comment4").html("")
        }
    })

     $(".cpc_accept5").change(function () {

            var cpc_score5 = $("input[type=radio][name=cpc_score5]:checked").val();
            var cpc_accept5 = $("input[type=radio][name=cpc_accept5]:checked").val();
            var txt ='';
            if (cpc_score5 != cpc_accept5) {
                txt = "<td colspan='3'>"+
                    "<label for='message' style='color:#F44336;'>กรุณาอธิบายเหตุผล:</label>"+
                    "<textarea  required='required' class='form-control' style='border:1px solid #F44336;' "+
                        "name='cpc_comment5'></textarea>"+
                        "</td>"
                $("#add_comment5").html(txt)
            }else{
            $("#add_comment5").html("")
            }
        })
        
       

    $("#submit_cpcScore ,#submit_cpcScore_1").click(function () {
        var c1 = $("textarea[name='cpc_comment1']").val()
        var c2 = $("textarea[name='cpc_comment2']").val()
        var c3 = $("textarea[name='cpc_comment3']").val()
        var c4 = $("textarea[name='cpc_comment4']").val()
        var c5 = $("textarea[name='cpc_comment5']").val()
        if(c1 != 'undefined' && c1 == ''){
                notify('การประเมินสมรรถนะ','ไม่สำเร็จ คุณยังไม่ได้กรอกเหตุผล ข้อที่ 1','danger')
        }else if(c2 != 'undefined' && c2 == ''){
                notify('การประเมินสมรรถนะ','ไม่สำเร็จ คุณยังไม่ได้กรอกเหตุผล ข้อที่ 2','danger')
        }else if(c3 != 'undefined' && c3 == ''){
                notify('การประเมินสมรรถนะ','ไม่สำเร็จ คุณยังไม่ได้กรอกเหตุผล ข้อที่ 3','danger')
        }else if(c4 != 'undefined' && c4 == ''){
                notify('การประเมินสมรรถนะ','ไม่สำเร็จ คุณยังไม่ได้กรอกเหตุผล ข้อที่ 4','danger')
        }else if(c5 != 'undefined' && c5 == ''){
                notify('การประเมินสมรรถนะ','ไม่สำเร็จ คุณยังไม่ได้กรอกเหตุผล ข้อที่ 5','danger')
        }else{
            $.ajax({
                url: "module/evaluation/accept-ajax-eva-cpc-modal-add_score.php",
                dataType: "json",
                type: "POST",
                data: $("#frm_cpc_score").serializeArray(),
                success:function (result) {
                    if (result.success === true) {
                        //console.log('test')
                        notify('การประเมินสมรรถนะ','สำเร็จ ','success')
                        $("#modal-cpc-eva").modal('hide')
                        refreshEvaTable()
                    }else if(result.success === false){
                        notify('การประเมินสมรรถนะ',result.msg,'warning')
                        $("#modal-cpc-eva").modal('hide')
                        refreshEvaTable()
                    }else if(result.success === null){
                        notify('การประเมินสมรรถนะ','ไม่สำเร็จ '+ result.msg,'danger')
                    }
                } 
            })

        }
    });

      $("#submit_cpcScore ,#submit_cpcScore_1").popConfirm({
        title: "<b class=text-danger>ยืนยันผล </b>", // The title of the confirm
        content: "<b class=text-warning>คุณต้องการยืนยันผลจริงหรือไม่ ? </b>", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ยืนยัน",
        noBtn: "ไม่ยืนยัน"
    });
</script>

                

