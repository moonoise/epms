<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../../includes/editprofile.php";
    include_once "../../includes/class.password-hash.php";
  
    function checkUser($name,$email) {
        $err = '';
        try{
            
            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $sql= "select id from " .$tbl_members. " where username = :username or email = :email ";
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

      // echo $_POST['user_name']. "<br>";
    // echo $_POST['password1']. "<br>";
    // echo $_POST['password2']. "<br>";
    // echo $_POST['name']. "<br>";
    // echo $_POST['org_id']. "<br>";
    // echo $_POST['user_group']. "<br>";
    (isset($_POST['user_name'])? $user_name = $_POST['user_name'] : $user_name='' );
    (isset($_POST['password1'])? $password1 = $_POST['password1'] : $password1='' );
    (isset($_POST['password2'])? $password2 = $_POST['password2'] : $password2='' );
    (isset($_POST['name'])? $name = $_POST['name'] : $name='' );
    (isset($_POST['email'])? $email = $_POST['email'] : $email='' );
    (isset($_POST['tel'])? $tel = $_POST['tel'] : $tel='' );
    (isset($_POST['org_id'])? $org_id = $_POST['org_id'] : NULL );
    (isset($_POST['org_id_1'])? $org_id_1 = $_POST['org_id_1'] : NULL );
    (isset($_POST['org_id_2'])? $org_id_2 = $_POST['org_id_2'] : NULL );
    (isset($_POST['user_group'])? $user_group = $_POST['user_group'] : $user_group='' );
    
    if (!empty($user_name) && !empty($password1) && !empty($password2) 
        && !empty($name) && !empty($org_id) && !empty($user_group)) {
        $msg = array(); 
        $err = '';
        $s = checkUser($user_name,$email);
            
        if($s == true){    
            
            // $newid = uniqid(rand(), false);
            $nameArr = array();
            // $lname = '';
            // $nameArr = explode(" ",$name);
            // if(count($nameArr) >2){
            //     $lname = $nameArr[1]." ".$nameArr[2];
            // }elseif (count($nameArr) == 2) {
            //     $lname = $nameArr[1];
            // }
    $pass_hash = new Password_Hash;

            if ($password1 == $password2 ) {
                $passEncyt1 =$pass_hash->create_password_hash($password1);
                
                try{

                    $db = new DbConn;
                    $tbl_members = $db->tbl_members;
                    // prepare sql and bind parameters
                    $stmt = $db->conn->prepare("INSERT INTO ".$tbl_members.
                    " (id, username, password,  email, fname,  lname,  tel , org_id,  org_id_1 , org_id_2)
                    VALUES 
                      (:id,:username,:password,:email, :fname ,:lname, :tel, :org_id, :org_id_1, :org_id_2)");
                      
                    $stmt->bindParam(':id', $user_name);
                    $stmt->bindParam(':username', $user_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $passEncyt1);
                    $stmt->bindParam(':fname',$name);
                    $stmt->bindParam(':lname',$lname);
                    $stmt->bindParam(':tel',$tel);
                    $stmt->bindParam(':org_id',$org_id);
                    $stmt->bindParam(':org_id_1',$org_id_1);
                    $stmt->bindParam(':org_id_2',$org_id_2);
                    $stmt->execute();

                    // echo $org_id . "<br>";
                    // echo $org_id_1 . "<br>";
                    // echo $org_id_2 . "<br>";
                    

                    // if (!empty($org_id_2)) {
                    //     $orgID = $org_id_2;
                    // }elseif (!empty($org_id_1)) {
                    //     $orgID = $org_id_1;
                    // }elseif (!empty($org_id)) {
                    //     $orgID = $org_id;
                    // }
                
                    $tbl_groupUsers = $db->tbl_groupUsers;
                    // prepare sql and bind parameters
                    $stmt = $db->conn->prepare("INSERT INTO ".$tbl_groupUsers.
                    " (id,group_id,org_id,org_id_1,org_id_2,head_admin) VALUES (:uid,:group_id,:org_id, :org_id_1, :org_id_2,:head_admin)");
                    
                    $stmt->bindParam(':uid', $user_name);
                    $stmt->bindParam(':group_id',$user_group);
                    $stmt->bindParam(':org_id',$org_id);
                    $stmt->bindParam(':org_id_1',$org_id_1);
                    $stmt->bindParam(':org_id_2',$org_id_2);
                    $stmt->bindParam(':head_admin',$_POST['head_admin']);
                    $stmt->execute();

                }catch(Exception $e)
                {
                    $err = "Error ". $e->getMessage(); 
                }
                if ($err != '') {
                    $msg['success'] = null;
                    $msg['msg'] = $err;
                }else {
                    $msg['success'] = true;
                    $msg['msg'] = "<div class='alert alert-success' id='msg'>เพิ่ม Account ".$user_name."</div>"; 
                }

            }else{
                $msg['success'] = null; 
                $msg['msg'] = "<div class='alert alert-danger' id='msg'>Password ไม่ตรงกัน </div>";
            }
         
        }elseif($s== false){
            $msg['success'] = null;
            $msg['msg'] = "<div class='alert alert-danger' id='msg'>ไม่สามารถเพิ่มได้  User หรือ  Email อาจมีการใช้งานอยู่แล้ว หรือเคยใช้งานแล้ว</div>" ;
        }else{
            $msg['success'] = null;
            $msg['msg']= $s;
        }

    }else {
        $msg['msg'] = "<div class='alert alert-danger' id='msg'>ข้อมูลไม่ครบถ้วน</div>";
        $msg['success'] = null;
    }
   // $msg['success'] = $s;
echo json_encode($msg);
