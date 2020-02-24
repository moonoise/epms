<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

if(!empty($_GET['head']))
{
    $db = new DbConn;
    $sql = "SELECT * FROM ".$db->tbl_per_personal." WHERE head = :head";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":head",$_GET['head']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    if ($stm->rowCount()) {
        $t = '';
        $n = 1;
        foreach ($result as $key => $value) {
           $t .= "<tr>";
           $t .= "<td>$n</td>";
           $t .= "<td>".$value['per_cardno']."</td>";
           $t .= "<td>".$value['pn_name'].$value['per_name']." ".$value['per_surname']."</td>";
           $t .= "<td>".$value['pm_name']."</td>";
           $t .= "<td>
                    <button type='button' class='btn btn-danger btn-xs confirm-del-subordinate' onclick='delSubordinate(`".$value['per_cardno']."`)' data-original-title='' title=''>
                    <i class='fa fa-eraser'></i></button></td>";
           $t .= "</tr>";
           $t .= " <script>
                    $('.confirm-del-subordinate').popConfirm({
                            title: 'ลบรายชื่อ', // The title of the confirm
                            content: 'คุณต้องการลบรายชื่อนี้ จริงๆ หรือใหม่ ?', // The message of the confirm
                            placement: 'right', // The placement of the confirm (Top, Right, Bottom, Left)
                            container: 'body', // The html container
                            yesBtn: 'ใช่',
                            noBtn: 'ไม่'
                            });
                    </script>";
        $n++;
        }
        echo $t;
    }
}

