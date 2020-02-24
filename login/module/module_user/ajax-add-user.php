<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../../includes/editprofile.php";
    include_once "../../includes/class.password-hash.php";
    
    $dbAddMembers = new DbConn;
    $dbGroup_users = new DbConn;
    $pass_hash = new Password_Hash;
    $codeAddMembers = null;
    $codeGroup_users = null;
    $messageAddMembers = null;
    $messageGroup_users = null;

    ($_POST['org_id'] !="" ? $org_id = $_POST['org_id'] : NULL );
    ($_POST['org_id_1'] !="" ? $org_id_1 = $_POST['org_id_1'] : NULL );
    ($_POST['org_id_2']!="" ? $org_id_2 = $_POST['org_id_2'] : NULL );

    function checkUser($name,$email) {
        $db = new DbConn;
        $err = '';
        try{
            $sql= "select id from " .$db->tbl_members. " where id = :username or email = :email ";
            $queryResult = $db->conn->prepare($sql);
            $queryResult->bindParam(':username',$name);
            $queryResult->bindParam(':email',$email);
            $queryResult->execute();
            
            if($queryResult->fetchColumn()){
                $success = false;
            }else {
                $success = true;
            }
        }catch(PDOException $e){
            $err = "Error: " . $e->getMessage();
        }

        if($err != ''){
             $success = $err;
        }

        return $success;

    }


$s = checkUser($_POST['username_new'],$_POST['email_new']);
            
        if($s === true){    
                   
            $nameArr = array();

    

            if ($_POST['password'] == $_POST['password_confirm'] ) {
                $passEncyt1 =$pass_hash->create_password_hash($_POST['password']);
                
                try{
                
                    $sql_dbAddMembers  = "INSERT INTO ".$tbl_members.
                    " (id, username, password,  email, fname,  lname,  phone, phone_org , org_id,  org_id_1 , org_id_2)
                    VALUES 
                      (:id,:username,:password,:email, :fname ,:lname,  :phone, :phone_org , :org_id,  :org_id_1 , :org_id_2)"; 

                    $stm_dbAddMembers = $dbAddMembers->conn->prepare($sql_dbAddMembers);
                    $stm_dbAddMembers->bindParam(":id",$_POST['username_new']);
                    $stm_dbAddMembers->bindParam(":username",$_POST['username_new']);

                    $stm_dbAddMembers->bindParam(":password",$passEncyt1);
                    $stm_dbAddMembers->bindParam(":email",$_POST['email_new']);
                    $stm_dbAddMembers->bindParam(":fname",$_POST['first_name']);
                    $stm_dbAddMembers->bindParam(":lname",$_POST['last_name']);

                    $stm_dbAddMembers->bindParam(":phone",$_POST['phone']);
                    $stm_dbAddMembers->bindParam(":phone_org",$_POST['phone_org']);
                    $stm_dbAddMembers->bindParam(":org_id",$org_id);
                    $stm_dbAddMembers->bindParam(":org_id_1",$org_id_1);
                    $stm_dbAddMembers->bindParam(":org_id_2",$org_id_2);

                    $stm_dbAddMembers->execute();
                    
                }catch(\Exception  $e)
                {
                    $codeAddMembers =  $e->getCode();
                    $messageAddMembers = $e->getMessage();  

                }

                try {
                    $sql_dbGroup_users = "INSERT INTO `".$tbl_groupUsers."`   
                        (id,group_id,org_id,org_id_1,org_id_2,head_admin) 
                        VALUES 
                        (:id,:group_id,:org_id, :org_id_1, :org_id_2,:head_admin) ";
                    $stm_dbGroup_users = $dbGroup_users->conn->prepare($sql_dbGroup_users);
                    $stm_dbGroup_users->bindParam(":id",$_POST['username_new']);
                    $stm_dbGroup_users->bindParam(":group_id",$_POST['user_group']);
                    $stm_dbGroup_users->bindParam(":org_id",$org_id);
                    $stm_dbGroup_users->bindParam(":org_id_1",$org_id_1);
                    $stm_dbGroup_users->bindParam(":org_id_2",$org_id_2);
                    $stm_dbGroup_users->bindParam(":head_admin",$_POST['head_admin']);

                    $stm_dbGroup_users->execute();

                }catch (\Exception $e) {
                    $codeGroup_users =  $e->getCode();
                    $messageGroup_users = $e->getMessage();  
                }
              
                if ($codeAddMembers != null || $codeGroup_users != null) {
                    
                    $msg['success'] = null; 
                    $msg['msg'] = "<br>".$messageAddMembers."<br>".$messageGroup_users;

                }else {

                    $msg['success'] = true; 
                    $msg['msg'] = "OK";
                }

            }else{
                $msg['success'] = null; 
                $msg['msg'] = "password ไม่ตรงกัน";
            }
         
        }elseif($s== false){
            $msg['success'] = null;
            $msg['msg'] = "ไม่สามารถเพิ่มได้  User หรือ  Email อาจมีการใช้งานอยู่แล้ว หรือเคยใช้งานแล้ว" ;
        }else{
            $msg['success'] = null;
            $msg['msg']= $s;
        }

   
echo json_encode($msg);
