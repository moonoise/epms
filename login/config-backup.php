<?php
date_default_timezone_set("Asia/bangkok");
// DATABASE CONNECTION VARIABLES


$db_host = ""; // Host name
$db_username = "root"; // Mysql username
$db_password = ""; // Mysql password
$db_name = ""; // Database name

$GLOBALS['ociUser'] = '';
$GLOBALS['ociPass'] = '';
$GLOBALS['ociHost'] = '';
$GLOBALS['ociTNS'] = '';

//path รูปภาพใน dpis 
// define("__PATH_PICTURE__","http://localhost/php-login/external/pic_personal/");
define("__PATH_PICTURE__", "http://epm.rid.go.th/external/pic_personal/");

//path   เว็บ  
define("__PATH_WEB__", "http://localhost:8091/epm");  // ห้ามมี / ปิดท้าย 
//  define("__PATH_WEB__","http://epm.rid.go.th");



//Set this for global site use
$site_name = 'ระบบ Epms ';


//set Active time out
$login_timeout = 3 * 3600;



$tbl_members = "members";
$tbl_attempts = "loginAttempts";
$tbl_groupUsers = "group_users";
$tbl_membersGroups = "member_groups";


$session_prefix = 'epms_';
define("__USER_ID__", $session_prefix . "user_id");
define("__USER_NAME__", $session_prefix . "username");
define("__EMAIL__", $session_prefix . "email");
define("__GROUP_NAME__", $session_prefix . "group_name");
define("__GROUP_ID__", $session_prefix . "group_id");
define("__ADMIN_ORG_ID__", $session_prefix . "admin_org_id");
define("__ADMIN_ORG_ID_1__", $session_prefix . "admin_org_id_1");
define("__ADMIN_ORG_ID_2__", $session_prefix . "admin_org_id_2");
define("__F_NAME__", $session_prefix . "fname");
define("__L_NAME__", $session_prefix . "lname");
define("__PICTURE_PROFILE__", $session_prefix . "picture_profile");
define("__SESSION_TIME_LIFE__", $session_prefix . "session_time_life");

define("__ORG_ID__", $session_prefix . "org_id");
define("__ORG_ID_1__", $session_prefix . "org_id_1");
define("__ORG_ID_2__", $session_prefix . "org_id_2");

define("__USERONLINE__", $session_prefix . "userOnline");

define("__EVALUATION_ON_OFF__", $session_prefix . "evaluation_on_off");

$cpcType = array(
    '1' => 'สมรรถนะหลัก (Core Competency)',
    '2' => 'สมรรถนะทางการบริหาร (Managerial Competency)',
    '3' => 'สมรรถนะเฉพาะตามลักษณะงานที่ปฏิบัติ (Functional Competency)',
    '4' => 'ความรู้ที่ใช้ในการปฎิบัติงาน (Knowledge)',
    '5' => 'ความรู้ด้านกฎหมาย (Knowledge of Laws)',
    '6' => 'ทักษะ (Skills)'
);

$kpiType = array(
    '1' => 'กลยุทธ์',
    '2' => 'ประจำ',
    '3' => 'พิเศษ'
);

$kpi_type_text  = array(
    1 => 'รายเดือน',
    2 => 'เชิงร้อยละ',
    3 => 'ใส่คะแนน'
);

$grade  = array(
    'A' => "ดีเด่น",
    'B' => "ดีมาก",
    'C' => "ดี",
    'D' => "พอใช้",
    'F' => "ต้องปรับปรุง",
    "Error" => "ไม่สามารถตัดเกรดได้"
);
