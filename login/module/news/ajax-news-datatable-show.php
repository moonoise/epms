<?php 
include_once '../../config.php';
include_once '../../includes/dbconn.php';

$db = new dbConn;
$sql = "SELECT * FROM `news` WHERE solfdelete = 0 ORDER BY new_order DESC ";
$stm = $db->conn->prepare($sql);
$stm->execute();
$result = $stm->fetchAll();
$i=1;
$d = array();
foreach ($result as $key => $row) {
    $d[] = array($i,
               '<p>'.$row['new_title'].'</p>',
               '<button type="button" class="btn btn-default btn-xs"
               onclick="newPublic('.$row['new_id'].')" 
               data-toggle="tooltip" 
               data-placement="top" 
               title=""
               id="p-'.$row['new_id'].'" 
               data-original-title="เผยแพร่/ไม่เพยแพร่">
               <span class="fa '.($row['new_public']==1?"fa-unlock text-success":"fa-lock text-danger").'  setting-icon" aria-hidden="true"></span>
           </button>
           <button type="button" class="btn btn-default btn-xs"
               onclick="editNewShow('.$row['new_id'].')" 
               data-toggle="tooltip" 
               data-placement="top" 
               title="" 
               data-original-title="แก้ไข">
               <span class="fa fa-pencil text-warning setting-icon" aria-hidden="true"></span>
           </button>
           <button type="button" class="btn btn-default btn-xs confirm-delete"
               onclick="deleteNew('.$row['new_id'].')" 
               data-toggle="tooltip" 
               data-placement="top" 
               title="" 
               data-original-title="ลบ">
               <span class="fa fa-eraser text-danger setting-icon" aria-hidden="true"></span>
           </button>
           <script>
            $("[data-toggle=\'tooltip\']").tooltip();
            $(".confirm-delete").popConfirm({
                title: "คุณต้องการลบจริงๆ หรือไม่", // The title of the confirm
                content: "คุณต้องการลบ จริงๆ หรือไม่?", // The message of the confirm
                placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
                container: "body", // The html container
                yesBtn: "ใช่",
                noBtn: "ไม่"
                })  
           </script>
           '
    );

    $i++;
}

$data = array('data' => $d );
    echo json_encode($data);