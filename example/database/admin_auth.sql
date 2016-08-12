-- --------------------------------------------------------
-- admin 模块 权限相关表 结构示例
-- --------------------------------------------------------


CREATE TABLE `admin_accounts` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`account` CHAR(16) NOT NULL DEFAULT '' COMMENT '账号',
	`password` CHAR(60) NOT NULL DEFAULT '' COMMENT '密码',
	`last_logged_at` TIMESTAMP NULL DEFAULT NULL COMMENT '最后登录时间',
	`last_login_ip` BIGINT(20) NULL DEFAULT NULL COMMENT '最后登录IP',
	`created_at` TIMESTAMP NOT NULL COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL COMMENT '更新时间',
	`status` TINYINT(1) NULL DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `account` (`account`)
)
COMMENT='admin模块：账号'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;


CREATE TABLE `admin_account_duty` (
	`account_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '账户ID（admin_account_id）',
	`duty_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '职务ID（admin_duty_id）',
	`created_at` TIMESTAMP NOT NULL COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL COMMENT '更新时间'
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
	`route_name` VARCHAR(50) NULL DEFAULT NULL COMMENT '路由名称（多路由竖线分割，前后竖线补全）',
	`sort` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
	`created_at` TIMESTAMP NOT NULL COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL COMMENT '更新时间',
	`status` TINYINT(1) NULL DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
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
	`created_at` TIMESTAMP NOT NULL COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL COMMENT '更新时间'
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
	`created_at` TIMESTAMP NOT NULL COMMENT '创建时间',
	`updated_at` TIMESTAMP NOT NULL COMMENT '更新时间',
	`status` TINYINT(1) NULL DEFAULT '1' COMMENT '状态（1.正常 2.禁用）',
	PRIMARY KEY (`id`)
)
COMMENT='admin模块：职务'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;

