<?php
//PUT THIS HEADER ON TOP OF EACH UNIQUE PAGE
session_start();
if (!isset($_SESSION[__USER_ID__])) {
    header("location:main_login.php");
}

include_once('config.php');