<?php
if(!empty($_GET['per_cardno'])){
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";
include_once "../../includes/ociConn.php";
// include_once "../module_dpis/class-dpis.php";

$person = new person;
// $dpis = new dpis;
$r ='';
$r2 ='';
$org = '';
$org2 = '';
$result = $person->personSelect($_GET['per_cardno']);
// $queryDPIS = $dpis->queryPersonal($_GET['per_cardno']);
// echo "<pre>";
//    print_r($queryDPIS);
// echo "</pre>";
echo "<div class='row'>";
if (count($result['result']) == 1) {
        if ($result['result'][0]['org_name'] != '') {
            $org .= "<li><i class='fa fa-building text-info'></i><strong> สังกัด: </strong>".$result['result'][0]['org_name']."</li>";
        }
        if ($result['result'][0]['org_name1'] != '') {
            $org .= "<li>
                        <a href='#/chevron-right'>
                            <i class='fa fa-chevron-right'></i>
                        </a>
                        ".$result['result'][0]['org_name1']."
                    </li>";
        }
        if ($result['result'][0]['org_name2'] != '') {
            $org .= "<li>
                        <a href='#/chevron-right'>
                            <i class='fa fa-chevron-right'></i>
                        </a>
                        ".$result['result'][0]['org_name2']."
                    </li>";
        }

$r .= "
        <div class='col-md-8 col-sm-8 col-xs-8 profile_details'>
            <div class='well profile_view'>
                <div class='col-md-12 col-sm-12 col-xs-12'>
                <h4 class='brief text-success'><i>สังกัด <span class='text-warning'>(ในระบบ e-PM)</span> </i></h4>
                <div class='left col-md-8 col-sm-8 col-xs-7'>
                    <h3>".$result['result'][0]['per_name']." ".$result['result'][0]['per_surname']."</h3>
                    <p><strong>ตำแหน่งทางบริหาร: </strong> ".$result['result'][0]['pm_name']." </p>
                    <p><strong>ตำแหน่ง: </strong> ".$result['result'][0]['pl_name']." </p>
                    <ul class='list-unstyled'>
                     
                    ".$org."
                    
                    </ul>
                </div>
                    <div class='right col-md-4 col-sm-4 col-xs-5 text-center'>
                        <img src='".checkPicture(__PATH_PICTURE__.$result['result'][0]['per_picture'])."' alt='' class='img-circle img-responsive'>
                    </div>
                </div>
            </div>
        </div>
    ";
    echo $r;
    }
    
// if (count($queryDPIS['result'] ) == 1) {
//     if ($queryDPIS['result'][0]['ORG_NAME'] != '') {
//         $org2 .= "<li><i class='fa fa-building text-info'></i><strong> สังกัด: </strong>".$queryDPIS['result'][0]['ORG_NAME']."</li>";
//     }
//     if ($queryDPIS['result'][0]['ORG_NAME1'] != '') {
//         $org2 .= "<li>
//                     <a href='#/chevron-right'>
//                         <i class='fa fa-chevron-right'></i>
//                     </a>
//                     ".$queryDPIS['result'][0]['ORG_NAME1']."
//                 </li>";
//     }
//     if ($queryDPIS['result'][0]['ORG_NAME2'] != '') {
//         $org2 .= "<li>
//                     <a href='#/chevron-right'>
//                         <i class='fa fa-chevron-right'></i>
//                     </a>
//                     ".$queryDPIS['result'][0]['ORG_NAME2']."
//                 </li>";
//     }

//     $r2 .= "
//         <div class='col-md-6 col-sm-6 col-xs-12 profile_details'>
//             <div class='well profile_view'>
//                 <div class='col-sm-12'>
//                 <h4 class='brief text-success'><i>สังกัดปัจจุบัน <span class='text-warning'>(ในระบบ DPIS)</span> </i></h4>
//                 <div class='left col-xs-7'>
//                     <h3>".$queryDPIS['result'][0]['PER_NAME']." ".$queryDPIS['result'][0]['PER_SURNAME']."</h3>
//                     <p><strong>ตำแหน่งทางบริหาร: </strong> ".$queryDPIS['result'][0]['PM_NAME']." </p>
//                     <p><strong>ตำแหน่ง: </strong> ".$queryDPIS['result'][0]['PL_NAME']." </p>
//                     <ul class='list-unstyled'>
                     
//                     ".$org2."
                    
//                     </ul>
//                 </div>
//                     <div class='right col-xs-5 text-center'>
//                         <img src='".checkPicture(__PATH_PICTURE__.$queryDPIS['result'][0]['PER_PICTURE'])."' alt='' class='img-circle img-responsive'>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     ";
//     echo $r2;
// } 

// echo "</div>";    
    
}


function checkPicture($namePicture) {
    $file1 = $namePicture;
    $file_headers1 = @get_headers($file1);
   
    if ($file_headers1[0] != 'HTTP/1.1 404 Not Found') {
        return $file1;
    }else return "../external/images_profile/user.png";
}

