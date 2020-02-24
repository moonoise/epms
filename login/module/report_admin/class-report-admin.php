<?php
class reportAdmin extends DbConn
{
    public function dataTablePersonReport($result,$years) {
        // $r = array();
        $d = array();
        foreach ($result as $key => $row) {
          $cpcStatus = "";
          $kpiStatus = "";
          if ($row['cpcisnotnull'] == "1") {
            $cpcStatus =  " <span class='label label-success'>สมรรถนะ<p hidden> เสร็จแล้ว </p></span> ";
          }elseif ($row['cpcisnotnull'] === 0 ||  empty($row['cpcisnotnull']) ) {
            $cpcStatus =  " <span class='label label-default'>สมรรถนะ<p hidden> ยังไม่เสร็จ </p></span> ";
          }
          if ($row['kpiisnotnull'] == "1") {
            $kpiStatus =  " <span class='label label-success'>ตัวชี้วัด<p hidden> เสร็จแล้ว </p></span> ";
          }elseif ($row['kpiisnotnull'] === 0 || empty($row['kpiisnotnull'])  ) {
            $kpiStatus =  " <span class='label label-default'>ตัวชี้วัด<p hidden> ยังไม่เสร็จ </p></span> ";
          }
        $d[] = array($row['per_cardno'],
                     $row['pn_name'].$row['per_name']." ". $row['per_surname']." ".($row['through_trial'] == 2 ? "<span class='text-warning' id='tr2-".$row['per_cardno']."'>ยังไม่ผ่านทดลองงาน</span>":"<span class='text-warning' id='tr2-".$row['per_cardno']."'> </span>" ),
                     $row['pm_name']." ".$row['position_level'],
                     $cpcStatus.$kpiStatus,
                     "<button type='button' class='btn btn-default btn-xs'
                     onclick='cpc135(`".$row['per_cardno']."`,`".$years."`)'
                     data-toggle='tooltip' 
                     data-placement='top' 
                     title='' 
                     data-original-title='แบบสรุปการประเมินผลการปฏิบัติราชการของข้าราชการ'>
                     <span class='far fa-file-pdf text-success setting-icon' aria-hidden='true'></span> 
                     ชป.135
                   </button>
                   <button type='button' class='btn btn-default btn-xs'
                     onclick='cpc135_2(`".$row['per_cardno']."`,`".$years."`)'
                     data-toggle='tooltip' 
                     data-placement='top' 
                     title='' 
                     data-original-title='แบบกำหนดและประเมินสมรรถนะสำหรับข้าราชการ '>
                     <span class='far fa-file-pdf text-success setting-icon' aria-hidden='true'></span> 
                     ชป.135/<b>2</b>
                   </button>
                   
                   <button type='button' class='btn btn-default btn-xs'
                     onclick='kpi135(`".$row['per_cardno']."`,`".$years."`)'
                     data-toggle='tooltip' 
                     data-placement='top' 
                     title='' 
                     data-original-title='แบบกำหนดและประเมินผลสัมฤทธิ์ของงาน'>
                     <span class='fab fa-kickstarter-k green setting-icon' aria-hidden='true'></span>
                     ชป.135/<b>1</b> 
                   </button>

                   "
                         );
      
        }
    
    //     echo "<pre>";
    //     print_r($result);
    //  echo "</pre>";
    // <span class='fab fa-dashcube green setting-icon' aria-hidden='true'></span> 
      if(count($d) > 0){
        $data = array('data' => $d,
                      'success' => true );
      }else{
        $data = array('success' => false );
      }
       
       return $data;
    }

  function checkScore($result,$years,$tableCPCscore) { // $cpc_accept  ฟังก์ชั่น ไว้หาว่าผ่านกี่ข้อ  โดยต้องผ่าน 1 ไปหา 2 , 3 ,4 ตามลำดับ  
    $err = "";
    $success = array();


    try {
      $sql = "SELECT CASE WHEN cpc_accept1 IS NULL OR  cpc_accept2 IS NULL OR cpc_accept3 IS NULL OR cpc_accept4 IS NULL OR cpc_accept5 IS NULL
              THEN 0 
              ELSE 1 
              END AS check_sum 
              FROM $tableCPCscore
              WHERE per_cardno = :per_cardno AND years = '$years' ";
              
      foreach ($result as $key => $value) {
        # code...
      }
     


    } catch (Exception $e) {
      $err = $e->getMessage();
    }

  }


}
// $row['pm_name'],