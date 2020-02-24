<?php
class myClass extends DbConn
{
    function callYear() {  // ปีปัจจุบัน ที่จะประเมิน
        $success = array('data' => null,
                         'success' => null,
                         'msg' => null);
        
            try {
                $sql= "SELECT * FROM table_year WHERE default_status = '1' AND use_status = '1' ";
                $stm = $this->conn->prepare($sql);
                $stm->execute();
               $result =  $stm->fetchAll(PDO::FETCH_ASSOC);
                $success['data'] = $result[0];
                $success['success'] = true;

            } catch (\Exception $e) {
                $success['msg'] = $e->getMessage();
                $success['success'] = false;
            }
    
        return  $success;
        
    }

    function callYears() {  // select ปี ทุกปีที่มีในระบบ
        $success = array('data' => null,
                         'success' => null,
                         'msg' => null);
        
            try {
                $sql= "SELECT * FROM table_year WHERE   use_status = '1' ";
                $stm = $this->conn->prepare($sql);
                $stm->execute();
               $result =  $stm->fetchAll(PDO::FETCH_ASSOC);
                $success['data'] = $result;
                $success['success'] = true;

            } catch (\Exception $e) {
                $success['msg'] = $e->getMessage();
                $success['success'] = false;
            }
    
        return  $success;
        
    }

    function callYearsOld() {  // เลือกเฉพาะปีเก่า
        $success = array('data' => null,
                         'success' => null,
                         'msg' => null);
        
            try {
                $sql= "SELECT * FROM table_year WHERE   use_status = '1' AND default_status is null ";
                $stm = $this->conn->prepare($sql);
                $stm->execute();
               $result =  $stm->fetchAll(PDO::FETCH_ASSOC);
                $success['data'] = $result;
                $success['success'] = true;

            } catch (\Exception $e) {
                $success['msg'] = $e->getMessage();
                $success['success'] = false;
            }
    
        return  $success;
        
    }

    function callYearByID($id) {  // select โดยใช้ table_id
        $success = array('data' => null,
                        'success' => null,
                        'msg' => null);
        try {
            $sqlYear  = "SELECT  * FROM `table_year` WHERE table_id = :selectYears " ;
            $stmYear = $this->conn->prepare($sqlYear);
            $stmYear->bindParam(":selectYears" , $id);
            $stmYear->execute();
            $resultYear = $stmYear->fetchAll(PDO::FETCH_ASSOC);

            $success['data'] = $resultYear[0];
            $success['success'] = true;
            
        } catch (\Exception $e) {
            $success['msg'] = $e->getMessage();
            $success['success'] = false;
        }
        return  $success;

    }

}

