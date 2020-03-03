<?php
//DO NOT ECHO ANYTHING ON THIS PAGE OTHER THAN RESPONSE
//'true' triggers login success
ob_start();
include 'config.php';
include_once 'includes/ociConn.php';
include_once 'includes/dbconn.php';
include_once 'includes/respobj.php';
include_once 'includes/loginform.php';

include_once "includes/class.password-hash.php";
include_once "includes/class-userOnline.php";
include_once "module/myClass.php";

// Define $myusername and $mypassword
$username = $_POST['myusername'];
$password = $_POST['mypassword'];

// To protect MySQL injection
$username = stripslashes($username);
$password = stripslashes($password);

$response = '';
$loginCtl = new LoginForm;

$userOnline = new userOnline;
$db = new DbConn;

$myClass = new myClass;
$currentYear = $myClass->callYear();
$per_personal = $currentYear['data']['per_personal'];

//-------------------------------
$response = $loginCtl->checkLogin($username, $password);

if ($response['check'] == 'true') {
  
        session_start();
        $_SESSION[__USER_ID__]   =  $response['user_id'] ;
        $_SESSION[__USER_NAME__] = $response['username'] ;
        $_SESSION[__EMAIL__]  = $response['email'];
        $_SESSION[__GROUP_NAME__] = $response['group_name'];
        $_SESSION[__GROUP_ID__]  = $response['group_id'] ;
        $_SESSION[__ADMIN_ORG_ID__]  = $response['admin_org_id'] ;
        $_SESSION[__ADMIN_ORG_ID_1__]  = $response['admin_org_id_1'] ;
        $_SESSION[__ADMIN_ORG_ID_2__]  = $response['admin_org_id_2'] ;
        $_SESSION[__F_NAME__] = $response['fname'] ;
        $_SESSION[__L_NAME__]= $response['lname'] ;
        $_SESSION[__PICTURE_PROFILE__] = $response['picture_profile'] ;
        $_SESSION[__SESSION_TIME_LIFE__] = $response['session_time_life'] ;
        $_SESSION[__ORG_ID__] = $response['org_id'];
                     

        $_SESSION[__USERONLINE__] = $userOnline->usersOnline();  //จำนวนผู้ใช้งานปัจจุบัน

        $sqlConfig = "SELECT `config_value` FROM `config` WHERE `config_name` = 'evaluation_on_off' ";
        $stm2 = $db->conn->prepare($sqlConfig);
        $stm2->execute();
        $result2 = $stm2->fetchAll();
        if($result2[0]['config_value'] == "1" ){
                $_SESSION[__EVALUATION_ON_OFF__] = "";
        }elseif ($result2[0]['config_value'] == "0") {
                $_SESSION[__EVALUATION_ON_OFF__] = "disabled";
        }



        $resp = new RespObj($username, $response['check']);
        $jsonResp = json_encode($resp);
        echo $jsonResp;

}else {
    
        $resp = new RespObj($username, $response['msg']);
        $jsonResp = json_encode($resp);
        echo $jsonResp;
}
unset($resp, $jsonResp);
ob_end_flush();

//-------------------------------


