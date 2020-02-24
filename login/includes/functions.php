<?php
//Class Autoloader
// spl_autoload_register(function ($className) {
   
//     $className = strtolower($className);
//     $path = "includes/{$className}.php";

//     if (file_exists($path)) {

//         require_once($path);

//     }elseif (!file_exists($path)) {
//         $path = "login/includes/{$className}.php";
//         if (file_exists($path)) {
//             require_once($path);
//         }else {
//             die("The file {$className}.php could not be found.");
//             }
//     } 
// });

// function checkAttempts($username)
// {
//     try {

//         $db = new DbConn;
//         $conf = new GlobalConf;
//         $tbl_attempts = $db->tbl_attempts;
//         $ip_address = $conf->ip_address;
//         $tbl_members = $db->tbl_members;
//         $err = '';

//         $member = "SELECT * FROM ".$tbl_members." WHERE username = :username or email = :username";
//         $stmt2 = $db->conn->prepare($member);
//         $stmt2->bindParam(':username',$username);
//         $stmt2->execute();
//         $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

//         if(!empty($result2['username'])){
//             $sql = "SELECT Attempts as attempts, lastlogin ,username FROM ".$tbl_attempts." WHERE IP = :ip and Username = :username";

//             $stmt = $db->conn->prepare($sql);
//             $stmt->bindParam(':ip', $ip_address);
//             $stmt->bindParam(':username', $result2['username']);
//             $stmt->execute();
//             $result = $stmt->fetch(PDO::FETCH_ASSOC);
//             return $result;
    
//             $oldTime = strtotime($result['lastlogin']);
//             $newTime = strtotime($datetimeNow);
//             $timeDiff = $newTime - $oldTime;
//         }else {
//             $sql = "SELECT Attempts as attempts, lastlogin, username FROM ".$tbl_attempts." WHERE IP = :ip and Username = :username";

//             $stmt = $db->conn->prepare($sql);
//             $stmt->bindParam(':ip', $ip_address);
//             $stmt->bindParam(':username', $username);
//             $stmt->execute();
//             $result = $stmt->fetch(PDO::FETCH_ASSOC);
//             return $result;
    
//             $oldTime = strtotime($result['lastlogin']);
//             $newTime = strtotime($datetimeNow);
//             $timeDiff = $newTime - $oldTime;
//         }

//     } catch (PDOException $e) {

//         $err = "Error: " . $e->getMessage();

//     }

//     //Determines returned value ('true' or error code)
//     $resp = ($err == '') ? 'true' : $err;

//     return $resp;

// };

// function mySqlErrors($response)
// {
//     //Returns custom error messages instead of MySQL errors
//     switch (substr($response, 0, 22)) {

//         case 'Error: SQLSTATE[23000]':
//             echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Username or email already exists</div>";
//             break;

//         default:
//             echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>An error occurred... try again</div>";

//     }
// };
