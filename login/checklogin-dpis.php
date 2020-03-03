<?php
//DO NOT ECHO ANYTHING ON THIS PAGE OTHER THAN RESPONSE
//'true' triggers login success
session_start();
include_once 'config.php';
include_once 'includes/ociConn.php';
include_once 'includes/class.login-dpis.php';
include_once 'includes/dbconn.php';
include_once 'includes/respobj.php';
include_once "includes/class-userOnline.php";
include_once "module/myClass.php";
// Define $myusername and $mypassword
$username = $_POST['myusername'];
$password = $_POST['mypassword'];

// To protect MySQL injection
$username = stripslashes($username);
$password = stripslashes($password);

$response = '';


$loginCtl = new LoginDPIS;
$userOnline = new userOnline;
$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$per_personal = $currentYear['data']['per_personal'];

$s = "SELECT `login_status` FROM ".$per_personal." WHERE `per_cardno` = :username";
$stmStatus = $db->conn->prepare($s);

$stmStatus->bindParam(":username",$username);
$stmStatus->execute();
$resultStatus = $stmStatus->fetchAll();
$c = $stmStatus->rowCount();
if($c == 1) {
        if ($resultStatus[0]['login_status'] == 1 ) {
                $response = $loginCtl->checkLogin($username, $password,$per_personal);
                if ($response['check'] == 'true') {
        
                        
                       
                        $sql = "SELECT org_id,org_id_1,org_id_2 FROM ".$per_personal." WHERE per_cardno = :user_id";
                        $stm = $db->conn->prepare($sql);
                        $stm->bindParam(":user_id",$response['user_id']);
                        $stm->execute();
                        $result = $stm->fetchAll();
                        if (count($result) == 1)   {
                             $_SESSION[__ORG_ID__] =  $result[0]['org_id'];  
                             $_SESSION[__ORG_ID_1__] =  $result[0]['org_id_1']; 
                             $_SESSION[__ORG_ID_2__] =  $result[0]['org_id_2']; 
                        }

                        $_SESSION[__USER_ID__]   =  $response['user_id'] ;
                        $_SESSION[__USER_NAME__] = $response['username'] ;
                        $_SESSION[__EMAIL__]  = $response['email'];
                        $_SESSION[__GROUP_NAME__] = $response['group_name'];
                        $_SESSION[__GROUP_ID__]  = $response['group_id'] ;
                        $_SESSION[__F_NAME__] = $response['fname'] ;
                        $_SESSION[__L_NAME__]= $response['lname'] ;
                        $_SESSION[__PICTURE_PROFILE__] = $response['picture_profile'] ;
                        $_SESSION[__SESSION_TIME_LIFE__] = $response['session_time_life'] ;
                
                        $_SESSION[__USERONLINE__] = $userOnline->usersOnline(); //จำนวนผู้ใช้งานปัจจุบัน

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
        }elseif ($resultStatus[0]['login_status'] == 0) {
                $response['msg'] = "<div class=\"text text-danger \">ท่านไม่ใช่ผู้ที่ต้องรับการประเมิน หรือถูกระงับการประเมิน กรุณาติดต่อ admin ของสำนักงานท่าน </div>";
                $resp = new RespObj($username, $response['msg']);
                $jsonResp = json_encode($resp);
                echo $jsonResp;
        
                unset($resp, $jsonResp);
                ob_end_flush();
        }
}else {
        $response['msg'] = "<div class=\"text text-danger \">ท่านไม่ใช่ผู้ที่ต้องรับการประเมิน หรือ ท่านไม่ได้เป็นข้าราชการของกรมชลประทาน</div>";
        $resp = new RespObj($username, $response['msg']);
        $jsonResp = json_encode($resp);
        echo $jsonResp;

        unset($resp, $jsonResp);
        ob_end_flush();
}



//-------------------------------



//-------------------------------


