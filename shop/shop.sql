-- 后台管理员表

DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE IF NOT EXISTS `shop_admin`(
	`adminid` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
	`adminuser` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员',
	`adminpass` CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
	`adminemail` CHAR(50) NOT NULL DEFAULT ''COMMENT '管理员邮箱',
	`logintime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
	`loginip` BIGINT NOT NULL DEFAULT '0'COMMENT '登录ip',
	`createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY(`adminid`),
	UNIQUE shop_admin_adminuser_adminpass(`adminuser`,`adminpass`),
	UNIQUE shop_admin_adminuser_adminemail(`adminuser`,`adminemail`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户表
DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE IF NOT EXISTS `shop_user`(
	`userid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
	`username` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '用户名',
	`userpass` CHAR(32) NOT NULL DEFAULT '' COMMENT '用户密码',
	`useremail` VARCHAR(100) NOT NULL DEFAULT ''COMMENT '用户邮箱',
	`createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY(`userid`),
	UNIQUE shop_user_username_userpass(`username`,`userpass`),
	UNIQUE shop_user_useremail_userpass(`useremail`,`userpass`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户详细信息表
DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE IF NOT EXISTS `shop_profile`(
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
	`truename` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
	`age` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '年龄',
	`sex` ENUM('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别',
	`birthday` date NOT NULL DEFAULT '2016-01-01' COMMENT '生日',
	`nickname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '昵称',
	`company` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '公司',
	`userid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '外键',
	`createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY(`id`),
	UNIQUE shop_profile_userid(`userid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 无限分类表
DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category`(
	`cateid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
	`title` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '名称',
	`parentid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '外键',
	`createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY(`cateid`),
	KEY shop_category_parentid(`parentid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--商品表 
DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product`(
	`productid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
	`cateid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '外键',
	`title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '名称',
	`descr` TEXT,
	`num` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '数量',
	`price` DECIMAL(10,2) NOT NULL DEFAULT '00000000.00' COMMENT '价格',
	`cover` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '图片',
	`pics` TEXT,
	`issale` ENUM('0','1') NOT NULL DEFAULT '0',
	`saleprice` DECIMAL(10,2) NOT NULL DEFAULT '00000000.00' COMMENT '价格',
	`ishot` ENUM('0','1') NOT NULL DEFAULT '0',
	`createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY(`productid`),
	KEY shop_product_cateid(`cateid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

















