<?php
    include_once 'config.php';
    include_once "includes/dbconn.php";
    include_once 'includes/class.permission.php';
    include_once "includes/class-userOnline.php";

    session_start();
    $userOnline = new userOnline;
    $userOnline->delete_user_now();
    logout_all();