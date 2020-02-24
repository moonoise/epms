<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
 include_once "../kpi/class-kpi.php";
 include_once "../myClass.php";

 $success = array();
 $t = "";
 $s = 0;
 $w = 0;
 if(!empty($_POST['per_cardno'])){
  
    $kpi = new kpi;
    $db = new DbConn;
    $myClass = new myClass;
    $result = $kpi->KpiScoreSelect($_POST['per_cardno']);
    if ($result['success'] == true && count($result['result']) > 0) {
        
        foreach ($result['result'] as $key => $value) {
            if ($value['kpi_code']=="rid-01") {
                $f = "<form name='form_score' class='form_score'>
                        <input type='number' min='1' max='5' name='change_score' id='change_score' value='".$value['kpi_score']."'>
                        <input type='hidden' name='change_kpi_code' id='change_kpi_code' value='".$value['kpi_code']."'>
                        <button type='button' class='btn btn-info btn-xs class-submit-score' value='".$value['kpi_score_id']."'>
                        <i class='fa fa-save'></i></button>
                     </form>";
                $d = "<button type='button' class='btn btn-danger btn-xs' id='id-delete-kpi' value='".$value['kpi_score_id']."'>
                <i class='fa fa-eraser'></i></button>";
                $script = ' <script>
                        
                        $("#id-delete-kpi").click(function (e) { 
                            e.preventDefault();
                            $.ajax({
                            type: "POST",
                            url: "module/change_score/ajax-delete-kpi-specialCaseByID.php",
                            data: {"kpi_score_id":$(this).val()},
                            dataType: "jSON",
                            success: function (response) {
                                if (response.success == true) {
                                    notify("ลบข้อมูล","สำเร็จ","success")
                                    refresh_score()
                                    }else{
                                    notify("ลบข้อมูล","ไม่สำเร็จ","danger")
                                    }
                            }
                            });
                        });

                      $("#id-delete-kpi").popConfirm({
                            title: "ลบตัวขี้วัดพิเศษ", // The title of the confirm
                            content: "คุณต้องการตัวขี้วัดพิเศษ จริงๆ หรือใหม่ ?", // The message of the confirm
                            placement: "bottom", // The placement of the confirm (Top, Right, Bottom, Left)
                            container: "body", // The html container
                            yesBtn: "ใช่",
                            noBtn: "ไม่"
                        });
                </script>
                ';

            }else {
                $f = $value['kpi_score'];
                $d = "";
                $script = "";
            }
            $t .= "<tr>";
            $t .= "<td> ".$value['kpi_code_org']."</td>";
            $t .= "<td>".$value['kpi_title']." ".$d.$script."</td>";
            $t .= "<td class='text-center'>".$f."</td>";
            $t .= "<td class='text-center'>
                         <form name='form_weight' class='form_weight'>
                        <input type='hidden' name='change_kpi_code' id='change_kpi_code' value='".$value['kpi_code']."'>
                        <input type='number' name='change_weight'  min='0' max='100' value='".$value['weight']."'> 
                        <button type='button' class='btn btn-info btn-xs class-submit-weight' value='".$value['kpi_score_id']."'>
                        <i class='fa fa-save'></i></button>
                        </form>
                    </td>";
            $t .= "<td class='text-center'>". $s += (($value['kpi_score'] * $value['weight'] * 20 ) / 100)."</td>";
            $t .= "</tr>";
            $w += $value['weight'];
        }
        $t .= "<tr>
                    <td colspan='3' class='text-right'><b>รวม</b></td>
                    <td class='text-center'><b>$w</b</td>
                    <td  class='text-center'><b>$s</b> </td>
                </tr>";

        $success['kpi_weight_new'] = $w;
        $success['kpi_score_new'] = $s;
         try {
             $tableYears = $myClass->callYear();
             $sql = "select per_name,per_surname from ".$tableYears['data']['per_personal']." WHERE per_cardno = :per_cardno";
             $stm = $db->conn->prepare($sql);
             $stm->bindParam(':per_cardno',$_POST['per_cardno']);
             $stm->execute();
             $result = $stm->fetchAll(PDO::FETCH_ASSOC);
             $success['name'] = $result[0]['per_name'] ." ".$result[0]['per_surname'];
             $success['per_cardno'] = $_POST['per_cardno'];
         } catch (\Exception $e) {
            $success['success'] = false;
            $success['msg'] = $e->getMessage();
         }


        $success['success'] = true;
        $success['msg'] = null;
        $success['html'] = $t;
       
    }else {
        $success['success'] = false;
        $success['msg'] = 'not found data';
    }

 }else {
    $success['success'] = false;
    $success['msg'] = 'เกิดข้อผิดพลาด';
 }

echo json_encode($success);


