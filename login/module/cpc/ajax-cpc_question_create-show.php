<?php
if (isset($_GET['pl_code'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    $msg = array();
    // $cpcType = array('1' => 'สมรรถนะหลัก (Core Competency)' ,
    //                 '2' => 'สมรรถนะทางการบริหาร (Managerial Competency)',
    //                 '3' => 'สมรรถนะเฉพาะตามลักษณะงานที่ปฏิบัติ (Functional Competency)',
    //                 '4' => 'ความรู้ที่ใช้ในการปฎิบัติงาน (Knowledge)',
    //                 '5' => 'ความรู้ด้านกฎหมาย (Knowledge of Laws)',
    //                 '6' => 'ทักษะ (Skills)' );
    $err = '';
    try{
        $db  = new DbConn;
        $sql = "SELECT
                `cpc_question_create`.`qc_id`,
                `cpc_question_create`.`question_no`,
                `cpc_question_create`.`pl_code`,
                `per_line`.`pl_name`,
                `cpc_question`.`question_code`,
                `cpc_question`.`question_title`,
                `cpc_question`.`question_type`
                FROM
                `cpc_question_create`
                RIGHT JOIN `per_line`
                ON `cpc_question_create`.`pl_code` = `per_line`.`pl_code` 
                RIGHT JOIN `cpc_question`
                ON `cpc_question_create`.`question_no` = `cpc_question`.`question_no`
                and cpc_question.question_type = :question_type
                WHERE cpc_question_create.pl_code = :position order by question_no asc
                ";
 
        $stm =  $db->conn->prepare($sql);
        $stm->bindParam(':position',$_GET['pl_code'],PDO::PARAM_STR);
        $num = 1;

        foreach ($cpcType as $key => $value) {
            $stm->bindParam(':question_type',$key);
            $stm->execute();
            $queryResult = $stm->fetchAll();
            //echo var_dump($queryResult);
            echo "<tr>
                    <td colspan='4' class='success'>".$value."</td>
                 </tr>";
            foreach ($queryResult as $row) {
                
                echo  "<tr>
                        <th scope='row'>".$num++."</th>
                        <td>".$row['question_code']."</td>
                        <td>".$row['question_title']."</td>
                        <td>
                            <button type='button' class='btn btn-danger btn-sm' onclick='delQuestion(".$row['qc_id'].",`".$_GET['pl_code']."`)'><i class='fa fa-eraser'></i></button>
                        </td>
                    </tr>";
                
                        //unset($row);
                
                }
        }   
        
    }catch(PDOException $e){
        $err = $e->getMessage();
        echo $err;
    }
}




