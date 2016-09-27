/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : db_hris

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2016-04-13 15:16:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `audittrail`
-- ----------------------------
DROP TABLE IF EXISTS `audittrail`;
CREATE TABLE `audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of audittrail
-- ----------------------------
INSERT INTO `audittrail` VALUES ('1', '2016-04-02 05:40:36', '/hris/tbl_employee_deductionadd.php', 'cmalvarez', 'A', 'tbl_employee_deduction', 'deduction_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('2', '2016-04-02 05:40:36', '/hris/tbl_employee_deductionadd.php', 'cmalvarez', 'A', 'tbl_employee_deduction', 'deduction_amount', '1', '', '200');
INSERT INTO `audittrail` VALUES ('3', '2016-04-02 05:40:36', '/hris/tbl_employee_deductionadd.php', 'cmalvarez', 'A', 'tbl_employee_deduction', 'emp_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('4', '2016-04-02 05:40:36', '/hris/tbl_employee_deductionadd.php', 'cmalvarez', 'A', 'tbl_employee_deduction', 'deduction_ref_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('5', '2016-04-02 05:41:02', '/hris/tbl_employee_leavecreditadd.php', 'cmalvarez', 'A', 'tbl_employee_leavecredit', 'emp_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('6', '2016-04-02 05:41:02', '/hris/tbl_employee_leavecreditadd.php', 'cmalvarez', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('7', '2016-04-02 05:41:02', '/hris/tbl_employee_leavecreditadd.php', 'cmalvarez', 'A', 'tbl_employee_leavecredit', 'leave_credit', '1', '', '10');
INSERT INTO `audittrail` VALUES ('8', '2016-04-02 05:41:02', '/hris/tbl_employee_leavecreditadd.php', 'cmalvarez', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '1', '', '1');
INSERT INTO `audittrail` VALUES ('9', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'emp_id', '0000000001', '0', '1');
INSERT INTO `audittrail` VALUES ('10', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'username', '0000000001', 'cmalvarez', 'admin');
INSERT INTO `audittrail` VALUES ('11', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'firstname', '0000000001', 'Carla', 'admin');
INSERT INTO `audittrail` VALUES ('12', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'middlename', '0000000001', 'M', 'admin');
INSERT INTO `audittrail` VALUES ('13', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'surname', '0000000001', 'Alvarez', 'admin');
INSERT INTO `audittrail` VALUES ('14', '2016-04-02 05:41:38', '/hris/tbl_useredit.php', 'cmalvarez', 'U', 'tbl_user', 'position', '0000000001', 'ITO-1', null);
INSERT INTO `audittrail` VALUES ('15', '2016-04-02 05:47:41', '/hris/userlevelsadd.php', 'cmalvarez', 'A', 'userlevels', 'userlevelid', '2', '', '2');
INSERT INTO `audittrail` VALUES ('16', '2016-04-02 05:47:41', '/hris/userlevelsadd.php', 'cmalvarez', 'A', 'userlevels', 'userlevelname', '2', '', 'Employee');
INSERT INTO `audittrail` VALUES ('17', '2016-04-02 05:52:15', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('18', '2016-04-02 05:52:22', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('19', '2016-04-02 05:52:25', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('20', '2016-04-02 05:52:46', '/hris/tbl_useredit.php', 'admin', 'U', 'tbl_user', 'emp_id', '0000000004', '0', '2');
INSERT INTO `audittrail` VALUES ('21', '2016-04-02 05:52:46', '/hris/tbl_useredit.php', 'admin', 'U', 'tbl_user', 'user_level', '0000000004', null, '2');
INSERT INTO `audittrail` VALUES ('22', '2016-04-02 05:55:57', '/hris/tbl_useredit.php', 'admin', 'U', 'tbl_user', 'activate', '0000000004', '0', '1');
INSERT INTO `audittrail` VALUES ('23', '2016-04-02 05:58:22', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('24', '2016-04-02 05:58:27', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('25', '2016-04-02 05:58:31', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('26', '2016-04-02 06:05:09', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('27', '2016-04-02 06:24:22', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('28', '2016-04-02 06:24:28', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('29', '2016-04-02 06:41:55', '/hris/logout.php', 'cmalvarez', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('30', '2016-04-02 06:41:59', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('31', '2016-04-02 06:42:09', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('32', '2016-04-02 06:42:15', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('33', '2016-04-02 07:00:14', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('34', '2016-04-02 07:29:39', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('35', '2016-04-02 07:29:50', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('36', '2016-04-02 07:46:26', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('37', '2016-04-02 07:46:31', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('38', '2016-04-02 08:18:03', '/hris/tbl_employeeedit.php', 'admin', 'U', 'tbl_employee', 'date_hired', '1', '2016-04-01 00:00:00', '2016-04-06');
INSERT INTO `audittrail` VALUES ('39', '2016-04-02 08:29:24', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('40', '2016-04-02 08:29:24', '/hris/logout.php', '-1', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('41', '2016-04-02 08:29:24', '/hris/logout.php', '-1', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('42', '2016-04-02 08:31:52', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('43', '2016-04-02 08:51:20', '/hris_generated/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('44', '2016-04-02 08:51:25', '/hris_generated/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('45', '2016-04-02 08:52:39', '/hris_generated/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('46', '2016-04-02 08:52:43', '/hris_generated/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('47', '2016-04-02 09:08:20', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('48', '2016-04-02 09:08:26', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('49', '2016-04-02 10:32:17', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('50', '2016-04-02 10:32:22', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('51', '2016-04-02 11:55:29', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '2', '', '2');
INSERT INTO `audittrail` VALUES ('52', '2016-04-02 11:55:29', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '2', '', '3');
INSERT INTO `audittrail` VALUES ('53', '2016-04-02 11:55:29', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '2', '', '2');
INSERT INTO `audittrail` VALUES ('54', '2016-04-02 11:55:29', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '2', '', '2');
INSERT INTO `audittrail` VALUES ('55', '2016-04-02 16:17:22', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('56', '2016-04-03 02:47:20', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('57', '2016-04-03 02:53:43', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_id', '2', '', '1');
INSERT INTO `audittrail` VALUES ('58', '2016-04-03 02:53:43', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_amount', '2', '', '200');
INSERT INTO `audittrail` VALUES ('59', '2016-04-03 02:53:43', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'emp_id', '2', '', '2');
INSERT INTO `audittrail` VALUES ('60', '2016-04-03 02:53:43', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_ref_id', '2', '', '2');
INSERT INTO `audittrail` VALUES ('61', '2016-04-03 02:53:54', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_id', '3', '', '2');
INSERT INTO `audittrail` VALUES ('62', '2016-04-03 02:53:54', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_amount', '3', '', '200');
INSERT INTO `audittrail` VALUES ('63', '2016-04-03 02:53:54', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'emp_id', '3', '', '2');
INSERT INTO `audittrail` VALUES ('64', '2016-04-03 02:53:54', '/hris/tbl_employee_deductionadd.php', 'admin', 'A', 'tbl_employee_deduction', 'deduction_ref_id', '3', '', '3');
INSERT INTO `audittrail` VALUES ('65', '2016-04-03 06:41:39', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('66', '2016-04-03 15:46:40', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('67', '2016-04-03 15:48:37', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('68', '2016-04-03 15:49:33', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('69', '2016-04-03 15:49:37', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('70', '2016-04-03 15:51:02', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('71', '2016-04-03 15:51:07', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('72', '2016-04-03 16:05:57', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('73', '2016-04-03 16:06:05', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('74', '2016-04-03 16:06:27', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('75', '2016-04-03 16:06:47', '/hris/tbl_employeeedit.php', 'admin', 'U', 'tbl_employee', 'schedule_id', '2', '1', '2');
INSERT INTO `audittrail` VALUES ('76', '2016-04-03 16:06:47', '/hris/tbl_employeeedit.php', 'admin', 'U', 'tbl_employee', 'date_hired', '2', '2016-01-01 00:00:00', '2016-01-01');
INSERT INTO `audittrail` VALUES ('77', '2016-04-03 17:12:56', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('78', '2016-04-03 17:13:03', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('79', '2016-04-03 17:20:40', '/hris/logout.php', 'employee', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('80', '2016-04-03 17:20:54', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('81', '2016-04-03 17:21:59', '/hris/tbl_employeeedit.php', 'admin', 'U', 'tbl_employee', 'schedule_id', '2', '2', '1');
INSERT INTO `audittrail` VALUES ('82', '2016-04-03 17:21:59', '/hris/tbl_employeeedit.php', 'admin', 'U', 'tbl_employee', 'date_hired', '2', '2016-01-01 00:00:00', '2016-01-01');
INSERT INTO `audittrail` VALUES ('83', '2016-04-03 17:23:57', '/hris/tbl_useredit.php', 'admin', 'U', 'tbl_user', 'email', '0000000001', 'cmalvarez@dswd.gov.ph', 'acrjamero@sample.com');
INSERT INTO `audittrail` VALUES ('84', '2016-04-03 17:24:19', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('85', '2016-04-04 02:01:21', '/hris/login.php', 'employee', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('86', '2016-04-04 02:14:21', '/hris/logout.php', 'employee', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('87', '2016-04-04 02:14:26', '/hris/login.php', 'admin', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('88', '2016-04-04 02:46:30', '/hris/tbl_employee_leavecreditedit.php', 'admin', 'U', 'tbl_employee_leavecredit', 'leave_credit', '2', '-1', '2');
INSERT INTO `audittrail` VALUES ('89', '2016-04-04 03:28:05', '/hris/tbl_employee_leavecreditedit.php', 'admin', 'U', 'tbl_employee_leavecredit', 'leave_credit', '2', '0', '2');
INSERT INTO `audittrail` VALUES ('90', '2016-04-04 03:33:47', '/hris/logout.php', 'admin', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('91', '2016-04-04 03:33:51', '/hris/login.php', 'employee', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('92', '2016-04-04 06:20:04', '/hris/login.php', 'admin', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('93', '2016-04-04 06:27:30', '/hris/logout.php', 'admin', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('94', '2016-04-04 06:27:34', '/hris/login.php', 'admin', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('95', '2016-04-04 09:56:24', '/hris/logout.php', 'admin', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('96', '2016-04-04 09:56:43', '/hris/login.php', 'employee', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('97', '2016-04-07 07:42:07', '/hris/logout.php', 'employee', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('98', '2016-04-05 07:49:49', '/hris/login.php', 'employee', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('99', '2016-04-07 06:21:21', '/hris/logout.php', 'employee', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('100', '2016-04-07 06:21:26', '/hris/login.php', 'admin', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('101', '2016-04-07 06:23:00', '/hris/logout.php', 'admin', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('102', '2016-04-07 06:23:06', '/hris/login.php', 'employee', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('103', '2016-04-07 06:23:14', '/hris/logout.php', 'employee', 'logout', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('104', '2016-04-07 06:23:18', '/hris/login.php', 'admin', 'login', '::1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('105', '2016-04-10 14:06:38', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('106', '2016-04-10 14:08:20', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('107', '2016-04-10 14:08:26', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('108', '2016-04-10 17:10:04', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('109', '2016-04-10 17:11:29', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('110', '2016-04-11 10:55:32', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('111', '2016-04-11 12:15:22', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('112', '2016-04-11 12:15:30', '/hris/login.php', 'employee', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('113', '2016-04-11 12:17:40', '/hris/login.php', 'admin', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('114', '2016-04-11 14:01:15', '/hris/lib_leaveadd.php', 'admin', 'A', 'lib_leave', 'leave_type_title', '5', '', 'Bereavement Leave');
INSERT INTO `audittrail` VALUES ('115', '2016-04-11 14:01:15', '/hris/lib_leaveadd.php', 'admin', 'A', 'lib_leave', 'leave_type_id', '5', '', '5');
INSERT INTO `audittrail` VALUES ('116', '2016-04-11 14:03:06', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '4', '', '1');
INSERT INTO `audittrail` VALUES ('117', '2016-04-11 14:03:06', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '4', '', '3');
INSERT INTO `audittrail` VALUES ('118', '2016-04-11 14:03:06', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '4', '', '10');
INSERT INTO `audittrail` VALUES ('119', '2016-04-11 14:03:06', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '4', '', '4');
INSERT INTO `audittrail` VALUES ('120', '2016-04-11 14:03:15', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '5', '', '1');
INSERT INTO `audittrail` VALUES ('121', '2016-04-11 14:03:15', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '5', '', '5');
INSERT INTO `audittrail` VALUES ('122', '2016-04-11 14:03:15', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '5', '', '3');
INSERT INTO `audittrail` VALUES ('123', '2016-04-11 14:03:15', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '5', '', '5');
INSERT INTO `audittrail` VALUES ('124', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'empFirstName', '8', '', 'MELCHORA');
INSERT INTO `audittrail` VALUES ('125', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'empMiddleName', '8', '', 'A');
INSERT INTO `audittrail` VALUES ('126', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'empLastName', '8', '', 'DIMASALANG');
INSERT INTO `audittrail` VALUES ('127', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'empExtensionName', '8', '', null);
INSERT INTO `audittrail` VALUES ('128', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'sex_id', '8', '', '2');
INSERT INTO `audittrail` VALUES ('129', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'schedule_id', '8', '', '1');
INSERT INTO `audittrail` VALUES ('130', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'salary_id', '8', '', '11');
INSERT INTO `audittrail` VALUES ('131', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'tax_category_id', '8', '', '2');
INSERT INTO `audittrail` VALUES ('132', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'date_hired', '8', '', '2016-04-11');
INSERT INTO `audittrail` VALUES ('133', '2016-04-11 14:04:56', '/hris/tbl_employeeadd.php', 'admin', 'A', 'tbl_employee', 'emp_id', '8', '', '8');
INSERT INTO `audittrail` VALUES ('134', '2016-04-11 14:05:09', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '6', '', '8');
INSERT INTO `audittrail` VALUES ('135', '2016-04-11 14:05:09', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '6', '', '3');
INSERT INTO `audittrail` VALUES ('136', '2016-04-11 14:05:09', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '6', '', '10');
INSERT INTO `audittrail` VALUES ('137', '2016-04-11 14:05:09', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '6', '', '6');
INSERT INTO `audittrail` VALUES ('138', '2016-04-11 14:05:21', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '7', '', '8');
INSERT INTO `audittrail` VALUES ('139', '2016-04-11 14:05:21', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '7', '', '5');
INSERT INTO `audittrail` VALUES ('140', '2016-04-11 14:05:21', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '7', '', '3');
INSERT INTO `audittrail` VALUES ('141', '2016-04-11 14:05:21', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '7', '', '7');
INSERT INTO `audittrail` VALUES ('142', '2016-04-11 14:05:32', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_id', '8', '', '8');
INSERT INTO `audittrail` VALUES ('143', '2016-04-11 14:05:32', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_type_id', '8', '', '4');
INSERT INTO `audittrail` VALUES ('144', '2016-04-11 14:05:32', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'leave_credit', '8', '', '10');
INSERT INTO `audittrail` VALUES ('145', '2016-04-11 14:05:32', '/hris/tbl_employee_leavecreditadd.php', 'admin', 'A', 'tbl_employee_leavecredit', 'emp_leave_credit_id', '8', '', '8');
INSERT INTO `audittrail` VALUES ('146', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'emp_id', '5', '', '8');
INSERT INTO `audittrail` VALUES ('147', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'username', '5', '', 'melchora');
INSERT INTO `audittrail` VALUES ('148', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'password', '5', '', 'melchora');
INSERT INTO `audittrail` VALUES ('149', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'email', '5', '', 'melchora@sample.com');
INSERT INTO `audittrail` VALUES ('150', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'firstname', '5', '', 'melchora');
INSERT INTO `audittrail` VALUES ('151', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'middlename', '5', '', 'melchora');
INSERT INTO `audittrail` VALUES ('152', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'surname', '5', '', 'melchora');
INSERT INTO `audittrail` VALUES ('153', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'extensionname', '5', '', null);
INSERT INTO `audittrail` VALUES ('154', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'position', '5', '', null);
INSERT INTO `audittrail` VALUES ('155', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'designation', '5', '', null);
INSERT INTO `audittrail` VALUES ('156', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'office_code', '5', '', null);
INSERT INTO `audittrail` VALUES ('157', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'user_level', '5', '', '2');
INSERT INTO `audittrail` VALUES ('158', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'contact_no', '5', '', null);
INSERT INTO `audittrail` VALUES ('159', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'activate', '5', '', '1');
INSERT INTO `audittrail` VALUES ('160', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'profile', '5', '', 'a');
INSERT INTO `audittrail` VALUES ('161', '2016-04-11 14:08:30', '/hris/tbl_useradd.php', 'admin', 'A', 'tbl_user', 'uid', '5', '', '5');
INSERT INTO `audittrail` VALUES ('162', '2016-04-11 14:09:03', '/hris/logout.php', '-1', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('163', '2016-04-11 14:09:07', '/hris/login.php', 'melchora', 'login', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('164', '2016-04-11 14:26:49', '/hris/logout.php', 'melchora', 'logout', '127.0.0.1', '', '', '', '');
INSERT INTO `audittrail` VALUES ('165', '2016-04-11 15:14:59', '/hris/logout.php', 'admin', 'logout', '127.0.0.1', '', '', '', '');

-- ----------------------------
-- Table structure for `lib_cutoff`
-- ----------------------------
DROP TABLE IF EXISTS `lib_cutoff`;
CREATE TABLE `lib_cutoff` (
  `cut_off_id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_off_title` varchar(200) NOT NULL,
  `cut_off_start` int(11) NOT NULL,
  `cut_off_end` int(11) NOT NULL,
  PRIMARY KEY (`cut_off_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_cutoff
-- ----------------------------
INSERT INTO `lib_cutoff` VALUES ('1', '1 to 15', '1', '15');
INSERT INTO `lib_cutoff` VALUES ('2', '16 to 30', '16', '31');
INSERT INTO `lib_cutoff` VALUES ('3', '1 to 30', '1', '31');

-- ----------------------------
-- Table structure for `lib_day`
-- ----------------------------
DROP TABLE IF EXISTS `lib_day`;
CREATE TABLE `lib_day` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_title` varchar(11) NOT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_day
-- ----------------------------
INSERT INTO `lib_day` VALUES ('1', '1');
INSERT INTO `lib_day` VALUES ('2', '2');
INSERT INTO `lib_day` VALUES ('3', '3');
INSERT INTO `lib_day` VALUES ('4', '4');
INSERT INTO `lib_day` VALUES ('5', '5');
INSERT INTO `lib_day` VALUES ('6', '6');
INSERT INTO `lib_day` VALUES ('7', '7');
INSERT INTO `lib_day` VALUES ('8', '8');
INSERT INTO `lib_day` VALUES ('9', '9');
INSERT INTO `lib_day` VALUES ('10', '10');
INSERT INTO `lib_day` VALUES ('11', '11');
INSERT INTO `lib_day` VALUES ('12', '12');
INSERT INTO `lib_day` VALUES ('13', '13');
INSERT INTO `lib_day` VALUES ('14', '14');
INSERT INTO `lib_day` VALUES ('15', '15');
INSERT INTO `lib_day` VALUES ('16', '16');
INSERT INTO `lib_day` VALUES ('17', '17');
INSERT INTO `lib_day` VALUES ('18', '18');
INSERT INTO `lib_day` VALUES ('19', '19');
INSERT INTO `lib_day` VALUES ('20', '20');
INSERT INTO `lib_day` VALUES ('21', '21');
INSERT INTO `lib_day` VALUES ('22', '22');
INSERT INTO `lib_day` VALUES ('23', '23');
INSERT INTO `lib_day` VALUES ('24', '24');
INSERT INTO `lib_day` VALUES ('25', '25');
INSERT INTO `lib_day` VALUES ('26', '26');
INSERT INTO `lib_day` VALUES ('27', '27');
INSERT INTO `lib_day` VALUES ('28', '28');
INSERT INTO `lib_day` VALUES ('29', '29');
INSERT INTO `lib_day` VALUES ('30', '30');
INSERT INTO `lib_day` VALUES ('31', '31');

-- ----------------------------
-- Table structure for `lib_deduction`
-- ----------------------------
DROP TABLE IF EXISTS `lib_deduction`;
CREATE TABLE `lib_deduction` (
  `deduction_id` int(11) NOT NULL AUTO_INCREMENT,
  `deduction_title` varchar(100) NOT NULL,
  PRIMARY KEY (`deduction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_deduction
-- ----------------------------
INSERT INTO `lib_deduction` VALUES ('1', 'SSS Contribution');
INSERT INTO `lib_deduction` VALUES ('2', 'PAG-IBIG Contribution');
INSERT INTO `lib_deduction` VALUES ('3', 'PHIL HEALTH Contribution');
INSERT INTO `lib_deduction` VALUES ('4', 'Withholding Tax');

-- ----------------------------
-- Table structure for `lib_holiday`
-- ----------------------------
DROP TABLE IF EXISTS `lib_holiday`;
CREATE TABLE `lib_holiday` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_title` varchar(255) NOT NULL,
  `holiday_month` varchar(11) NOT NULL,
  `holiday_day` varchar(11) NOT NULL,
  `holiday_year` varchar(11) NOT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_holiday
-- ----------------------------
INSERT INTO `lib_holiday` VALUES ('1', 'Araw ng Kagitingan', '04', '9', '2016');

-- ----------------------------
-- Table structure for `lib_leave`
-- ----------------------------
DROP TABLE IF EXISTS `lib_leave`;
CREATE TABLE `lib_leave` (
  `leave_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_type_title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`leave_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_leave
-- ----------------------------
INSERT INTO `lib_leave` VALUES ('1', 'Paternity Leave');
INSERT INTO `lib_leave` VALUES ('2', 'Maternity Leave');
INSERT INTO `lib_leave` VALUES ('3', 'Sick Leave');
INSERT INTO `lib_leave` VALUES ('4', 'Vacation Leave');
INSERT INTO `lib_leave` VALUES ('5', 'Bereavement Leave');

-- ----------------------------
-- Table structure for `lib_month`
-- ----------------------------
DROP TABLE IF EXISTS `lib_month`;
CREATE TABLE `lib_month` (
  `month_id` int(11) NOT NULL AUTO_INCREMENT,
  `month_val` varchar(11) NOT NULL,
  `month_title` varchar(11) NOT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_month
-- ----------------------------
INSERT INTO `lib_month` VALUES ('1', '01', 'JANUARY');
INSERT INTO `lib_month` VALUES ('2', '02', 'FEBRUARY');
INSERT INTO `lib_month` VALUES ('3', '03', 'MARCH');
INSERT INTO `lib_month` VALUES ('4', '04', 'APRIL');
INSERT INTO `lib_month` VALUES ('5', '05', 'MAY');
INSERT INTO `lib_month` VALUES ('6', '06', 'JUNE');
INSERT INTO `lib_month` VALUES ('7', '07', 'JULY');
INSERT INTO `lib_month` VALUES ('8', '08', 'AUGUST');
INSERT INTO `lib_month` VALUES ('9', '09', 'SEPTEMBER');
INSERT INTO `lib_month` VALUES ('10', '10', 'OCTOBER');
INSERT INTO `lib_month` VALUES ('11', '11', 'NOVEMBER');
INSERT INTO `lib_month` VALUES ('12', '12', 'DECEMBER');

-- ----------------------------
-- Table structure for `lib_philhealth`
-- ----------------------------
DROP TABLE IF EXISTS `lib_philhealth`;
CREATE TABLE `lib_philhealth` (
  `ph_id` int(11) NOT NULL AUTO_INCREMENT,
  `ph_range_from` varchar(10) NOT NULL,
  `ph_range_to` varchar(30) NOT NULL,
  `ph_employer_share` varchar(10) NOT NULL,
  `ph_employee_share` varchar(10) NOT NULL,
  `ph_total_contribution` varchar(10) NOT NULL,
  PRIMARY KEY (`ph_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_philhealth
-- ----------------------------
INSERT INTO `lib_philhealth` VALUES ('130', '0', '8999.99', '100.00', '100.00', '200.00');
INSERT INTO `lib_philhealth` VALUES ('131', '9000', '9999.99', '112.50', '112.50', '225.00');
INSERT INTO `lib_philhealth` VALUES ('132', '10000', '10999.99', '125.00', '125.00', '250.00');
INSERT INTO `lib_philhealth` VALUES ('133', '11000', '11999.99', '137.50', '137.50', '275.00');
INSERT INTO `lib_philhealth` VALUES ('134', '12000', '12999.99', '150.00', '150.00', '300.00');
INSERT INTO `lib_philhealth` VALUES ('135', '13000', '13999.99', '162.50', '162.50', '325.00');
INSERT INTO `lib_philhealth` VALUES ('136', '14000', '14999.99', '175.00', '175.00', '350.00');
INSERT INTO `lib_philhealth` VALUES ('137', '15000', '15999.99', '187.50', '187.50', '375.00');
INSERT INTO `lib_philhealth` VALUES ('138', '16000', '16999.99', '200.00', '200.00', '400.00');
INSERT INTO `lib_philhealth` VALUES ('139', '17000', '17999.99', '212.50', '212.50', '425.00');
INSERT INTO `lib_philhealth` VALUES ('140', '18000', '18999.99', '225.00', '225.00', '450.00');
INSERT INTO `lib_philhealth` VALUES ('141', '19000', '19999.99', '237.50', '237.50', '475.00');
INSERT INTO `lib_philhealth` VALUES ('142', '20000', '20999.99', '250.00', '250.00', '500.00');
INSERT INTO `lib_philhealth` VALUES ('143', '21000', '21999.99', '262.50', '262.50', '525.00');
INSERT INTO `lib_philhealth` VALUES ('144', '22000', '22999.99', '275.00', '275.00', '550.00');
INSERT INTO `lib_philhealth` VALUES ('145', '23000', '23999.99', '287.50', '287.50', '575.00');
INSERT INTO `lib_philhealth` VALUES ('146', '24000', '24999.99', '300.00', '300.00', '600.00');
INSERT INTO `lib_philhealth` VALUES ('147', '25000', '25999.99', '312.50', '312.50', '625.00');
INSERT INTO `lib_philhealth` VALUES ('148', '26000', '26999.99', '325.00', '325.00', '650.00');
INSERT INTO `lib_philhealth` VALUES ('149', '27000', '27999.99', '337.50', '337.50', '675.00');
INSERT INTO `lib_philhealth` VALUES ('150', '28000', '28999.99', '350.00', '350.00', '700.00');
INSERT INTO `lib_philhealth` VALUES ('151', '29000', '29999.99', '362.50', '362.50', '725.00');
INSERT INTO `lib_philhealth` VALUES ('152', '30000', '30999.99', '375.00', '375.00', '750.00');
INSERT INTO `lib_philhealth` VALUES ('153', '31000', '31999.99', '387.50', '387.50', '775.00');
INSERT INTO `lib_philhealth` VALUES ('154', '32000', '32999.99', '400.00', '400.00', '800.00');
INSERT INTO `lib_philhealth` VALUES ('155', '33000', '33999.99', '412.50', '412.50', '825.00');
INSERT INTO `lib_philhealth` VALUES ('156', '34000', '34999.99', '425.00', '425.00', '850.00');
INSERT INTO `lib_philhealth` VALUES ('157', '35000', '999999999999999999999999999.99', '437.50', '437.50', '875.00');

-- ----------------------------
-- Table structure for `lib_salary`
-- ----------------------------
DROP TABLE IF EXISTS `lib_salary`;
CREATE TABLE `lib_salary` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_amount` double(11,2) NOT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_salary
-- ----------------------------
INSERT INTO `lib_salary` VALUES ('1', '10000.00');
INSERT INTO `lib_salary` VALUES ('2', '11000.00');
INSERT INTO `lib_salary` VALUES ('3', '12000.00');
INSERT INTO `lib_salary` VALUES ('4', '13000.00');
INSERT INTO `lib_salary` VALUES ('5', '14000.00');
INSERT INTO `lib_salary` VALUES ('6', '15000.00');
INSERT INTO `lib_salary` VALUES ('7', '16000.00');
INSERT INTO `lib_salary` VALUES ('8', '17000.00');
INSERT INTO `lib_salary` VALUES ('9', '18000.00');
INSERT INTO `lib_salary` VALUES ('10', '19000.00');
INSERT INTO `lib_salary` VALUES ('11', '20000.00');
INSERT INTO `lib_salary` VALUES ('12', '75010.45');

-- ----------------------------
-- Table structure for `lib_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `lib_schedule`;
CREATE TABLE `lib_schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_title` varchar(50) NOT NULL,
  `schedule_time_in` time NOT NULL,
  `schedule_time_out` time NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_schedule
-- ----------------------------
INSERT INTO `lib_schedule` VALUES ('1', 'Fixed (8AM to 5PM)', '08:00:00', '17:00:00');
INSERT INTO `lib_schedule` VALUES ('2', 'Fixed (9AM to 6PM)', '09:00:00', '18:00:00');

-- ----------------------------
-- Table structure for `lib_sex`
-- ----------------------------
DROP TABLE IF EXISTS `lib_sex`;
CREATE TABLE `lib_sex` (
  `sex_id` int(11) NOT NULL AUTO_INCREMENT,
  `sex_title` varchar(50) NOT NULL,
  PRIMARY KEY (`sex_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_sex
-- ----------------------------
INSERT INTO `lib_sex` VALUES ('1', 'Male');
INSERT INTO `lib_sex` VALUES ('2', 'Female');

-- ----------------------------
-- Table structure for `lib_sss`
-- ----------------------------
DROP TABLE IF EXISTS `lib_sss`;
CREATE TABLE `lib_sss` (
  `sss_id` int(11) NOT NULL AUTO_INCREMENT,
  `sss_range_from` varchar(10) NOT NULL,
  `sss_range_to` varchar(30) NOT NULL,
  `sss_employer_share` varchar(10) NOT NULL,
  `sss_employee_share` varchar(10) NOT NULL,
  `sss_total_contribution` varchar(10) NOT NULL,
  PRIMARY KEY (`sss_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_sss
-- ----------------------------
INSERT INTO `lib_sss` VALUES ('132', '1000.00', '1249.99', '83.70', '36.30', '120.00');
INSERT INTO `lib_sss` VALUES ('133', '1250.00', '1749.99', '120.50', '54.50', '175.00');
INSERT INTO `lib_sss` VALUES ('134', '1750.00', '2249.99', '157.30', '72.70', '230.00');
INSERT INTO `lib_sss` VALUES ('135', '2250.00', '2749.99', '194.20', '90.80', '285.00');
INSERT INTO `lib_sss` VALUES ('136', '2750.00', '3249.99', '231.00', '109.00', '340.00');
INSERT INTO `lib_sss` VALUES ('137', '3250.00', '3749.99', '267.80', '127.20', '395.00');
INSERT INTO `lib_sss` VALUES ('138', '3750.00', '4249.99', '304.70', '145.30', '450.00');
INSERT INTO `lib_sss` VALUES ('139', '4250.00', '4749.99', '341.50', '163.50', '505.00');
INSERT INTO `lib_sss` VALUES ('140', '4750.00', '5249.99', '378.30', '181.70', '560.00');
INSERT INTO `lib_sss` VALUES ('141', '5250.00', '5749.99', '415.20', '199.80', '615.00');
INSERT INTO `lib_sss` VALUES ('142', '5750.00', '6249.99', '452.00', '218.00', '670.00');
INSERT INTO `lib_sss` VALUES ('143', '6250.00', '6749.99', '488.80', '236.20', '725.00');
INSERT INTO `lib_sss` VALUES ('144', '6750.00', '7249.99', '525.70', '254.30', '780.00');
INSERT INTO `lib_sss` VALUES ('145', '7250.00', '7749.99', '562.50', '272.50', '835.00');
INSERT INTO `lib_sss` VALUES ('146', '7750.00', '8249.99', '599.30', '290.70', '890.00');
INSERT INTO `lib_sss` VALUES ('147', '8250.00', '8749.99', '636.20', '308.80', '945.00');
INSERT INTO `lib_sss` VALUES ('148', '8750.00', '9249.99', '673.00', '327.00', '1000.00');
INSERT INTO `lib_sss` VALUES ('149', '9250.00', '9749.99', '709.80', '345.20', '1055.00');
INSERT INTO `lib_sss` VALUES ('150', '9750.00', '10249.99', '746.70', '363.30', '1110.00');
INSERT INTO `lib_sss` VALUES ('151', '10250.00', '10749.99', '783.50', '381.50', '1165.00');
INSERT INTO `lib_sss` VALUES ('152', '10750.00', '11249.99', '820.30', '399.70', '1220.00');
INSERT INTO `lib_sss` VALUES ('153', '11250.00', '11749.99', '857.20', '417.80', '1275.00');
INSERT INTO `lib_sss` VALUES ('154', '11750.00', '12249.99', '894.00', '436.00', '1330.00');
INSERT INTO `lib_sss` VALUES ('155', '12250.00', '12749.99', '930.80', '454.20', '1385.00');
INSERT INTO `lib_sss` VALUES ('156', '12750.00', '13249.99', '967.70', '472.30', '1440.00');
INSERT INTO `lib_sss` VALUES ('157', '13250.00', '13749.99', '1004.50', '490.50', '1495.00');
INSERT INTO `lib_sss` VALUES ('158', '13750.00', '14249.99', '1041.30', '508.70', '1550.00');
INSERT INTO `lib_sss` VALUES ('159', '14250.00', '14749.99', '1078.20', '526.80', '1605.00');
INSERT INTO `lib_sss` VALUES ('160', '14750.00', '15249.99', '1135.00', '545.00', '1680.00');
INSERT INTO `lib_sss` VALUES ('161', '15250.00', '15749.99', '1171.80', '563.20', '1735.00');
INSERT INTO `lib_sss` VALUES ('162', '15750.00', '999999999999999999999999999.99', '1208.70', '581.30', '1790.00');

-- ----------------------------
-- Table structure for `lib_status`
-- ----------------------------
DROP TABLE IF EXISTS `lib_status`;
CREATE TABLE `lib_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_title` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_status
-- ----------------------------
INSERT INTO `lib_status` VALUES ('1', 'Pending');
INSERT INTO `lib_status` VALUES ('2', 'Approved');
INSERT INTO `lib_status` VALUES ('3', 'Disapproved');

-- ----------------------------
-- Table structure for `lib_tax_category`
-- ----------------------------
DROP TABLE IF EXISTS `lib_tax_category`;
CREATE TABLE `lib_tax_category` (
  `tax_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_category_code` varchar(50) NOT NULL,
  `tax_category_title` varchar(100) NOT NULL,
  PRIMARY KEY (`tax_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_tax_category
-- ----------------------------
INSERT INTO `lib_tax_category` VALUES ('1', 'S/W/ME', 'Single/Widowed/Married');
INSERT INTO `lib_tax_category` VALUES ('2', 'ME1/S1', 'Married/Single with 1 dependent');
INSERT INTO `lib_tax_category` VALUES ('3', 'ME2/S2', 'Married/Single with 2 dependents');
INSERT INTO `lib_tax_category` VALUES ('4', 'ME3/S3', 'Married/Single with 3 dependents');
INSERT INTO `lib_tax_category` VALUES ('5', 'ME4/S4', 'Married/Single with 4 or more dependents');

-- ----------------------------
-- Table structure for `lib_tax_table`
-- ----------------------------
DROP TABLE IF EXISTS `lib_tax_table`;
CREATE TABLE `lib_tax_table` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_category_id` int(11) NOT NULL,
  `over_percentage` varchar(11) NOT NULL,
  `exact_tax` varchar(11) NOT NULL,
  `tax_ceiling` varchar(11) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_tax_table
-- ----------------------------
INSERT INTO `lib_tax_table` VALUES ('1', '1', '0.05', '0.00', '4167.00');
INSERT INTO `lib_tax_table` VALUES ('2', '1', '0.10', '41.67', '5000.00');
INSERT INTO `lib_tax_table` VALUES ('3', '1', '0.15', '208.33', '6667');
INSERT INTO `lib_tax_table` VALUES ('4', '1', '0.20', '708.00', '10000.00');
INSERT INTO `lib_tax_table` VALUES ('5', '1', '0.25', '1875.00', '15833.00');
INSERT INTO `lib_tax_table` VALUES ('6', '1', '0.30', '4166.67', '25000.00');
INSERT INTO `lib_tax_table` VALUES ('7', '1', '0.32', '10416.67', '45833.00');
INSERT INTO `lib_tax_table` VALUES ('8', '2', '0.05', '0.00', '6250.00');
INSERT INTO `lib_tax_table` VALUES ('9', '2', '0.10', '41.67', '7083.00');
INSERT INTO `lib_tax_table` VALUES ('10', '2', '0.15', '208.33', '8750.00');
INSERT INTO `lib_tax_table` VALUES ('11', '2', '0.20', '708.00', '12083.00');
INSERT INTO `lib_tax_table` VALUES ('12', '2', '0.25', '1875.00', '17917.00');
INSERT INTO `lib_tax_table` VALUES ('13', '2', '0.30', '4166.67', '27083.00');
INSERT INTO `lib_tax_table` VALUES ('14', '2', '0.32', '10416.67', '47917.00');
INSERT INTO `lib_tax_table` VALUES ('15', '3', '0.05', '0.00', '8333.33');
INSERT INTO `lib_tax_table` VALUES ('16', '3', '0.10', '41.67', '9167.00');
INSERT INTO `lib_tax_table` VALUES ('17', '3', '0.15', '208.33', '10833.00');
INSERT INTO `lib_tax_table` VALUES ('18', '3', '0.20', '708.00', '14167.00');
INSERT INTO `lib_tax_table` VALUES ('19', '3', '0.25', '1875.00', '20000.00');
INSERT INTO `lib_tax_table` VALUES ('20', '3', '0.30', '4166.67', '29167.00');
INSERT INTO `lib_tax_table` VALUES ('21', '3', '0.32', '10416.67', '50000.00');
INSERT INTO `lib_tax_table` VALUES ('22', '4', '0.05', '0.00', '10417.00');
INSERT INTO `lib_tax_table` VALUES ('23', '4', '0.10', '41.67', '11250.00');
INSERT INTO `lib_tax_table` VALUES ('24', '4', '0.15', '208.33', '12917.00');
INSERT INTO `lib_tax_table` VALUES ('25', '4', '0.20', '708.00', '16250.00');
INSERT INTO `lib_tax_table` VALUES ('26', '4', '0.25', '1875.00', '22083.00');
INSERT INTO `lib_tax_table` VALUES ('27', '4', '0.30', '4166.67', '31250.00');
INSERT INTO `lib_tax_table` VALUES ('28', '4', '0.32', '10416.67', '52083.00');
INSERT INTO `lib_tax_table` VALUES ('29', '5', '0.05', '0.00', '12500.00');
INSERT INTO `lib_tax_table` VALUES ('30', '5', '0.10', '41.67', '13333.00');
INSERT INTO `lib_tax_table` VALUES ('31', '5', '0.15', '208.33', '15000.00');
INSERT INTO `lib_tax_table` VALUES ('32', '5', '0.20', '708.00', '18333.00');
INSERT INTO `lib_tax_table` VALUES ('33', '5', '0.25', '1875.00', '24167.00');
INSERT INTO `lib_tax_table` VALUES ('34', '5', '0.30', '4166.67', '33333.00');
INSERT INTO `lib_tax_table` VALUES ('35', '5', '0.32', '10416.67', '54167.00');

-- ----------------------------
-- Table structure for `lib_tax_table_old`
-- ----------------------------
DROP TABLE IF EXISTS `lib_tax_table_old`;
CREATE TABLE `lib_tax_table_old` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_category_id` int(11) NOT NULL,
  `over_percentage` double(11,2) NOT NULL,
  `exact_tax` double(11,2) NOT NULL,
  `tax_ceiling` double(11,2) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_tax_table_old
-- ----------------------------
INSERT INTO `lib_tax_table_old` VALUES ('1', '1', '0.05', '0.00', '4167.00');
INSERT INTO `lib_tax_table_old` VALUES ('2', '1', '0.10', '41.67', '5000.00');
INSERT INTO `lib_tax_table_old` VALUES ('3', '1', '0.15', '208.33', '6667.00');
INSERT INTO `lib_tax_table_old` VALUES ('4', '1', '0.20', '708.00', '10000.00');
INSERT INTO `lib_tax_table_old` VALUES ('5', '1', '0.25', '1875.00', '15833.00');
INSERT INTO `lib_tax_table_old` VALUES ('6', '1', '0.30', '4166.67', '25000.00');
INSERT INTO `lib_tax_table_old` VALUES ('7', '1', '0.32', '10416.67', '45833.00');
INSERT INTO `lib_tax_table_old` VALUES ('8', '2', '0.05', '0.00', '6250.00');
INSERT INTO `lib_tax_table_old` VALUES ('9', '2', '0.10', '41.67', '7083.00');
INSERT INTO `lib_tax_table_old` VALUES ('10', '2', '0.15', '208.33', '8750.00');
INSERT INTO `lib_tax_table_old` VALUES ('11', '2', '0.20', '708.00', '12083.00');
INSERT INTO `lib_tax_table_old` VALUES ('12', '2', '0.25', '1875.00', '17917.00');
INSERT INTO `lib_tax_table_old` VALUES ('13', '2', '0.30', '4166.67', '27083.00');
INSERT INTO `lib_tax_table_old` VALUES ('14', '2', '0.32', '10416.67', '47917.00');
INSERT INTO `lib_tax_table_old` VALUES ('15', '3', '0.05', '0.00', '8333.33');
INSERT INTO `lib_tax_table_old` VALUES ('16', '3', '0.10', '41.67', '9167.00');
INSERT INTO `lib_tax_table_old` VALUES ('17', '3', '0.15', '208.33', '10833.00');
INSERT INTO `lib_tax_table_old` VALUES ('18', '3', '0.20', '708.00', '14167.00');
INSERT INTO `lib_tax_table_old` VALUES ('19', '3', '0.25', '1875.00', '20000.00');
INSERT INTO `lib_tax_table_old` VALUES ('20', '3', '0.30', '4166.67', '29167.00');
INSERT INTO `lib_tax_table_old` VALUES ('21', '3', '0.32', '10416.67', '50000.00');
INSERT INTO `lib_tax_table_old` VALUES ('22', '4', '0.05', '0.00', '10417.00');
INSERT INTO `lib_tax_table_old` VALUES ('23', '4', '0.10', '41.67', '11250.00');
INSERT INTO `lib_tax_table_old` VALUES ('24', '4', '0.15', '208.33', '12917.00');
INSERT INTO `lib_tax_table_old` VALUES ('25', '4', '0.20', '708.00', '16250.00');
INSERT INTO `lib_tax_table_old` VALUES ('26', '4', '0.25', '1875.00', '22083.00');
INSERT INTO `lib_tax_table_old` VALUES ('27', '4', '0.30', '4166.67', '31250.00');
INSERT INTO `lib_tax_table_old` VALUES ('28', '4', '0.32', '10416.67', '52083.00');
INSERT INTO `lib_tax_table_old` VALUES ('29', '5', '0.05', '0.00', '12500.00');
INSERT INTO `lib_tax_table_old` VALUES ('30', '5', '0.10', '41.67', '13333.00');
INSERT INTO `lib_tax_table_old` VALUES ('31', '5', '0.15', '208.33', '15000.00');
INSERT INTO `lib_tax_table_old` VALUES ('32', '5', '0.20', '708.00', '18333.00');
INSERT INTO `lib_tax_table_old` VALUES ('33', '5', '0.25', '1875.00', '24167.00');
INSERT INTO `lib_tax_table_old` VALUES ('34', '5', '0.30', '4166.67', '33333.00');
INSERT INTO `lib_tax_table_old` VALUES ('35', '5', '0.32', '10416.67', '54167.00');

-- ----------------------------
-- Table structure for `lib_year`
-- ----------------------------
DROP TABLE IF EXISTS `lib_year`;
CREATE TABLE `lib_year` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_val` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lib_year
-- ----------------------------
INSERT INTO `lib_year` VALUES ('1', '2016');
INSERT INTO `lib_year` VALUES ('2', '2017');
INSERT INTO `lib_year` VALUES ('3', '2018');
INSERT INTO `lib_year` VALUES ('4', '2019');
INSERT INTO `lib_year` VALUES ('5', '2020');
INSERT INTO `lib_year` VALUES ('6', '2021');

-- ----------------------------
-- Table structure for `tbl_createdtr`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_createdtr`;
CREATE TABLE `tbl_createdtr` (
  `dtr_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `month` varchar(2) NOT NULL,
  `day` varchar(2) NOT NULL,
  `year` int(4) NOT NULL,
  `is_holiday` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dtr_id`),
  UNIQUE KEY `DTRforThisMonthDup` (`emp_id`,`month`,`day`,`year`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1288 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_createdtr
-- ----------------------------
INSERT INTO `tbl_createdtr` VALUES ('896', '1', '01', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('897', '1', '01', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('898', '1', '01', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('899', '1', '01', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('900', '1', '01', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('901', '1', '01', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('902', '1', '01', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('903', '1', '01', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('904', '1', '01', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('905', '1', '01', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('906', '1', '01', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('907', '1', '01', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('908', '1', '01', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('909', '1', '01', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('910', '1', '01', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('911', '1', '01', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('912', '1', '01', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('913', '1', '01', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('914', '1', '01', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('915', '1', '01', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('916', '1', '01', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('917', '1', '01', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('918', '1', '01', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('919', '1', '01', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('920', '1', '01', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('921', '1', '01', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('922', '1', '01', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('923', '1', '01', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('924', '1', '01', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('925', '1', '01', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('926', '1', '01', '31', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('927', '1', '03', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('928', '1', '03', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('929', '1', '03', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('930', '1', '03', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('931', '1', '03', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('932', '1', '03', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('933', '1', '03', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('934', '1', '03', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('935', '1', '03', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('936', '1', '03', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('937', '1', '03', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('938', '1', '03', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('939', '1', '03', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('940', '1', '03', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('941', '1', '03', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('942', '1', '03', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('943', '1', '03', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('944', '1', '03', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('945', '1', '03', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('946', '1', '03', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('947', '1', '03', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('948', '1', '03', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('949', '1', '03', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('950', '1', '03', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('951', '1', '03', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('952', '1', '03', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('953', '1', '03', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('954', '1', '03', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('955', '1', '03', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('956', '1', '03', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('957', '1', '03', '31', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('958', '1', '', '1', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('959', '1', '', '2', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('960', '1', '', '3', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('961', '1', '', '4', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('962', '1', '', '5', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('963', '1', '', '6', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('964', '1', '', '7', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('965', '1', '', '8', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('966', '1', '', '9', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('967', '1', '', '10', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('968', '1', '', '11', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('969', '1', '', '12', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('970', '1', '', '13', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('971', '1', '', '14', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('972', '1', '', '15', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('973', '1', '', '16', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('974', '1', '', '17', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('975', '1', '', '18', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('976', '1', '', '19', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('977', '1', '', '20', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('978', '1', '', '21', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('979', '1', '', '22', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('980', '1', '', '23', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('981', '1', '', '24', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('982', '1', '', '25', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('983', '1', '', '26', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('984', '1', '', '27', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('985', '1', '', '28', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('986', '1', '', '29', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('987', '1', '', '30', '0', '0');
INSERT INTO `tbl_createdtr` VALUES ('988', '1', '04', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('989', '1', '04', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('990', '1', '04', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('991', '1', '04', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('992', '1', '04', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('993', '1', '04', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('994', '1', '04', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('995', '1', '04', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('996', '1', '04', '9', '2016', '1');
INSERT INTO `tbl_createdtr` VALUES ('997', '1', '04', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('998', '1', '04', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('999', '1', '04', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1000', '1', '04', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1001', '1', '04', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1002', '1', '04', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1003', '1', '04', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1004', '1', '04', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1005', '1', '04', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1006', '1', '04', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1007', '1', '04', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1008', '1', '04', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1009', '1', '04', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1010', '1', '04', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1011', '1', '04', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1012', '1', '04', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1013', '1', '04', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1014', '1', '04', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1015', '1', '04', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1016', '1', '04', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1017', '1', '04', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1018', '1', '02', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1019', '1', '02', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1020', '1', '02', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1021', '1', '02', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1022', '1', '02', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1023', '1', '02', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1024', '1', '02', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1025', '1', '02', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1026', '1', '02', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1027', '1', '02', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1028', '1', '02', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1029', '1', '02', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1030', '1', '02', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1031', '1', '02', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1032', '1', '02', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1033', '1', '02', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1034', '1', '02', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1035', '1', '02', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1036', '1', '02', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1037', '1', '02', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1038', '1', '02', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1039', '1', '02', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1040', '1', '02', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1041', '1', '02', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1042', '1', '02', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1043', '1', '02', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1044', '1', '02', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1045', '1', '02', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1046', '1', '01', '1', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1047', '1', '01', '2', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1048', '1', '01', '3', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1049', '1', '01', '4', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1050', '1', '01', '5', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1051', '1', '01', '6', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1052', '1', '01', '7', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1053', '1', '01', '8', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1054', '1', '01', '9', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1055', '1', '01', '10', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1056', '1', '01', '11', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1057', '1', '01', '12', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1058', '1', '01', '13', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1059', '1', '01', '14', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1060', '1', '01', '15', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1061', '1', '01', '16', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1062', '1', '01', '17', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1063', '1', '01', '18', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1064', '1', '01', '19', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1065', '1', '01', '20', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1066', '1', '01', '21', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1067', '1', '01', '22', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1068', '1', '01', '23', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1069', '1', '01', '24', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1070', '1', '01', '25', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1071', '1', '01', '26', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1072', '1', '01', '27', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1073', '1', '01', '28', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1074', '1', '01', '29', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1075', '1', '01', '30', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1076', '1', '01', '31', '2017', '0');
INSERT INTO `tbl_createdtr` VALUES ('1077', '2', '01', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1078', '2', '01', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1079', '2', '01', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1080', '2', '01', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1081', '2', '01', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1082', '2', '01', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1083', '2', '01', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1084', '2', '01', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1085', '2', '01', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1086', '2', '01', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1087', '2', '01', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1088', '2', '01', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1089', '2', '01', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1090', '2', '01', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1091', '2', '01', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1092', '2', '01', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1093', '2', '01', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1094', '2', '01', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1095', '2', '01', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1096', '2', '01', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1097', '2', '01', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1098', '2', '01', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1099', '2', '01', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1100', '2', '01', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1101', '2', '01', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1102', '2', '01', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1103', '2', '01', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1104', '2', '01', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1105', '2', '01', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1106', '2', '01', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1107', '2', '01', '31', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1108', '2', '02', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1109', '2', '02', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1110', '2', '02', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1111', '2', '02', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1112', '2', '02', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1113', '2', '02', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1114', '2', '02', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1115', '2', '02', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1116', '2', '02', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1117', '2', '02', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1118', '2', '02', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1119', '2', '02', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1120', '2', '02', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1121', '2', '02', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1122', '2', '02', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1123', '2', '02', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1124', '2', '02', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1125', '2', '02', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1126', '2', '02', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1127', '2', '02', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1128', '2', '02', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1129', '2', '02', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1130', '2', '02', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1131', '2', '02', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1132', '2', '02', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1133', '2', '02', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1134', '2', '02', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1135', '2', '02', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1166', '2', '04', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1167', '2', '04', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1168', '2', '04', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1169', '2', '04', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1170', '2', '04', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1171', '2', '04', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1172', '2', '04', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1173', '2', '04', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1174', '2', '04', '9', '2016', '1');
INSERT INTO `tbl_createdtr` VALUES ('1175', '2', '04', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1176', '2', '04', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1177', '2', '04', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1178', '2', '04', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1179', '2', '04', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1180', '2', '04', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1181', '2', '04', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1182', '2', '04', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1183', '2', '04', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1184', '2', '04', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1185', '2', '04', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1186', '2', '04', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1187', '2', '04', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1188', '2', '04', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1189', '2', '04', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1190', '2', '04', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1191', '2', '04', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1192', '2', '04', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1193', '2', '04', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1194', '2', '04', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1195', '2', '04', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1196', '2', '05', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1197', '2', '05', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1198', '2', '05', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1199', '2', '05', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1200', '2', '05', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1201', '2', '05', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1202', '2', '05', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1203', '2', '05', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1204', '2', '05', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1205', '2', '05', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1206', '2', '05', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1207', '2', '05', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1208', '2', '05', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1209', '2', '05', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1210', '2', '05', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1211', '2', '05', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1212', '2', '05', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1213', '2', '05', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1214', '2', '05', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1215', '2', '05', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1216', '2', '05', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1217', '2', '05', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1218', '2', '05', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1219', '2', '05', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1220', '2', '05', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1221', '2', '05', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1222', '2', '05', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1223', '2', '05', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1224', '2', '05', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1225', '2', '05', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1226', '2', '05', '31', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1227', '1', '05', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1228', '1', '05', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1229', '1', '05', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1230', '1', '05', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1231', '1', '05', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1232', '1', '05', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1233', '1', '05', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1234', '1', '05', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1235', '1', '05', '9', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1236', '1', '05', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1237', '1', '05', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1238', '1', '05', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1239', '1', '05', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1240', '1', '05', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1241', '1', '05', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1242', '1', '05', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1243', '1', '05', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1244', '1', '05', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1245', '1', '05', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1246', '1', '05', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1247', '1', '05', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1248', '1', '05', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1249', '1', '05', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1250', '1', '05', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1251', '1', '05', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1252', '1', '05', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1253', '1', '05', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1254', '1', '05', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1255', '1', '05', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1256', '1', '05', '30', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1257', '1', '05', '31', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1258', '8', '04', '1', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1259', '8', '04', '2', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1260', '8', '04', '3', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1261', '8', '04', '4', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1262', '8', '04', '5', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1263', '8', '04', '6', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1264', '8', '04', '7', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1265', '8', '04', '8', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1266', '8', '04', '9', '2016', '1');
INSERT INTO `tbl_createdtr` VALUES ('1267', '8', '04', '10', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1268', '8', '04', '11', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1269', '8', '04', '12', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1270', '8', '04', '13', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1271', '8', '04', '14', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1272', '8', '04', '15', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1273', '8', '04', '16', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1274', '8', '04', '17', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1275', '8', '04', '18', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1276', '8', '04', '19', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1277', '8', '04', '20', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1278', '8', '04', '21', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1279', '8', '04', '22', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1280', '8', '04', '23', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1281', '8', '04', '24', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1282', '8', '04', '25', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1283', '8', '04', '26', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1284', '8', '04', '27', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1285', '8', '04', '28', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1286', '8', '04', '29', '2016', '0');
INSERT INTO `tbl_createdtr` VALUES ('1287', '8', '04', '30', '2016', '0');

-- ----------------------------
-- Table structure for `tbl_employee`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee`;
CREATE TABLE `tbl_employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `empLastName` varchar(100) NOT NULL,
  `empFirstName` varchar(100) NOT NULL,
  `empMiddleName` varchar(100) DEFAULT NULL,
  `empExtensionName` varchar(10) DEFAULT NULL,
  `sex_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `tax_category_id` int(11) NOT NULL,
  `date_hired` datetime NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee
-- ----------------------------
INSERT INTO `tbl_employee` VALUES ('1', 'JAMERO', 'ALONA CHRISTINE', 'RAMIRES', null, '2', '2', '9', '1', '2016-04-06 00:00:00');
INSERT INTO `tbl_employee` VALUES ('2', 'Dela Cruz', 'Juan', 'A', 'Jr', '1', '1', '12', '3', '2016-01-01 00:00:00');
INSERT INTO `tbl_employee` VALUES ('8', 'DIMASALANG', 'MELCHORA', 'A', null, '2', '1', '11', '2', '2016-04-11 00:00:00');

-- ----------------------------
-- Table structure for `tbl_employee_deduction`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee_deduction`;
CREATE TABLE `tbl_employee_deduction` (
  `deduction_ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `deduction_id` int(11) NOT NULL,
  `deduction_amount` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`deduction_ref_id`),
  UNIQUE KEY `Deduction Duplicate` (`deduction_id`,`emp_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee_deduction
-- ----------------------------
INSERT INTO `tbl_employee_deduction` VALUES ('1', '1', '200', '1');
INSERT INTO `tbl_employee_deduction` VALUES ('2', '1', '200', '2');
INSERT INTO `tbl_employee_deduction` VALUES ('3', '2', '200', '2');

-- ----------------------------
-- Table structure for `tbl_employee_leaveapplication`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee_leaveapplication`;
CREATE TABLE `tbl_employee_leaveapplication` (
  `leave_application_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `sickness` varchar(255) DEFAULT NULL,
  `place_to_visit` varchar(255) DEFAULT NULL,
  `days_to_leave` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`leave_application_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee_leaveapplication
-- ----------------------------
INSERT INTO `tbl_employee_leaveapplication` VALUES ('1', '2', '3', 'sasa', 'sasas', '1', '2');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('2', '1', '1', 'sas', 'asas', '1', '1');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('3', '2', '3', 'ASAS', 'asAS', '1', '1');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('49', '2', '3', 'sasa', 'sasas', '1', '1');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('50', '2', '3', 'sasa', 'sasas', '1', '1');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('58', '8', '3', '1', '1', '3', '1');

-- ----------------------------
-- Table structure for `tbl_employee_leavecredit`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee_leavecredit`;
CREATE TABLE `tbl_employee_leavecredit` (
  `emp_leave_credit_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `leave_credit` int(11) NOT NULL,
  PRIMARY KEY (`emp_leave_credit_id`),
  UNIQUE KEY `emp_id` (`emp_id`,`leave_type_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee_leavecredit
-- ----------------------------
INSERT INTO `tbl_employee_leavecredit` VALUES ('1', '1', '1', '1');
INSERT INTO `tbl_employee_leavecredit` VALUES ('2', '2', '3', '0');
INSERT INTO `tbl_employee_leavecredit` VALUES ('3', '2', '2', '0');
INSERT INTO `tbl_employee_leavecredit` VALUES ('4', '1', '3', '10');
INSERT INTO `tbl_employee_leavecredit` VALUES ('5', '1', '5', '3');
INSERT INTO `tbl_employee_leavecredit` VALUES ('6', '8', '3', '10');
INSERT INTO `tbl_employee_leavecredit` VALUES ('7', '8', '5', '3');
INSERT INTO `tbl_employee_leavecredit` VALUES ('8', '8', '4', '10');

-- ----------------------------
-- Table structure for `tbl_employee_timelog`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee_timelog`;
CREATE TABLE `tbl_employee_timelog` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `dtr_id` int(11) NOT NULL,
  `emp_timein` time NOT NULL,
  `emp_timeout` time DEFAULT NULL,
  `emp_totalhours` varchar(10) DEFAULT NULL,
  `emp_late` varchar(10) DEFAULT NULL,
  `emp_excesstime` varchar(10) DEFAULT NULL,
  `emp_undertime` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ref_id`),
  UNIQUE KEY `duplicate_date_entry` (`emp_id`,`dtr_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee_timelog
-- ----------------------------
INSERT INTO `tbl_employee_timelog` VALUES ('5', '1', '990', '16:20:01', '18:01:00', '00:40:00', '07:20:00', '00:01:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('6', '2', '1169', '08:19:02', '16:00:00', '06:41:00', '00:19:00', '00:00:00', '01:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('7', '2', '1170', '07:21:14', '12:00:00', '03:00:00', '00:00:00', '00:00:00', '05:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('8', '2', '1171', '08:00:00', '17:27:12', '08:00:00', '00:00:00', '00:27:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('9', '2', '1172', '17:25:17', '17:25:23', '00:00:00', '09:25:00', '00:25:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('10', '2', '1174', '07:28:44', '17:00:00', '16:00:00', '00:00:00', '00:00:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('11', '2', '1175', '07:28:44', '17:05:00', '08:00:00', '00:00:00', '00:05:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('12', '2', '1176', '07:28:44', '16:00:00', '07:00:00', '00:00:00', '00:00:00', '01:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('13', '2', '1177', '12:10:30', '15:51:00', '02:41:00', '04:10:00', '00:00:00', '01:09:00');
INSERT INTO `tbl_employee_timelog` VALUES ('14', '2', '1178', '07:11:41', null, '00:00:00', '00:00:00', '00:00:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('15', '2', '1179', '08:01:00', null, '00:00:00', '00:01:00', '00:00:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('16', '2', '1180', '12:17:10', null, '00:00:00', '04:17:00', '00:00:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('17', '2', '1181', '12:17:57', '15:05:57', '01:48:00', '04:17:00', '00:00:00', '01:55:00');
INSERT INTO `tbl_employee_timelog` VALUES ('18', '2', '1183', '14:32:56', '19:06:10', '01:28:00', '06:32:00', '02:06:00', '00:00:00');
INSERT INTO `tbl_employee_timelog` VALUES ('19', '2', '1214', '06:20:42', '16:20:44', '07:20:00', '00:00:00', '00:00:00', '00:40:00');

-- ----------------------------
-- Table structure for `tbl_leavecoverage`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_leavecoverage`;
CREATE TABLE `tbl_leavecoverage` (
  `leave_coverage_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_application_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  PRIMARY KEY (`leave_coverage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_leavecoverage
-- ----------------------------
INSERT INTO `tbl_leavecoverage` VALUES ('1', '1', '2', '2016-04-04', '2016-04-05');
INSERT INTO `tbl_leavecoverage` VALUES ('2', '3', '2', '2016-04-06', '2016-04-21');

-- ----------------------------
-- Table structure for `tbl_payroll`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_payroll`;
CREATE TABLE `tbl_payroll` (
  `payroll_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `payroll_month` int(11) NOT NULL,
  `payroll_year` int(11) NOT NULL,
  `cut_off_start` int(11) NOT NULL,
  `cut_off_end` int(11) NOT NULL,
  `total_hours_comp` varchar(11) NOT NULL DEFAULT '0',
  `total_min_comp` varchar(11) NOT NULL DEFAULT '0',
  `salary_as_per_logs` varchar(11) NOT NULL,
  `sss_cont_ep` varchar(11) NOT NULL,
  `ph_cont_ep` varchar(11) NOT NULL,
  `pagibig_cont_ep` varchar(11) NOT NULL,
  `sss_cont_ee` varchar(11) NOT NULL,
  `ph_cont_ee` varchar(11) NOT NULL,
  `pagibig_cont_ee` varchar(11) NOT NULL,
  `total_salary` varchar(11) NOT NULL,
  `tax_cont` varchar(11) NOT NULL,
  `salary_as_per_contract` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`payroll_id`),
  UNIQUE KEY `payroll_gen_dup` (`emp_id`,`payroll_month`,`payroll_year`,`cut_off_start`,`cut_off_end`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_payroll
-- ----------------------------
INSERT INTO `tbl_payroll` VALUES ('19', '2', '4', '2016', '1', '15', '50', '82', '15536.28', '1208.70', '437.50', '100', '581.30', '437.50', '100', '13659.38', '758.096', '75010.45');
INSERT INTO `tbl_payroll` VALUES ('20', '1', '4', '2016', '1', '15', '0', '40', '48.4', '1208.70', '225.00', '100', '581.30', '225.00', '100', '0', '0', '18000.00');
INSERT INTO `tbl_payroll` VALUES ('21', '2', '3', '2016', '16', '31', '', '', '0', '1208.70', '437.50', '100', '581.30', '437.50', '100', '0', '0', '75010.45');
INSERT INTO `tbl_payroll` VALUES ('22', '1', '3', '2016', '16', '31', '', '', '0', '1208.70', '225.00', '100', '581.30', '225.00', '100', '0', '0', '18000.00');
INSERT INTO `tbl_payroll` VALUES ('23', '2', '4', '2016', '1', '31', '52', '158', '16524.24', '1208.70', '437.50', '100', '581.30', '437.50', '100', '14449.75', '955.688', '75010.45');
INSERT INTO `tbl_payroll` VALUES ('24', '8', '4', '2016', '1', '31', '', '', '0', '1208.70', '250.00', '100', '581.30', '250.00', '100', '0', '0', '20000.00');
INSERT INTO `tbl_payroll` VALUES ('25', '1', '4', '2016', '1', '31', '0', '40', '48.4', '1208.70', '225.00', '100', '581.30', '225.00', '100', '0', '0', '18000.00');
INSERT INTO `tbl_payroll` VALUES ('26', '2', '4', '2016', '16', '31', '2', '76', '987.96', '1208.70', '437.50', '100', '581.30', '437.50', '100', '0', '0', '75010.45');
INSERT INTO `tbl_payroll` VALUES ('27', '8', '4', '2016', '16', '31', '', '', '0', '1208.70', '250.00', '100', '581.30', '250.00', '100', '0', '0', '20000.00');
INSERT INTO `tbl_payroll` VALUES ('28', '1', '4', '2016', '16', '31', '', '', '0', '1208.70', '225.00', '100', '581.30', '225.00', '100', '0', '0', '18000.00');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `uid` bigint(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstname` varchar(40) NOT NULL COMMENT 'Firstname',
  `middlename` varchar(40) NOT NULL COMMENT 'Middle Name',
  `surname` varchar(40) NOT NULL COMMENT 'Surname',
  `extensionname` varchar(3) DEFAULT NULL COMMENT 'Extension',
  `position` varchar(80) DEFAULT NULL,
  `designation` varchar(80) DEFAULT NULL,
  `office_code` int(11) DEFAULT NULL,
  `user_level` int(3) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `activate` int(2) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `emp_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`,`password`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  KEY `position` (`position`) USING BTREE,
  KEY `designation` (`designation`) USING BTREE,
  KEY `office_code` (`office_code`) USING BTREE,
  KEY `user_fullname` (`firstname`) USING BTREE,
  KEY `user_level` (`user_level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='System Users';

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('0000000001', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'acrjamero@sample.com', 'admin', 'admin', 'admin', null, null, null, null, '-1', null, '1', 'a:4:{s:15:\"LoginRetryCount\";i:0;s:9:\"SessionID\";s:0:\"\";s:20:\"LastAccessedDateTime\";s:19:\"2015/06/02 15:37:01\";s:20:\"LastBadLoginDateTime\";s:19:\"2015/04/14 02:48:42\";}', '1');
INSERT INTO `tbl_user` VALUES ('0000000002', 'sample', '5e8ff9bf55ba3508199d22e984129be6', 'sample', 'sample', 'sample', 'sample', null, null, null, null, '1', null, '1', 'a:3:{s:15:\"LoginRetryCount\";i:0;s:9:\"SessionID\";s:0:\"\";s:20:\"LastAccessedDateTime\";s:19:\"2015/04/10 08:57:35\";}', '0');
INSERT INTO `tbl_user` VALUES ('0000000003', 'dlloadmin', 'a48703ba275c9538d90a342c6c90b6f4', 'dlloadmin@sample.com', 'dlloadmin', 'dlloadmin', 'dlloadmin', null, null, null, null, '1', null, '1', 'a:3:{s:15:\"LoginRetryCount\";i:0;s:9:\"SessionID\";s:0:\"\";s:20:\"LastAccessedDateTime\";s:19:\"2015/04/16 08:48:31\";}', '0');
INSERT INTO `tbl_user` VALUES ('0000000004', 'employee', 'fa5473530e4d1a5a1e1eb53d2fedb10c', 'employee@sample.com', 'Juan', 'A', 'Dela Cruz', 'Jr', null, null, null, '2', null, '1', null, '2');
INSERT INTO `tbl_user` VALUES ('0000000005', 'melchora', '7a64da9ced4038b66bce890ee9342526', 'melchora@sample.com', 'melchora', 'melchora', 'melchora', null, null, null, null, '2', null, '1', 'a', '8');

-- ----------------------------
-- Table structure for `tbl_user_old`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_old`;
CREATE TABLE `tbl_user_old` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstname` varchar(40) NOT NULL COMMENT 'Firstname',
  `middlename` varchar(40) NOT NULL COMMENT 'Middle Name',
  `surname` varchar(40) NOT NULL COMMENT 'Surname',
  `extensionname` varchar(3) DEFAULT NULL COMMENT 'Extension',
  `position` varchar(80) DEFAULT NULL,
  `designation` varchar(80) DEFAULT NULL,
  `region_code` bigint(9) unsigned zerofill NOT NULL,
  `user_level` int(3) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL,
  `profile` text NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`,`password`),
  UNIQUE KEY `email` (`email`) USING BTREE,
  KEY `position` (`position`) USING BTREE,
  KEY `designation` (`designation`) USING BTREE,
  KEY `region_code` (`region_code`) USING BTREE,
  KEY `user_fullname` (`firstname`) USING BTREE,
  KEY `user_level` (`user_level`) USING BTREE,
  CONSTRAINT `tbl_user_old_ibfk_1` FOREIGN KEY (`region_code`) REFERENCES `lib_regions` (`region_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1 COMMENT='System Users';

-- ----------------------------
-- Records of tbl_user_old
-- ----------------------------
INSERT INTO `tbl_user_old` VALUES ('11', 'josef', '30fe54c74a3eab44a718aad89ddc52990fdc2d77', 'j@asddswd.gov.ph', 'Josef Friedrich', 'Saligumba', 'Baldo', 'Jr', 'ISA III', 'Systems Developer', '130000000', '-1', '09175554041', '1', 'a:3:{s:9:\"SessionID\";s:0:\"\";s:20:\"LastAccessedDateTime\";s:19:\"2015/12/15 07:01:09\";s:23:\"LastPasswordChangedDate\";s:10:\"2015/12/11\";}');
INSERT INTO `tbl_user_old` VALUES ('101', 'titojaymz', '30fe54c74a3eab44a718aad89ddc52990fdc2d77', 'j@a.com', 'Josef Friedrich', 'Saligumba', 'Baldo', 'Jr', 'ISA III', 'Systems Developer', '130000000', '1', '1', '1', '');
INSERT INTO `tbl_user_old` VALUES ('102', 'titojaymz1', '30fe54c74a3eab44a718aad89ddc52990fdc2d77', 'a@a.comaaa', 'Josef Friedrich', 'Saligumba', 'Baldo', 'Jr', 'Position', 'Positio', '130000000', '-1', '1234', '1', '');
INSERT INTO `tbl_user_old` VALUES ('103', 'lerrie', '8cb2237d0679ca88db6464eac60da96345513964', 'l@l.com', 'Lerrie John', 'E', 'Saclayan', '', 'ITO I', 'Programmer', '130000000', '-1', '', '1', '');
INSERT INTO `tbl_user_old` VALUES ('104', 'leri', 'leri', 'leri@leri.com', 'Lerrie John', 'Espejo', 'Saclayan', '', null, null, '130000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('108', 'leri', 'c7f736afba4eb9462858f0105352a44b29cd142b', 'leri@leri.coms', 'Lerrie John', 'Espejo', 'Saclayan', '', null, null, '010000000', '-1', null, '1', '');
INSERT INTO `tbl_user_old` VALUES ('109', 'john', '58fc5c89562abe851efbb0301a0843c6f6dde9b2', 'john@john.com', 'john', 'john', 'john', 'joh', null, null, '010000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('111', '123', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '12@123.com', '123', '123', '123', '123', null, null, '010000000', '-1', null, '1', '');
INSERT INTO `tbl_user_old` VALUES ('112', 'zxc', '7f99d1549212d6d8ffb7eb5723cf2195bdd6cb11', 'zxc@zxc.com', 'zxc', 'zxc', 'zxc', 'zxc', null, null, '010000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('114', 'zxcx', '7f99d1549212d6d8ffb7eb5723cf2195bdd6cb11', 'zxasdc@zxc.com', 'zxc', 'zxc', 'zxc', 'zxc', null, null, '010000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('115', 'zxcx', '7c4d254c9f8b37c85d31832e4ad07020351d7d79', 'zxasdasdc@zxc.com', 'zxc', 'zxc', 'zxc', 'zxc', null, null, '010000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('116', 'qwe', '5029ee379285ae06aab12ae10bb843d26e9b5660', 'qwe@qwe.con', 'qwe', 'qwe', 'qwe', 'qwe', null, null, '030000000', null, null, '0', '');
INSERT INTO `tbl_user_old` VALUES ('117', 'cmalvarez', '3883590efefbdfd1038995610188436f798aedc4', 'cmalvarez@dswd.gov.ph', 'cmalvarez', 'cmalvarez', 'cmalvarez', 'cma', null, null, '130000000', '-1', null, '1', '');

-- ----------------------------
-- Table structure for `userlevelpermissions`
-- ----------------------------
DROP TABLE IF EXISTS `userlevelpermissions`;
CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of userlevelpermissions
-- ----------------------------
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_deduction', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_leave', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_salary', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_schedule', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_sex', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_tax_category', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee', '104');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_deduction', '8');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_leavecredit', '8');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_timelog', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_payroll', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_user_old', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_user', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_employee_leaveapplication', '45');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}tbl_leavecoverage', '45');
INSERT INTO `userlevelpermissions` VALUES ('2', '{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}lib_status', '0');

-- ----------------------------
-- Table structure for `userlevels`
-- ----------------------------
DROP TABLE IF EXISTS `userlevels`;
CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of userlevels
-- ----------------------------
INSERT INTO `userlevels` VALUES ('-1', 'Administrator');
INSERT INTO `userlevels` VALUES ('0', 'Default');
INSERT INTO `userlevels` VALUES ('2', 'Employee');
