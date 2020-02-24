<?php
class proFile 
{   
    public function urlPic($idCard,$type=1) {
        $file1 = "http://dpis.rid.go.th:8080/attachment/pic_personal/".$idCard."-001.jpg";
        $file2 = "http://dpis.rid.go.th:8080/attachment/pic_personal/".$idCard."-002.jpg";
        $file3 = "http://dpis.rid.go.th:8080/attachment/pic_personal/".$idCard."-003.jpg";
        $file_headers3 = @get_headers($file3);
        $file_headers2 = @get_headers($file2);
        $file_headers1 = @get_headers($file1);

        if ($file_headers3[0] != 'HTTP/1.1 404 Not Found') {
            return $file3;
        }elseif ($file_headers2[0] != 'HTTP/1.1 404 Not Found') {
            return $file2;
        }elseif ($file_headers1[0] != 'HTTP/1.1 404 Not Found') {
            return $file1;
        }else return "../external/images_profile/no-picture.png";
    }
    


    public function detail($idcard) {
    $db = new DbConn;
    $tbl_per_personal = $db->tbl_per_personal;

    $sql = "SELECT t1.*,
                    t2.pn_name as head_pn_name,
                    t2.per_name as head_per_name,
                    t2.per_surname as head_per_surname,
                    t2.per_cardno as head_per_cardno
             FROM ".$tbl_per_personal." t1 
             LEFT JOIN ".$tbl_per_personal." t2
             ON t1.head = t2.`per_cardno`
             where t1.per_cardno = :idcard";
    $stmt = $db->conn->prepare($sql);
    $stmt->bindParam(":idcard",$idcard);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 1) {

        foreach ($result as $row) {
            $p = $row;
            unset($row);
        }
        return $p;
    }else return false;
    
    }

}
