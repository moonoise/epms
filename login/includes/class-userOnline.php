<?php

@include_once "config.php";
@include_once "includes/dbconn.php";

class userOnline extends DbConn 
{
	var $count = 0;
	var $error =  array();
    var $i = 0;
    function usersOnline () {
        $this->per_cardno = $_SESSION[__USER_ID__];
        
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
		return $this->count_users();
    }
    
    function ipCheck() {
        /*
        This function will try to find out if user is coming behind proxy server. Why is this important?
        If you have high traffic web site, it might happen that you receive lot of traffic
        from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
        This function tryes to get real IP address.
        Note that getenv() function doesn't work when PHP is running as ISAPI module
        */
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            }
            elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            }
            elseif (getenv('HTTP_X_FORWARDED')) {
                $ip = getenv('HTTP_X_FORWARDED');
            }
            elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
            }
            elseif (getenv('HTTP_FORWARDED')) {
                $ip = getenv('HTTP_FORWARDED');
            }
            else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }


        function new_user() {
            // $insert = mysql_query ("INSERT INTO useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
            $err = "";
            try{
                $sql = "INSERT INTO useronline (`timestamp`,`per_cardno_ip`) 
                        VALUES (:user_timestamp ,
                                :per_cardno_ip  )";
                $per_cardno_ip = $this->per_cardno."-".$this->ip;
                // echo $per_cardno_ip;
                $stm = $this->conn->prepare($sql);
                $stm->bindParam(":user_timestamp",$this->timestamp);
                $stm->bindParam(":per_cardno_ip" , $per_cardno_ip);
                $stm->execute();
                $result = $stm->fetchAll();
                
            }catch(Exception $e){
                $err = $e->getMessage();
            }
            if ($err != '') {
                $this->error[$this->i] = "insert Error";
                //  echo $err;
            }else {
                $this->i++;
            }
            
        }
        
        function delete_user() {
            $err = "";
            $timeout = $GLOBALS['login_timeout'];
            try{
                $sql = "DELETE FROM useronline WHERE timestamp < (:user_timestamp - :user_timeout)";
                $stm = $this->conn->prepare($sql);
                $stm->bindParam(":user_timestamp",$this->timestamp);
                $stm->bindParam(":user_timeout" , $timeout);
                $stm->execute();
                
            }catch(Exception $e){
                $err = $e->getMessage();
            }
            if ($err != '') {

                $this->error[$this->i] = "delete Error";
                // echo $err;
                
            }else {
                $this->i++;
            }
        }
        
        function count_users() {
            $err = "";
            try{
                $sql = "SELECT DISTINCT per_cardno_ip FROM useronline WHERE `per_cardno_ip` NOT LIKE '-%' ";
                $stm = $this->conn->prepare($sql);
                $stm->execute();
                $count = $stm->rowCount();
                
            }catch(Exception $e){
                $err = $e->getMessage();
            }
            if ($err != '') {

                $this->error[$this->i] = "count Error";
                
            }else {
                return $count;
            }
        }

        function delete_user_now() {
            $err = "";
            try{
                $this->per_cardno = $_SESSION[__USER_ID__];
                $this->ip = $this->ipCheck();
                $per_cardno_ip = $this->per_cardno."-".$this->ip;

                $sql = "DELETE FROM useronline WHERE per_cardno_ip = :per_cardno_ip";
                $stm = $this->conn->prepare($sql);
                $stm->bindParam(":per_cardno_ip" , $per_cardno_ip);
                $stm->execute();
                
            }catch(Exception $e){
                $err = $e->getMessage();
            }
            if ($err != '') {
                $this->error[$this->i] = "delete Error";
                //  echo $err;
            }else {
                $this->i++;
            }
        }


}
