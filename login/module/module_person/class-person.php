<?php 

// @include_once "../../config.php";
// @include_once "../../includes/dbconn.php";
// @include_once "../report/class-report.php";
class person extends DbConn 
{
  function OrgArrange($orgID) {
    $err = "";
    $success = array();
    $org = array();
    try
    {
      for ($i=0; $i < 3; $i++) { 
       
        $sql = "SELECT `org_id`,`org_name`,`org_id_ref` FROM per_org WHERE org_id = :org_id";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":org_id",$orgID);
        $stm->execute();
        $r = $stm->fetchAll();

        if ((count($r)) == 1 ) {
            $org[] = $r[0];
            $orgID = $r[0]['org_id_ref'];
        }
      }
    }catch(Exception $e){
      $err = $e->getMessage();
    }
    if ($err != '') {
      $success['success'] = null;
      $success['msg'] = $err;
    }else {
      $success['success'] = true;
      $success['msg'] = 'ok';
      $success['result'] = $org;
    }
    return $success;
  } 


  function OrgAdd($per_cardno,$data) {
    $err = "";
    $success = array();
    $r = '';
    try
    {
      $sqlInsert = "UPDATE ".$this->tbl_per_personal." SET 
                    `org_id` = :org_id,
                    `org_name` = :org_name,
                    `org_id_1` = :org_id_1,
                    `org_name1` = :org_name1,
                    `org_id_2` = :org_id_2,
                    `org_name2` = :org_name2 
                    WHERE per_cardno = :per_cardno";
      $stm = $this->conn->prepare($sqlInsert);
      $stm->bindParam(":per_cardno",$per_cardno);
      switch (count($data)) {
        case 1:
            $stm->bindParam(":org_id",$data[0]['org_id']);
            $stm->bindParam(":org_name",$data[0]['org_name']);
            
            $stm->bindValue(":org_id_1",null);
            $stm->bindValue(":org_name1",null);

            $stm->bindValue(":org_id_2",null);
            $stm->bindValue(":org_name2",null);
            $r .= $data[0]['org_name'];
          break;
        case 2:
            $stm->bindParam(":org_id",$data[1]['org_id']);
            $stm->bindParam(":org_name",$data[1]['org_name']);

            $stm->bindParam(":org_id_1",$data[0]['org_id']);
            $stm->bindParam(":org_name1",$data[0]['org_name']);

            $stm->bindValue(":org_id_2",null);
            $stm->bindValue(":org_name2",null);
            $r .= $data[1]['org_name']."->".$data[0]['org_name'];
          break;
        case 3:
            $stm->bindParam(":org_id",$data[2]['org_id']);
            $stm->bindParam(":org_name",$data[2]['org_name']);

            $stm->bindParam(":org_id_1",$data[1]['org_id']);
            $stm->bindParam(":org_name1",$data[1]['org_name']);

            $stm->bindParam(":org_id_2",$data[0]['org_id']);
            $stm->bindParam(":org_name2",$data[0]['org_name']);

            $r .= $data[2]['org_name']."->".$data[1]['org_name']."->".$data[0]['org_name'];
          break;
        default:
      }

       $stm->execute();

    }catch(Exception $e)
    {
      $err = $e->getMessage();
    }

    if ($err != '') {
      $success['success'] = null;
      $success['msg'] = $err;
    }else {
      $success['success'] = true;
      $success['msg'] = 'ok';
      $success['result'] = $r;
    }
    return $success;

  }

// ใช้กับไฟล์ ajax-modal-move_person-show.php
  function personSelect($per_cardno) {
    $err = "";
    $success = array();
    try
    {
        $sql = "SELECT * FROM ".$this->tbl_per_personal." WHERE per_cardno = :per_cardno ";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":per_cardno",$per_cardno);
        $stm->execute();

        $r = $stm->fetchAll();

    }catch(Exception $e)
    {
      $err = $e->getMessage();
    }
    if (count($r) > 0) {
      $success['success'] = true;
      $success['msg'] = count($r).' record';
      $success['result'] = $r ;
    }

    return $success;
  }

  function dataTable($result,$eva) {
    // $r = array();
    $d = array();
    foreach ($result as $key => $row) {
      // $pm_pl = (strcmp($row['pm_name'],$row['pl_name'])) ?$row['pm_name']." ".$row['pl_name']  : $row['pm_name'] ;

    $d[] = array($row['per_cardno'],
                 $row['pn_name'].$row['per_name']." ". $row['per_surname']." ".($row['through_trial'] == 2 ? "<span class='text-warning' id='tr2-".$row['per_cardno']."'>ยังไม่ผ่านทดลองงาน</span>":"<span class='text-warning' id='tr2-".$row['per_cardno']."'> </span>" ),
                 $row['pm_name']." ".$row['position_level'],
                 "<button type='button' class='btn btn-default btn-xs'
                 onclick='cpcChange(`".$row['per_cardno']."`,`".$row['pl_code']."`,`".$row['level_no']."`,`".$row['per_name']." ".$row['per_surname']."`)' 
                 data-toggle='tooltip' 
                 data-placement='top' 
                 title='' 
                 data-original-title='รายการสมรรถนะ'>
                 <span class='fa fa-graduation-cap green setting-icon' aria-hidden='true'></span>
                 <span class='fa fa-list-ol text-success setting-icon' aria-hidden='true'></span> 
               </button>
               
               <button type='button' class='btn btn-default btn-xs'
                    onclick='kpiChange(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`,`".$row['org_id']."`)' 
                    data-toggle='tooltip' 
                    data-placement='top' 
                    title='' 
                    data-original-title='รายการตัวชี้วัด'>
                    <span class='fa fa-male text-success setting-icon' aria-hidden='true'></span>
                    <span class='fa fa-list-ol setting-icon' aria-hidden='true'></span> 
                </button>

                <button type='button' class='btn btn-default btn-xs'
                    onclick='movePerson(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`)' 
                    data-toggle='tooltip' 
                    data-placement='top' 
                    title='' 
                    data-original-title='ย้ายบุคลากร'>
                    <span class='fa fa-user text-success setting-icon' aria-hidden='true'></span>
                    <span class='fa fa-exchange setting-icon' aria-hidden='true'></span>
                    <span class='fa fa-university blue setting-icon' aria-hidden='true'></span> 
              </button>

                    <button type='button' class='btn btn-default btn-xs' 
                        onclick='settingHead(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`),
                                            subordinateShow(`".$row['per_cardno']."`),
                                            personHead_show(`".$row['org_id']."`,`".$row['org_id_1']."`,`".$row['org_id_2']."`,`".$row['per_cardno']."`)'
                        data-toggle='tooltip' 
                        data-placement='top' 
                        title='' 
                        data-original-title='กำหนดผู้ใต้บังคับบัญชา'>
                    <span class='fa fa-users blue setting-icon' aria-hidden='true'></span>
                    
                    </button>

                    <button type='button' class='btn btn-default btn-xs' 
                    onclick='settingHead2(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`),
                                        personHead_show2(`".$row['org_id']."`,`".$row['org_id_1']."`,`".$row['org_id_2']."`,`".$row['per_cardno']."`)'
                    data-toggle='tooltip' 
                    data-placement='top' 
                    title='' 
                    data-original-title='กำหนดผู้บังคับบัญชา'>
                <span class='fa fa-user green setting-icon' aria-hidden='true'></span>
                
                </button>

                    <button type='button' class='btn btn-default btn-xs' 
                        onclick='clearScore(`".$row['per_cardno']."`,`".$row['per_name']." ".$row['per_surname']."`)'
                        data-toggle='tooltip'
                        data-placement='top' 
                        title='' 
                        data-original-title='ล้างข้อมูลการประเมิน'>
                        <span class='fa fa-file-o red setting-icon' aria-hidden='true'></span>
                    </button>

                    <button type='button' class='btn ".($row['through_trial'] == 1 ? "btn-default" : "btn-danger")." btn-xs confirm-tr' 
                        onclick='through_trial(".$row['per_cardno'].")'
                        id='tr-".$row['per_cardno']."'
                        data-toggle='tooltip' 
                        data-placement='top' 
                        title='' 
                        data-original-title='".($row['through_trial'] == 1 ? "ผ่านทดลองงาน" : "ยังไม่ผ่านทดลองงาน")."' ".$eva.">
                    <span class='fa fa-user ".($row['through_trial'] == 1 ? "blue" : "")." setting-icon' aria-hidden='true'></span>
                    <span class='fa fa-angellist ".($row['through_trial'] == 1 ? "blue" : "")." setting-icon' aria-hidden='true'></span>
                    </button>
                    
                    <button type='button' class='btn ".($row['login_status'] == 1?'btn-default':'btn-danger')." btn-xs confirm-lock-login' 
                        data-toggle='tooltip' id='lock-".$row['per_cardno']."' onclick='lock_login(`".$row['per_cardno']."`,`lock-".$row['per_cardno']."`)'
                        data-placement='top' 
                        title='' 
                        data-original-title='".($row['login_status'] == 1?'ใช้งานได้ปกติ':'ระงับการใช้งาน')."'>
                        <span class='fa fa-key ".($row['login_status'] == 1?'green':'')." setting-icon' aria-hidden='true'></span>
                    </button> 
                <script>
                $('[data-toggle=\"tooltip\"]').tooltip()
                $('.confirm-lock-login').popConfirm({
                  title: 'การระงับการใช้งาน', // The title of the confirm
                  content: 'คุณต้องการเปลี่ยนแปลง<b class=text-danger>สถานะการระงับการใช้งาน</b> จริงๆ หรือใหม่ ?', // The message of the confirm
                  placement: 'left', // The placement of the confirm (Top, Right, Bottom, Left)
                  container: 'body', // The html container
                  yesBtn: 'ใช่',
                  noBtn: 'ไม่'
                  })
                  $('.confirm-tr').popConfirm({
                    title: 'สถานะการผ่านช่วงทดลองงาน', // The title of the confirm
                    content: 'คุณต้องการเปลี่ยนแปลง<b class=text-danger>สถานะการผ่านทดลองงาน</b> จริงๆ หรือใหม่ ? ', // The message of the confirm
                    placement: 'left', // The placement of the confirm (Top, Right, Bottom, Left)
                    container: 'body', // The html container
                    yesBtn: 'ใช่',
                    noBtn: 'ไม่'
                    })  
                </script>
               "
                     );
  
    }

//     echo "<pre>";
//     print_r($result);
//  echo "</pre>";
  if(count($d) > 0){
    $data = array('data' => $d,
                  'success' => true );
  }else{
    $data = array('success' => false );
  }
   
   return $data;
    
}


  function checkPicture($namePicture,$rootPath="../external/images_profile/") {
    $file1 = $namePicture;
    $file_headers1 = @get_headers($file1);
    // ../external/images_profile/
    if ($file_headers1[0] != 'HTTP/1.1 404 Not Found') {
        return $file1;
    }else return $rootPath."user.png";
  }

  function perHead($per_cardno) {  
    $success = array();
    $success['msg'] = "";
    try{
        $sql = "SELECT `per_cardno`,
                        `pn_name`,
                        `per_name`,
                        `per_surname`,
                        per_picture
                 FROM ".$this->tbl_per_personal
                ."  where per_cardno = (select head from ".$this->tbl_per_personal
                ." where per_cardno = :per_cardno) ";

        $stm = $this->conn->prepare($sql);
        $stm->bindParam(":per_cardno",$per_cardno);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) == 1) {
          $success['success'] = true;
          $success['result'] = $result;
        }else {
          $success['success'] = false;
          $success['result'][0]['per_cardno'] = "";
          $success['result'][0]['pn_name'] = "";
          $success['result'][0]['per_name'] = "";
          $success['result'][0]['per_surname'] = "";
          $success['result'][0]['per_picture'] = "";
          $success['msg'] = "ยังไม่ได้ระบุ";
        }       

    }catch(Exception $e){
      $success['success'] = null;
      $success['msg']  = $e->getMessage();
    }
    return $success;
  }


}
