/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_hris

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-10-04 21:16:15
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `date_applied` date NOT NULL,
  PRIMARY KEY (`leave_application_id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_employee_leaveapplication
-- ----------------------------
INSERT INTO `tbl_employee_leaveapplication` VALUES ('87', '75', '3', '', null, '1', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('88', '75', '3', '', null, '1', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('89', '75', '4', '', null, '3', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('90', '76', '3', '', null, '2', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('91', '72', '3', '', null, '3', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('92', '72', '3', '', null, '2', '3', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('93', '77', '3', '', null, '2', '2', '2016-09-01');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('94', '77', '3', '', null, '1', '1', '2016-10-04');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('95', '77', '4', '', null, '1', '1', '2016-10-04');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('96', '77', '4', '', null, '1', '1', '2016-10-04');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('97', '77', '3', '', null, '1', '1', '2016-10-04');
INSERT INTO `tbl_employee_leaveapplication` VALUES ('98', '77', '4', '', null, '1', '1', '2016-10-04');
