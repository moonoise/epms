<?php
session_start();
@include_once '../config.php';
$msg['url'] = $_SESSION[__PICTURE_PROFILE__];
echo json_encode($msg);
