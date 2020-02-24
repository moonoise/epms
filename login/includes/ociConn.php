<?php
    class ociConn 
    {
        public function ociConnect() {
             
        $ociConn = oci_connect($GLOBALS['ociUser'] , $GLOBALS['ociPass'], $GLOBALS['ociHost'] . "/" . $GLOBALS['ociTNS'] , 'AL32UTF8');
        if (!$ociConn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $ociConn;
            
        }
    }
    


 
