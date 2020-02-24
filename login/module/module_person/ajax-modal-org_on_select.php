<?php
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
 include_once "class-person.php";

$person = new person;
$r = '';
$result = $person->OrgArrange($_GET['org_id']);
//  echo "<pre>";
//    print_r($result);
// echo "</pre>";

$s = array_reverse($result['result']);
// echo "<pre>";
//    print_r($s);
// echo "</pre>";

foreach ($s as $key => $value) {
    $r .= "
            <a href='#/chevron-right'>
                <i class='fa fa-chevron-right'></i>
            </a>
            ".$value['org_name']."
            ";
}
$r .= " <button type='button' class='btn btn-success confirm-move-org' onclick ='movePersonSave(`".$s[count($s)-1]['org_id']."`)'><i class='fa fa-save'></i></button>";
// foreach ($result['result'] as $key => $value) {
//    $r .= "<div class='fa-hover col-md-3 col-sm-4 col-xs-12'>
//             <a href='#/chevron-right'>
//                 <i class='fa fa-chevron-right'></i>
//             </a>
//             </div>".$value['org_name'];
// }

$r .= "<script>
$('.confirm-move-org').popConfirm({
    title: 'เปลี่ยนสังกัดของผู้ประเมิน', 
    content: 'คุณต้องการเปลี่ยนสังกัดของผู้ประเมิน จริงๆ หรือใหม่ ?', 
    placement: 'right', 
    container: 'body',
    yesBtn: 'ใช่',
    noBtn: 'ไม่'
    });
</script>
";
echo $r;