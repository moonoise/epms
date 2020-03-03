<?php
//require_once 'config.php';
//require_once 'includes/dbconn.php';

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
    


function ckeckLogin() {
    if (!isset($_SESSION[__USER_ID__])) {
        header("location:login-dpis.php");
    }
}


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

