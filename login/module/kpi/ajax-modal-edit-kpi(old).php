<?php
if(!empty($_GET['per_cardno'])){
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    
    $kpiType = array('1' => 'กลยุทธ์' ,
                     '2' => 'ประจำ',
                     '3' => 'พิเศษ');
    $err =  '';
    try{
        $db = new DbConn;
        $sqlKpi = "select * from kpi_question ";
        $kpi = $db->conn->prepare($sqlKpi);
        $kpi->execute();
        $kpiResult = $kpi->fetchAll();

       
    }catch(Exception $e){
        $err = $e->getMessage();
    }

    if ($err!='') {
        $s = $err;
    }else {
        $s = s($kpiResult,$_GET['per_cardno'],$kpiType);
    }
}else {
        $s = 'เกิดข้อผิดพลาด';
}

function s($kpiResult,$per_cardno,$kpiType) {
    $n ="";
    foreach ($kpiResult as $row) {
        
        $n .=  "<tr>";
        $n .= "<td>".$row['kpi_code']."</td>";
        $n .= "<td>".$row['kpi_title']."</td>";
        $n .= "<td>".$kpiType[$row['kpi_type']]."</td>";
        $n .= "<td><a href='#' class='btn btn-info btn-xs' onclick='kpiAdd(".$_GET['per_cardno'].",".$row['kpi_code'].")'><i class='fa fa-plus-square'></i> </a></td>";
        $n .= "</tr>";
    }
    return $n;
}
?>
<!-- Modal -->
        <table id="show-question" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>รหัส</th>
                <th>รายการตัวชี้วัด</th>
                <th>ประเภท</th>
                <th><i class="fa fa-save"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php
                
                if (!empty($s)) {
                    echo $s;
                }
            ?>

            </tbody>
            </table>
         <br>

        <table  class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>รหัส</th>
                <th>รายการตัวชี้วัด</th>
                <th>ประเภท</th>
                <th>ค่าน้ำหนัก</th>
            </tr>
            </thead>
            <tbody id="kpi-question-person">
                

            </tbody>
            </table>


       
