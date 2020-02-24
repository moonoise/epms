<?php
// Extend this class to re-use db connection
class DbConn
{
    public $conn;
    public function __construct()
    {
        //require 'config.php';
        $this->host = $GLOBALS['db_host']; // Host name
        $this->username = $GLOBALS['db_username']; // Mysql username
        $this->password = $GLOBALS['db_password']; // Mysql password
        $this->db_name = $GLOBALS['db_name']; // Database name
        $this->tbl_prefix = $GLOBALS['tbl_prefix']; // Prefix for all database tables
        $this->tbl_members = $GLOBALS['tbl_members'];
        $this->tbl_attempts = $GLOBALS['tbl_attempts'];
        $this->tbl_module_permission = $GLOBALS['tbl_module_permission'];
        $this->tbl_page_permission = $GLOBALS['tbl_page_permission'];
        $this->tbl_groupUsers = $GLOBALS['tbl_groupUsers'];
    
        $this->tbl_per_personal = $GLOBALS['tbl_per_personal'];
        $this->tbl_cpc_score =  $GLOBALS['tbl_cpc_score'];
        $this->tbl_cpc_score_result  =  $GLOBALS['tbl_cpc_score_result'];
        $this->tbl_kpi_score =   $GLOBALS['tbl_kpi_score'];
        $this->tbl_kpi_score_result =    $GLOBALS['tbl_kpi_score_result'];
        $this->tbl_kpi_comment  =  $GLOBALS['tbl_kpi_comment'];
        $this->tbl_idp_score =  $GLOBALS['tbl_idp_score'];
        try {
			// Connect to server and select database.
			$this->conn = new PDO('mysql:host=' . $GLOBALS['db_host'] . ';dbname=' . $GLOBALS['db_name'] . ';charset=utf8', $GLOBALS['db_username'], $GLOBALS['db_password']);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\Exception $e) {
			die('Database connection error');
		}
    }
}
