-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: rid_Mariadb
-- Generation Time: Mar 03, 2020 at 03:55 AM
-- Server version: 10.3.12-MariaDB-1:10.3.12+maria~bionic
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epm_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `config_id` int(4) NOT NULL,
  `config_name` varchar(100) DEFAULT NULL,
  `config_value` varchar(100) DEFAULT NULL,
  `config_last_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `config_comment` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_divisor`
--

CREATE TABLE `cpc_divisor` (
  `cpc_weigth_id` int(11) UNSIGNED NOT NULL,
  `level_no` varchar(5) DEFAULT NULL,
  `question_type_1` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะหลัก (Core Competency)',
  `question_type_2` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะทางการบริหาร (Managerial Competency)',
  `question_type_3` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะเฉพาะตามลักษณะงานที่ปฏิบัติ (Functional Competency)',
  `question_type_4` tinyint(1) DEFAULT NULL COMMENT 'ความรู้ที่ใช้ในการปฎิบัติงาน (Knowledge)',
  `question_type_5` tinyint(1) DEFAULT NULL COMMENT 'ความรู้ด้านกฎหมาย (Knowledge of Laws)',
  `question_type_6` tinyint(1) DEFAULT NULL COMMENT 'ทักษะ (Skills)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_question`
--

CREATE TABLE `cpc_question` (
  `question_no` varchar(11) NOT NULL,
  `question_code` varchar(11) DEFAULT NULL,
  `question_title` varchar(255) DEFAULT NULL,
  `question_type` int(3) DEFAULT NULL COMMENT 'สมรรถนะ / หลัก	/บริหาร/เฉพาะ/ความรู้/กฏหมาย/ทักษะ',
  `question_exp` varchar(255) DEFAULT NULL,
  `question_self` int(3) DEFAULT NULL,
  `question_meth` int(3) DEFAULT NULL,
  `question_cel` int(3) DEFAULT NULL,
  `question_tot_qst` int(3) DEFAULT NULL,
  `question_tot_idp` int(3) DEFAULT NULL,
  `question_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `question_status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_question_create`
--

CREATE TABLE `cpc_question_create` (
  `qc_id` int(11) UNSIGNED NOT NULL,
  `question_no` varchar(20) DEFAULT NULL,
  `pl_code` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_question_sub`
--

CREATE TABLE `cpc_question_sub` (
  `qst_no` mediumint(7) UNSIGNED NOT NULL,
  `question_no` varchar(11) CHARACTER SET utf8 NOT NULL COMMENT 'กลุ่มคำถามย่อย ref question_no ',
  `qst_index` tinyint(1) NOT NULL DEFAULT 0,
  `qst_title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qst_kbi_0` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_2019`
--

CREATE TABLE `cpc_score_2019` (
  `cpc_score_id` int(11) UNSIGNED NOT NULL,
  `question_no` varchar(20) DEFAULT NULL COMMENT 'RF จาก cpc_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'ไอดีผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'admin  ผู้เพิ่ม  แล้วเป็นผู้มีสิทธิเข้ามาแก้ไขข้อมูลการประเมิน',
  `cpc_score1` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score2` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score3` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score4` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score5` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย  เช่น 2561-1',
  `date_key_score` timestamp NULL DEFAULT NULL COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `cpc_accept1` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept2` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept3` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept4` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept5` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_comment1` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment2` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment3` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment4` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment5` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_divisor` tinyint(2) UNSIGNED DEFAULT NULL COMMENT 'ค่าคาดหวัง  หรือจำนวนข้อที่เอาไปหารเป็นคะแนน',
  `who_is_accept` char(23) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_2019_2`
--

CREATE TABLE `cpc_score_2019_2` (
  `cpc_score_id` int(11) UNSIGNED NOT NULL,
  `question_no` varchar(20) DEFAULT NULL COMMENT 'RF จาก cpc_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'ไอดีผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'admin  ผู้เพิ่ม  แล้วเป็นผู้มีสิทธิเข้ามาแก้ไขข้อมูลการประเมิน',
  `cpc_score1` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score2` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score3` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score4` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score5` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย  เช่น 2561-1',
  `date_key_score` timestamp NULL DEFAULT NULL COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `cpc_accept1` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept2` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept3` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept4` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept5` float UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_comment1` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment2` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment3` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment4` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment5` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_divisor` tinyint(2) UNSIGNED DEFAULT NULL COMMENT 'ค่าคาดหวัง  หรือจำนวนข้อที่เอาไปหารเป็นคะแนน',
  `who_is_accept` char(23) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `total_head` float(5,2) DEFAULT NULL,
  `sum_head` float(5,2) DEFAULT NULL,
  `point_result` float(5,2) DEFAULT NULL COMMENT 'จำนวนข้อที่ได้ ตั้งแต่ 1-5',
  `gap_status` enum('0','1') DEFAULT NULL COMMENT '0 ไม่ติดgap | 1 ติดgap',
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_history`
--

CREATE TABLE `cpc_score_history` (
  `cpc_score_id` int(11) UNSIGNED NOT NULL,
  `question_no` int(11) DEFAULT NULL COMMENT 'RF จาก cpc_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'ไอดีผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'admin  ผู้เพิ่ม  แล้วเป็นผู้มีสิทธิเข้ามาแก้ไขข้อมูลการประเมิน',
  `cpc_score1` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score2` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score3` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score4` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `cpc_score5` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'คะแนน เก็บ 1-5 ',
  `year` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย  เช่น 2561-1',
  `cpc_result` int(10) DEFAULT NULL COMMENT 'ผลเก็บเมื่อการประเมินสมบูรณ์',
  `date_key_score` timestamp NULL DEFAULT NULL COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `cpc_accept1` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept2` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept3` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept4` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_accept5` tinyint(1) UNSIGNED DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน คะแนน เก็บ 1-5 ',
  `cpc_comment1` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment2` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment3` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment4` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `cpc_comment5` varchar(255) DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `choice_use_process` tinyint(2) UNSIGNED DEFAULT NULL COMMENT 'ค่าคาดหวัง  หรือจำนวนข้อที่เอาไปหารเป็นคะแนน',
  `who_is_accept` char(23) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0,
  `set_no` varchar(50) DEFAULT NULL COMMENT 'ชุดประเมินที่เท่าไร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_progress`
--

CREATE TABLE `cpc_score_progress` (
  `cpc_progress_id` int(11) NOT NULL,
  `per_cardno` varchar(20) DEFAULT NULL,
  `years` varchar(10) DEFAULT NULL,
  `cpc_progress` int(4) DEFAULT NULL,
  `kpi_progress` int(4) DEFAULT NULL,
  `idp_progress` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_result_2019`
--

CREATE TABLE `cpc_score_result_2019` (
  `cpc_score_result_id` int(11) UNSIGNED NOT NULL,
  `per_cardno` varchar(15) NOT NULL,
  `cpc_score_result_yourself` float DEFAULT NULL COMMENT 'คะแนนที่คำนวณเรียบร้อยแล้ว',
  `cpc_score_result_head` float DEFAULT NULL COMMENT 'คะแนนที่หัวหน้าให้',
  `scoring` float DEFAULT NULL COMMENT 'สัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
  `years` varchar(10) NOT NULL COMMENT 'ปีงบประมาณ ช่วงครึ่งแรก ครึ่งหลัง',
  `type` tinyint(1) NOT NULL COMMENT 'เป็นแบบ  1.ไม่คิดตามความคาดหวัง  2.คิดตามความคาดหวัง',
  `soft_delete` tinyint(1) DEFAULT 0 COMMENT '0.ใช้งาน  1.ลบแล้ว',
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cpc_score_result_2019_2`
--

CREATE TABLE `cpc_score_result_2019_2` (
  `cpc_score_result_id` int(11) UNSIGNED NOT NULL,
  `per_cardno` varchar(15) NOT NULL,
  `cpc_score_result_yourself` float DEFAULT NULL COMMENT 'คะแนนที่คำนวณเรียบร้อยแล้ว',
  `cpc_score_result_head` float DEFAULT NULL COMMENT 'คะแนนที่หัวหน้าให้',
  `scoring` float DEFAULT NULL COMMENT 'สัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
  `years` varchar(10) NOT NULL COMMENT 'ปีงบประมาณ ช่วงครึ่งแรก ครึ่งหลัง',
  `cpc_sum_weight` float(5,2) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'เป็นแบบ  1.ไม่คิดตามความคาดหวัง  2.คิดตามความคาดหวัง',
  `soft_delete` tinyint(1) DEFAULT 0 COMMENT '0.ใช้งาน  1.ลบแล้ว',
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `group_auto_id` int(10) NOT NULL,
  `id` char(23) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL COMMENT 'กรณีบ้างคนมีหลาย group',
  `org_id` varchar(10) DEFAULT NULL,
  `org_id_1` varchar(10) DEFAULT NULL,
  `org_id_2` varchar(10) DEFAULT NULL,
  `head_admin` char(23) DEFAULT NULL COMMENT 'user ที่ใช้ว่าตัวเอง 1  ระดับ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `idp_score_2018`
--

CREATE TABLE `idp_score_2018` (
  `idp_id` int(255) NOT NULL,
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
  `idp_type` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะ / หลัก	/บริหาร/เฉพาะ/ความรู้/กฏหมาย/ทักษะ',
  `idp_type_detail` varchar(255) DEFAULT NULL COMMENT 'กรณีไม่ได้อ้างอิงกับ สมถรรณะอะไรเลยให้ใส่รายละเอียดที่นี้',
  `idp_title` varchar(255) DEFAULT NULL COMMENT 'หลักสูตร/หัวข้อ/ประเด็น/เรื่องที่จะพัฒนา',
  `idp_training_method` varchar(255) DEFAULT NULL COMMENT 'วิธีพัฒนา',
  `idp_training_hour` int(10) DEFAULT NULL COMMENT 'จำนวนชั่วโมงที่จะ  training',
  `idp_training_hour_success` int(10) DEFAULT NULL COMMENT 'จำนวนที่อบรมสำเร็จ',
  `idp_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null ยังไม่มีการยืนยันคะแนน',
  `idp_who_is_accept` varchar(40) DEFAULT NULL COMMENT 'id 13 หลัก ของผู้ยืนยัน',
  `cpc_score_id` int(11) DEFAULT NULL COMMENT 'อ้างอิงจะสมถรรณะ score ข้อใด',
  `question_no` varchar(20) DEFAULT NULL COMMENT 'id ข้อคำถาม เก็บเผื่อไว้',
  `soft_delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `idp_score_2019`
--

CREATE TABLE `idp_score_2019` (
  `idp_id` int(255) NOT NULL,
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
  `idp_type` tinyint(1) DEFAULT NULL COMMENT 'สมรรถนะ / หลัก	/บริหาร/เฉพาะ/ความรู้/กฏหมาย/ทักษะ',
  `idp_type_detail` varchar(255) DEFAULT NULL COMMENT 'กรณีไม่ได้อ้างอิงกับ สมถรรณะอะไรเลยให้ใส่รายละเอียดที่นี้',
  `idp_title` varchar(255) DEFAULT NULL COMMENT 'หลักสูตร/หัวข้อ/ประเด็น/เรื่องที่จะพัฒนา',
  `idp_training_method` varchar(255) DEFAULT NULL COMMENT 'วิธีพัฒนา',
  `idp_training_hour` int(10) DEFAULT NULL COMMENT 'จำนวนชั่วโมงที่จะ  training',
  `idp_training_hour_success` int(10) DEFAULT NULL COMMENT 'จำนวนที่อบรมสำเร็จ',
  `idp_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null ยังไม่มีการยืนยันคะแนน',
  `idp_who_is_accept` varchar(40) DEFAULT NULL COMMENT 'id 13 หลัก ของผู้ยืนยัน',
  `cpc_score_id` int(11) DEFAULT NULL COMMENT 'อ้างอิงจะสมถรรณะ score ข้อใด',
  `question_no` varchar(20) DEFAULT NULL COMMENT 'id ข้อคำถาม เก็บเผื่อไว้',
  `soft_delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `idp_score_2019_2`
--

CREATE TABLE `idp_score_2019_2` (
  `idp_id` int(255) NOT NULL,
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
  `soft_delete` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_comment_2019`
--

CREATE TABLE `kpi_comment_2019` (
  `kpi_comment_id` int(11) UNSIGNED NOT NULL,
  `kpi_score_id` int(11) UNSIGNED NOT NULL,
  `kpi_score_raw` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
  `kpi_score` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
  `kpi_comment` text NOT NULL,
  `who_is_accept` varchar(32) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_comment_2019_2`
--

CREATE TABLE `kpi_comment_2019_2` (
  `kpi_comment_id` int(11) UNSIGNED NOT NULL,
  `kpi_score_id` int(11) UNSIGNED NOT NULL,
  `kpi_score_raw` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
  `kpi_score` float DEFAULT NULL COMMENT 'ประวัติคะแนนเก่า',
  `kpi_comment` text NOT NULL,
  `who_is_accept` varchar(32) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_question`
--

CREATE TABLE `kpi_question` (
  `kpi_code` varchar(20) NOT NULL,
  `kpi_org` varchar(255) DEFAULT NULL COMMENT 'ชื่อกลุ่มของการประเมิน เช่น กลุ่ม ฝ่ายบริหารทั่วไป',
  `kpi_code_org` varchar(20) DEFAULT NULL COMMENT 'code ของกลุ่มประเมิน เช่น ฝบท06(61) ฝบท19(61)',
  `kpi_title` varchar(255) DEFAULT NULL,
  `kpi_type` int(3) DEFAULT NULL COMMENT 'ลักษณะงาน 1.กลยุทธ์/2.ประจำ/3.พิเศษ',
  `kpi_con_type` int(3) DEFAULT NULL,
  `kpi_type2` int(3) DEFAULT NULL COMMENT 'ประเภท 1.รายเดือน /2.เชิงร้อยละหรือผลสำเร็จ/3.ใส่คะแนน',
  `kpi_level1` varchar(255) DEFAULT NULL,
  `kpi_level2` varchar(255) DEFAULT NULL,
  `kpi_level3` varchar(255) DEFAULT NULL,
  `kpi_level4` varchar(255) DEFAULT NULL,
  `kpi_level5` varchar(255) DEFAULT NULL,
  `kpi_con1` int(3) DEFAULT NULL COMMENT '1 การประเมินเชิงปริมาณ 2 เชิงร้อยละ',
  `kpi_con2` int(3) DEFAULT NULL COMMENT '1 การประเมินเชิงบวก  2 เชิงลบ',
  `kpi_rank1` float DEFAULT NULL COMMENT 'ค่าระดับคะแนน 1 (สัมพันธ์กับ LEVEL1)',
  `kpi_rank2` float DEFAULT NULL COMMENT 'ค่าระดับคะแนน 2 (สัมพันธ์กับ LEVEL2)',
  `kpi_rank3` float DEFAULT NULL COMMENT 'ค่าระดับคะแนน 3 (สัมพันธ์กับ LEVEL3)',
  `kpi_rank4` float DEFAULT NULL COMMENT 'ค่าระดับคะแนน 4 (สัมพันธ์กับ LEVEL4)',
  `kpi_rank5` float DEFAULT NULL COMMENT 'ค่าระดับคะแนน 5 (สัมพันธ์กับ LEVEL5)',
  `kpi_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_score_2018`
--

CREATE TABLE `kpi_score_2018` (
  `kpi_score_id` double UNSIGNED NOT NULL,
  `kpi_code` varchar(20) DEFAULT NULL COMMENT 'rf จาก kpi_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'id admin ที่คีย์ข้อมูลประเมินให้',
  `kpi_score` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน 1-5',
  `kpi_score_raw` float UNSIGNED DEFAULT NULL COMMENT 'คะแนนดิบเชิงร้อยละหรือผลสำเร็จ',
  `works_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผลงาน ',
  `weight` float UNSIGNED DEFAULT 0 COMMENT 'น้ำหนักคะแนน  แต่ละคนจะไม่เท่ากัน ต้องกำหนดตั้งแต่แรก รวมทุกข้อต้องได้ 100 ตอนadmin เพิ่มตัวข้อต้องกำหนดค่าน้ำหนักเอง',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
  `date_key_score` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `kpi_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null > ยังไม่มีการยืนยันคะแนน',
  `kpi_comment` text DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `who_is_accept` varchar(32) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_score_2019`
--

CREATE TABLE `kpi_score_2019` (
  `kpi_score_id` double UNSIGNED NOT NULL,
  `kpi_code` varchar(20) DEFAULT NULL COMMENT 'rf จาก kpi_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'id admin ที่คีย์ข้อมูลประเมินให้',
  `kpi_score` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน 1-5',
  `kpi_score_raw` float UNSIGNED DEFAULT NULL COMMENT 'คะแนนดิบเชิงร้อยละหรือผลสำเร็จ',
  `works_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผลงาน ',
  `weight` float UNSIGNED DEFAULT 0 COMMENT 'น้ำหนักคะแนน  แต่ละคนจะไม่เท่ากัน ต้องกำหนดตั้งแต่แรก รวมทุกข้อต้องได้ 100 ตอนadmin เพิ่มตัวข้อต้องกำหนดค่าน้ำหนักเอง',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
  `date_key_score` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `kpi_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null > ยังไม่มีการยืนยันคะแนน',
  `kpi_comment` text DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `who_is_accept` varchar(32) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_score_2019_2`
--

CREATE TABLE `kpi_score_2019_2` (
  `kpi_score_id` double UNSIGNED NOT NULL,
  `kpi_code` varchar(20) DEFAULT NULL COMMENT 'rf จาก kpi_question',
  `per_cardno` varchar(20) DEFAULT NULL COMMENT 'id 13 ผู้รับการประเมิน',
  `id_admin` char(23) DEFAULT NULL COMMENT 'id admin ที่คีย์ข้อมูลประเมินให้',
  `kpi_score` float UNSIGNED DEFAULT NULL COMMENT 'คะแนน 1-5',
  `kpi_score_raw` float UNSIGNED DEFAULT NULL COMMENT 'คะแนนดิบเชิงร้อยละหรือผลสำเร็จ',
  `works_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อผลงาน ',
  `weight` float UNSIGNED DEFAULT 0 COMMENT 'น้ำหนักคะแนน  แต่ละคนจะไม่เท่ากัน ต้องกำหนดตั้งแต่แรก รวมทุกข้อต้องได้ 100 ตอนadmin เพิ่มตัวข้อต้องกำหนดค่าน้ำหนักเอง',
  `years` varchar(10) DEFAULT NULL COMMENT 'ปีงบประมาณที่ประเมิน ช่วง ต้นงบ หรือ ปลายงบ เก็บค่า -1=ต้น -2=ปลาย เช่น 2561-1',
  `date_key_score` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'วันที่ข้อมูลมีการเคลื่อนไหวล่าสุด',
  `kpi_accept` tinyint(1) DEFAULT NULL COMMENT 'ผู้บังคับบัญชายื่นยัน 1.ยืนยัน ตามคะแนนที่กรอก 2. ไม่ยืนยันตามคะแนนที่กรอก null > ยังไม่มีการยืนยันคะแนน',
  `kpi_comment` text DEFAULT NULL COMMENT 'กรณีใส่คะแนนไม่ตรงกันผู้ประเมิน',
  `who_is_accept` varchar(32) DEFAULT NULL COMMENT 'id  admin  หรือ  id 13 หลักของคนที่มาทำยืนยันให้  ถ้าคนยืนยันเป็นผู้บังคับบัญชาอยู่แล้วก็ไม่ต้องเก็บ',
  `date_who_id_accept` timestamp NULL DEFAULT NULL COMMENT 'วันที่มายืนยัน',
  `kpi_sum_head` float(5,2) DEFAULT NULL,
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_score_result_2019`
--

CREATE TABLE `kpi_score_result_2019` (
  `kpi_score_result_id` int(11) NOT NULL,
  `per_cardno` varchar(15) NOT NULL,
  `kpi_score_result` float(20,0) DEFAULT NULL,
  `scoring` float DEFAULT NULL COMMENT 'ค่าสัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
  `years` varchar(10) NOT NULL,
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0.ใช้งาน 1.ลบแล้ว',
  `time_stamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_score_result_2019_2`
--

CREATE TABLE `kpi_score_result_2019_2` (
  `kpi_score_result_id` int(11) NOT NULL,
  `per_cardno` varchar(15) NOT NULL,
  `kpi_score_result` float(5,2) DEFAULT NULL,
  `kpi_weight_sum` float(5,2) DEFAULT NULL,
  `scoring` float(5,2) DEFAULT NULL COMMENT 'ค่าสัดส่วนคะแนน ตอนที่เอา kpi รวมกับ cpc',
  `years` varchar(10) NOT NULL,
  `soft_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0.ใช้งาน 1.ลบแล้ว',
  `time_stamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` char(23) NOT NULL,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(65) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 1,
  `mod_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `picture_profile` varchar(255) DEFAULT NULL,
  `sex` enum('male','female','','') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone_org` varchar(15) DEFAULT NULL,
  `org_id` int(8) DEFAULT NULL,
  `org_id_1` int(8) DEFAULT NULL,
  `org_id_2` int(8) DEFAULT NULL,
  `status_user` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'สถานะของ user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `member_groups`
--

CREATE TABLE `member_groups` (
  `group_id` int(3) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_detail` varchar(255) NOT NULL,
  `level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `new_id` int(11) NOT NULL,
  `new_title` text NOT NULL,
  `new_content` text NOT NULL,
  `new_create_date` datetime DEFAULT current_timestamp(),
  `new_modify_date` datetime DEFAULT NULL,
  `new_user_create` varchar(50) NOT NULL,
  `new_order` int(11) NOT NULL,
  `new_public` tinyint(1) NOT NULL DEFAULT 1,
  `solfdelete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `per_level`
--

CREATE TABLE `per_level` (
  `level_no` varchar(2) NOT NULL,
  `level_act` tinyint(1) DEFAULT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `per_type` tinyint(1) DEFAULT NULL,
  `level_shotname` varchar(50) DEFAULT NULL,
  `level_seq_no` int(3) DEFAULT NULL,
  `position_type` varchar(100) DEFAULT NULL,
  `position_level` varchar(100) DEFAULT NULL,
  `level_othername` varchar(100) DEFAULT NULL,
  `level_engname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `per_line`
--

CREATE TABLE `per_line` (
  `pl_code` varchar(50) NOT NULL,
  `pl_name` varchar(255) DEFAULT NULL,
  `pl_shortname` varchar(255) DEFAULT NULL,
  `pl_active` tinyint(1) DEFAULT NULL,
  `update_user` varchar(50) DEFAULT NULL,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pl_type` tinyint(1) DEFAULT NULL,
  `pl_code_new` varchar(50) DEFAULT NULL,
  `lg_code` varchar(50) DEFAULT NULL,
  `pl_code_direct` varchar(50) DEFAULT NULL,
  `cl_name` varchar(255) DEFAULT NULL,
  `layer_type` tinyint(1) DEFAULT NULL,
  `pl_seq_no` varchar(5) DEFAULT NULL,
  `pl_othername` varchar(50) DEFAULT NULL,
  `level_no_min` varchar(50) DEFAULT NULL,
  `level_no_max` varchar(50) DEFAULT NULL,
  `pl_cp_code` varchar(50) DEFAULT NULL,
  `pl_engname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `per_mgt`
--

CREATE TABLE `per_mgt` (
  `pm_code` varchar(20) NOT NULL,
  `pm_name` varchar(100) DEFAULT NULL,
  `pm_shortname` varchar(100) DEFAULT NULL,
  `ps_code` varchar(5) DEFAULT NULL,
  `pm_active` tinyint(1) DEFAULT NULL,
  `update_user` varchar(50) DEFAULT NULL,
  `update_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `per_org`
--

CREATE TABLE `per_org` (
  `org_id` int(8) NOT NULL,
  `org_name` varchar(150) DEFAULT NULL,
  `org_code` int(15) DEFAULT NULL,
  `org_id_ref` int(8) DEFAULT NULL,
  `org_active` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `per_personal_2019`
--

CREATE TABLE `per_personal_2019` (
  `per_id` varchar(5) NOT NULL,
  `per_cardno` varchar(13) NOT NULL COMMENT 'หมายเลขประจำตัวประชาชน',
  `pn_name` varchar(15) DEFAULT NULL COMMENT 'คำนำหน้าชื่อ',
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
  `per_mgtsalary` int(10) DEFAULT NULL COMMENT 'เงินประจำตำแหน่ง',
  `per_spsalary` int(10) DEFAULT NULL COMMENT 'อัตราเงินเดือน',
  `pl_name` varchar(100) DEFAULT NULL,
  `pl_code` varchar(10) DEFAULT NULL,
  `pm_code` varchar(10) DEFAULT NULL,
  `pm_name` varchar(100) DEFAULT NULL,
  `pt_name` varchar(100) DEFAULT NULL,
  `level_no` char(2) DEFAULT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `per_mobile` varchar(15) DEFAULT NULL,
  `per_email` varchar(50) DEFAULT NULL,
  `per_address` varchar(255) DEFAULT NULL,
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
  `login_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `per_personal_2019_2`
--

CREATE TABLE `per_personal_2019_2` (
  `per_id` varchar(5) NOT NULL,
  `per_cardno` varchar(13) NOT NULL COMMENT 'หมายเลขประจำตัวประชาชน',
  `pn_name` varchar(15) DEFAULT NULL COMMENT 'คำนำหน้าชื่อ',
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
  `per_mgtsalary` int(10) DEFAULT NULL COMMENT 'เงินประจำตำแหน่ง',
  `per_spsalary` int(10) DEFAULT NULL COMMENT 'อัตราเงินเดือน',
  `pl_name` varchar(100) DEFAULT NULL,
  `pl_code` varchar(10) DEFAULT NULL,
  `pm_code` varchar(10) DEFAULT NULL,
  `pm_name` varchar(100) DEFAULT NULL,
  `pt_name` varchar(100) DEFAULT NULL,
  `level_no` char(2) DEFAULT NULL,
  `level_name` varchar(100) DEFAULT NULL,
  `per_mobile` varchar(15) DEFAULT NULL,
  `per_email` varchar(50) DEFAULT NULL,
  `per_address` varchar(255) DEFAULT NULL,
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
  `login_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `table_year`
--

CREATE TABLE `table_year` (
  `table_id` int(5) NOT NULL,
  `detail` varchar(255) DEFAULT NULL COMMENT 'ประจำปีงบประมาณ',
  `detail_short` varchar(255) DEFAULT NULL,
  `per_personal` varchar(100) NOT NULL,
  `cpc_score` varchar(50) NOT NULL,
  `cpc_score_result` varchar(50) NOT NULL,
  `kpi_score` varchar(50) NOT NULL,
  `kpi_score_result` varchar(50) NOT NULL,
  `kpi_comment` varchar(50) NOT NULL,
  `idp_score` varchar(50) DEFAULT NULL,
  `start_evaluation` varchar(20) DEFAULT NULL COMMENT 'เริ่มประเมิน',
  `end_evaluation` varchar(20) DEFAULT NULL COMMENT 'สิ้นสุดประเมิน',
  `start_evaluation_2` varchar(20) DEFAULT NULL,
  `end_evaluation_2` varchar(20) DEFAULT NULL,
  `table_year` varchar(15) NOT NULL,
  `default_status` int(1) DEFAULT NULL,
  `use_status` int(1) DEFAULT NULL COMMENT 'กรณีที่รอบงบประมาณยังมาไม่ถึง  หรือต้องการปิดลิล์ต ไม่ให้มองเห็น'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `useronline`
--

CREATE TABLE `useronline` (
  `useronline_id` int(10) NOT NULL,
  `per_cardno_ip` varchar(100) DEFAULT NULL,
  `timestamp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `cpc_divisor`
--
ALTER TABLE `cpc_divisor`
  ADD PRIMARY KEY (`cpc_weigth_id`);

--
-- Indexes for table `cpc_question`
--
ALTER TABLE `cpc_question`
  ADD PRIMARY KEY (`question_no`);

--
-- Indexes for table `cpc_question_create`
--
ALTER TABLE `cpc_question_create`
  ADD PRIMARY KEY (`qc_id`);

--
-- Indexes for table `cpc_question_sub`
--
ALTER TABLE `cpc_question_sub`
  ADD PRIMARY KEY (`qst_no`),
  ADD UNIQUE KEY `qst_no` (`qst_no`),
  ADD KEY `mod_no` (`question_no`,`qst_index`);

--
-- Indexes for table `cpc_score_2019`
--
ALTER TABLE `cpc_score_2019`
  ADD PRIMARY KEY (`cpc_score_id`);

--
-- Indexes for table `cpc_score_2019_2`
--
ALTER TABLE `cpc_score_2019_2`
  ADD PRIMARY KEY (`cpc_score_id`);

--
-- Indexes for table `cpc_score_history`
--
ALTER TABLE `cpc_score_history`
  ADD PRIMARY KEY (`cpc_score_id`);

--
-- Indexes for table `cpc_score_progress`
--
ALTER TABLE `cpc_score_progress`
  ADD PRIMARY KEY (`cpc_progress_id`);

--
-- Indexes for table `cpc_score_result_2019`
--
ALTER TABLE `cpc_score_result_2019`
  ADD PRIMARY KEY (`cpc_score_result_id`);

--
-- Indexes for table `cpc_score_result_2019_2`
--
ALTER TABLE `cpc_score_result_2019_2`
  ADD PRIMARY KEY (`cpc_score_result_id`);

--
-- Indexes for table `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`group_auto_id`);

--
-- Indexes for table `idp_score_2018`
--
ALTER TABLE `idp_score_2018`
  ADD PRIMARY KEY (`idp_id`);

--
-- Indexes for table `idp_score_2019`
--
ALTER TABLE `idp_score_2019`
  ADD PRIMARY KEY (`idp_id`);

--
-- Indexes for table `idp_score_2019_2`
--
ALTER TABLE `idp_score_2019_2`
  ADD PRIMARY KEY (`idp_id`);

--
-- Indexes for table `kpi_comment_2019`
--
ALTER TABLE `kpi_comment_2019`
  ADD PRIMARY KEY (`kpi_comment_id`);

--
-- Indexes for table `kpi_comment_2019_2`
--
ALTER TABLE `kpi_comment_2019_2`
  ADD PRIMARY KEY (`kpi_comment_id`);

--
-- Indexes for table `kpi_question`
--
ALTER TABLE `kpi_question`
  ADD PRIMARY KEY (`kpi_code`);

--
-- Indexes for table `kpi_score_2018`
--
ALTER TABLE `kpi_score_2018`
  ADD PRIMARY KEY (`kpi_score_id`);

--
-- Indexes for table `kpi_score_2019`
--
ALTER TABLE `kpi_score_2019`
  ADD PRIMARY KEY (`kpi_score_id`);

--
-- Indexes for table `kpi_score_2019_2`
--
ALTER TABLE `kpi_score_2019_2`
  ADD PRIMARY KEY (`kpi_score_id`);

--
-- Indexes for table `kpi_score_result_2019`
--
ALTER TABLE `kpi_score_result_2019`
  ADD PRIMARY KEY (`kpi_score_result_id`);

--
-- Indexes for table `kpi_score_result_2019_2`
--
ALTER TABLE `kpi_score_result_2019_2`
  ADD PRIMARY KEY (`kpi_score_result_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `member_groups`
--
ALTER TABLE `member_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`new_id`);

--
-- Indexes for table `per_level`
--
ALTER TABLE `per_level`
  ADD PRIMARY KEY (`level_no`);

--
-- Indexes for table `per_line`
--
ALTER TABLE `per_line`
  ADD PRIMARY KEY (`pl_code`);

--
-- Indexes for table `per_mgt`
--
ALTER TABLE `per_mgt`
  ADD PRIMARY KEY (`pm_code`);

--
-- Indexes for table `per_org`
--
ALTER TABLE `per_org`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `per_personal_2019`
--
ALTER TABLE `per_personal_2019`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `per_personal_2019_2`
--
ALTER TABLE `per_personal_2019_2`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `table_year`
--
ALTER TABLE `table_year`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `useronline`
--
ALTER TABLE `useronline`
  ADD PRIMARY KEY (`useronline_id`),
  ADD UNIQUE KEY `per_cardno_ip` (`per_cardno_ip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_divisor`
--
ALTER TABLE `cpc_divisor`
  MODIFY `cpc_weigth_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_question_create`
--
ALTER TABLE `cpc_question_create`
  MODIFY `qc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_question_sub`
--
ALTER TABLE `cpc_question_sub`
  MODIFY `qst_no` mediumint(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_2019`
--
ALTER TABLE `cpc_score_2019`
  MODIFY `cpc_score_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_2019_2`
--
ALTER TABLE `cpc_score_2019_2`
  MODIFY `cpc_score_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_history`
--
ALTER TABLE `cpc_score_history`
  MODIFY `cpc_score_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_progress`
--
ALTER TABLE `cpc_score_progress`
  MODIFY `cpc_progress_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_result_2019`
--
ALTER TABLE `cpc_score_result_2019`
  MODIFY `cpc_score_result_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpc_score_result_2019_2`
--
ALTER TABLE `cpc_score_result_2019_2`
  MODIFY `cpc_score_result_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_users`
--
ALTER TABLE `group_users`
  MODIFY `group_auto_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idp_score_2018`
--
ALTER TABLE `idp_score_2018`
  MODIFY `idp_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idp_score_2019`
--
ALTER TABLE `idp_score_2019`
  MODIFY `idp_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idp_score_2019_2`
--
ALTER TABLE `idp_score_2019_2`
  MODIFY `idp_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_comment_2019`
--
ALTER TABLE `kpi_comment_2019`
  MODIFY `kpi_comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_comment_2019_2`
--
ALTER TABLE `kpi_comment_2019_2`
  MODIFY `kpi_comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_score_2018`
--
ALTER TABLE `kpi_score_2018`
  MODIFY `kpi_score_id` double UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_score_2019`
--
ALTER TABLE `kpi_score_2019`
  MODIFY `kpi_score_id` double UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_score_2019_2`
--
ALTER TABLE `kpi_score_2019_2`
  MODIFY `kpi_score_id` double UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_score_result_2019`
--
ALTER TABLE `kpi_score_result_2019`
  MODIFY `kpi_score_result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kpi_score_result_2019_2`
--
ALTER TABLE `kpi_score_result_2019_2`
  MODIFY `kpi_score_result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_groups`
--
ALTER TABLE `member_groups`
  MODIFY `group_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `per_org`
--
ALTER TABLE `per_org`
  MODIFY `org_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_year`
--
ALTER TABLE `table_year`
  MODIFY `table_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useronline`
--
ALTER TABLE `useronline`
  MODIFY `useronline_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
