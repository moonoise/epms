<?php
session_start();

require_once '../config.php';
require_once '../includes/dbconn.php';
require_once '../includes/editprofile.php';
require_once '../includes/class.upload.php';

try{
    $err = '';
    $fileUpload = new EditProfile;
$rd = $fileUpload->randomName();
$genFileName = date("Y-m-d")."-".$_SESSION[__USER_NAME__]."-".$rd;
$temp = explode(".",$_FILES['file']['name']);
$nameNewFile = $genFileName.".".end($temp);
$handle = new upload($_FILES['file']);
if ($handle->uploaded) {
  $handle->file_new_name_body   = $genFileName;
  $handle->image_resize         = true;
  $handle->image_x              = 200;
  $handle->image_ratio_y        = true;
  $handle->process('../../external/images_profile/');
  if ($handle->processed) {
   // echo 'image resized';
  $handle->clean();

  } else {
    $success = $handle->error;
    // echo 'error : ' . $handle->error;
  }
}


    $db = new Dbconn;
    $tbl_members = $db->tbl_members;
    $query = "UPDATE ".$tbl_members
            ." SET `picture_profile` = :picture 
            where `username` = :username";
    $stmt = $db->conn->prepare($query);
    $stmt->bindParam(':picture',$nameNewFile);
    $stmt->bindParam(':username',$_SESSION[__USER_NAME__]);
    $stmt->execute();

    $_SESSION[__PICTURE_PROFILE__] = $nameNewFile;
}catch(PDOException $e){
    $err = "Error ".$e->getMessage();
}
if($err ==''){
    $success = 'true';
}else{
    $success = $err;
}

$form_data['success'] = $success;

echo json_encode($form_data);





