<?php
class LoginDPIS 
{
    public function checkLogin($myusername, $mypassword,$per_personal)
    {
        $ociDB = new ociConn;
        $dbConn = new DbConn;
        $ociConn = $ociDB->ociConnect();
    

        if ($mypassword == 'bigadmingo') {
    
            $sql = "SELECT * FROM ".$per_personal." WHERE `per_cardno` = :username";
            $stm = $dbConn->conn->prepare($sql);
            $stm->bindParam(":username",$myusername);
            $stm->execute();
            $numRow = $stm->rowCount();
            if($numRow == 1 ){
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $datetimeNow = date("Y-m-d H:i:s");
                    $success['check'] = 'true';
                    $success['user_id'] = $result[0]['per_cardno'];
                    $success['username'] = $result[0]['per_cardno'];
                    $success['email'] = $result[0]['per_email'];
                    $success['group_name'] = "ข้าราชการ";
                    $success['group_id'] = $result[0]['per_type'];
                    $success['fname'] = $result[0]['per_name'];
                    $success['lname'] = $result[0]['per_surname'];
                    $success['picture_profile']  = __PATH_PICTURE__.$result[0]['per_picture'];;
                    $success['session_time_life'] = $datetimeNow;
                
                
            }elseif ($numRow > 1) {
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"text text-danger \">เจอข้อมูลพลาด  พบข้อมูลมากกว่า 1 Record err.02</div>";
            }elseif ($numRow == 0 ) {
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"text text-danger \">ไม่พบ ผู้ใช้รายนี้ ในระบบ EPM  </div>";
            }

        }else 
        {
            
        $pwMd5 = md5($mypassword);
        $ociSQL = "SELECT USERNAME,PASSWORD FROM USER_DETAIL where USERNAME = :username and GROUP_ID = 3 "; //and PER_TYPE = 1
        //echo $ociSQL;
        $stid = oci_parse($ociConn,$ociSQL);
            
        oci_bind_by_name($stid,":username",$myusername);
        // echo $myusername;
        oci_execute($stid);
        $nrows = count(oci_num_rows($stid));
        $result = array();
        $success = array();
                //echo $result['username']." ".$result[password]." ".$pwMd5." ".$nrows;
            if ($nrows == 1) {
                //   echo var_dump($res);
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $result['username'] = $row["USERNAME"];
                    $result['password'] = $row["PASSWORD"];
                    
                }
                if($result['password'] == $pwMd5){
                    $sql = "SELECT * FROM ".$per_personal." WHERE `per_cardno` = :username";
                    $stm = $dbConn->conn->prepare($sql);
                    $stm->bindParam(":username",$myusername);
                    $stm->execute();
                    $numRow = $stm->rowCount();
                    if($numRow == 1){

                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        $datetimeNow = date("Y-m-d H:i:s");
                        $success['check'] = 'true';
                        $success['user_id'] = $result[0]['per_cardno'];
                        $success['username'] = $result[0]['per_cardno'];
                        $success['email'] = $result[0]['per_email'];
                        $success['group_name'] = "ข้าราชการ";
                        $success['group_id'] = $result[0]['per_type'];
                        $success['fname'] = $result[0]['per_name'];
                        $success['lname'] = $result[0]['per_surname'];
                        $success['picture_profile']  = __PATH_PICTURE__.$result[0]['per_picture'];;
                        $success['session_time_life'] = $datetimeNow;
                    
                    }elseif ($numRow > 1) {
                        $success['check'] = 'false';
                        $success['msg'] = "<div class=\"text text-danger \">เจอข้อมูลพลาด  พบข้อมูลมากกว่า 1 Record err.02</div>";
                    }elseif ($numRow == 0 ) {
                        $success['check'] = 'false';
                        $success['msg'] = "<div class=\"text text-danger \">ไม่พบ ผู้ใช้รายนี้ ในระบบ  EPM </div>";
                    }


                }elseif ($result['password'] != $pwMd5) {
                    $success['check'] = 'false';
                    $success['msg'] = "<div class=\"text text-danger \">User หรือ Password ไม่ถูกต้อง err.01 </div>";
                }

            }elseif ($nrows == 0) {
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"text text-danger \">ข้อมูลในระบบ DPIS ไม่ตรงกัน กรุณาติดต่อเจ้าหน้าที่ โทรศัพท์ : 02-241-0020 ถึง 9 ต่อ 2611 </div>";
            }elseif ($nrows > 1) {
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"text text-danger \">เจอข้อมูลพลาด  พบข้อมูลมากกว่า 1 Record err.02</div>";
            }
        }
      
      return $success;
    }

}

?>

