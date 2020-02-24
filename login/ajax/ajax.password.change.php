<?php
session_start();

require_once '../config.php';
require_once '../includes/dbconn.php';
require_once '../includes/editprofile.php';
include_once '../includes/class.password-hash.php';
$pw = new EditProfile;
$result = $pw->changePassword($_SESSION[__USER_NAME__],$_POST['password_old'],$_POST['password1'],$_POST['password2']);


if ($result == 'true') {
    $msg['msg'] = "<div class='alert alert-success alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>ข้อมูลถูกบันทึกแล้ว!</strong>
    </div>";
} else {
    $msg['msg'] = "<div class='alert alert-danger alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>มีข้อผิดพลาดข้อมูลไม่ถูกบันทึก</strong> <small>".$result."</smail>
  </div>";
}

echo json_encode($msg);