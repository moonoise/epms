<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "../../includes/class.permission.php";
include_once "../../includes/class-date.php";
include_once "../report/class-report.php";
include_once "../cpc/class-cpc.php";

require_once "../../vendor/autoload.php";

if(!isset($_SESSION[__USER_ID__]) ){ 
    header("location:../../login-dpis.php");
  }

activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__],"../../login-dpis.php");

// $success =  groupUsers($_SESSION[__USER_ID__]);
// if (($success['success'] === true)   ) {
//    if ($success['result']['group_id'] == 6 || $success['result']['group_id'] == 7) {
//       $gOrg_id = $success['result']['org_id'];
//    }else 
//    {
//      $gOrg_id = '77';
//    }
// }elseif ($success['success'] === false) {
//     if ($_SESSION[__GROUP_ID__] == 1 || $_SESSION[__GROUP_ID__] == 2 || $_SESSION[__GROUP_ID__] == 3) {
//         $per_cardno = $_SESSION[__USER_ID__];
//         $name = $_SESSION[__F_NAME__] ." ".$_SESSION[__L_NAME__];
        
//     }
// }

$kpiTypeText = array('1' => '1. งานที่สนับสนุนตัวชี้วัดของผู้บังคับบัญชาตามยุทธศาสตร์กรม / คำรับรองการปฏิบัติราชการ (กรม สำนัก กอง)' ,
                '2' => '2. งานตามบทบาทหน้าที่ของตำแหน่งงาน',
                '3' => '3. งานที่ได้รับมอบหมายพิเศษ');
$html ="";
$css = "
<style>
@font-face {
    font-family: myFirstFont;
    src: url('../../vendor/mpdf/mpdf/ttfonts/THSarabun.ttf');
}
body {
    font-family: myFirstFont;
    
}
@page {
    margin-top: 0.5cm;
    margin-bottom: 0cm;
    margin-left: 0.3cm;
    margin-right: 0.3cm;
   
    
}



table.inner {
    border-collapse: collapse;
    border-top: 1px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    border-bottom: 1px solid #1a1a1b;
    
    padding: 3px;
    margin: 5px;
    empty-cells: show;
    
   }
   td.inner_td {
    border-collapse: collapse;
    border-top: 0px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    border-bottom: 1px solid #1a1a1b;
    padding: 1px;
    margin: 3px;
    empty-cells: show;
    
   }
   td.kpi_level_td {
    border-collapse: collapse;
    border-top: 0px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    border-bottom: 1px solid #1a1a1b;
    padding: 1px;
    margin: 3px;
    empty-cells: show;
    
    
   }

td.head_line1 {
border-collapse: collapse;
border-top: 1px solid #1a1a1b;
border-bottom: 0px solid #000000;
border-left: 1px solid #1a1a1b;
border-right: 1px solid #1a1a1b;

padding: 3px;
margin: 5px;
empty-cells: show;

}

td.head_line2 {
    border-collapse: collapse;
    border-top: 0px solid #000000;
    border-bottom: 1px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    
    padding: 0px;
    margin: 5px;
    empty-cells: show;
    
    }

table.inner  td{
    
    padding: 0px;
     
}

.line0 {
    border-collapse: collapse;
    border-top: 1px solid #ffffff;
    border-bottom: 1px solid #ffffff;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    height: 0px;
    padding: 0px;
    margin: 0px;
    empty-cells: show;
}
.line00 {
    border-collapse: collapse;
    border-top: 1px solid #ffffff;
    border-bottom: 1px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    
    padding: 0px;
    margin-left: 5px;
    empty-cells: show;
}

</style>

    ";
$html .= $css;

function headDetail($param){
    
    $head_logo = '
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30%"></td>
            <td align="center" width="40%"><img src="../../../external/logo_rid/rid_112x132.png" border="0"  width="60"></td>
            <td width="30%" align="right"><div style="float:right;"><b>ชป.135/1</b><br>หน้า '.$param['page'].'</div></td>
        </tr>
    </tbody>
    </table>
    ';
    
    $head_topic = '
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px 0;">
        <tbody>
            <tr>
                <td align="center" style="font-size: 16pt;"><b>แบบสรุปการประเมินผลการปฏิบัติราชการของข้าราชการ</b></td>
            </tr>
        </tbody>
    </table>';


    $head_detail = '
<table cellpadding="0" cellspacing="0" border="0" style="padding-top:5px; font-size: 12pt; " width="100%">
<tbody>

    <tr>
        <td colspan = "2" >รอบการประเมิน (1) <img src= "'.($param['part']==1?'../../../external/report/block_ok.png' : '../../../external/report/block.png' ).'" border="0" > รอบที่ 1 ตั้งแต่วันที่ '.$param['date1'].' ถึงวันที่ '.$param['date11'].'	</td>
        <td colspan = "2" ><img src= "'.($param['part']==2?'../../../external/report/block_ok.png' : '../../../external/report/block.png' ).'" border="0" > รอบที่ 2 ตั้งแต่วันที่ '.$param['date2'].'	ถึงวันที่ '.$param['date22'].' </td>
    </tr>
    <tr>
        <td width="24%" style="padding-top:5px; font-size: 12pt;"> ชื่อผู้รับการประเมิน (2) '.$param['name_lastname'].' </td>
        <td width="35%" style="padding-top:5px; font-size: 12pt;"> ตำแหน่ง/ระดับ (3) '.($param['pm_name'] == $param['pl_name']? ' '.$param['pl_name'].' '.$param['position_level'].'' : $param['pm_name'].' ('.$param['pl_name'].' '.$param['position_level'].')').' </td>
        <td width="41%" style="padding-top:5px; font-size: 12pt;" colspan = "2"> ลงชื่อ (4.1) ............................. วันที่ .................... ลงชื่อ (4.2) ............................. วันที่ .................... </td>
       
    </tr>
    <tr>
        <td style="padding-top:5px; font-size: 12pt;"> ชื่อผู้บังคัญบัญชา (5) '.$param['head_nameLastname'].' </td>
        <td style="padding-top:5px; font-size: 12pt;"> ตำแหน่ง/ระดับ (6)	'.($param['head_pm_name'] == $param['head_pl_name']? ' '.$param['head_pl_name'].' '.$param['head_position_level'].' ' : $param['head_pm_name'].' ('.$param['head_pl_name'].' '.$param['head_position_level'].')').'</td>
        <td style="padding-top:5px; font-size: 12pt;" colspan = "2"> ลงชื่อ (7.1) ............................. วันที่ .................... ลงชื่อ (7.2) ............................. วันที่ .................... </td>
    
    </tr>

</tbody>
</table>';

$head_table = '
<table cellpadding="3" cellspacing="0" border="0" style="padding-top:5px; font-size: 12pt;" width="100%" class="inner">
<tbody>
    <tr>
        <td width="15%"  align="center" style="font-size: 12pt;" class="head_line1" rowspan="2">ผลงาน</td>
        <td width="25%"  align="center" style="font-size: 12pt;" class="head_line1" colspan="2">ตัวชี้วัดผลงาน</td>
        <td width="40%"  align="center" style="font-size: 12pt;" class="head_line1" colspan="5">คะแนนตามระดับค่าเป้าหมาย (11)</td>
        <td width="5%"  align="center" style="font-size: 12pt;" class="head_line1" rowspan="2">ผลสัมฤทธิ์ของงาน</td>
        <td width="5%"  align="center"  style="font-size: 12pt;" class="head_line1" rowspan="2">คะแนน<br>(ก)</td>
        <td width="5%"  align="center"  style="font-size: 12pt;" class="head_line1" rowspan="2">น้ำหนัก<br>(ข)</td>
        <td width="5%"  align="center"  style="font-size: 12pt;" class="head_line1" rowspan="2">รวมคะแนน<br>(<u>กxขx20</u>)<br>100</td>
    </tr>
    <tr >
        
        <td width="20%" align="center" style="font-size: 12pt;" class="head_line1">ตัวชี้วัด</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">หน่วยนับ</td>

        <td width="8%" align="center" style="font-size: 12pt;"  class="head_line1">ค่าเป้าหมาย<br>ต่ำสุดที่รับได้</td>
        <td width="8%" align="center" style="font-size: 12pt;"  class="head_line1">ค่าเป้าหมาย<br>ในระดับต่ำกว่า<br>มาตรฐาน</td>
        <td width="8%" align="center" style="font-size: 12pt;"  class="head_line1">ค่าเป้าหมาย<br>ที่เป็นค่ามาตรฐาน</td>
        <td width="8%" align="center" style="font-size: 12pt;"  class="head_line1">ค่าเป้าหมาย<br>ที่สูงกว่ามาตรฐาน<br>(ความยากปานกลาง)</td>
        <td width="8%" align="center" style="font-size: 12pt;"  class="head_line1">ค่าเป้าหมาย<br>ในระดับท้าทายมี<br>ความยากค่อนข้างมาก</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 12pt;" class="head_line2">(8)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(9)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(10)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">1</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">2</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">3</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">4</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">5</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(12)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(13)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(14)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(15)</td>
        
    </tr>
    ';
    

 return $head_logo.$head_topic.$head_detail.$head_table;
}



function htmlTopic($text) {
    return '
        <tr>
        <td colspan="12" style="font-size: 12pt; padding: 1px;" class="inner_td"><b>'.$text.'</b></td>
        </tr>';
}

function html_content($text) {
   
    
    // $kpi_level2 = wordwrap($text['kpi_level2'],10, "<br>\n");
   
        return ' <tr>
        <td  width="15%" style="font-size: 12pt; padding: 1px;" class="inner_td">'.$text['works_name'].'</td>
        <td  width="20%"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.$text['kpi_title'].'</td>
        <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">'.$text['kpi_level1'].'</td>
        <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">'.$text['kpi_level2'].'</td>
        <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">'.$text['kpi_level3'].'</td>
        <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">'.$text['kpi_level4'].'</td>
        <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">'.$text['kpi_level5'].'</td>
        <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.($text['kpi_score_raw']!=""?$text['kpi_score_raw']:$text['kpi_score']).'</td>
        <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.$text['kpi_score'].'</td>
        <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.$text['weight'].'</td>
        <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.$text['sum'].'</td>
    </tr>

';        
}
function html_content_blank(){
    return '<tr>
                <td  width="15%" style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="20%"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="font-size: 12pt; padding: 1px;" class="kpi_level_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td  width="5%" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>';
}

function endPage($sumAll) {
    return  '
    <tr>
        <td  colspan="11" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">รวม (16)</td>
        <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">'.$sumAll.'</td>
    </tr>
        
    </tbody>
    </table>';


}



$per_cardno = $_POST['per_cardno'];
$part = explode("-",$_POST['years']);
$years = $_POST['years'];
$err = "";
$db = new DbConn;
$dateCovert = new dateCovert;

try {
    $sqlSelectYear = "SELECT * FROM `table_year` WHERE `table_year`.`table_year` LIKE :yy ORDER BY `table_year`.`table_year` ASC  ";
    $stmY = $db->conn->prepare($sqlSelectYear);
    // $yy = $part[0]."%";
    // $stmY->bindParam(":yy",$yy);
    $stmY->bindParam(":yy",$_POST['years']);
    $stmY->execute();
    $tableYear = $stmY->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>";
    // print_r($yy);
    // echo "</pre>";
    if (count($tableYear) === 1) {
        $tablePersonal = $tableYear[0]['per_personal']; 
        $tableCPCscore = $tableYear[0]['cpc_score'];
        $tableKPIscore = $tableYear[0]['kpi_score'];
        $startEvaluation_part1 = $tableYear[0]['start_evaluation'];  //วันเริ่มต้นช่วงที่ 1
        $endEvaluation_part1 = $tableYear[0]['end_evaluation'];
        $startEvaluation_part2 = $tableYear[0]['start_evaluation_2']; //วันเริ่มต้นช่วงที่ 2
        $endEvaluation_part2 = $tableYear[0]['end_evaluation_2'];
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


try{
    $sql = "SELECT `$tablePersonal`.`per_id`,
						`$tablePersonal`.`per_cardno`,
						`$tablePersonal`.`pn_name`,
						`$tablePersonal`.`per_name`,
						`$tablePersonal`.`per_surname`,
						`$tablePersonal`.`pos_no`,
						`$tablePersonal`.`level_no`,
						`$tablePersonal`.`org_id`,
						`$tablePersonal`.`org_id_1`,
						`$tablePersonal`.`org_id_2`,
                        `$tablePersonal`.`mov_code`,
						`per_level`.`position_type`,
                        `per_level`.`position_level`,
						`per_line`.`pl_name`,
						`per_mgt`.`pm_name`,
						(SELECT org_name FROM per_org WHERE `per_org`.`org_id` = `$tablePersonal`.`org_id`) AS org_name,
						(SELECT org_name FROM per_org WHERE `per_org`.`org_id` = `$tablePersonal`.`org_id_1`) AS org_name1, 
						(SELECT org_name FROM per_org WHERE `per_org`.`org_id` = `$tablePersonal`.`org_id_2`) AS org_name2,
                        (SELECT pn_name FROM `$tablePersonal` t2 WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_pn_name,
                        (SELECT per_name FROM `$tablePersonal` t2 WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_per_name,
                        (SELECT per_surname FROM `$tablePersonal` t2 WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_per_surname,
                        (SELECT position_type FROM `$tablePersonal` t2 LEFT JOIN `per_level` ON t2.`level_no` = `per_level`.`level_no` WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_position_type,
                        (SELECT position_level FROM `$tablePersonal` t2 LEFT JOIN `per_level` ON t2.`level_no` = `per_level`.`level_no` WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_position_level,
                        (SELECT `per_line`.`pl_name` FROM `$tablePersonal` t2 LEFT JOIN `per_line` ON `per_line`.`pl_code` = `t2`.`pl_code` WHERE t2.per_cardno = `$tablePersonal`.`head` ) AS head_pl_name,
                        (SELECT `per_mgt`.`pm_name` FROM `$tablePersonal` t2 LEFT JOIN `per_mgt` ON `per_mgt`.`pm_code` = `t2`.`pm_code` WHERE t2.per_cardno = `$tablePersonal`.head ) AS head_pm_name
                        
				FROM $tablePersonal
				LEFT JOIN per_level ON per_level.level_no = $tablePersonal.level_no  
				LEFT JOIN per_line ON per_line.pl_code = $tablePersonal.pl_code		
				LEFT JOIN per_mgt ON per_mgt.pm_code = $tablePersonal.pm_code	
		WHERE per_cardno = :per_cardno ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":per_cardno",$per_cardno);
    $stm->execute();
    $result = $stm->fetchAll();
     //echo $sql;

}catch(Exception $e)
{
    $err = $e->getMessage();
}
if ($err != '') {
    echo $err;
}

$date1 = $dateCovert->fullDateEngToThai($startEvaluation_part1);
$date11 = $dateCovert->fullDateEngToThai($endEvaluation_part1);

$date2 = $dateCovert->fullDateEngToThai($startEvaluation_part2);
$date22 = $dateCovert->fullDateEngToThai($endEvaluation_part2);

$name_lastname = $result[0]['pn_name'].$result[0]['per_name']." ".$result[0]['per_surname'];

$position_type = $result[0]['position_type'];
$pl_name = $result[0]['pl_name'];
$pm_name = $result[0]['pm_name'];
$position_level = $result[0]['position_level'];


$head_nameLastname = $result[0]['head_pn_name'].$result[0]['head_per_name']." ".$result[0]['head_per_surname'];
$head_position_type = $result[0]['head_position_type'];
$head_pl_name = $result[0]['head_pl_name'];
$head_pm_name = $result[0]['head_pm_name'];
$head_position_level = $result[0]['head_position_level'];

// echo $sql;
// echo "<pre>";
// print_r($result);
// echo "</pre>";

$report = new report;



$sumWeight = 0;
$sum2 = 0;
$param = array('name_lastname' => $name_lastname,
                'position_type' => $position_type,
                'pl_name' => $pl_name,
                'pm_name' => $pm_name,
                'position_level' => $position_level,
                'head_nameLastname' => $head_nameLastname,
                'head_position_type' => $head_position_type,
                'head_pl_name' => $head_pl_name,
                'head_pm_name' => $head_pm_name,
                'head_position_level' => $head_position_level,
                'part' => $part[1],
                'date1' => $date1,
                'date11' => $date11,
                'date2' => $date2,
                'date22' => $date22,
                'page' => 1
                );


$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf(
[
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '../../vendor/mpdf/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabun.ttf',
            'I' => 'THSarabun Italic.ttf',
            'B' => 'THSarabun Bold.ttf',
        ]
    ],
    'default_font' => 'thsarabun',
    'orientation' => 'L'
]);

$html .= headDetail($param);
$sumAll = 0;

foreach ($kpiTypeText as $k => $v){
    $html .= htmlTopic($v);
    $kpiResult = $report->reportKPI($per_cardno,$years,$k,$tableKPIscore);
    if(count($kpiResult['result']) > 0){
        foreach ($kpiResult['result'] as $key => $value) {

            if ($value['kpi_accept'] == 1) {
                $sum = ($value['kpi_score'] * $value['weight'] * 20 ) / 100;
            }else {
                $sum = '<small style="color: red;">คะแนนยังไม่สมบูรณ์</small>';
            }
            $value['sum'] = $sum;
            $sumAll = $sumAll + $sum;
            $html .= html_content($value);   
           }
    }else{
            $html .= html_content_blank();
    }   
   
}

$html .= endPage($sumAll);


        
// $test = array("works_name" => 'ระดับความสำเร็จในการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน',
// "kpi_title" => 'ระดับความสำเร็จในการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน',
// "kpi_score_raw" => '95',
// "kpi_score" => 5,
// "weight" => 20,
// "kpi_level1" => 'ไม่มีการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน',
// "kpi_level2" => 'มีการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน',
// "kpi_level3" => 'มีการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน ครบทุกไตรมาส',
// "kpi_level4" => 'มีการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน ที่มีความถี่มากกว่ารายไตรมาส',
// "kpi_level5" => 'มีการจัดทำรายงานผลการปฏิบัติงานเพื่อคณะอนุและคณะกรรมการบริหารเงินทุนหมุนเวียนเพื่อการชลประทาน เป็นรายเดือนครบ 12 เดือน'
// );
// $test2 = array("works_name" => '-',
// "kpi_title" => '=',
// "kpi_score_raw" => '95',
// "kpi_score" => 5,
// "weight" => 20,
// "kpi_level1" => '-',
// "kpi_level2" => '-',
// "kpi_level3" => '- ครบทุกไตรมาส',
// "kpi_level4" => '- ที่มีความถี่มากกว่ารายไตรมาส',
// "kpi_level5" => '- เป็นรายเดือนครบ 12 เดือน'
// );
// $html .= html_content($test);


// $html .= ' </tbody>
//         </table>';


//  $mpdf->WriteHTML($html);
// $mpdf->Output();

// echo "<pre>";
// print_r($kpiResult);
// echo "</pre>";

echo ($html);


