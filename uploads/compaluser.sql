/*
 Navicat Premium Data Transfer

 Source Server         : ret
 Source Server Type    : MySQL
 Source Server Version : 50547
 Source Host           : 182.61.173.1:3306
 Source Schema         : compaluser

 Target Server Type    : MySQL
 Target Server Version : 50547
 File Encoding         : 65001

 Date: 28/05/2020 18:42:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bios_system
-- ----------------------------
DROP TABLE IF EXISTS `bios_system`;
CREATE TABLE `bios_system`  (
  `Id` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Activity` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPRS` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Eco_no` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_ver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_sysver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `New_ver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `New_sysver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Begingtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `1_Endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `1_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Status` int(1) NULL DEFAULT NULL,
  `1_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_ck_date` timestamp NULL DEFAULT NULL,
  `1_ck_day` int(2) NULL DEFAULT NULL,
  `1_Score` int(2) NULL DEFAULT NULL,
  `1_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Begingtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `2_Endtime` timestamp NULL DEFAULT NULL,
  `2_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Status` int(2) NULL DEFAULT NULL,
  `2_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_ck_date` timestamp NULL DEFAULT NULL,
  `2_ck_day` int(2) NULL DEFAULT NULL,
  `2_Score` int(2) NULL DEFAULT NULL,
  `2_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Begingtime` timestamp NULL DEFAULT NULL,
  `3_Endtime` timestamp NULL DEFAULT NULL,
  `3_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Status` int(2) NULL DEFAULT NULL,
  `3_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_ck_date` timestamp NULL DEFAULT NULL,
  `3_ck_day` int(2) NULL DEFAULT NULL,
  `3_Score` int(2) NULL DEFAULT NULL,
  `3_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Begingtime` timestamp NULL DEFAULT NULL,
  `4_Endtime` timestamp NULL DEFAULT NULL,
  `4_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Status` int(2) NULL DEFAULT NULL,
  `4_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_ck_date` timestamp NULL DEFAULT NULL,
  `4_ck_day` int(2) NULL DEFAULT NULL,
  `4_Score` int(2) NULL DEFAULT NULL,
  `4_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Begingtime` timestamp NULL DEFAULT NULL,
  `5_Endtime` timestamp NULL DEFAULT NULL,
  `5_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Status` int(2) NULL DEFAULT NULL,
  `5_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_ck_date` timestamp NULL DEFAULT NULL,
  `5_ck_day` int(2) NULL DEFAULT NULL,
  `5_Score` int(2) NULL DEFAULT NULL,
  `5_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Begingtime` timestamp NULL DEFAULT NULL,
  `6_Endtime` timestamp NULL DEFAULT NULL,
  `6_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Status` int(2) NULL DEFAULT NULL,
  `6_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_ck_date` timestamp NULL DEFAULT NULL,
  `6_ck_day` int(2) NULL DEFAULT NULL,
  `6_Score` int(2) NULL DEFAULT NULL,
  `6_ck_mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT 0,
  `Suo` int(1) NOT NULL DEFAULT 0,
  `D_bgtime` timestamp NULL DEFAULT NULL,
  `debug_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ceb_check_data
-- ----------------------------
DROP TABLE IF EXISTS `ceb_check_data`;
CREATE TABLE `ceb_check_data`  (
  `PPID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'CEB'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ceb_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `ceb_fail_data`;
CREATE TABLE `ceb_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ceb_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `ceb_fail_data1`;
CREATE TABLE `ceb_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ceb_testlog
-- ----------------------------
DROP TABLE IF EXISTS `ceb_testlog`;
CREATE TABLE `ceb_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 292692 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ceb_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `ceb_vifi_check`;
CREATE TABLE `ceb_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ceb_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `ceb_wednesday`;
CREATE TABLE `ceb_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cep_check_data
-- ----------------------------
DROP TABLE IF EXISTS `cep_check_data`;
CREATE TABLE `cep_check_data`  (
  `PPID` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'CEP'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cep_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `cep_fail_data`;
CREATE TABLE `cep_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cep_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `cep_fail_data1`;
CREATE TABLE `cep_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cep_testlog
-- ----------------------------
DROP TABLE IF EXISTS `cep_testlog`;
CREATE TABLE `cep_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  INDEX `PPID`(`PPID`, `Date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 939027 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cep_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `cep_vifi_check`;
CREATE TABLE `cep_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cep_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `cep_wednesday`;
CREATE TABLE `cep_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cgs_check_data
-- ----------------------------
DROP TABLE IF EXISTS `cgs_check_data`;
CREATE TABLE `cgs_check_data`  (
  `PPID` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'CGS'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cgs_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `cgs_fail_data`;
CREATE TABLE `cgs_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cgs_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `cgs_fail_data1`;
CREATE TABLE `cgs_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cgs_testlog
-- ----------------------------
DROP TABLE IF EXISTS `cgs_testlog`;
CREATE TABLE `cgs_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 131703 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cgs_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `cgs_vifi_check`;
CREATE TABLE `cgs_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cgs_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `cgs_wednesday`;
CREATE TABLE `cgs_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for checker
-- ----------------------------
DROP TABLE IF EXISTS `checker`;
CREATE TABLE `checker`  (
  `Activity` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPR` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `1_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Approw_Date` timestamp NULL DEFAULT NULL,
  `1_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Score` int(2) NULL DEFAULT NULL,
  `1_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Approw_Date` timestamp NULL DEFAULT NULL,
  `2_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Score` int(2) NULL DEFAULT NULL,
  `2_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Approw_Date` timestamp NULL DEFAULT NULL,
  `3_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Score` int(2) NULL DEFAULT NULL,
  `3_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Approw_Date` timestamp NULL DEFAULT NULL,
  `4_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Score` int(2) NULL DEFAULT NULL,
  `4_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Approw_Date` timestamp NULL DEFAULT NULL,
  `5_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Score` int(2) NULL DEFAULT NULL,
  `5_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Approw` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Approw_Date` timestamp NULL DEFAULT NULL,
  `6_day` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Score` int(2) NULL DEFAULT NULL,
  `6_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  INDEX `Activity`(`Activity`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cts_check_data
-- ----------------------------
DROP TABLE IF EXISTS `cts_check_data`;
CREATE TABLE `cts_check_data`  (
  `PPID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cts_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `cts_fail_data`;
CREATE TABLE `cts_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cts_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `cts_fail_data1`;
CREATE TABLE `cts_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cts_testlog
-- ----------------------------
DROP TABLE IF EXISTS `cts_testlog`;
CREATE TABLE `cts_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24109 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cts_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `cts_vifi_check`;
CREATE TABLE `cts_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cts_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `cts_wednesday`;
CREATE TABLE `cts_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eco_delay
-- ----------------------------
DROP TABLE IF EXISTS `eco_delay`;
CREATE TABLE `eco_delay`  (
  `Id` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPR` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `eaction` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `efile` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `etime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eco_system
-- ----------------------------
DROP TABLE IF EXISTS `eco_system`;
CREATE TABLE `eco_system`  (
  `Id` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Activity` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPRS` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Eco_no` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_ECO_Number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `New_comp` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Begingtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `1_Endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `1_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Status` int(1) NULL DEFAULT NULL,
  `1_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Begingtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `2_Endtime` timestamp NULL DEFAULT NULL,
  `2_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Status` int(2) NULL DEFAULT NULL,
  `2_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PO_number` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Begingtime` timestamp NULL DEFAULT NULL,
  `3_Endtime` timestamp NULL DEFAULT NULL,
  `3_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Status` int(2) NULL DEFAULT NULL,
  `3_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Begingtime` timestamp NULL DEFAULT NULL,
  `4_Endtime` timestamp NULL DEFAULT NULL,
  `4agtime` datetime NULL DEFAULT NULL,
  `4_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Status` int(2) NULL DEFAULT NULL,
  `4_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Begingtime` timestamp NULL DEFAULT NULL,
  `5_Endtime` timestamp NULL DEFAULT NULL,
  `5_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Status` int(2) NULL DEFAULT NULL,
  `5_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Begingtime` timestamp NULL DEFAULT NULL,
  `6_Endtime` timestamp NULL DEFAULT NULL,
  `6_Remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Status` int(2) NULL DEFAULT NULL,
  `6_Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_file` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT 0,
  `D_bgtime` timestamp NULL DEFAULT NULL,
  `debug_time` timestamp NULL DEFAULT NULL,
  `Verify` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'pass',
  `suo` int(6) NOT NULL,
  `Last_ECO` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `flag` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for h4_aduit
-- ----------------------------
DROP TABLE IF EXISTS `h4_aduit`;
CREATE TABLE `h4_aduit`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dept` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `steps` int(6) NOT NULL,
  `mail` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tpr` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `steps`(`steps`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for heco
-- ----------------------------
DROP TABLE IF EXISTS `heco`;
CREATE TABLE `heco`  (
  `No` int(255) NOT NULL AUTO_INCREMENT,
  `Model` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DMname` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `history_ECO` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`No`) USING BTREE,
  UNIQUE INDEX `add_model`(`Model`, `history_ECO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for igs_check_data
-- ----------------------------
DROP TABLE IF EXISTS `igs_check_data`;
CREATE TABLE `igs_check_data`  (
  `PPID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'IGS'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for igs_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `igs_fail_data`;
CREATE TABLE `igs_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for igs_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `igs_fail_data1`;
CREATE TABLE `igs_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for igs_testlog
-- ----------------------------
DROP TABLE IF EXISTS `igs_testlog`;
CREATE TABLE `igs_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1508595 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for igs_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `igs_vifi_check`;
CREATE TABLE `igs_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for igs_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `igs_wednesday`;
CREATE TABLE `igs_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for mail
-- ----------------------------
DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail`  (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mail` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tpr` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `spmaflag` int(1) UNSIGNED NOT NULL,
  `dept` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 669 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_cebs
-- ----------------------------
DROP TABLE IF EXISTS `matrix_cebs`;
CREATE TABLE `matrix_cebs`  (
  `DELL_PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_ceps
-- ----------------------------
DROP TABLE IF EXISTS `matrix_ceps`;
CREATE TABLE `matrix_ceps`  (
  `DELL_PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_csats
-- ----------------------------
DROP TABLE IF EXISTS `matrix_csats`;
CREATE TABLE `matrix_csats`  (
  `DELL_PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_example
-- ----------------------------
DROP TABLE IF EXISTS `matrix_example`;
CREATE TABLE `matrix_example`  (
  `DELL_PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_igss
-- ----------------------------
DROP TABLE IF EXISTS `matrix_igss`;
CREATE TABLE `matrix_igss`  (
  `DELL_PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for matrix_rlc_sh
-- ----------------------------
DROP TABLE IF EXISTS `matrix_rlc_sh`;
CREATE TABLE `matrix_rlc_sh`  (
  `DELL_PN` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Compal_Name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DELL_Name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DPK_Inject` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `HDD_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Q3_Image_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BIOS_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Update_BIOS_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `EC_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MB_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `VGA_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `CPU_Ver` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPM_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TBT_FW` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DOCK` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `SystemID_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MSR_VER` int(11) NULL DEFAULT NULL,
  `Last_Update_Date` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Old_BIOS_Ver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `NewBios_Time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`DELL_PN`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for model
-- ----------------------------
DROP TABLE IF EXISTS `model`;
CREATE TABLE `model`  (
  `No` int(255) NOT NULL AUTO_INCREMENT,
  `Model` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DMname` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Oldver` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Old_sysver` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`No`) USING BTREE,
  UNIQUE INDEX `add_model`(`Model`, `Oldver`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 735 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for mppid
-- ----------------------------
DROP TABLE IF EXISTS `mppid`;
CREATE TABLE `mppid`  (
  `Numb` int(12) NOT NULL AUTO_INCREMENT,
  `multippid` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mtime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Numb`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 395 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for new_vfir_report
-- ----------------------------
DROP TABLE IF EXISTS `new_vfir_report`;
CREATE TABLE `new_vfir_report`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID_Out` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Scrap` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Ship_Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for newpn
-- ----------------------------
DROP TABLE IF EXISTS `newpn`;
CREATE TABLE `newpn`  (
  `Date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`PN`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for npi_file
-- ----------------------------
DROP TABLE IF EXISTS `npi_file`;
CREATE TABLE `npi_file`  (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `primary_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `file_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `step` int(1) NULL DEFAULT NULL,
  `up_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_filepath
-- ----------------------------
DROP TABLE IF EXISTS `npi_filepath`;
CREATE TABLE `npi_filepath`  (
  `id` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `station` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `path` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_model
-- ----------------------------
DROP TABLE IF EXISTS `npi_model`;
CREATE TABLE `npi_model`  (
  `primary_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qc1_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qc2_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qc3_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `oba_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `runin_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_model_data
-- ----------------------------
DROP TABLE IF EXISTS `npi_model_data`;
CREATE TABLE `npi_model_data`  (
  `model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qc1_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qc2_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qc3_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `runin_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `oba_img` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`model`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_owner
-- ----------------------------
DROP TABLE IF EXISTS `npi_owner`;
CREATE TABLE `npi_owner`  (
  `username` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dept` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Owner` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Checker` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `steps` int(6) NOT NULL,
  `mail` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tpr` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  INDEX `steps`(`steps`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_primary
-- ----------------------------
DROP TABLE IF EXISTS `npi_primary`;
CREATE TABLE `npi_primary`  (
  `id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sort` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tpr` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `station` char(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_path` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bgtime` timestamp NULL DEFAULT NULL,
  `edtime` timestamp NULL DEFAULT NULL,
  `dytime` timestamp NULL DEFAULT NULL,
  `suo` int(1) NULL DEFAULT 0,
  `status` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_station
-- ----------------------------
DROP TABLE IF EXISTS `npi_station`;
CREATE TABLE `npi_station`  (
  `primary_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `station` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for npi_step
-- ----------------------------
DROP TABLE IF EXISTS `npi_step`;
CREATE TABLE `npi_step`  (
  `step` int(2) NULL DEFAULT NULL,
  `primary_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bgtime` timestamp NULL DEFAULT NULL,
  `owner` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `checker` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remark` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `file_id` int(1) NULL DEFAULT 0,
  `ck_date` timestamp NULL DEFAULT NULL,
  `ck_day` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `score` int(2) NULL DEFAULT NULL,
  `ck_remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `edtime` timestamp NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `No` int(255) NOT NULL AUTO_INCREMENT,
  `Model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Description` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Oldver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Old_sysver` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Newver` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `New_sysver` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Eco_no` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPRS` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Begingtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Endtime` timestamp NULL DEFAULT NULL,
  `Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `State` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  PRIMARY KEY (`No`) USING BTREE,
  INDEX `Description`(`Description`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 441 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for register
-- ----------------------------
DROP TABLE IF EXISTS `register`;
CREATE TABLE `register`  (
  `username` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rlc_sh_check_data
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_check_data`;
CREATE TABLE `rlc_sh_check_data`  (
  `PPID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'RLC_SH'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rlc_sh_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_fail_data`;
CREATE TABLE `rlc_sh_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rlc_sh_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_fail_data1`;
CREATE TABLE `rlc_sh_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rlc_sh_testlog
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_testlog`;
CREATE TABLE `rlc_sh_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 181692 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rlc_sh_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_vifi_check`;
CREATE TABLE `rlc_sh_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rlc_sh_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `rlc_sh_wednesday`;
CREATE TABLE `rlc_sh_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sneco
-- ----------------------------
DROP TABLE IF EXISTS `sneco`;
CREATE TABLE `sneco`  (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Model` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `eco` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 102 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for steps
-- ----------------------------
DROP TABLE IF EXISTS `steps`;
CREATE TABLE `steps`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Activity` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TPR` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Model` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `1_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `1_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `1_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `1_Begingtime` timestamp NULL DEFAULT NULL,
  `1_Endtime` timestamp NULL DEFAULT NULL,
  `1_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `1_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Begingtime` timestamp NULL DEFAULT NULL,
  `2_Endtime` timestamp NULL DEFAULT NULL,
  `2_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `2_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Begingtime` timestamp NULL DEFAULT NULL,
  `3_Endtime` timestamp NULL DEFAULT NULL,
  `3_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `3_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Begingtime` timestamp NULL DEFAULT NULL,
  `4_Endtime` timestamp NULL DEFAULT NULL,
  `4_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `4_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Begingtime` timestamp NULL DEFAULT NULL,
  `5_Endtime` timestamp NULL DEFAULT NULL,
  `5_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `5_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Econo` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Owner` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Checker` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Begingtime` timestamp NULL DEFAULT NULL,
  `6_Endtime` timestamp NULL DEFAULT NULL,
  `6_Remark` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `6_Status` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Lock` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE,
  INDEX `Activity`(`Activity`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 201 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for temp_device_fcg
-- ----------------------------
DROP TABLE IF EXISTS `temp_device_fcg`;
CREATE TABLE `temp_device_fcg`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `device` int(3) NOT NULL,
  `name` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `floor` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `x` int(11) NULL DEFAULT NULL,
  `y` int(11) NULL DEFAULT NULL,
  `maxtemp` float(4, 1) NULL DEFAULT NULL,
  `mintemp` float(4, 1) NULL DEFAULT NULL,
  `maxhumi` float(4, 1) NULL DEFAULT NULL,
  `minhumi` float(4, 1) NULL DEFAULT NULL,
  `enableused` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for temp_table_fcg
-- ----------------------------
DROP TABLE IF EXISTS `temp_table_fcg`;
CREATE TABLE `temp_table_fcg`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `device` int(5) NOT NULL DEFAULT 0,
  `temp` float(4, 1) NOT NULL DEFAULT 0.0,
  `humi` float(4, 1) NOT NULL DEFAULT 0.0,
  `cord_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 504917 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for temp_table_tmp_fcg
-- ----------------------------
DROP TABLE IF EXISTS `temp_table_tmp_fcg`;
CREATE TABLE `temp_table_tmp_fcg`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `device` int(3) NOT NULL DEFAULT 0,
  `temp` float(4, 1) NOT NULL DEFAULT 0.0,
  `humi` float(4, 1) NOT NULL DEFAULT 0.0,
  `cord_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tpr_name
-- ----------------------------
DROP TABLE IF EXISTS `tpr_name`;
CREATE TABLE `tpr_name`  (
  `No` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Checer` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`No`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tprchecktable
-- ----------------------------
DROP TABLE IF EXISTS `tprchecktable`;
CREATE TABLE `tprchecktable`  (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `tablename` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for tsi_check_data
-- ----------------------------
DROP TABLE IF EXISTS `tsi_check_data`;
CREATE TABLE `tsi_check_data`  (
  `PPID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Test_time` date NOT NULL,
  `Station` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Item` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Befor_time` date NULL DEFAULT NULL,
  `TPR_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_owner` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR_FA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Compal_check` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `TPR` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'TSI'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tsi_fail_data
-- ----------------------------
DROP TABLE IF EXISTS `tsi_fail_data`;
CREATE TABLE `tsi_fail_data`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tsi_fail_data1
-- ----------------------------
DROP TABLE IF EXISTS `tsi_fail_data1`;
CREATE TABLE `tsi_fail_data1`  (
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TPR` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Result` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Fail_Item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fail_Detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Correct` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Last_Update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tsi_testlog
-- ----------------------------
DROP TABLE IF EXISTS `tsi_testlog`;
CREATE TABLE `tsi_testlog`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `PN` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1823 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tsi_vifi_check
-- ----------------------------
DROP TABLE IF EXISTS `tsi_vifi_check`;
CREATE TABLE `tsi_vifi_check`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Station` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Detail_PPID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sheet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`, `Detail_PPID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tsi_wednesday
-- ----------------------------
DROP TABLE IF EXISTS `tsi_wednesday`;
CREATE TABLE `tsi_wednesday`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `username` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` int(11) NOT NULL,
  `usertpr` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dept` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for weekdate
-- ----------------------------
DROP TABLE IF EXISTS `weekdate`;
CREATE TABLE `weekdate`  (
  `Id` int(50) NOT NULL AUTO_INCREMENT,
  `Date` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `Year` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `FY` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `ChinaWeek` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `DellWeek` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `Week` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 31515 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zhoubao
-- ----------------------------
DROP TABLE IF EXISTS `zhoubao`;
CREATE TABLE `zhoubao`  (
  `TPR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Test_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Q2failnum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Q2lognum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Q3failnum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Q3lognum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `OBAlognum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `File_Week` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Totalnum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for bios
-- ----------------------------
DROP VIEW IF EXISTS `bios`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `bios` AS select tpr tpr ,count(*) biosno from bios_system where Status!=1 and Status!=5 and Status!=2 group by tpr ;

-- ----------------------------
-- View structure for eco
-- ----------------------------
DROP VIEW IF EXISTS `eco`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `eco` AS select tpr ,count(*) econo from eco_system where Status=0 group by tpr ;

-- ----------------------------
-- View structure for faca
-- ----------------------------
DROP VIEW IF EXISTS `faca`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `faca` AS select tpr tpr,count(*) facano from cgs_check_data where Compal_check is null or Compal_check='' group by tpr union all select tpr tpr,count(*) facano from rlc_sh_check_data where Compal_check is null or Compal_check='' group by tpr union all select tpr tpr,count(*) facano from cep_check_data where Compal_check is null or Compal_check='' group by tpr union all select tpr tpr,count(*) facano from tsi_check_data where Compal_check is null or Compal_check='' group by tpr union all select tpr tpr,count(*) facano from igs_check_data where Compal_check is null or Compal_check='' group by tpr union all select tpr tpr,count(*) facano from ceb_check_data where Compal_check is null or Compal_check='' group by tpr ;

-- ----------------------------
-- View structure for facaecobios
-- ----------------------------
DROP VIEW IF EXISTS `facaecobios`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `facaecobios` AS select tprfacaeco.tpr,tprfacaeco.facano,tprfacaeco.econo,bios.biosno from tprfacaeco left join bios on tprfacaeco.tpr = bios.tpr ;

-- ----------------------------
-- View structure for facano
-- ----------------------------
DROP VIEW IF EXISTS `facano`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `facano` AS select tprview.tpr,faca.facano facano from tprview left join faca on tprview.tpr=faca.tpr ;

-- ----------------------------
-- View structure for facaview
-- ----------------------------
DROP VIEW IF EXISTS `facaview`;
CREATE ALGORITHM = UNDEFINED DEFINER = `sodsod`@`58.210.66.77` SQL SECURITY DEFINER VIEW `facaview` AS (select distinct cep_check_data.Model as model,cep_check_data.PPID as ppid,cep_check_data.Station as station,cep_check_data.Fail_Item as fail,cep_check_data.Fail_Detail as fdetail,cep_check_data.Test_time as ttime ,cep_check_data.Correct as correct,cep_check_data.TPR_owner as towner,cep_check_data.Compal_owner as cowner ,cep_check_data.TPR_FA as fa,cep_check_data.Action as action,cep_check_data.Compal_check as Compal_check,cep_check_data.update_time as uptime from cep_check_data where cep_check_data.Compal_check is null order by ttime DESC ) UNION all (select distinct cgs_check_data.Model ,cgs_check_data.PPID,cgs_check_data.Station,cgs_check_data.Fail_Item,cgs_check_data.Fail_Detail as fdetail,cgs_check_data.Test_time,cgs_check_data.Correct,cgs_check_data.TPR_owner,cgs_check_data.Compal_owner,cgs_check_data.TPR_FA,cgs_check_data.Action,cgs_check_data.Compal_check as Compal_check,cgs_check_data.update_time from cgs_check_data where cgs_check_data.Compal_check is null) UNION all (select distinct ceb_check_data.Model ,ceb_check_data.PPID,ceb_check_data.Station,ceb_check_data.Fail_Item,ceb_check_data.Fail_Detail as fdetail,ceb_check_data.Test_time,ceb_check_data.Correct,ceb_check_data.TPR_owner,ceb_check_data.Compal_owner,ceb_check_data.TPR_FA,ceb_check_data.Action,ceb_check_data.Compal_check as Compal_check,ceb_check_data.update_time from ceb_check_data where ceb_check_data.Compal_check is null) UNION all (select distinct igs_check_data.Model ,igs_check_data.PPID,igs_check_data.Station,igs_check_data.Fail_Item,igs_check_data.Fail_Detail as fdetail,igs_check_data.Test_time,igs_check_data.Correct,igs_check_data.TPR_owner,igs_check_data.Compal_owner,igs_check_data.TPR_FA,igs_check_data.Action,igs_check_data.Compal_check as Compal_check,igs_check_data.update_time from igs_check_data where igs_check_data.Compal_check is null) UNION all (select distinct rlc_sh_check_data.Model ,rlc_sh_check_data.PPID,rlc_sh_check_data.Station,rlc_sh_check_data.Fail_Item,rlc_sh_check_data.Fail_Detail as fdetail,rlc_sh_check_data.Test_time,rlc_sh_check_data.Correct,rlc_sh_check_data.TPR_owner,rlc_sh_check_data.Compal_owner,rlc_sh_check_data.TPR_FA,rlc_sh_check_data.Action,rlc_sh_check_data.Compal_check as Compal_check,rlc_sh_check_data.update_time from rlc_sh_check_data where rlc_sh_check_data.Compal_check is null) UNION all (select distinct tsi_check_data.Model ,tsi_check_data.PPID,tsi_check_data.Station,tsi_check_data.Fail_Item,tsi_check_data.Fail_Detail as fdetail,tsi_check_data.Test_time,tsi_check_data.Correct,tsi_check_data.TPR_owner,tsi_check_data.Compal_owner,tsi_check_data.TPR_FA,tsi_check_data.Action,tsi_check_data.Compal_check as Compal_check,tsi_check_data.update_time from tsi_check_data where tsi_check_data.Compal_check is null order by tsi_check_data.Test_time DESC) ;

-- ----------------------------
-- View structure for tprfacaeco
-- ----------------------------
DROP VIEW IF EXISTS `tprfacaeco`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `tprfacaeco` AS select facano.tpr,facano.facano,eco.econo from facano left join   eco on facano.tpr = eco.tpr ;

-- ----------------------------
-- View structure for tprview
-- ----------------------------
DROP VIEW IF EXISTS `tprview`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `tprview` AS select tpr from tpr_name ;

SET FOREIGN_KEY_CHECKS = 1;
