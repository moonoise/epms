<?php
// Extend this class to re-use db connection
class DbConnEpp
{
    public $conn;
    public function __construct()
    {
         $this->host = "localhost"; // Host name
        $this->username = "root"; // Mysql username
        $this->password = ""; // Mysql password
        $this->db_name = "epp"; // Database name

        try {
			// Connect to server and select database.
			$this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8', $this->username , $this->password );
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (\Exception $e) {
			die('Database connection error');
		}
    }
}