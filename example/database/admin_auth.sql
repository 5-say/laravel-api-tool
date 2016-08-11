-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.17 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------


CREATE TABLE `admin_account_duty` (
	`account_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '账户ID（admin_account_id）',
	`duty_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '职务ID（admin_duty_id）',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间'
)
COMMENT='admin模块：账号 && 职务'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;


CREATE TABLE `admin_authorities` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`pid` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
	`name` VARCHAR(50) NOT NULL COMMENT '权限名称',
	`route_name` VARCHAR(50) NULL DEFAULT NULL COMMENT '路由名称',
	`sort` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
	`status` INT(11) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态（1.禁用 2.正常）',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `route_name` (`route_name`)
)
COMMENT='admin模块：权限'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;


CREATE TABLE `admin_authority_duty` (
	`duty_id` INT(11) UNSIGNED NOT NULL COMMENT '职务ID（admin_duty_id）',
	`authority_id` INT(11) UNSIGNED NOT NULL COMMENT '权限ID（admin_authority_id）',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间'
)
COMMENT='admin模块：权限 && 职务'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;


CREATE TABLE `admin_duties` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`name` VARCHAR(50) NOT NULL COMMENT '名称',
	`sort` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
	PRIMARY KEY (`id`)
)
COMMENT='admin模块：职务'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;

