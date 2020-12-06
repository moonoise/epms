<?php

$perPersonal = "CREATE TABLE $perPersonalName (
                `per_id` varchar(5) NOT NULL,
                `per_cardno` varchar(13) NOT NULL COMMENT 'หมายเลขประจำตัวประชาชน',
                `pn_name` varchar(20) DEFAULT NULL COMMENT 'คำนำหน้าชื่อ',
                `per_name` varchar(100) DEFAULT NULL,
                `per_surname` varchar(100) DEFAULT NULL,
                `per_eng_name` varchar(100) DEFAULT NULL,
                `per_eng_surname` varchar(100) DEFAULT NULL,
                `per_gender` tinyint(1) DEFAULT NULL,
                `per_type` tinyint(1) DEFAULT NULL COMMENT 'ประเภทบุคลากร\n1 = ข้าราชการ\n2 = ลูกจ้างประจำ\n3 = พนักงานราชการ',
                `pos_id` varchar(15) DEFAULT NULL COMMENT 'id ของ pos_no',
                `pos_no` varchar(15) DEFAULT NULL COMMENT 'เลขที่ตำแหน่ง ตำแหน่งปัจจุบัน(ข้าราชการ)',
                `per_birthdate` varchar(20) DEFAULT NULL,
                `per_startdate` varchar(20) DEFAULT NULL,
                `per_retiredate` varchar(20) DEFAULT NULL,
                `pl_name` varchar(100) DEFAULT NULL COMMENT 'ตำแหน่งสายงาน',
                `pl_code` int(10) DEFAULT NULL COMMENT 'ตำแหน่งสายงาน',
                `pm_code` varchar(10) DEFAULT NULL COMMENT 'ตำแหน่งสายบริหาร',
                `pm_name` varchar(255) DEFAULT NULL COMMENT 'ตำแหน่งสายบริหาร',
                `level_no` char(2) DEFAULT NULL,
                `level_name` varchar(100) DEFAULT NULL,
                `per_mobile` varchar(15) DEFAULT NULL,
                `per_email` varchar(50) DEFAULT NULL,
                `per_picture` varchar(100) DEFAULT NULL COMMENT 'รูปภาพที่อยู่ในระบบ dpis',
                `org_id` varchar(10) DEFAULT NULL,
                `org_name` varchar(255) DEFAULT NULL,
                `org_id_1` varchar(10) DEFAULT NULL,
                `org_name1` varchar(255) DEFAULT NULL,
                `org_id_2` varchar(10) DEFAULT NULL,
                `org_name2` varchar(255) DEFAULT NULL,
                `head` varchar(13) DEFAULT NULL COMMENT 'ผู้บังคับบัญชา',
                `mov_code` int(10) DEFAULT NULL COMMENT 'รหัสสถานะ ว่าผ่านช่วงทดลองงานยัง',
                `through_trial` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1.ผ่านทดลองงาน 2.ไม่ผ่านทดสองงาน',
                `login_status` tinyint(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`per_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";

$cpcScore = "CREATE TABLE $cpcScoreName (
                `cpc_score_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `question_no` varchar(20) DEFAULT NULL COMMENT 'RF จาก cpc_question',
                `per_cardno` varchar(20) DEFAULT NULL COMMENT 'ไอดีผู้รับการประเมิน',
                `id_admin` char(23) DEFAULT NULL COMMENT 'admin  ผู้เพิ่ม  แล้วเป็นผู้มีสิทธิเข้ามาแก้ไขข้อมูลการประเมิน',
                `cpc_score1` float unsigned DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
                `cpc_score2` float unsigned DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
                `cpc_score3` float unsigned DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
                `cpc_score4` float unsigned DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
                `cpc_score5` float unsigned DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
                `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย  เช่น 2561-1',
                `date_key_score` timestamp NULL DEFAULT NULL COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
                `cpc_accept1` float unsigned DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
                `cpc_accept2` float unsigned DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
                `cpc_accept3` float unsigned DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
                `cpc_accept4` float unsigned DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
                `cpc_accept5` float unsigned DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
                `cpc_comment1` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `cpc_comment2` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `cpc_comment3` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `cpc_comment4` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `cpc_comment5` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `cpc_divisor` tinyint(2) unsigned DEFAULT NULL COMMENT 'ค่าคาดหวัง  หรือจำนวนข้อที่เอาไปหารเป็นคะแนน',
                `cpc_weight` tinyint(3) DEFAULT NULL COMMENT 'ค่าน้ำหนัก',
                `who_is_accept` char(23) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
                `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
                `total_head` float(5,2) DEFAULT NULL,
                `sum_head` float(5,2) DEFAULT NULL,
                `point_result` float(5,2) DEFAULT NULL COMMENT 'จำนวนข้อที่ได้ ตั้งแต่ 1-5',
                `gap_status` enum('0','1') DEFAULT NULL COMMENT '0 ไม่ติดgap | 1 ติดgap',
                `soft_delete` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`cpc_score_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=39163 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";


$cpcScoreResult = "CREATE TABLE $cpcScoreResultName (
                    `cpc_score_result_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `per_cardno` varchar(15) NOT NULL,
                    `cpc_score_result_yourself` float DEFAULT NULL COMMENT 'คะแนนที่คำนวณเรียบร้อยแล้ว',
                    `cpc_score_result_head` float DEFAULT NULL COMMENT 'คะแนนที่หัวหน้าให้',
                    `scoring` float DEFAULT NULL COMMENT 'สัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
                    `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณ ช่วงครึ่งแรก ครึ่งหลัง',
                    `cpc_sum_weight` float(5,2) DEFAULT NULL,
                    `soft_delete` tinyint(1) DEFAULT 0 COMMENT '0.ใช้งาน  1.ลบแล้ว',
                    `timestamp` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`cpc_score_result_id`),
                    UNIQUE KEY `per_cardno` (`per_cardno`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=11776 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";

$kpiScore = "CREATE TABLE $kpiScoreName (
                `kpi_score_id` double unsigned NOT NULL AUTO_INCREMENT,
                `kpi_code` varchar(20) DEFAULT NULL COMMENT 'rf จาก kpi_question',
                `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
                `id_admin` char(23) DEFAULT NULL COMMENT 'id admin ที่คีย์ข้อมูลประเมินให้',
                `kpi_score` float unsigned DEFAULT NULL COMMENT 'คะแนน 1-5',
                `kpi_score_raw` float unsigned DEFAULT NULL COMMENT 'คะแนนดิบเชิงร้อยละหรือผลสำเร็จ',
                `works_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผลงาน ',
                `weight` float unsigned DEFAULT 0 COMMENT 'น้ำหนักคะแนน  แต่ละคนจะไม่เท่ากัน ต้องกำหนดตั้งแต่แรก รวมทุกข้อต้องได้ 100 ตอนadmin เพิ่มตัวข้อต้องกำหนดค่าน้ำหนักเอง',
                `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
                `date_key_score` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
                `kpi_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null > ยังไม่มีการยืนยันคะแนน',
                `kpi_comment` text DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
                `who_is_accept` varchar(32) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
                `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
                `kpi_sum_head` float(5,2) DEFAULT NULL,
                `soft_delete` tinyint(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`kpi_score_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=94484 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";

$kpiScoreResult = "CREATE TABLE $kpiScoreResultName (
                    `kpi_score_result_id` int(11) NOT NULL AUTO_INCREMENT,
                    `per_cardno` varchar(15) NOT NULL,
                    `kpi_score_result` float(5,2) DEFAULT NULL,
                    `kpi_weight_sum` float(5,2) DEFAULT NULL,
                    `scoring` float(5,2) DEFAULT NULL COMMENT 'ค่าสัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
                    `years` varchar(10) DEFAULT NULL,
                    `soft_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0.ใช้งาน 1.ลบแล้ว',
                    `time_stamp` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`kpi_score_result_id`),
                    UNIQUE KEY `per_cardno` (`per_cardno`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=11783 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";

$kpiComment = "CREATE TABLE $kpiCommentName (
                `kpi_comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `kpi_score_id` int(11) unsigned NOT NULL,
                `kpi_score_raw` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
                `kpi_score` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
                `kpi_comment` text NOT NULL,
                `who_is_accept` varchar(32) DEFAULT NULL,
                `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`kpi_comment_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";


$idpScore = "CREATE TABLE $idpScoreName (
                `idp_id` int(255) NOT NULL AUTO_INCREMENT,
                `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
                `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
                `idp_type` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะ / หลัก /บริหาร/เฉพาะ/ความรู้/กฏหมาย/ทักษะ',
                `idp_type_detail` varchar(255) DEFAULT NULL COMMENT 'กรณีไม่ได้อ้างอิงกับ สมถรรณะอะไรเลยให้ใส่รายละเอียดที่นี้',
                `idp_title` varchar(255) DEFAULT NULL COMMENT 'หลักสูตร/หัวข้อ/ประเด็น/เรื่องที่จะพัฒนา',
                `idp_training_method` varchar(255) DEFAULT NULL COMMENT 'วิธีพัฒนา',
                `idp_training_hour` int(10) DEFAULT NULL COMMENT 'จำนวนชั่วโมงที่จะ  training',
                `idp_training_hour_success` int(10) DEFAULT NULL COMMENT 'จำนวนที่อบรมสำเร็จ',
                `idp_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null ยังไม่มีการยืนยันคะแนน',
                `idp_who_is_accept` varchar(40) DEFAULT NULL COMMENT 'id 13 หลัก ของผู้ยืนยัน',
                `cpc_score_id` int(11) DEFAULT NULL COMMENT 'อ้างอิงจะสมถรรณะ score ข้อใด',
                `question_no` varchar(20) DEFAULT NULL COMMENT 'id ข้อคำถาม เก็บเผื่อไว้',
                `soft_delete` tinyint(1) DEFAULT NULL,
                PRIMARY KEY (`idp_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT";
