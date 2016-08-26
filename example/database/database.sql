-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.40 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 laravel_vue 的数据库结构
DROP DATABASE IF EXISTS `laravel_vue`;
CREATE DATABASE IF NOT EXISTS `laravel_vue` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `laravel_vue`;


-- 导出  表 laravel_vue.admin_accounts 结构
CREATE TABLE IF NOT EXISTS `admin_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account` char(16) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(60) NOT NULL DEFAULT '' COMMENT '密码',
  `last_logged_at` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` bigint(20) DEFAULT NULL COMMENT '最后登录IP',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
  `is_super_account` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否超级账户（0.否 1.是）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='admin模块：账号';

-- 正在导出表  laravel_vue.admin_accounts 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `admin_accounts` DISABLE KEYS */;
INSERT INTO `admin_accounts` (`id`, `account`, `password`, `last_logged_at`, `last_login_ip`, `created_at`, `updated_at`, `status`, `is_super_account`) VALUES
	(1, 'admin', '$2y$10$utwAStPeSBLNn1WYZRmyr.P9MeX1/oIY8t.VUF8cbuKkbWAsqjwuC', NULL, NULL, '2016-08-17 16:01:24', '2016-08-19 04:19:46', 1, 1),
	(2, '2222', '$2y$10$UWDRRZtjqBI46.gzIijrjuIOrIn4k8J45030Dqg2NOtFyHoSIOJtq', NULL, NULL, '2016-08-21 15:58:21', '2016-08-21 15:58:21', 1, 1),
	(3, '33', '$2y$10$crJ778I4O9L5v2oOQVSvG.v0Ultf7oE0Gu4bbhgMMfA9PWAttnSaS', NULL, NULL, '2016-08-21 15:58:27', '2016-08-21 15:58:27', 1, 0),
	(4, '44', '$2y$10$q5VKTcbVAP7J9D0xl2YwQO76MoOqloxKyTYiGQchsEsqsU.SbjVAO', NULL, NULL, '2016-08-21 15:59:51', '2016-08-21 15:59:51', 1, 0);
/*!40000 ALTER TABLE `admin_accounts` ENABLE KEYS */;


-- 导出  表 laravel_vue.admin_account_duty 结构
CREATE TABLE IF NOT EXISTS `admin_account_duty` (
  `account_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '账户ID（admin_account_id）',
  `duty_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职务ID（admin_duty_id）',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='admin模块：账号 && 职务';

-- 正在导出表  laravel_vue.admin_account_duty 的数据：~5 rows (大约)
/*!40000 ALTER TABLE `admin_account_duty` DISABLE KEYS */;
INSERT INTO `admin_account_duty` (`account_id`, `duty_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2016-08-18 18:14:29', '0000-00-00 00:00:00'),
	(1, 2, '2016-08-21 23:40:59', '0000-00-00 00:00:00'),
	(1, 3, '2016-08-21 23:47:06', '0000-00-00 00:00:00'),
	(1, 4, '2016-08-21 23:47:21', '0000-00-00 00:00:00'),
	(1, 10, '2016-08-21 23:56:48', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `admin_account_duty` ENABLE KEYS */;


-- 导出  表 laravel_vue.admin_authorities 结构
CREATE TABLE IF NOT EXISTS `admin_authorities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(50) NOT NULL COMMENT '权限名称',
  `route_name` varchar(50) DEFAULT NULL COMMENT '路由名称（多路由竖线分割，前后竖线补全）',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `route_name` (`route_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='admin模块：权限';

-- 正在导出表  laravel_vue.admin_authorities 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `admin_authorities` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_authorities` ENABLE KEYS */;


-- 导出  表 laravel_vue.admin_authority_duty 结构
CREATE TABLE IF NOT EXISTS `admin_authority_duty` (
  `duty_id` int(11) unsigned NOT NULL COMMENT '职务ID（admin_duty_id）',
  `authority_id` int(11) unsigned NOT NULL COMMENT '权限ID（admin_authority_id）',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='admin模块：权限 && 职务';

-- 正在导出表  laravel_vue.admin_authority_duty 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `admin_authority_duty` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_authority_duty` ENABLE KEYS */;


-- 导出  表 laravel_vue.admin_duties 结构
CREATE TABLE IF NOT EXISTS `admin_duties` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='admin模块：职务';

-- 正在导出表  laravel_vue.admin_duties 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `admin_duties` DISABLE KEYS */;
INSERT INTO `admin_duties` (`id`, `name`, `sort`, `created_at`, `updated_at`, `status`) VALUES
	(1, '管理员', 0, '2016-08-18 09:14:01', '2016-08-18 09:14:01', 1);
/*!40000 ALTER TABLE `admin_duties` ENABLE KEYS */;


-- 导出  表 laravel_vue.upload_the_files 结构
CREATE TABLE IF NOT EXISTS `upload_the_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `size` int(11) unsigned NOT NULL COMMENT '大小',
  `client_name` varchar(200) NOT NULL COMMENT '客户端文件名称（原文件名）',
  `mime_type` varchar(50) NOT NULL COMMENT 'MIME 类型',
  `extension` varchar(10) NOT NULL COMMENT '后缀名',
  `md5` char(32) NOT NULL COMMENT 'MD5',
  `save_path` varchar(500) NOT NULL COMMENT '存储路径（相对路径，含后缀名）',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户上传的文件';

-- 正在导出表  laravel_vue.upload_the_files 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `upload_the_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_the_files` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
