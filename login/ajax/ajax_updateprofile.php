<?php
session_start();
require_once '../config.php';
require_once '../includes/dbconn.php';
require_once '../includes/editprofile.php';

$username = $_SESSION[__USER_NAME__];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$email = $_POST['email'];
$sex = $_POST['sex'];
$birthday = $_POST['birthday'];


$updateP = new EditProfile;
$ck = $updateP->updateUser($username,$fname,$lname,$address,$email,$sex,$birthday);
$form_data['success'] = $ck;


if ($ck = 'true') {
    $form_data['msg'] = "<div class='alert alert-success alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>ข้อมูลถูกบันทึกแล้ว!</strong>
    </div>";
} else {
    $form_data['msg'] = "<div class='alert alert-danger alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>มีข้อผิดพลาดข้อมูลไม่ถูกบันทึก</strong> 
  </div>";
}

echo json_encode($form_data);

