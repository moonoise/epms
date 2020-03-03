<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();
// foreach ($_POST as $key => $value) {
//    echo $key ."->". $value;
// }
if(isset($_POST['org_id_2']) and $_POST['org_id_2'] != ""){

    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id_2 = :org_id_2";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_2',$_POST['org_id_2']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    createButton($result);
    
}elseif (isset($_POST['org_id_1']) and $_POST['org_id_1'] != "") {

    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id_1 = :org_id_1";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_1',$_POST['org_id_1']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    createButton($result);
  
}elseif (isset($_POST['org_id']) and $_POST['org_id'] != "") {
    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id = :org_id";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id',$_POST['org_id']);
    $stm->execute();
    $result = $stm->fetchAll();
    // echo $sql;
    createButton($result);

}

function createButton($r) {

    foreach ($r as $row) {
  
        echo  "<tr>";
        echo "<td>".$row['per_cardno']."</td>";
        echo "<td>".$row['pn_name'].$row['per_name']." ".$row['per_surname']."</td>";
        echo "<td>".$row['pm_name']."</td>";
        echo "<td>";
        echo "<button type='button' class='btn btn-default btn-xs'
                onclick='cpcChange(`".$row['per_cardno']."`,`".$row['pl_code']."`,`".$row['level_no']."`,`".$row['per_name']." ".$row['per_surname']."`)' 
                data-toggle='tooltip' 
                data-placement='top' 
                title='' 
                data-original-title='รายการสรรถณะ'>
                <span class='fa fa-graduation-cap green' aria-hidden='true'></span>
                <span class='fa fa-list-ol text-success' aria-hidden='true'></span> 
              </button> ";
        
        echo "<button type='button' class='btn btn-default btn-xs'
                onclick='kpiChange(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`)' 
                data-toggle='tooltip' 
                data-placement='top' 
                title='' 
                data-original-title='รายการตัวชี้วัด'>
                <span class='fa fa-male text-success' aria-hidden='true'></span>
                <span class='fa fa-list-ol' aria-hidden='true'></span> 
                </button> ";

        echo "<button type='button' class='btn btn-default btn-xs'
                onclick='movePerson(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`)' 
                data-toggle='tooltip' 
                data-placement='top' 
                title='' 
                data-original-title='ย้ายบุคลากร'>
                <span class='fa fa-user text-success' aria-hidden='true'></span>
                <span class='fa fa-exchange' aria-hidden='true'></span>
                <span class='fa fa-university blue' aria-hidden='true'></span> 
              </button> ";
              
        echo "<button type='button' class='btn btn-default btn-xs' 
                onclick='settingHead(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`),
                                    subordinateShow(`".$row['per_cardno']."`),
                                    personHead_show(`".$row['org_id']."`,`".$row['org_id_1']."`,`".$row['org_id_2']."`,`".$row['per_cardno']."`)'
                data-toggle='tooltip' 
                data-placement='top' 
                title='' 
                data-original-title='กำหนดหัวหน้า'>
            <span class='fa fa-users blue' aria-hidden='true'></span>
            
            </button> ";

              echo "<button type='button' class='btn btn-default btn-xs' 
                        onclick='editProfile(".$row['per_cardno'].")'
                        data-toggle='tooltip' 
                        data-placement='top' 
                        title='' 
                        data-original-title='แก้ไขข้อมูลส่วนตัว'>
                    <span class='fa fa-user blue' aria-hidden='true'></span>
                    <span class='fa fa-pencil red' aria-hidden='true'></span>
                    </button> ";

            echo "<button type='button' class='btn btn-default btn-xs' 
                    onclick='clearScore(".$row['per_cardno'].")'
                    data-toggle='tooltip'
                    data-placement='top' 
                    title='' 
                    data-original-title='ล้างข้อมูลการประเมิน'>
                    <span class='fa fa-file-o red' aria-hidden='true'></span>
                </button> ";
            

        echo "</td>";
        echo "</tr>";
    }
}