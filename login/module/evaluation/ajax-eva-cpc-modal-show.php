<?php
    session_start();
     if (!empty($_GET['question_no']) && !empty($_GET['per_cardno']) && !empty($_GET['cpc_score_id'])) {
        // && !empty($_GET['cpc_score_id'])
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../cpc/class-cpc.php";
    include_once "../myClass.php";
    $t = "";
    $n = 1;
    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];
 
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
            `cpc_question`.`question_type`,
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
        `$cpcScoreTable`.`cpc_score_id`,
        `$cpcScoreTable`.`question_no`,
        `$cpcScoreTable`.`per_cardno`,
        `$cpcScoreTable`.`id_admin`,
        `$cpcScoreTable`.`cpc_score1`,
        `$cpcScoreTable`.`cpc_score2`,
        `$cpcScoreTable`.`cpc_score3`,
        `$cpcScoreTable`.`cpc_score4`,
        `$cpcScoreTable`.`cpc_score5`,
        `$cpcScoreTable`.`years`,
        `$cpcScoreTable`.`date_key_score`,
        `$cpcScoreTable`.`cpc_divisor`,
        `$cpcScoreTable`.`cpc_accept1`,
        `$cpcScoreTable`.`cpc_accept2`,
        `$cpcScoreTable`.`cpc_accept3`,
        `$cpcScoreTable`.`cpc_accept4`,
        `$cpcScoreTable`.`cpc_accept5`,
        `$cpcScoreTable`.`cpc_comment1`,
        `$cpcScoreTable`.`cpc_comment2`,
        `$cpcScoreTable`.`cpc_comment3`,
        `$cpcScoreTable`.`cpc_comment4`,
        `$cpcScoreTable`.`cpc_comment5`
        FROM
        `$cpcScoreTable`
        WHERE `$cpcScoreTable`.`cpc_score_id` = :cpc_score_id ";

        $stmCS = $cpc->conn->prepare($sqlCPC_score);
        $stmCS->bindParam(":cpc_score_id",$_GET['cpc_score_id']);
        $stmCS->execute();
        $r = $stmCS->fetchAll();

        $checkScore = $cpc->cpcBtnStatus1($_GET['cpc_score_id'],$cpcScoreTable);
        
        if ($checkScore['success'] === true) {
            $scoreDisabled  = 'Disabled';
            $acceptDisabled = 'Disabled';
        }elseif ($checkScore['success'] === false) {
            $scoreDisabled  = '';
            $acceptDisabled = 'Disabled';
        }
        
        if ($result[0]['question_type']==1 || $result[0]['question_type']==2 || $result[0]['question_type']==3 ){
            $cc = " <button type='button' class='btn btn-info btn-xs' onclick='checkAll(2)'>2</button>
            <button type='button' class='btn btn-info btn-xs' onclick='checkAll(3)'>3</button>
            <button type='button' class='btn btn-info btn-xs' onclick='checkAll(4)'>4</button>
            <button type='button' class='btn btn-info btn-xs' onclick='checkAll(5)'>5</button>";
        }else {
            $cc = "";
        }
       
        // echo "<pre>";
        // print_r($r);
        // echo "</pre>";
    $cc .= "<div class='pull-right'> <i class='fa fa-square' style='background-color:rgb(216, 236, 245);color:rgb(165, 198, 213);'></i> คือคำนวณข้อคำถามที่คาดหวัง</div>";
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
                    <button type='button' class='btn btn-info btn-xs' onclick='checkAll(0)'>0</button>
                    <button type='button' class='btn btn-info btn-xs' onclick='checkAll(1)'>1</button>
                   
                    $cc
                    <button type='button' class='btn btn-primary btn-xs' id='submit_cpcScore_1' ".$scoreDisabled.">บันทึก</button>
                    </td>
                    </tr>";
    $t .= "<tr>";
    $t .= "<td colspan='3'>";
    $c_qst = 1;
    foreach ($result as $key => $value) {
    $str = $scoreC[$value['qst_index']];
    $strH = $scoreH[$value['qst_index']];
    $strComment = $scoreComment[$value['qst_index']];

    $t .= "<table class='table table-bordered ".($r[0]['cpc_divisor'] >= $c_qst ? "table-blue" : "" )." '>
            <tbody>";
    $c_qst++; 
    $t .= "";
    $t .= " <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-info text-center'><small>ตนเอง</small></td>
                <td class='col-md-1 col-sm-1 col-xs-1 text-info text-center'><small>ผู้บังคับบัญชา</small></td>
                <td  class='col-md-10 col-sm-10 col-xs-1 '>
                    <label class='text-info'>".$n.") ".$value['qst_title']."
                    </label> 
                </td>
            </tr>";

        if ($value['qst_kbi_0'] != "") {
            $t .= "
            <tr>
                <td class='col-md-1 col-sm-1 col-xs-1 text-center '>
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
                <td class='choise-td text-danger' >
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
                $t .= "<td colspan='4'> <label> <h5 class='text text-info'>ความเห็นของผู้บังคับบัญชา </h5>".$r[0][$strComment]." </label></td>";
            $t .= "</tr>";
        }

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
    $t .= " <button type='button' class='btn btn-primary' id='submit_cpcScore' ".$scoreDisabled.">บันทึก</button>
            <button type='button' class='btn btn-default' data-dismiss='modal' >ยกเลิก</button>";
    $t .= "</form>";


    echo $t;
   
    }

    

?>

<script>
    
    $("#submit_cpcScore ,#submit_cpcScore_1").click(function () {

            $.ajax({
                url: "module/evaluation/ajax-eva-cpc-modal-add_score.php",
                dataType: "json",
                type: "POST",
                data: $("#frm_cpc_score").serializeArray(),
                success:function (result) {
                    if (result.success === true) {
                        //console.log('test')
                        notify('การประเมินสมรรถนะ',result.msg,'success')
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
        
    })


    $("#submit_cpcScore ,#submit_cpcScore_1").popConfirm({
        title: "<b class=text-danger>บันทึก </b>", // The title of the confirm
        content: "<b class=text-warning>คุณต้องการบันทึกคะแนนจริงหรือไม่ ? </b>", // The message of the confirm
        placement: "right", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "บันทึก",
        noBtn: "ไม่บันทึก"
});
</script>

            