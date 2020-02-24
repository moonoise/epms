<!-- $query = addFilterField('nic_name:'.$_POST["search_nic"]);
ตัวsearch_nic เป็น input จากหน้าhtml
ตอนนี้โค้ดตัวนี้ หาได้แค่ peter ถ้าเราพิมทั้งหมดว่า peter
แต่ถ้าพิม pet เฉยๆจะมองว่าไม่มีข้อมูล -->

<?php
// if(strlen(strpos($_POST["search_nic"],"pet"))){
//  echo 'true';
// }else echo strpos("peter","pet");

$s =  strpos('peter',"pet");

if(strlen($s) == 1){
    echo "แปลว่ามีข้อมูล อยู่ที่ตำแหน่ง " . $s;
}
