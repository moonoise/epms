<?php
class LoginForm extends DbConn
{
    public function checkLogin($myusername, $mypassword)
    {
  

        try {

            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        $stmt = $db->conn->prepare("SELECT `members`.`id`,
        `$tbl_members`.`username`,
        `$tbl_members`.`password`,
        `$tbl_members`.`fname`,
        `$tbl_members`.`lname`,
        `$tbl_members`.`email`,
        `$tbl_members`.`picture_profile`,
        `$tbl_members`.`verified`,
        `$tbl_members`.`status_user`,
        `group_users`.`group_id`,
        `group_users`.`org_id`,
        `group_users`.`org_id_1`,
        `group_users`.`org_id_2`,
        `member_groups`.*
         FROM ".$tbl_members." 
         LEFT JOIN `group_users` ON `".$tbl_members."`.`id` = `group_users`.`id` 
         LEFT JOIN `member_groups`
         ON `member_groups`.`group_id` = `group_users`.`group_id` WHERE `$tbl_members`.`username` = :myusername or `$tbl_members`.`email` = :myusername  ");
        
        $stmt->bindParam(':myusername', $myusername);
        $stmt->execute();

        // Gets query result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pass_hash = new Password_Hash;
             //If max attempts not exceeded, continue
            // Checks password entered against db password hash
            if ($pass_hash->verify_password_hash($mypassword, $result['password']) && $result['status_user'] == 1) {
                
                $base_url = __PATH_WEB__.'/external/images_profile/';

                //Success! Register $myusername, $mypassword and return "true"
                $success['check'] = 'true';
                $datetimeNow = date("Y-m-d H:i:s");
                $success['user_id'] = $result['id'];
                $success['username'] = $result['username'];
                $success['email'] = $result['email'];
                $success['group_name'] = $result['group_name'];
                $success['group_id'] = $result['group_id'];
                $success['admin_org_id'] = $result['org_id'];
                $success['admin_org_id_1'] = $result['org_id_1'];
                $success['admin_org_id_2'] = $result['org_id_2'];
                $success['fname'] = $result['fname'];
                $success['lname'] = $result['lname'];
                $success['picture_profile'] = $base_url.(!empty($result['picture_profile'])?$result['picture_profile'] : "user.png");
                $success['session_time_life'] = $datetimeNow;
                $success['org_id'] = $result['org_id'];    
                    
            } elseif ($pass_hash->verify_password_hash($mypassword, $result['password'])  && $result['status_user'] == 0) {

                //Account not yet verified
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>สถานะบัญชี ยังใช้ไม่ได้ หรือถูกระงับไปแล้ว โปรดติดต่อเจ้าหน้าที่</div>";

            } else {

                //Wrong username or password
                $success['check'] = 'false';
                $success['msg'] = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Wrong Username or Password (คุณใส่ user password ไม่ถูก)</div>";

            }
           // echo $success['check'];
        return $success;
    }

}
