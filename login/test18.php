<?php
$html = "
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
    border-top: 1px solid #1a1a1b;
    border-left: 1px solid #1a1a1b;
    border-right: 1px solid #1a1a1b;
    border-bottom: 0px solid #1a1a1b;
    
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
    
    padding: 0px;
    margin: 0px;
    empty-cells: show;
}
</style>

    ";




    $head_logo = '
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr valign="top">
            <td width="30%"></td>
            <td align="center" width="40%"><img src="../../../external/logo_rid/rid_112x132.png" border="0"  width="60"></td>
            <td width="30%" align="right"><div style="float:right;"><b>ชป.135/2-2</b><br>หน้า 1</div></td>
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
        <td colspan = "2" >รอบการประเมิน (1) <img src= "'.($part[1]==1?'../../../external/report/block_ok.png' : '../../../external/report/block.png' ).'" border="0" > รอบที่ 1 ตั้งแต่วันที่ '.$date1.' ถึงวันที่ '.$date11.'	</td>
        <td colspan = "2" ><img src= "'.($part[1]==2?'../../../external/report/block_ok.png' : '../../../external/report/block.png' ).'" border="0" > รอบที่ 2 ตั้งแต่วันที่ '.$date2.'	ถึงวันที่ '.$date22.' </td>
    </tr>
    <tr>
        <td width="25%" style="padding-top:5px;"> ชื่อผู้รับการประเมิน (2) '.$name_lastname.' </td>
        <td width="35%" style="padding-top:5px;"> ตำแหน่ง/ระดับ(3) '.$pm_name.' ('.$pl_name.') '.$position_type.' '.$position_level.' </td>
        <td width="40%" style="padding-top:5px;" colspan = "2"> ลงชื่อ (4.1) ............................. วันที่ ......................... ลงชื่อ (4.2) ............................. วันที่ ........................ </td>
       
    </tr>
    <tr>
        <td style="padding-top:5px;"> ชื่อผู้รับการประเมิน (5) '.$head_nameLastname.' </td>
        <td style="padding-top:5px;"> ตำแหน่ง / ระดับ (6)	'.$head_pm_name.' ('.$head_pl_name.') '.$head_position_level.' '.$position_level.' </td>
        <td style="padding-top:5px;" colspan = "2"> ลงชื่อ (7.1) ............................. วันที่ ......................... ลงชื่อ (7.2) ............................. วันที่ ........................ </td>
    
    </tr>

</tbody>
</table>';

$head_table = '
<table cellpadding="3" cellspacing="0" border="0" style="padding-top:5px; font-size: 12pt; " width="100%" class="inner">
<tbody>
    <tr >
        <td width="20%" height="80" align="center" class="head_line1">รายการสมรรถนะ</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">ระดับ<br>สมรรถนะที่<br>องค์กรคาด<br>หวัง</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">คะแนน<br>(ก)</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">น้ำหนัก <br>(ข)</td>
        <td width="5%" align="center" style="font-size: 12pt;" class="head_line1">รวมคะแนน  <br> (กxขx20)<br>/100</td>
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

    $html_2 .= '
    <tr>
    <td colspan="7" style="font-size: 12pt; padding: 1px;" class="inner_td"><b>'.$v.($k==3?' (คะแนนรวม 30 คะแนน โดยต้องมีสมรรถนะอย่างน้อย 3 สมรรถนะ)':'').'</b></td>
    </tr>';

    $html_2 .= ' <tr>
                                <td    style="font-size: 12pt; padding: 1px;" class="inner_td">'.$value['question_title'].'</td>
                                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">4</td>
                                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">0</td>
                                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">10</td>
                                <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">0</td>
                                <td   style="font-size: 12pt;  padding: 1px;" class="inner_td"></td>
                                <td   style="font-size: 12pt;  padding: 1px;" class="inner_td"></td>
                            </tr>';


  

    $html_3 .= '
    <tr>
        <td colspan="3" style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        <td align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td">100%</td>
        <td align="center" rowspan="2" style="font-size: 12pt; padding: 1px;" class="inner_td">92</td>
        <td colspan="2" rowspan="2" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        <td rowspan="2" align="center"  style="font-size: 12pt; padding: 1px;" class="inner_td"></td>
        </tr>

        <tr>
        <td  colspan="4"  style="font-size: 12pt; padding: 1px;" class="inner_td">รวม</td>

    </tr>
        
    </tbody>
    </table>';

    



$html_1 .= '
<tr>
    <td colspan="7" class="line0" > </td>
    <td class="line0"  rowspan="'.($rowspan >= 13 ? 13 : $rowspan).'"> ผู้บังคับบัญชาจะต้องประเมินสมรรถนะ<br>โดยใช้มาตรวัดแบบเปรียบเทียบกับ<br>สมรรถนะของข้าราชการอื่น<br>ในประเภท/ตำแหน่งเดียวกัน<br>ซึ่งมีเกณฑ์การให้คะแนนประเมิน ดังนี้                                                                                 
    <br>
    <u>คะแนน</u><u>นิยาม</u> <br>
    <p>1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำเป็นต้องพัฒนาอย่างยิ่ง </p>
    <p>2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้อยกว่าข้าราชการอื่นในประเภท<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ตำแหน่งเดียวกัน</p> 

    <p>3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทัดเทียมกับข้าราชการอื่น ในประเภท/<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในประเภท/ตำแหน่งเดียวกัน</p>
    
    
    <p>4 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สูงกว่าข้าราชการอื่นในประเภท/<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่งเดียวกัน </p>
    
    <p>5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เป็นเลิศกว่าข้าราชการอื่น<br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในประเภท/ตำแหน่งเดียวกัน</p></td>
</tr>';

$html .= $html_1.$html_2.$html_3;

echo $html;

// echo "<pre>";
// print_r($resultCPC);
// echo "</pre>";

// $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
// $fontDirs = $defaultConfig['fontDir'];

// $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
// $fontData = $defaultFontConfig['fontdata'];

// $mpdf = new \Mpdf\Mpdf(
// [
//     'fontDir' => array_merge($fontDirs, [
//         __DIR__ . '../../vendor/mpdf/ttfonts',
//     ]),
//     'fontdata' => $fontData + [
//         'thsarabun' => [
//             'R' => 'THSarabun.ttf',
//             'I' => 'THSarabun Italic.ttf',
//             'B' => 'THSarabun Bold.ttf',
//         ]
//     ],
//     'default_font' => 'thsarabun',
//     'mode' => 'utf-8',
//     'format' => 'A4-L'
// ]);


// $mpdf->WriteHTML($html);
// $mpdf->Output();

?>