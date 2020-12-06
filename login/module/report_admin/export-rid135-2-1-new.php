<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "../../includes/class.permission.php";
include_once "../../includes/class-date.php";
include_once "../report/class-report.php";
include_once "../cpc/class-cpc.php";
include_once "../myClass.php";

require_once "../../vendor/autoload.php";

if (!isset($_SESSION[__USER_ID__])) {
    header("location:../../login-dpis.php");
}

activeTime($login_timeout, $_SESSION[__SESSION_TIME_LIFE__], "../../login-dpis.php");

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
$html = "";
$css = "
<style>
@page {
    margin-top: 0cm;
    margin-bottom: 0cm;
    margin-left: 0cm;
    margin-right: 0cm;
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

td.head_line1 {
border-collapse: collapse;
border-top: 1px solid #1a1a1b;
border-bottom: 0px solid #000000;
border-left: 1px solid #1a1a1b;
border-right: 1px solid #1a1a1b;

padding: 0px;
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

function headDetail($param)
{

    $head_logo = '
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30%"></td>
            <td align="center" width="40%"><img src="../../../external/logo_rid/rid_112x132.png" border="0"  width="60"></td>
            <td width="30%" align="right"><div style="float:right;"><b>ชป.135/2-2</b><br>หน้า ' . $param['page'] . '</div></td>
        </tr>
    </tbody>
    </table>
    ';

    $head_topic = '
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px 0;">
        <tbody>
            <tr>
                <td align="center" style="font-size: 16pt;"><b>แบบสรุปการประเมินผลการปฏิบัติราชการของพนักงานราชการ</b></td>
            </tr>
        </tbody>
    </table>';


    $head_detail = '
<table cellpadding="0" cellspacing="0" border="0" style="padding-top:5px; font-size: 12pt; " width="100%">
<tbody>

    <tr>
        <td colspan = "2" >รอบการประเมิน (1) <img src= "' . ($param['part'] == 1 ? '../../../external/report/block_ok.png' : '../../../external/report/block.png') . '" border="0" > รอบที่ 1 ตั้งแต่วันที่ ' . $param['date1'] . ' ถึงวันที่ ' . $param['date11'] . '	</td>
        <td colspan = "2" ><img src= "' . ($param['part'] == 2 ? '../../../external/report/block_ok.png' : '../../../external/report/block.png') . '" border="0" > รอบที่ 2 ตั้งแต่วันที่ ' . $param['date2'] . '	ถึงวันที่ ' . $param['date22'] . ' </td>
    </tr>
    <tr>
        <td width="25%" style="padding-top:5px;"> ชื่อผู้รับการประเมิน (2) ' . $param['name_lastname'] . ' </td>
        <td width="35%" style="padding-top:5px;"> ตำแหน่ง/ระดับ (3) ' . ($param['pm_name'] == $param['pl_name'] ? ' ' . $param['pl_name'] . ' ' . $param['position_level'] . '' : $param['pm_name'] . ' (' . $param['pl_name'] . ' ' . $param['position_level'] . ')') . ' </td>
        <td width="40%" style="padding-top:5px;" colspan = "2"> ลงชื่อ (4.1) ............................. วันที่ ......................... ลงชื่อ (4.2) ............................. วันที่ ........................ </td>
       
    </tr>
    <tr>
        <td style="padding-top:5px;"> ชื่อผู้บังคับบัญชา (5) ' . $param['head_nameLastname'] . ' </td>
        <td style="padding-top:5px;"> ตำแหน่ง/ระดับ (6)	' . ($param['head_pm_name'] == $param['head_pl_name'] ? ' ' . $param['head_pl_name'] . ' ' . $param['head_position_level'] . ' ' : $param['head_pm_name'] . ' (' . $param['head_pl_name'] . ' ' . $param['head_position_level'] . ')') . ' </td>
        <td style="padding-top:5px;" colspan = "2"> ลงชื่อ (7.1) ............................. วันที่ ......................... ลงชื่อ (7.2) ............................. วันที่ ........................ </td>
    
    </tr>

</tbody>
</table>';
    // ('.$param['pl_name'].')
    // ('.$param['head_pl_name'].')
    $head_table = '
<table cellpadding="3" cellspacing="0" border="0" style="padding-top:5px; font-size: 12pt; " width="100%" class="inner">
<tbody>
    <tr >
        <td width="20%" height="80" align="center" class="head_line1">รายการสมรรถนะ</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">ระดับ<br>สมรรถนะที่<br>องค์กรคาด<br>หวัง</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">คะแนน<br>(ก)</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">น้ำหนัก <br>(ข)</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">รวมคะแนน  <br> (<u>กxขx20</u>)<br>100</td>
        <td width="20%" align="center" style="font-size: 12pt;" class="head_line1">บันทึกเหตุการณ์สำคัญที่แสดงถึงพฤติกรรม<br>ตามสมรรถนะที่ประเมิน (กรณีพื้นที่ไม่พอให้<br>บันทึกลงในแบบชป.135/3-1)</td>
        <td width="20%" align="center" class="head_line1">วิธีการพัฒนา</td>
        <td width="20%" align="center" class="head_line1">แนวทางการประเมินสมรรถนะ</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 12pt;" class="head_line2">(8)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(9)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(10)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(11)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(12)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(13)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(14)</td>
        <td align="center" style="font-size: 12pt;" class="head_line2">(15)</td>
        
    </tr>
    ';


    return $head_logo . $head_topic . $head_detail . $head_table;
}

function mark($rowspan)
{
    return  '
    <tr>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line0" > </td>
        <td class="line00"  rowspan="' . $rowspan . '"> <span> &nbsp;&nbsp;ผู้บังคับบัญชาจะต้องประเมินสมรรถนะ<br>
                                                            &nbsp;&nbsp;โดยใช้มาตรวัดแบบเปรียบเทียบกับ<br>
                                                            &nbsp;&nbsp;สมรรถนะของพนักงานราชการอื่น<br>
                                                            &nbsp;&nbsp;ในประเภท/ตำแหน่งเดียวกัน<br>
                                                            &nbsp;&nbsp;ซึ่งมีเกณฑ์การให้คะแนนประเมิน ดังนี้ </span>                                                                                
        <br>
        &nbsp;&nbsp;<u>คะแนน</u>&nbsp;&nbsp;<u>นิยาม</u> <br>
        <p>&nbsp;&nbsp; 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำเป็นต้องพัฒนาอย่างยิ่ง </p>
        <p>&nbsp;&nbsp; 2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้อยกว่าพนักงานราชการอื่นในประเภท<br> 
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ตำแหน่งเดียวกัน</p> 
    
        <p>&nbsp;&nbsp; 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทัดเทียมกับพนักงานราชการอื่น ในประเภท/<br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในประเภท/ตำแหน่งเดียวกัน</p>
        
        
        <p>&nbsp;&nbsp; 4 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สูงกว่าพนักงานราชการอื่นในประเภท/<br> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่งเดียวกัน </p>
        
        <p>&nbsp;&nbsp; 5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป็นเลิศกว่าพนักงานราชการอื่น<br>  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในประเภท/ตำแหน่งเดียวกัน</p></td>
    </tr>';
}

function htmlTopic($cpcType, $value)
{
    return '
        <tr>
        <td colspan="7" style="font-size: 12pt; padding: 1px;" class="inner_td"><b>' . $cpcType . ($value == 3 ? ' (คะแนนรวม 30 คะแนน โดยต้องมีสมรรถนะอย่างน้อย 3 สมรรถนะ)' : '') . '</b></td>
        </tr>';
}

function html_content($question_title, $cpc_divisor, $total, $cpc_weight, $sum1)
{
    return ' <tr>
                <td    style="font-size: 12pt; padding: 1px;" class="inner_td">' . $question_title . '</td>
                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">' . $cpc_divisor . '</td>
                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">' . $total . '</td>
                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">' . $cpc_weight . '</td>
                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">' . $sum1 . '</td>
                <td   style="font-size: 12pt;  padding: 1px;" class="inner_td"></td>
                <td   style="font-size: 12pt;  padding: 1px;" class="inner_td"></td>
            </tr>';
}

function endPage($param)
{
    return  '
    <tr>
        <td colspan="3" style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"> ' . $param['sumWeight'] . '%</td>
        <td align="center" rowspan="2" style="font-size: 12pt; padding: 1px;" class="inner_td">' . $param['sumScore'] . '</td>
        <td colspan="2" rowspan="2" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        <td rowspan="2" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        </tr>

        <tr>
        <td  colspan="4" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">รวม (16)</td>

        </tr>
        
    </tbody>
    </table>';
}

$per_cardno = $_POST['per_cardno'];

$err = "";
$db = new DbConn;
$dateCovert = new dateCovert;
$myClass = new myClass;

$yearById = $myClass->callYearByID($_POST['years']);
$tablePersonal = $yearById['data']['per_personal'];
$tableCPCscore = $yearById['data']['cpc_score'];
$tableKPIscore = $yearById['data']['kpi_score'];
$startEvaluation_part1 = $yearById['data']['start_evaluation'];  //วันเริ่มต้นช่วงที่ 1
$endEvaluation_part1 = $yearById['data']['end_evaluation'];
$startEvaluation_part2 = $yearById['data']['start_evaluation_2']; //วันเริ่มต้นช่วงที่ 2
$endEvaluation_part2 = $yearById['data']['end_evaluation_2'];
$tableYear = $yearById['data']['table_year'];
$part = explode("-", $tableYear);


try {
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
    $stm->bindParam(":per_cardno", $per_cardno);
    $stm->execute();
    $result = $stm->fetchAll();
    //echo $sql;

} catch (Exception $e) {
    $err = $e->getMessage();
}
if ($err != '') {
    echo $err;
}

$date1 = $dateCovert->fullDateEngToThai($startEvaluation_part1);
$date11 = $dateCovert->fullDateEngToThai($endEvaluation_part1);

$date2 = $dateCovert->fullDateEngToThai($startEvaluation_part2);
$date22 = $dateCovert->fullDateEngToThai($endEvaluation_part2);

$name_lastname = $result[0]['pn_name'] . $result[0]['per_name'] . " " . $result[0]['per_surname'];

$position_type = $result[0]['position_type'];
$pl_name = $result[0]['pl_name'];
$pm_name = $result[0]['pm_name'];
$position_level = $result[0]['position_level'];


$head_nameLastname = $result[0]['head_pn_name'] . $result[0]['head_per_name'] . " " . $result[0]['head_per_surname'];
$head_position_type = $result[0]['head_position_type'];
$head_pl_name = $result[0]['head_pl_name'];
$head_pm_name = $result[0]['head_pm_name'];
$head_position_level = $result[0]['head_position_level'];

// echo $sql;
// echo "<pre>";
// print_r($result);
// echo "</pre>";

$report = new report;
$cpcTypeKey = array(1, 2, 3);
$a = 1;

$sumWeight = 0;
$sum2 = 0;
$param = array(
    'name_lastname' => $name_lastname,
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
    ]
);



$html .= headDetail($param);
$html .= mark(13);
$count_row = 0;
$page = 1;
$table_cpc = $report->tableCPC($per_cardno, $tableYear, array(1), $tablePersonal, $tableCPCscore);

$resultCPC = $report->cpcCalculate_new($table_cpc);
// echo "<pre>";
// print_r($resultCPC);
// echo "</pre>";
$num1 = count($resultCPC['cpc']);
if ($num1 > 0) {
    $html .= htmlTopic($cpcType['1'], 1);
    $count_row++;
    foreach ($resultCPC['cpc'] as $k => $v) {
        $html .= html_content($v['question_title'], $v['cpc_divisor'], $v['total'], $v['cpc_weight'], $v['sum1']);
        $count_row++;
        if ($count_row  >= 13) {
            echo  $html .= ' </tbody>
        </table>';
            $mpdf->WriteHTML($html);
            $mpdf->AddPage();
            $page++;
            $param['page'] = $page;
            $html =  headDetail($param);
            $html .= htmlTopic($cpcType['1'], 1);
            $count_row = 0;
        }
    }
}


$sumWeight += $resultCPC['CPCsumWeight'];
$sum2 +=  $resultCPC['cpcSum2'];

$table_cpc = $report->tableCPC($per_cardno, $tableYear, array(2), $tablePersonal, $tableCPCscore);
$resultCPC = $report->cpcCalculate_new($table_cpc);
$num2 = count($resultCPC['cpc']);
if ($num2 > 0) {
    $html .= htmlTopic($cpcType['2'], 2);
    $count_row++;
    foreach ($resultCPC['cpc'] as $k => $v) {
        $html .= html_content($v['question_title'], $v['cpc_divisor'], $v['total'], $v['cpc_weight'], $v['sum1']);
        $count_row++;
        if ($count_row  >= 13) {
            $html .= ' </tbody>
            </table>';
            $mpdf->WriteHTML($html);

            $mpdf->AddPage();
            $page++;
            $param['page'] = $page;
            $html =  headDetail($param);
            $html .= htmlTopic($cpcType['2'], 2);
            $count_row = 0;
        }
    }
}

$sumWeight += $resultCPC['CPCsumWeight'];
$sum2 +=  $resultCPC['cpcSum2'];

$table_cpc = $report->tableCPC($per_cardno, $tableYear, array(3), $tablePersonal, $tableCPCscore);
$resultCPC = $report->cpcCalculate_new($table_cpc);
$num3 = count($resultCPC['cpc']);
if ($num3 > 0) {
    $html .= htmlTopic($cpcType['3'], 3);
    $count_row++;
    foreach ($resultCPC['cpc'] as $k => $v) {
        $html .= html_content($v['question_title'], $v['cpc_divisor'], $v['total'], $v['cpc_weight'], $v['sum1']);
        $count_row++;
        if ($count_row  >= 13) {
            $html .= ' </tbody>
            </table>';
            $mpdf->WriteHTML($html);

            $mpdf->AddPage();
            $page++;
            $param['page'] = $page;
            $html =  headDetail($param);
            $html .= htmlTopic($cpcType['3'], 3);
            $count_row = 0;
        }
    }
}

$sumWeight += $resultCPC['CPCsumWeight'];
$sum2 +=  $resultCPC['cpcSum2'];

$engPage = array(
    'sumWeight' => $sumWeight,
    'sumScore' => $sum2
);
$html .= endPage($engPage);
$mpdf->WriteHTML($html);
$mpdf->Output();
echo ($html);
