/*
SQLyog Professional v12.09 (64 bit)
MySQL - 5.5.53 : Database - tp6
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE IF NOT EXISTS `jlwebsys` DEFAULT CHARACTER SET utf8;

USE `jlwebsys`;

/*Table structure for table `jl_admin` */

DROP TABLE IF EXISTS `jl_admin`;

CREATE TABLE `jl_admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `account` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆账号',
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆密码sha1',
  `pwd_mix` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00000' COMMENT '密码混淆码',
  `realname` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '真实姓名',
  `sex` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '男' COMMENT '管理员性别',
  `roleid` int(3) DEFAULT '0' COMMENT '权限组',
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机号',
  `regip` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册IP',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:可用 0：禁用',
  `remark` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '备注信息',
  `add_user` int(3) NOT NULL COMMENT '操作人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `jl_admin` */

insert  into `jl_admin`(`id`,`account`,`password`,`pwd_mix`,`realname`,`sex`,`roleid`,`email`,`mobile`,`regip`,`create_time`,`status`,`remark`,`add_user`) values (3,'admin','821d5917372b1cab5639d3262a230db05a96133f','51372','文磊','男',1,'806682495@qq.com','18330595919','',1563881643,1,'',0);

/*Table structure for table `jl_adminlog` */

DROP TABLE IF EXISTS `jl_adminlog`;

CREATE TABLE `jl_adminlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `adminid` int(11) NOT NULL COMMENT '登陆的用户id',
  `adminname` varchar(60) DEFAULT NULL COMMENT '登陆的用户名字',
  `logtime` int(11) DEFAULT NULL COMMENT '登陆时间',
  `logip` char(15) DEFAULT '0.0.0.0' COMMENT '登陆IP',
  `ipport` int(5) DEFAULT NULL COMMENT 'ip端口号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `jl_adminlog` */

insert  into `jl_adminlog`(`id`,`adminid`,`adminname`,`logtime`,`logip`,`ipport`) values (1,3,'admin',1563882600,'127.0.0.1',80),(2,3,'admin',1563888739,'127.0.0.1',80);

/*Table structure for table `jl_adminrole` */

DROP TABLE IF EXISTS `jl_adminrole`;

CREATE TABLE `jl_adminrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `rolename` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限组名称',
  `role_items` text COLLATE utf8_unicode_ci COMMENT '权限组内容',
  `sort` int(3) DEFAULT NULL COMMENT '分组排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `oper_user` int(3) DEFAULT NULL COMMENT '操作人员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `jl_adminrole` */

insert  into `jl_adminrole`(`id`,`rolename`,`role_items`,`sort`,`create_time`,`update_time`,`oper_user`) values (1,'超级管理员',NULL,1,NULL,NULL,0),(2,'网站主编',NULL,2,NULL,NULL,0);

/*Table structure for table `jl_user` */

DROP TABLE IF EXISTS `jl_user`;

CREATE TABLE `jl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `jl_user` */

insert  into `jl_user`(`user_id`,`name`,`age`,`email`,`password`) values (1,'韦小宝',25,'weixiaobao@mai','123456'),(2,'小龙驹',19,'xiaolongnv@m','123456'),(3,'杨过',20,'yangguo@qq.com','213323'),(4,'郭靖',45,'guojing@mail.com','6215621'),(5,'乔峰',38,'qiaofeng@qq.com','e10adc3949ba59abbe56e057f20f883e');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
