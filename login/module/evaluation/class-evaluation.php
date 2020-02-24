<?php
class evaluation extends DbConn
{
    function cpcQueryScore($per_cardno,$year_term,$cpcScoreTable) {
        
        $r = array("success"=> null,
                    "data" => null,
                    "msg"=> null);
        try {
           $sql = "select cpc_score1,
                            cpc_score2,
                            cpc_score3,
                            cpc_score4,
                            cpc_score5,
                            cpc_score_id
            FROM $cpcScoreTable WHERE per_cardno = :per_cardno AND years = :years_term" ;

           $stm = $this->conn->prepare($sql);
           $stm->bindParam(":per_cardno",$per_cardno);
           $stm->bindParam(":years_term",$year_term);
           $stm->execute();
           $r["data"] = $stm->fetchAll(PDO::FETCH_ASSOC);
           $r['success'] = true;
           return $r;
        } catch (\Exception $e) {
            $r['msg'] = $e->getMessage();
            return $r;
        }

    }

    function cpcUpdateScoreAccept($cpcScoreTable,$CPCscore) {  // ยืนยันตามผู้ประเมินตนเอง ทั้งหมด
        $r = array("CPCsuccess"=> null,
                    "cpc_score_id" => null,
                    "msg"=> null);
        try {
            $sqlUpdate = "UPDATE $cpcScoreTable SET cpc_accept1 = :cpc_accept1,
                                                    cpc_accept2 = :cpc_accept2,
                                                    cpc_accept3 = :cpc_accept3,
                                                    cpc_accept4 = :cpc_accept4,
                                                    cpc_accept5 = :cpc_accept5,
                                                    cpc_comment1 = NULL,
                                                    cpc_comment2 = NULL,
                                                    cpc_comment3 = NULL,
                                                    cpc_comment4 = NULL,
                                                    cpc_comment5 = NULL
                         WHERE cpc_score_id = :cpc_score_id";
            $stm = $this->conn->prepare($sqlUpdate);
            $stm->bindParam(":cpc_accept1",$CPCscore['cpc_score1']);
            $stm->bindParam(":cpc_accept2",$CPCscore['cpc_score2']);
            $stm->bindParam(":cpc_accept3",$CPCscore['cpc_score3']);
            $stm->bindParam(":cpc_accept4",$CPCscore['cpc_score4']);
            $stm->bindParam(":cpc_accept5",$CPCscore['cpc_score5']);
            $stm->bindParam(":cpc_score_id",$CPCscore['cpc_score_id']);
            $stm->execute();
            $r['CPCsuccess'] = true;
            $r['cpc_score_id'] = $CPCscore['cpc_score_id'];
            return $r;
        } catch (\Exception $e) {
            $r['cpc_score_id'] = $CPCscore['cpc_score_id'];
            $r['msg'] = $e->getMessage();
            return $r;
        } 
    }

    function kpiAcceptUpdate($kpiScoreTable,$year_term,$per_cardno,$kpi_accept) {  // update ให้ผู้บังดับบัญชายื่นยัน ทุกข้อ
        $r = array("KPIsuccess"=> null,
                    "per_cardno"=> null,
                    "msg"=> null);

        try {
            $sqlUpdate = "UPDATE $kpiScoreTable SET `kpi_accept` = :v  WHERE per_cardno = :per_cardno AND years = :years ";
            $stm = $this->conn->prepare($sqlUpdate);
            $stm->bindParam(":v",$kpi_accept);
            $stm->bindParam(":per_cardno",$per_cardno);
            $stm->bindParam(":years",$year_term);
            $stm->execute();
            $r['KPIsuccess'] = true;
            $r['per_cardno'] = $per_cardno;
            return $r;
        } catch (\Exception $e) {
            $r['per_cardno'] = $per_cardno;
            $r['msg'] = $e->getMessage();
            return $r;
        }
    }

    function kpiJoinComment($kpiScoreTable,$kpiScoreComment,$year_term,$per_cardno) {
        $r = array("success"=> null,
                    "data"=> null,
                    "msg"=> null);
        try {
            $sql = "SELECT * FROM $kpiScoreTable 
                    INNER JOIN $kpiScoreComment 
                        ON  $kpiScoreTable.kpi_score_id = $kpiScoreComment.kpi_score_id 
                    WHERE per_cardno = :per_cardno AND years = :years " ;

            $stm = $this->conn->prepare($sql);
            $stm->bindParam(':per_cardno' , $per_cardno);
            $stm->bindParam(':years',$year_term);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            
            $r['success'] = true;
            $r['data'] = $result;
            return $r;
        } catch (\Exception $e) {
            $r['msg'] = $e->getMessage();
            return $r;
        }
    }


    function getTableYear($year_term) {
        $r = array("success"=> null,
                    "data" => null,
                    "msg"=> null);
        try {
            $sql_years = "SELECT * FROM `table_year` WHERE `table_year`.`table_year` = :years ";
            $stmYears = $this->conn->prepare($sql_years);
            $stmYears->bindParam(':years',$year_term);
            $stmYears->execute();
            $r['data'] = $stmYears->fetchAll(PDO::FETCH_ASSOC);
            $r['success'] = true;
            return $r ;
        } catch (\Exception $e) {
            $r['msg'] = $e->getMessage();
            return $r;
        }
       
    }

    function sum_cpc_kpi($CPCscore,$KPIscore,$cpc_ratio,$kpi_ratio) {
        return ($CPCscore * ($cpc_ratio / 100) ) + ( $KPIscore * ($kpi_ratio / 100) ) ;
    }
}
