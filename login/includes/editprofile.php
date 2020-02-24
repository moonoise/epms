<?php
class EditProfile extends DbConn
{
    public function updateUser ($username,$fname,$lname,$address,$email,$sex,$birthday){
        try{
            
            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $query = "UPDATE ".$tbl_members
            ." SET `fname` = :fname
                  ,`lname` = :lname
                  ,`address` = :address
                  ,`email`  = :email
                  ,`sex`    = :sex
                  ,`birthday`  = :birthday
                  where `username` = :username";
            $stmt = $db->conn->prepare($query);      
            $stmt->bindParam(':fname',$fname);
            $stmt->bindParam(':lname',$lname);
            $stmt->bindParam(':address',$address);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':sex',$sex);
            $stmt->bindParam(':birthday',$birthday);
            $stmt->bindParam(':username',$username);
            $stmt->execute();
            //$stml->debugDumpParams();
            
            $err = '';

        }catch(PDOException $e){
            $err = "Error ". $e->getMessage(); 
        }

        if($err == ''){
            $success = 'true';
        }else{
            $success = $err;
        }

        return $success;

    }
    
   function groupUsersAdd($data) {
    $err = '';
    $success = array();
    try
    {
        $db = new DbConn;
        $sql = "INSERT INTO `group_users` (`id`,`group_id`,`org_id`) VALUES (:id,:group_id,:org_id)";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":id",$data['id']);
        $stm->bindParam(":group_id",$data['group_id']);
        $stm->bindParam(":org_id",$data['org_id']);
        $stm->execute();
        $success['success'] = true;
    }catch(Exception $e)
    {
        $err = "Error ". $e->getMessage(); 
    }
        if($err != '')
        {
            $success['success'] = null;
            $success['msg'] = $err;
        }
        return $success;
   }
   
   
   public function changePassword($username,$oldPassword,$newPassword1,$newPassword2) {
  
    try{
    if($newPassword1 != $newPassword2 ){
        // return "confrim password  not conrect.".$newPassword1." ".$newPassword2;
        return "confrim password  not conrect.";
        }
    
        $db = new DbConn;
        $tbl_members = $db->tbl_members;
    
        $query = "SELECT password FROM ".$tbl_members." 
                    WHERE `username` = :username ";
        $stmt = $db->conn->prepare($query);
        
        $stmt->bindParam(':username',$username);
      
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $pass_hash = new Password_Hash;

        if (!$pass_hash->verify_password_hash($oldPassword, $result['password'])) {
            return "Old Password not conrect.";
        } else {
         $passEncyt1 = $pass_hash->create_password_hash($newPassword1);
         $query = "UPDATE ".$tbl_members.
                  " SET password = :password 
                    where username = :username ";
        $stmt = $db->conn->prepare($query);
        $stmt->bindParam(':password',$passEncyt1);
        $stmt->bindParam(':username',$username);

        $stmt->execute();
         
        $err = '';

        }
        

    }catch(PDOException $e){
        $err = "Error ". $e->getMessage(); 
    }
    if($err == ''){
        $success = 'true';
    }else{
        $success = $err;
    };

    return $success;

   } 

   private $_supporttedFormats = ['image/png','image/jpeg','image/jpg','image/gif'];
   
       public function uploadFile($reName,$file,$w,$h,$crop=FALSE){
           if(is_array($file)){
               if(in_array($file['type'],$this->_supporttedFormats)){
                  move_uploaded_file($file['tmp_name'],'../../external/images_profile/'.$reName);
                   //echo 'File has been uploaded.';
                  // echo '</br>'.$genFileName;
                  return true;
               }else{
                   //die('File Format is not supported');
                   return false;
               }
           }else{
               //die('No file was uploaded!');
               return false;
           }
       }
   
       public function randomName(){
           $seed = str_split('abcdefghijklmnopqrstuvwxyz'
           .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
           .'0123456789'); 
           $rand = '';
           foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
           return $rand;
       }


       public function refreshPicture($userID){

        try{
            $db = new DbConn;
            $tbl_members = $db->tbl_members;
            $query = "select picture_profile from ".$tbl_members.
                    " where id = :userID";
            $stmt = $db->conn->prepare($query);
            $stmt->bindParam(':userID',$userID);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $err = '';
            
        }catch(PDOException $e){
            $err = "Error ". $e->getMessage(); 
        }
        if($err == ''){
            $success = $result['picture_profile'];
        }else{
            $success = $err;
        };
    
       return $success;
       }



    function uploadProfile($file,$user) {
        try{
            $err = '';

        $rd = randomName();
        $genFileName = date("Y-m-d")."-".$user."-".$rd;
        $temp = explode(".",$file['file']['name']);
        $nameNewFile = $genFileName.".".end($temp);
        $handle = new upload($file['file']);
        if ($handle->uploaded) {
          $handle->file_new_name_body   = $genFileName;
          $handle->image_resize         = true;
          $handle->image_x              = 200;
          $handle->image_ratio_y        = true;
          $handle->process('../../external/images_profile/');
          if ($handle->processed) {
           // echo 'image resized';
          $handle->clean();
            
          $db = new Dbconn;
          $tbl_members = $db->tbl_members;
          $query = "UPDATE ".$tbl_members
                  ." SET `picture_profile` = :picture 
                  where `username` = :username";
          $stmt = $db->conn->prepare($query);
          $stmt->bindParam(':picture',$nameNewFile);
          $stmt->bindParam(':username',$user);
          $stmt->execute();

          } else {
            $err = $handle->error;
            // echo 'error : ' . $handle->error;
          }
        }
            
        }catch(PDOException $e){
            $err = "Error ".$e->getMessage();
        }
        if($err ==''){
            $success = 'true';
        }else{
            $success = $err;
        }
        
        return $success;
        
    }

   

}

