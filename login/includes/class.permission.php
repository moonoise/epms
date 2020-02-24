<?php
//require_once 'config.php';
//require_once 'includes/dbconn.php';

    function checkGroup($userID,$groupAllow) {
        try{
            $db = new DbConn;
            
            if(in_array(1,$groupAllow)|| in_array(2,$groupAllow)|| in_array(3,$groupAllow) ){
                $tbl_per_personal = $db->tbl_per_personal;
                $sql = "select per_type from ".$tbl_per_personal." where per_cardno = :userID";
                $stmt2 = $db->conn->prepare($sql);
                 $stmt2->bindParam(':userID',$userID);
                 $stmt2->execute();
                $result2 = $stmt2->fetchAll();
              $n = count($result2);
                if ($n == 1) {
                    $per_type = array();
                    foreach ($result2 as $row) {
                        $per_type['per_type'] = $row['per_type'];
                        unset($row);
                   }
                   return $per_type;
                }else return false;
            }else {
                $tbl_members = $db->tbl_members;
                $query = "SELECT group_id from "."group_users"
                ." where id = :id AND group_id = :groupID " ;
                $stmt = $db->conn->prepare($query);
                $stmt->bindParam(':id',$userID);
                $c = '';
                foreach ($groupAllow as $arrGroupID) {
                    $stmt->bindParam(':groupID',$arrGroupID);
                    $stmt->execute();
        
                    $totalRows = count($result = $stmt->fetchAll());
                    $c += $totalRows;
                }
                if($c == 0){
                    return false;            
                }else {
                    return true;
                }
            }
        $err = '';
        }catch(PDOException $e){
            $err = "Error: ".$e->getMessage();        
        }
        if($err != ''){
            return $err;
        }
    }

function groupUsers($idAdmin) {
    $err = '';
    $success = array();
    try
    {
        $db = new DbConn;
        $sql = "SELECT * FROM ".$db->tbl_groupUsers." WHERE id = :idAdmin";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":idAdmin",$idAdmin);
        $stm->execute();
        
        if ($stm->rowCount() == 1)  {
            $result = $stm->fetchAll();
            $success['success'] = true;
            $success['result'] = $result[0];
        }elseif ($stm->rowCount() == 0) {
            $success['success'] = false;
            $success['msg'] = "not found record.";
        }elseif ($stm->rowCount() > 1) {
            $success['success'] = false;
            $success['msg'] = "error have ".$stm->rowCount()." record";
        } 
        
    }catch(Exception $e)
    {
        $err = $e->getMessage();
    }
    if ($err != "") {
        $success['success'] = null;
        $success['msg'] = $err;
    }

    return $success;
}

function activeTime($_timeSecond,$timeLife,$redirectURL='login-dpis.php') {
    $d = new DateTime($timeLife);
    $ssT =  $d->getTimestamp();
     //echo time()-$ssT."<br>";
     //echo time();
     if(isset($ssT) && time()-$ssT > $_timeSecond){

        // unset($_SESSION[__USER_ID__])   ;
        // unset($_SESSION[__USER_NAME__]) ;
        // unset($_SESSION[__EMAIL__] );
        // unset($_SESSION[__GROUP_NAME__] );
        // unset($_SESSION[__GROUP_ID__]  );
        // unset($_SESSION[__F_NAME__] );
        // unset($_SESSION[__L_NAME__]);
        // unset($_SESSION[__PICTURE_PROFILE__] );
        // unset($_SESSION[__SESSION_TIME_LIFE__] );

        // unset($_SESSION[__ORG_ID__] ); 
        // unset($_SESSION[__ORG_ID_1__] );
        // unset($_SESSION[__ORG_ID_2__] );
        // unset($_SESSION[__USERONLINE__] );

        session_destroy();

        header('Location: ' . $redirectURL);
        die();

     }elseif ( time()-$ssT < $_timeSecond) {
       // session_start();
        $_SESSION[__SESSION_TIME_LIFE__] = date("Y-m-d H:i:s");
        //echo $_SESSION[__SESSION_TIME_LIFE__];
        
     }
}
    
// function pagePermission($userID,$groupID,$page,$redirect=true,$redirectURL='disallow.php') {
//     $err = '';
//     $c ='';
//     try{
//         $db = new DbConn;
//         $tbl_page_permission =  $db->tbl_page_permission ;
//         $query = "SELECT * FROM ".$tbl_page_permission." where (id = :userID  or group_id = :groupID) and page_name = :pageName ";
//         $stmt = $db->conn->prepare($query);
//         $stmt->bindParam(':userID',$userID);
//         $stmt->bindParam(':groupID',$groupID);
//         $stmt->bindParam(':pageName',$page);
//         $stmt->execute();

//         $result = $stmt->fetch(PDO::FETCH_ASSOC);
//         // echo $query;
//         //echo $result['page_name'];

//         if(empty($result)){
//             if ($redirect == true) {
//                 header('Location: ' . $redirectURL);
//                 die();
//             }else {
//                 return $result['msg'] = 'เกิดข้อผิดพลาด  คุณไม่สามารถใช้งานส่วนนี้ได้';
//             }
//                 //echo 'ไม่พบข้อมูล';                   
//         }elseif(!empty($result)) {
//             return $result;
//         }
//     }catch(PDOException $e){
//         $err = "Error: ".$e->getMessage();
//     }
//     if($err != ''){
//         return $err;
//     }else {
//             return $result;
//     }
// }

function ckeckLogin() {
    if (!isset($_SESSION[__USER_ID__])) {
        header("location:login-dpis.php");
    }
}

// function modulePermission($userID,$groupID,$module){
//         $err = '';

//         try{
//             $db = new DbConn;
//             $tbl_module_permission = $db->tbl_module_permission;
//             $query = 'SELECT * FROM '.$tbl_module_permission.' WHERE (id = :UserID or group_id = :groupID ) AND module = :module' ;
//             $stmt = $db->conn->prepare($query);
//             $stmt->bindParam(':userID',$userID);
//             $stmt->bindParam(':groupID',$module);
//             $stmt->bindParam(':module',$module);
//             $stmt->execute();
            
//             $totalRows = count($result = $stmt->fetchAll());
//             $c += $totalRows;


//         }catch(PDOException $e){
//             $err = "Error: ".$e->getMessage();
//         }
//         if ($err != '') {
//             return $err;
//         }else{
//             if($c == 0){
//                 return false;
//             }else{
//                 return $result;
//             }
//         }       
// }

function logout() {

    unset($_SESSION[__USER_ID__])   ;
    unset($_SESSION[__USER_NAME__]) ;
    unset($_SESSION[__EMAIL__] );
    unset($_SESSION[__GROUP_NAME__] );
    unset($_SESSION[__GROUP_ID__]  );

    unset($_SESSION[__ADMIN_ORG_ID_1__]);
    unset($_SESSION[__ADMIN_ORG_ID_2__]);
    unset($_SESSION[__ADMIN_ORG_ID__]);

    unset($_SESSION[__F_NAME__] );
    unset($_SESSION[__L_NAME__]);
    unset($_SESSION[__PICTURE_PROFILE__] );
    unset($_SESSION[__SESSION_TIME_LIFE__] );

    unset($_SESSION[__ORG_ID__] ); 
    unset($_SESSION[__ORG_ID_1__] );
    unset($_SESSION[__ORG_ID_2__] );
    unset($_SESSION[__USERONLINE__] );
    unset($_SESSION[__EVALUATION_ON_OFF__]);
    
    // session_destroy();
    

    header('Location: ' . 'login-dpis.php');
    die();

}


function logout_all() {
    session_destroy();
    header('Location: ' . 'login-dpis.php');
    die();
}

