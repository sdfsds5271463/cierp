/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1DB
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : ci_erp

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-04-29 16:31:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ci_account`
-- ----------------------------
DROP TABLE IF EXISTS `ci_account`;
CREATE TABLE `ci_account` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `number` varchar(15) COLLATE utf8_unicode_ci DEFAULT '0',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `amount` double DEFAULT '0',
  `date` date DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `number` (`number`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_account
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_account_info`
-- ----------------------------
DROP TABLE IF EXISTS `ci_account_info`;
CREATE TABLE `ci_account_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '關聯ID',
  `uid` int(11) DEFAULT '0',
  `buId` smallint(6) DEFAULT '0' COMMENT '客戶ID',
  `billNo` varchar(25) DEFAULT '' COMMENT '單號',
  `billType` varchar(20) DEFAULT '',
  `billDate` date DEFAULT NULL COMMENT '單據日期',
  `accId` int(11) DEFAULT '0' COMMENT '結算賬戶ID',
  `payment` double DEFAULT '0' COMMENT '收款金額  採購退回為正',
  `wayId` int(11) DEFAULT '0' COMMENT '結算方式ID',
  `settlement` varchar(50) DEFAULT '' COMMENT '結算號',
  `remark` varchar(50) DEFAULT '' COMMENT '備註',
  `transType` int(11) DEFAULT '0',
  `transTypeName` varchar(50) DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `billdate` (`billDate`) USING BTREE,
  KEY `iid` (`iid`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_account_info
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_address`
-- ----------------------------
DROP TABLE IF EXISTS `ci_address`;
CREATE TABLE `ci_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `shortName` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT ' ',
  `postalcode` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `province` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `area` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `address` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `linkman` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `isdefault` tinyint(1) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `pid` (`postalcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_address
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ci_admin`;
CREATE TABLE `ci_admin` (
  `uid` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '使用者名稱稱',
  `userpwd` varchar(32) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '密碼',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否鎖定',
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT '',
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `lever` text COLLATE utf8_unicode_ci COMMENT '許可權',
  `roleid` tinyint(1) DEFAULT '1' COMMENT '角色ID',
  `righttype1` text COLLATE utf8_unicode_ci,
  `righttype2` text COLLATE utf8_unicode_ci,
  `righttype8` text COLLATE utf8_unicode_ci,
  `righttype4` text COLLATE utf8_unicode_ci,
  `rightids` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1,2,4,8',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_admin
-- ----------------------------
INSERT INTO `ci_admin` VALUES ('1', 'admin', '46f94c8de14fb36680850768ff1b7f2a', '1', 'CI科技', '0912345678', null, '0', null, null, null, null, '');

-- ----------------------------
-- Table structure for `ci_assistingprop`
-- ----------------------------
DROP TABLE IF EXISTS `ci_assistingprop`;
CREATE TABLE `ci_assistingprop` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `disable` tinyint(1) DEFAULT '0' COMMENT '狀態',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_assistingprop
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_assistsku`
-- ----------------------------
DROP TABLE IF EXISTS `ci_assistsku`;
CREATE TABLE `ci_assistsku` (
  `skuId` int(11) NOT NULL AUTO_INCREMENT,
  `skuClassId` int(11) DEFAULT '0',
  `skuAssistId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skuName` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`skuId`),
  KEY `id` (`skuClassId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_assistsku
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_category`
-- ----------------------------
DROP TABLE IF EXISTS `ci_category`;
CREATE TABLE `ci_category` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `parentId` smallint(6) DEFAULT '0' COMMENT '上級欄目ID',
  `path` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目路徑',
  `level` tinyint(2) DEFAULT '1' COMMENT '層次',
  `ordnum` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `typeNumber` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '區別',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `detail` tinyint(4) DEFAULT '1',
  `sortIndex` smallint(6) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `parentId` (`parentId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_category
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_contact`
-- ----------------------------
DROP TABLE IF EXISTS `ci_contact`;
CREATE TABLE `ci_contact` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '客戶名稱',
  `number` varchar(50) DEFAULT '0' COMMENT '客戶編號',
  `cCategory` smallint(6) DEFAULT '0' COMMENT '客戶類別',
  `cCategoryName` varchar(50) DEFAULT '' COMMENT '分類名稱',
  `taxRate` double DEFAULT '0' COMMENT '稅率',
  `amount` double DEFAULT '0' COMMENT '期初應付款',
  `periodMoney` double DEFAULT '0' COMMENT '期初預付款',
  `difMoney` double DEFAULT '0' COMMENT '初期往來餘額',
  `beginDate` date DEFAULT NULL COMMENT '餘額日期',
  `remark` varchar(100) DEFAULT '' COMMENT '備註',
  `place` varchar(100) DEFAULT '' COMMENT '職位',
  `linkMans` text COMMENT '客戶聯繫方式',
  `type` tinyint(1) DEFAULT '-10' COMMENT '-10客戶  10供應商',
  `contact` varchar(255) DEFAULT '',
  `cLevel` smallint(5) DEFAULT '1' COMMENT '客戶等級ID',
  `cLevelName` varchar(50) DEFAULT '' COMMENT '客戶等級',
  `pinYin` varchar(50) DEFAULT '',
  `disable` tinyint(1) DEFAULT '0' COMMENT '0啟用   1禁用',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '0正常 1刪除',
  PRIMARY KEY (`id`),
  KEY `number` (`number`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_contact
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_goods`
-- ----------------------------
DROP TABLE IF EXISTS `ci_goods`;
CREATE TABLE `ci_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '商品編號',
  `quantity` double DEFAULT '0' COMMENT '起初數量',
  `spec` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '規格',
  `baseUnitId` smallint(6) DEFAULT '0' COMMENT '單位ID',
  `unitName` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單位名稱',
  `categoryId` smallint(6) DEFAULT '0' COMMENT '商品分類ID',
  `categoryName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '分類名稱',
  `purPrice` double DEFAULT '0' COMMENT '預計採購價',
  `salePrice` double DEFAULT '0' COMMENT '預計銷售價',
  `unitCost` double DEFAULT '0' COMMENT '單位成本',
  `amount` double DEFAULT '0' COMMENT '期初總價',
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `goods` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `propertys` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初期設定',
  `vipPrice` double DEFAULT '0' COMMENT '會員價',
  `lowQty` double DEFAULT '0',
  `length` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `height` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `highQty` double DEFAULT '0',
  `isSerNum` double DEFAULT '0',
  `barCode` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `discountRate1` double DEFAULT '0' COMMENT '0',
  `discountRate2` double DEFAULT '0',
  `locationId` int(11) DEFAULT '0',
  `locationName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `wholesalePrice` double DEFAULT '0',
  `width` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `skuAssistId` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '輔助屬性分類',
  `pinYin` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `unitId` smallint(6) DEFAULT '0',
  `files` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '圖片路徑',
  `disable` tinyint(1) DEFAULT '0' COMMENT '0啟用   1禁用',
  `unitTypeId` int(11) DEFAULT '0',
  `assistIds` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `assistName` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `assistUnit` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `jianxing` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `josl` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `skuClassId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `property` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `safeDays` double DEFAULT '0',
  `advanceDay` double DEFAULT '0',
  `isWarranty` double DEFAULT '0',
  `delete` int(11) DEFAULT '0',
  `weight` double DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '0正常  1刪除',
  `warehouseWarning` tinyint(1) DEFAULT '0',
  `warehousePropertys` text,
  `dopey` tinyint(1) DEFAULT '0' COMMENT '是否多品',
  `sonGoods` text COMMENT '子商品集合',
  `udf01` varchar(255) DEFAULT '',
  `udf02` varchar(255) DEFAULT '',
  `udf03` varchar(255) DEFAULT '',
  `udf04` varchar(255) DEFAULT '',
  `udf05` varchar(255) DEFAULT '',
  `udf06` text,
  `udf07` text,
  `udf08` text,
  PRIMARY KEY (`id`),
  KEY `number` (`number`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_goods_img`
-- ----------------------------
DROP TABLE IF EXISTS `ci_goods_img`;
CREATE TABLE `ci_goods_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '名稱',
  `invId` int(11) DEFAULT '0',
  `type` varchar(100) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `thumbnailUrl` varchar(255) DEFAULT '',
  `size` int(11) DEFAULT '0',
  `deleteUrl` varchar(255) DEFAULT '',
  `deleteType` varchar(50) DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invId` (`invId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_goods_img
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_invoice`
-- ----------------------------
DROP TABLE IF EXISTS `ci_invoice`;
CREATE TABLE `ci_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buId` smallint(6) DEFAULT '0' COMMENT '供應商ID',
  `billNo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單據編號',
  `uid` smallint(6) DEFAULT '0',
  `userName` varchar(50) DEFAULT '' COMMENT '制單人',
  `transType` int(11) DEFAULT '0' COMMENT '150501購貨 150502退貨 150601銷售 150602退銷 150706其他入庫',
  `totalAmount` double DEFAULT '0' COMMENT '購貨總金額',
  `amount` double DEFAULT '0' COMMENT '折扣後金額',
  `rpAmount` double DEFAULT '0' COMMENT '本次付款',
  `billDate` date DEFAULT NULL COMMENT '單據日期',
  `description` varchar(255) DEFAULT '' COMMENT '備註',
  `arrears` double DEFAULT '0' COMMENT '本次欠款',
  `disRate` double DEFAULT '0' COMMENT '折扣率',
  `disAmount` double DEFAULT '0' COMMENT '折扣金額',
  `totalQty` double DEFAULT '0' COMMENT '總數量',
  `totalArrears` double DEFAULT '0',
  `billStatus` tinyint(1) DEFAULT '0' COMMENT '訂單狀態 ',
  `checkName` varchar(50) DEFAULT '' COMMENT '採購單審覈人',
  `totalTax` double DEFAULT '0',
  `totalTaxAmount` double DEFAULT '0',
  `createTime` datetime DEFAULT NULL,
  `checked` tinyint(1) DEFAULT '0' COMMENT '採購單狀態',
  `accId` tinyint(4) DEFAULT '0' COMMENT '結算賬戶ID',
  `billType` varchar(20) DEFAULT '' COMMENT 'PO採購訂單 OI其他入庫 PUR採購入庫 BAL初期餘額',
  `modifyTime` datetime DEFAULT NULL COMMENT '更新時間',
  `hxStateCode` tinyint(4) DEFAULT '0' COMMENT '0未付款  1部分付款  2全部付款',
  `transTypeName` varchar(20) DEFAULT '',
  `totalDiscount` double DEFAULT '0',
  `salesId` smallint(6) DEFAULT '0' COMMENT '銷售人員ID',
  `customerFree` double DEFAULT '0' COMMENT '客戶承擔費用',
  `hxAmount` double DEFAULT '0' COMMENT '本次覈銷金額',
  `payment` double DEFAULT '0' COMMENT '本次預收款',
  `discount` double DEFAULT '0' COMMENT '整單折扣',
  `srcOrderNo` varchar(255) DEFAULT '' COMMENT '訂單編號',
  `srcOrderId` int(11) DEFAULT '0',
  `postData` text COMMENT '提交訂單明細 ',
  `locationId` varchar(255) DEFAULT '',
  `inLocationId` varchar(255) DEFAULT '' COMMENT '調入倉庫ID多個,分割',
  `outLocationId` varchar(255) DEFAULT '' COMMENT '調出倉庫ID多個,分割',
  `paySettacctId` varchar(255) DEFAULT '',
  `recSettacctId` varchar(255) DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '1刪除  0正常',
  `serialno` text COMMENT '序列號',
  `udf01` varchar(255) DEFAULT '',
  `udf02` varchar(255) DEFAULT '',
  `udf03` varchar(255) DEFAULT '',
  `udf04` varchar(255) DEFAULT '',
  `udf05` varchar(255) DEFAULT '',
  `udf06` text,
  `udf07` text,
  `udf08` text,
  PRIMARY KEY (`id`),
  KEY `accId` (`accId`),
  KEY `buId` (`buId`),
  KEY `salesId` (`salesId`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_invoice_img`
-- ----------------------------
DROP TABLE IF EXISTS `ci_invoice_img`;
CREATE TABLE `ci_invoice_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '名稱',
  `billNo` varchar(50) DEFAULT '',
  `type` varchar(100) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `thumbnailUrl` varchar(255) DEFAULT '',
  `size` int(11) DEFAULT '0',
  `deleteUrl` varchar(255) DEFAULT '',
  `deleteType` varchar(50) DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invId` (`billNo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_invoice_img
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_invoice_info`
-- ----------------------------
DROP TABLE IF EXISTS `ci_invoice_info`;
CREATE TABLE `ci_invoice_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '關聯ID',
  `buId` smallint(6) DEFAULT '0' COMMENT '供應商ID',
  `billNo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單據編號',
  `transType` int(11) DEFAULT '0' COMMENT '150501採購 150502退貨',
  `amount` double DEFAULT '0' COMMENT '購貨金額',
  `billDate` date DEFAULT NULL COMMENT '單據日期',
  `serialno` text COMMENT '序列號',
  `description` varchar(255) DEFAULT '' COMMENT '備註',
  `invId` int(11) DEFAULT '0' COMMENT '商品ID',
  `price` double DEFAULT '0' COMMENT '單價',
  `deduction` double DEFAULT '0' COMMENT '折扣額',
  `discountRate` double DEFAULT '0' COMMENT '折扣率',
  `qty` double DEFAULT '0' COMMENT '數量',
  `locationId` smallint(6) DEFAULT '0',
  `tax` double DEFAULT '0',
  `taxRate` double DEFAULT '0',
  `taxAmount` double DEFAULT '0',
  `unitId` smallint(6) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `skuId` int(11) DEFAULT '0',
  `entryId` tinyint(1) DEFAULT '1' COMMENT '區分調撥單  進和出',
  `transTypeName` varchar(25) DEFAULT '',
  `srcOrderEntryId` int(11) DEFAULT '0',
  `srcOrderId` int(11) DEFAULT '0',
  `srcOrderNo` varchar(25) DEFAULT '',
  `billType` varchar(20) DEFAULT '',
  `salesId` smallint(6) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '1刪除 0正常',
  `srcDopey` varchar(255) DEFAULT '',
  `srcDopeyName` varchar(255) DEFAULT '',
  `udf01` varchar(255) DEFAULT '',
  `udf02` varchar(255) DEFAULT '',
  `udf03` varchar(255) DEFAULT '',
  `udf04` varchar(255) DEFAULT '',
  `udf05` varchar(255) DEFAULT '',
  `udf06` text,
  `udf07` text,
  `udf08` text,
  PRIMARY KEY (`id`),
  KEY `type` (`transType`),
  KEY `billdate` (`billDate`),
  KEY `invId` (`invId`) USING BTREE,
  KEY `transType` (`transType`),
  KEY `iid` (`iid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_invoice_info
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_invoice_type`
-- ----------------------------
DROP TABLE IF EXISTS `ci_invoice_type`;
CREATE TABLE `ci_invoice_type` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '名稱',
  `inout` tinyint(1) DEFAULT '1' COMMENT '1 入庫  -1出庫',
  `status` tinyint(1) DEFAULT '1',
  `type` varchar(10) DEFAULT '',
  `default` tinyint(1) DEFAULT '0',
  `number` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_invoice_type
-- ----------------------------
INSERT INTO `ci_invoice_type` VALUES ('1', '其他入庫', '1', '1', 'in', '1', '150706');
INSERT INTO `ci_invoice_type` VALUES ('2', '盤盈', '1', '1', 'in', '0', '150701');
INSERT INTO `ci_invoice_type` VALUES ('3', '其他出庫', '-1', '1', 'out', '1', '150806');
INSERT INTO `ci_invoice_type` VALUES ('4', '盤虧', '-1', '1', 'out', '0', '150801');

-- ----------------------------
-- Table structure for `ci_log`
-- ----------------------------
DROP TABLE IF EXISTS `ci_log`;
CREATE TABLE `ci_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` smallint(6) DEFAULT '0' COMMENT '使用者ID',
  `ip` varchar(25) DEFAULT '',
  `name` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '姓名',
  `log` text COMMENT '日誌內容',
  `type` tinyint(1) DEFAULT '1' COMMENT ' ',
  `loginName` varchar(50) DEFAULT '' COMMENT '使用者名稱',
  `modifyTime` datetime DEFAULT NULL COMMENT '寫入日期',
  `operateTypeName` varchar(50) DEFAULT '',
  `adddate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `adddate` (`adddate`)
) ENGINE=InnoDB AUTO_INCREMENT=1392 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_log
-- ----------------------------
INSERT INTO `ci_log` VALUES ('1380', null, '::1', null, '登陸成功 使用者名稱：admin', '1', null, '2015-12-17 18:08:40', '', '2015-12-17');
INSERT INTO `ci_log` VALUES ('1381', null, '::1', null, '登陸成功 使用者名稱：admin', '1', null, '2015-12-17 18:09:19', '', '2015-12-17');
INSERT INTO `ci_log` VALUES ('1382', '1', '::1', '小陽', '密碼修改成功 UID：1 真實姓名改為：模板俱樂部', '1', 'admin', '2015-12-17 18:09:43', '', '2015-12-17');
INSERT INTO `ci_log` VALUES ('1383', null, '::1', null, '登陸成功 使用者名稱：admin', '1', null, '2015-12-17 18:09:51', '', '2015-12-17');
INSERT INTO `ci_log` VALUES ('1384', '1', '::1', '模板俱樂部', '系統設定成功', '1', 'admin', '2015-12-17 18:10:30', '', '2015-12-17');
INSERT INTO `ci_log` VALUES ('1385', null, '127.0.0.1', null, '登陸成功 使用者名稱：admin', '1', null, '2021-04-29 16:27:36', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1386', '1', '127.0.0.1', 'CI科技', '切換面板：blue', '1', 'admin', '2021-04-29 16:28:16', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1387', '1', '127.0.0.1', 'CI科技', '切換面板：green', '1', 'admin', '2021-04-29 16:28:19', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1388', '1', '127.0.0.1', 'CI科技', '切換面板：default', '1', 'admin', '2021-04-29 16:28:21', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1389', '1', '127.0.0.1', 'CI科技', '切換面板：blue', '1', 'admin', '2021-04-29 16:28:23', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1390', '1', '127.0.0.1', 'CI科技', '切換面板：default', '1', 'admin', '2021-04-29 16:28:25', '', '2021-04-29');
INSERT INTO `ci_log` VALUES ('1391', null, '127.0.0.1', null, '登陸成功 使用者名稱：admin', '1', null, '2021-04-29 16:29:00', '', '2021-04-29');

-- ----------------------------
-- Table structure for `ci_menu`
-- ----------------------------
DROP TABLE IF EXISTS `ci_menu`;
CREATE TABLE `ci_menu` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `parentId` smallint(5) DEFAULT '0' COMMENT '上級欄目ID',
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目路徑',
  `level` tinyint(2) DEFAULT '1' COMMENT '層次',
  `ordnum` smallint(6) DEFAULT '0' COMMENT '排序',
  `module` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `typeNumber` varchar(25) COLLATE utf8_unicode_ci DEFAULT '',
  `detail` tinyint(1) DEFAULT '1',
  `sortIndex` smallint(6) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `parentId` (`parentId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_menu
-- ----------------------------
INSERT INTO `ci_menu` VALUES ('1', '購貨單', '0', '1', '1', '99', 'PU_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('2', '新增', '1', '1,2', '2', '99', 'PU_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('3', '修改', '1', '1,3', '2', '99', 'PU_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('4', '刪除', '1', '1,4', '2', '99', 'PU_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('5', '導出', '1', '1,5', '2', '99', 'PU_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('6', '銷貨單', '0', '6', '1', '99', 'SA_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('7', '新增', '6', '6,7', '2', '99', 'SA_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('8', '修改', '6', '6,8', '2', '99', 'SA_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('9', '刪除', '6', '6,9', '2', '99', 'SA_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('10', '導出', '6', '6,10', '2', '99', 'SA_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('11', '盤點', '0', '11', '1', '99', 'PD_GENPD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('12', '產生盤點記錄', '11', '11,12', '2', '99', 'PD_GENPD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('13', '導出', '11', '11,13', '2', '99', 'PD_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('14', '其他入庫單', '0', '14', '1', '99', 'IO_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('15', '新增', '14', '14,15', '2', '99', 'IO_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('16', '修改', '14', '14,16', '2', '99', 'IO_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('17', '刪除', '14', '14,17', '2', '99', 'IO_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('18', '其他出庫單', '0', '18', '1', '99', 'OO_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('19', '新增', '18', '18,19', '2', '99', 'OO_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('20', '修改', '18', '18,20', '2', '99', 'OO_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('21', '刪除', '18', '18,21', '2', '99', 'OO_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('22', '採購明細表', '0', '22', '1', '99', 'PUREOORTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('23', '導出', '22', '22,23', '2', '99', 'PUREOORTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('24', '列印', '22', '22,24', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('25', '採購彙總表（按商品）', '0', '25', '1', '99', 'PUREPORTINV_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('26', '導出', '25', '25,26', '2', '99', 'PUREPORTINV_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('27', '列印', '25', '25,27', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('28', '採購彙總表（按供應商）', '0', '28', '1', '99', 'PUREPORTPUR_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('29', '導出', '28', '28,29', '2', '99', 'PUREPORTPUR_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('30', '列印', '28', '28,30', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('31', '銷售明細表', '0', '31', '1', '99', 'SAREPORTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('32', '導出', '31', '31,32', '2', '99', 'SAREPORTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('33', '列印', '31', '31,33', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('34', '銷售彙總表（按商品）', '0', '34', '1', '99', 'SAREPORTINV_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('35', '導出', '34', '34,35', '2', '99', 'SAREPORTINV_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('36', '列印', '34', '34,36', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('37', '銷售彙總表（按客戶）', '0', '37', '1', '99', 'SAREPORTBU_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('38', '導出', '37', '37,38', '2', '99', 'SAREPORTBU_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('39', '列印', '37', '37,39', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('40', '商品庫存餘額表', '0', '40', '1', '99', 'InvBalanceReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('41', '導出', '40', '40,41', '2', '99', 'InvBalanceReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('42', '列印', '40', '40,42', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('43', '商品收發明細表', '0', '43', '1', '99', 'DeliverDetailReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('44', '導出', '43', '43,44', '2', '99', 'DeliverDetailReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('45', '列印', '43', '43,45', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('46', '商品收發彙總表', '0', '46', '1', '99', 'DeliverSummaryReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('47', '導出', '46', '46,47', '2', '99', 'DeliverSummaryReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('48', '列印', '46', '46,48', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('49', '往來單位欠款表', '0', '49', '1', '99', 'ContactDebtReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('50', '導出', '49', '49,50', '2', '99', 'ContactDebtReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('51', '列印', '49', '49,51', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('52', '應付賬款明細表', '0', '52', '1', '99', 'PAYMENTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('53', '導出', '52', '52,53', '2', '99', 'PAYMENTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('54', '列印', '52', '52,54', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('55', '應收賬款明細表', '0', '55', '1', '99', 'RECEIPTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('56', '導出', '55', '55,56', '2', '99', 'RECEIPTDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('57', '列印', '55', '55,57', '2', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('58', '客戶管理', '0', '58', '1', '99', 'BU_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('59', '新增', '58', '58,59', '2', '99', 'BU_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('60', '修改', '58', '58,60', '2', '99', 'BU_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('61', '刪除', '58', '58,61', '2', '99', 'BU_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('62', '導出', '58', '58,62', '2', '99', 'BU_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('63', '供應商管理', '0', '63', '1', '99', 'PUR_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('64', '新增', '63', '63,64', '2', '99', 'PUR_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('65', '修改', '63', '63,65', '2', '99', 'PUR_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('66', '刪除', '63', '63,66', '2', '99', 'PUR_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('67', '導出', '63', '63,67', '2', '99', 'PUR_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('68', '商品管理', '0', '68', '1', '99', 'INVENTORY_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('69', '新增', '68', '68,69', '2', '99', 'INVENTORY_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('70', '修改', '68', '68,70', '2', '99', 'INVENTORY_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('71', '刪除', '68', '68,71', '2', '99', 'INVENTORY_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('72', '導出', '68', '68,72', '2', '99', 'INVENTORY_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('73', '客戶類別', '0', '73', '1', '99', 'BUTYPE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('74', '新增', '73', '73,74', '2', '99', 'BUTYPE_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('75', '修改', '73', '73,75', '2', '99', 'BUTYPE_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('76', '刪除', '73', '73,76', '2', '99', 'BUTYPE_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('77', '計量單位', '0', '77', '1', '99', 'UNIT_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('78', '新增', '77', '77,78', '2', '99', 'UNIT_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('79', '修改', '77', '77,79', '2', '99', 'UNIT_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('80', '刪除', '77', '77,80', '2', '99', 'UNIT_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('81', '系統參數', '0', '81', '1', '99', 'PARAMETER', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('82', '許可權設定', '0', '82', '1', '99', 'AUTHORITY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('83', '操作日誌', '0', '83', '1', '99', 'OPERATE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('84', '數據備份', '0', '84', '1', '99', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('85', '列印', '1', '1,85', '2', '99', 'PU_PRINT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('86', '審覈', '1', '1,86', '2', '0', 'PU_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('87', '反審覈', '1', '1,87', '2', '0', 'PU_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('88', '列印', '6', '6,88', '2', '0', 'SA_PRINT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('89', '審覈', '6', '6,89', '2', '0', 'SA_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('90', '反審覈', '6', '6,90', '2', '0', 'SA_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('91', '禁用', '58', '58,91', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('92', '啟用', '58', '58,92', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('93', '禁用', '63', '63,93', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('94', '啟用', '63', '63,94', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('95', '禁用', '68', '68,95', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('96', '啟用', '68', '68,96', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('97', '職員管理', '0', '97', '1', '0', 'STAFF_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('98', '賬號管理', '0', '98', '1', '0', 'SettAcct_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('99', '匯入', '11', '11,99', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('100', '審覈', '14', '14,100', '2', '0', 'IO_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('101', '反審覈', '14', '14,101', '2', '0', 'IO_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('102', '導出', '14', '14,102', '2', '0', 'IO_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('103', '審覈', '18', '18,103', '2', '0', 'OO_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('104', '反審覈', '18', '18,104', '2', '0', 'OO_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('105', '導出', '18', '18,105', '2', '0', 'OO_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('106', '現金銀行報表', '0', '106', '1', '0', 'SettAcctReport_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('107', '列印', '106', '106,107', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('108', '導出', '106', '106,108', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('109', '客戶對賬單', '0', '109', '1', '0', 'CUSTOMERBALANCE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('110', '列印', '109', '109,110', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('111', '導出', '109', '109,111', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('112', '供應商對賬單', '0', '112', '1', '0', 'SUPPLIERBALANCE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('113', '列印', '112', '112,113', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('114', '導出', '112', '112,114', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('115', '其他收支明細表', '0', '115', '1', '0', 'ORIDETAIL_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('116', '列印', '115', '115,116', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('117', '導出', '115', '115,117', '2', '0', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('118', '新增', '97', '97,118', '2', '0', 'INVLOCTION_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('119', '修改', '97', '97,119', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('120', '刪除', '97', '97,120', '2', '0', 'INVLOCTION_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('121', '新增', '98', '98,121', '2', '0', 'SettAcct_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('122', '修改', '98', '98,122', '2', '0', 'SettAcct_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('123', '刪除', '98', '98,123', '2', '0', 'SettAcct_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('124', '收款單', '0', '124', '1', '0', 'RECEIPT_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('125', '新增', '124', '124,125', '2', '0', 'RECEIPT_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('126', '修改', '124', '124,126', '2', '0', 'RECEIPT_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('127', '刪除', '124', '124,127', '2', '0', 'RECEIPT_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('128', '導出', '124', '124,128', '2', '0', 'RECEIPT_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('129', '付款單', '0', '129', '1', '0', 'PAYMENT_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('130', '新增', '129', '129,130', '2', '0', 'PAYMENT_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('131', '修改', '129', '129,131', '2', '0', 'PAYMENT_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('132', '刪除', '129', '129,132', '2', '0', 'PAYMENT_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('133', '導出', '129', '129,133', '2', '0', 'PAYMENT_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('134', '其他收入單', '0', '134', '1', '0', 'QTSR_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('135', '新增', '134', '134,135', '2', '0', 'QTSR_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('136', '修改', '134', '134,136', '2', '0', 'QTSR_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('137', '刪除', '134', '134,137', '2', '0', 'QTSR_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('138', '導出', '134', '134,138', '2', '0', 'QTSR_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('139', '其他支出單', '0', '139', '1', '0', 'QTZC_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('140', '新增', '139', '139,140', '2', '0', 'QTZC_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('141', '修改', '139', '139,141', '2', '0', 'QTZC_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('142', '刪除', '139', '139,142', '2', '0', 'QTZC_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('143', '導出', '139', '139,143', '2', '0', 'QTZC_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('144', '調撥單', '0', '144', '1', '0', 'TF_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('145', '新增', '144', '144,145', '2', '0', 'TF_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('146', '修改', '144', '144,146', '2', '0', 'TF_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('147', '刪除', '144', '144,147', '2', '0', 'TF_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('148', '導出', '144', '144,148', '2', '0', 'TF_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('149', '重新初始化', '0', '149', '1', '0', '', '0', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('151', '成本調整單', '0', '151', '1', '0', 'CADJ_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('152', '新增', '151', '151,152', '2', '0', 'CADJ_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('153', '修改', '151', '151,153', '2', '0', 'CADJ_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('154', '刪除', '151', '151,154', '2', '0', 'CADJ_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('155', '倉庫管理', '0', '155', '1', '0', 'INVLOCTION_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('156', '新增', '155', '155,156', '2', '0', 'INVLOCTION_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('157', '修改', '155', '155,157', '2', '0', 'INVLOCTION_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('158', '刪除', '155', '155,158', '2', '0', 'INVLOCTION_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('159', '結算方式', '0', '159', '1', '0', 'Assist_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('160', '新增', '159', '159,160', '2', '0', 'Assist_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('161', '修改', '159', '159,161', '2', '0', 'Assist_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('162', '刪除', '159', '159,162', '2', '0', 'Assist_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('163', '供應商類別', '0', '163', '1', '0', 'SUPPLYTYPE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('164', '新增', '163', '163,164', '2', '0', 'SUPPLYTYPE_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('165', '修改', '163', '163,165', '2', '0', 'SUPPLYTYPE_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('166', '刪除', '163', '163,166', '2', '0', 'SUPPLYTYPE_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('167', '商品類別', '0', '167', '1', '0', 'TRADETYPE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('168', '新增', '167', '167,168', '2', '0', 'TRADETYPE_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('169', '修改', '167', '167,169', '2', '0', 'TRADETYPE_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('170', '刪除', '167', '167,170', '2', '0', 'TRADETYPE_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('171', '支出類別', '0', '171', '1', '0', 'PACCTTYPE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('172', '新增', '171', '171,172', '2', '0', 'PACCTTYPE_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('173', '修改', '171', '171,173', '2', '0', 'PACCTTYPE_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('174', '刪除', '171', '171,174', '2', '0', 'PACCTTYPE_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('175', '收入類別', '0', '175', '1', '0', 'RACCTTYPE_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('176', '新增', '175', '175,176', '2', '0', 'RACCTTYPE_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('177', '修改', '175', '175,177', '2', '0', 'RACCTTYPE_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('178', '刪除', '175', '175,178', '2', '0', 'RACCTTYPE_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('179', '列印', '144', '144,179', '2', '0', 'TF_PRINT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('180', '採購訂單', '0', '180', '1', '0', 'PO_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('181', '新增', '180', '180,181', '2', '0', 'PO_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('182', '修改', '180', '180,182', '2', '0', 'PO_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('183', '刪除', '180', '180,183', '2', '0', 'PO_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('184', '導出', '180', '180,184', '2', '0', 'PO_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('185', '列印', '180', '180,185', '2', '0', 'PO_PRINT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('186', '審覈', '180', '180,186', '2', '0', 'PO_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('187', '反審覈', '180', '180,187', '2', '0', 'PO_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('188', '銷售訂單', '0', '188', '1', '0', 'SO_QUERY', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('189', '新增', '188', '188,189', '2', '0', 'SO_ADD', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('190', '修改', '188', '188,190', '2', '0', 'SO_UPDATE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('191', '刪除', '188', '188,191', '2', '0', 'SO_DELETE', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('192', '導出', '188', '188,192', '2', '0', 'SO_EXPORT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('193', '列印', '188', '188,193', '2', '0', 'SO_PRINT', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('194', '審覈', '188', '188,194', '2', '0', 'SO_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('195', '反審覈', '188', '188,195', '2', '0', 'SO_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('196', '審覈', '144', '144,196', '2', '0', 'TF_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('197', '反審覈', '144', '144,197', '2', '0', 'TF_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('198', '審覈', '124', '124,198', '2', '0', 'RECEIPT_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('199', '反審覈', '124', '124,199', '2', '0', 'RECEIPT_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('200', '審覈', '129', '129,200', '2', '0', 'PAYMENT_CHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('201', '反審覈', '129', '129,201', '2', '0', 'PAYMENT_UNCHECK', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('202', '庫存預警', '0', '202', '1', '0', 'INVENTORY_WARNING', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('203', '合同上傳', '1', '1,203', '2', '99', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('204', '合同檢視', '1', '1,204', '2', '99', '', '1', 'trade', '1', '0', '0', '');
INSERT INTO `ci_menu` VALUES ('205', '合同刪除', '1', '1,205', '2', '99', '', '1', 'trade', '1', '0', '0', '');

-- ----------------------------
-- Table structure for `ci_options`
-- ----------------------------
DROP TABLE IF EXISTS `ci_options`;
CREATE TABLE `ci_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_options
-- ----------------------------
INSERT INTO `ci_options` VALUES ('1', 'system', 'a:10:{s:11:\"companyName\";s:24:\"優福數碼ERP進銷存\";s:11:\"companyAddr\";s:24:\"優福數碼ERP進銷存\";s:5:\"phone\";s:11:\"17701030513\";s:3:\"fax\";s:11:\"17701030513\";s:8:\"postcode\";s:11:\"17701030513\";s:9:\"qtyPlaces\";s:1:\"2\";s:11:\"pricePlaces\";s:1:\"2\";s:12:\"amountPlaces\";s:1:\"2\";s:10:\"valMethods\";s:13:\"movingAverage\";s:18:\"requiredCheckStore\";s:1:\"1\";}', 'yes');
INSERT INTO `ci_options` VALUES ('2', 'sales', 's:3893:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":60,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"nameExt\":\"<span id=\\\"barCodeInsert\\\">掃瞄槍錄入</span>\",\"width\":300,\"classes\":\"goods\",\"editable\":true,\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"skuName\",\"label\":\"屬性\",\"width\":100,\"classes\":\"ui-ellipsis\",\"hidden\":true,\"defLabel\":\"屬性\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":80,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"單位\"},{\"name\":\"unitId\",\"label\":\"單位Id\",\"hidden\":true,\"defLabel\":\"單位Id\",\"defhidden\":true},{\"name\":\"locationName\",\"label\":\"倉庫\",\"nameExt\":\"<small id=\\\"batchStorage\\\">(批量)</small>\",\"width\":100,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"倉庫\"},{\"name\":\"batch\",\"label\":\"批次\",\"width\":90,\"classes\":\"ui-ellipsis batch\",\"hidden\":true,\"title\":false,\"editable\":true,\"align\":\"left\",\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"批次\",\"defhidden\":true},{\"name\":\"prodDate\",\"label\":\"生產日期\",\"width\":90,\"hidden\":true,\"title\":false,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{},\"defLabel\":\"生產日期\",\"defhidden\":true},{\"name\":\"safeDays\",\"label\":\"保質期(天)\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"保質期(天)\",\"defhidden\":true},{\"name\":\"validDate\",\"label\":\"有效期至\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"有效期至\",\"defhidden\":true},{\"name\":\"qty\",\"label\":\"數量\",\"width\":80,\"align\":\"right\",\"formatter\":\"number\",\"formatoptions\":{\"decimalPlaces\":1},\"editable\":true,\"defLabel\":\"數量\"},{\"name\":\"price\",\"label\":\"銷售單價\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":1},\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"銷售單價\",\"defhidden\":false},{\"name\":\"discountRate\",\"label\":\"折扣率(%)\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"integer\",\"editable\":true,\"defLabel\":\"折扣率(%)\",\"defhidden\":false},{\"name\":\"deduction\",\"label\":\"折扣額\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"折扣額\",\"defhidden\":false},{\"name\":\"amount\",\"label\":\"銷售金額\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"銷售金額\",\"defhidden\":false},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"},{\"name\":\"srcOrderEntryId\",\"label\":\"源單分錄ID\",\"width\":0,\"hidden\":true,\"defLabel\":\"源單分錄ID\",\"defhidden\":true},{\"name\":\"srcOrderId\",\"label\":\"源單ID\",\"width\":0,\"hidden\":true,\"defLabel\":\"源單ID\",\"defhidden\":true},{\"name\":\"srcOrderNo\",\"label\":\"源單號\",\"width\":120,\"fixed\":true,\"hidden\":true,\"defLabel\":\"源單號\",\"defhidden\":true}],\"colModel\":[[\"operating\",\" \",null,60],[\"goods\",\"商品\",null,300],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"price\",\"銷售單價\",false,100],[\"discountRate\",\"折扣率(%)\",false,70],[\"deduction\",\"折扣額\",false,70],[\"amount\",\"銷售金額\",false,100],[\"description\",\"備註\",null,150],[\"srcOrderEntryId\",\"源單分錄ID\",true,0],[\"srcOrderId\",\"源單ID\",true,0],[\"srcOrderNo\",\"源單號\",true,120]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('3', 'purchase', 's:767:\"{\"grids\":{\"grid\":{\"colModel\":[[\"operating\",\" \",null,60],[\"goods\",\"商品\",null,260],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"price\",\"購貨單價\",false,100],[\"discountRate\",\"折扣率(%)\",false,70],[\"deduction\",\"折扣額\",false,70],[\"amount\",\"購貨金額\",false,100],[\"description\",\"備註\",null,150],[\"srcOrderEntryId\",\"源單分錄ID\",true,0],[\"srcOrderId\",\"源單ID\",true,0],[\"srcOrderNo\",\"源單號\",false,120]],\"isReg\":true}},\"curTime\":1448007624000,\"modifyTime\":1448007624000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('4', 'transfers', 's:2702:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":40,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"width\":318,\"title\":false,\"classes\":\"goods\",\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"skuName\",\"label\":\"屬性\",\"width\":100,\"classes\":\"ui-ellipsis\",\"hidden\":true,\"defLabel\":\"屬性\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":80,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"單位\"},{\"name\":\"unitId\",\"label\":\"單位Id\",\"hidden\":true,\"defLabel\":\"單位Id\",\"defhidden\":true},{\"name\":\"batch\",\"label\":\"批次\",\"width\":90,\"classes\":\"ui-ellipsis batch\",\"hidden\":true,\"title\":false,\"editable\":true,\"align\":\"left\",\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"批次\",\"defhidden\":true},{\"name\":\"prodDate\",\"label\":\"生產日期\",\"width\":90,\"hidden\":true,\"title\":false,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{},\"defLabel\":\"生產日期\",\"defhidden\":true},{\"name\":\"safeDays\",\"label\":\"保質期(天)\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"保質期(天)\",\"defhidden\":true},{\"name\":\"validDate\",\"label\":\"有效期至\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"有效期至\",\"defhidden\":true},{\"name\":\"qty\",\"label\":\"數量\",\"width\":80,\"align\":\"right\",\"formatter\":\"number\",\"formatoptions\":{\"decimalPlaces\":1},\"editable\":true,\"defLabel\":\"數量\"},{\"name\":\"outLocationName\",\"label\":\"調出倉庫\",\"nameExt\":\"<small id=\\\"batch-storageA\\\">(批量)</small>\",\"sortable\":false,\"width\":100,\"title\":true,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"調出倉庫\"},{\"name\":\"inLocationName\",\"label\":\"調入倉庫\",\"nameExt\":\"<small id=\\\"batch-storageB\\\">(批量)</small>\",\"width\":100,\"title\":true,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"調入倉庫\"},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"}],\"colModel\":[[\"operating\",\" \",null,40],[\"goods\",\"商品\",null,318],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"outLocationName\",\"調出倉庫\",null,100],[\"inLocationName\",\"調入倉庫\",null,100],[\"description\",\"備註\",null,150]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('5', 'otherWarehouse', 's:2906:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":40,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"width\":320,\"title\":true,\"classes\":\"goods\",\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"skuName\",\"label\":\"屬性\",\"width\":100,\"classes\":\"ui-ellipsis\",\"hidden\":true,\"defLabel\":\"屬性\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":80,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"單位\"},{\"name\":\"unitId\",\"label\":\"單位Id\",\"hidden\":true,\"defLabel\":\"單位Id\",\"defhidden\":true},{\"name\":\"locationName\",\"label\":\"倉庫\",\"nameExt\":\"<small id=\\\"batchStorage\\\">(批量)</small>\",\"width\":100,\"title\":true,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"倉庫\"},{\"name\":\"batch\",\"label\":\"批次\",\"width\":90,\"classes\":\"ui-ellipsis batch\",\"hidden\":true,\"title\":false,\"editable\":true,\"align\":\"left\",\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"批次\",\"defhidden\":true},{\"name\":\"prodDate\",\"label\":\"生產日期\",\"width\":90,\"hidden\":true,\"title\":false,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{},\"defLabel\":\"生產日期\",\"defhidden\":true},{\"name\":\"safeDays\",\"label\":\"保質期(天)\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"保質期(天)\",\"defhidden\":true},{\"name\":\"validDate\",\"label\":\"有效期至\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"有效期至\",\"defhidden\":true},{\"name\":\"qty\",\"label\":\"數量\",\"width\":80,\"align\":\"right\",\"formatter\":\"number\",\"formatoptions\":{\"decimalPlaces\":1},\"editable\":true,\"defLabel\":\"數量\"},{\"name\":\"price\",\"label\":\"入庫單價\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":1},\"editable\":true,\"defLabel\":\"入庫單價\",\"defhidden\":false},{\"name\":\"amount\",\"label\":\"入庫金額\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"入庫金額\",\"defhidden\":false},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"}],\"colModel\":[[\"operating\",\" \",null,40],[\"goods\",\"商品\",null,320],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"price\",\"入庫單價\",false,100],[\"amount\",\"入庫金額\",false,100],[\"description\",\"備註\",null,150]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('6', 'adjustment', 's:1337:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":40,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"width\":320,\"title\":true,\"classes\":\"goods\",\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis disableSku\"},\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":60,\"defLabel\":\"單位\"},{\"name\":\"amount\",\"label\":\"調整金額\",\"hidden\":false,\"width\":100,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"調整金額\",\"defhidden\":false},{\"name\":\"locationName\",\"label\":\"倉庫<small id=\\\"batchStorage\\\">(批量)</small>\",\"width\":100,\"title\":true,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"倉庫<small id=\\\"batchStorage\\\">(批量)</small>\"},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"}],\"colModel\":[[\"operating\",\" \",null,40],[\"goods\",\"商品\",null,320],[\"skuId\",\"屬性ID\",true,null],[\"mainUnit\",\"單位\",null,60],[\"amount\",\"調整金額\",false,100],[\"locationName\",\"倉庫<small id=\\\"batchStorage\\\">(批量)</small>\",null,100],[\"description\",\"備註\",null,150]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('7', 'purchaseBack', 'b:0;', 'yes');
INSERT INTO `ci_options` VALUES ('8', 'salesBack', 's:3893:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":60,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"nameExt\":\"<span id=\\\"barCodeInsert\\\">掃瞄槍錄入</span>\",\"width\":300,\"classes\":\"goods\",\"editable\":true,\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"skuName\",\"label\":\"屬性\",\"width\":100,\"classes\":\"ui-ellipsis\",\"hidden\":true,\"defLabel\":\"屬性\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":80,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"單位\"},{\"name\":\"unitId\",\"label\":\"單位Id\",\"hidden\":true,\"defLabel\":\"單位Id\",\"defhidden\":true},{\"name\":\"locationName\",\"label\":\"倉庫\",\"nameExt\":\"<small id=\\\"batchStorage\\\">(批量)</small>\",\"width\":100,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"倉庫\"},{\"name\":\"batch\",\"label\":\"批次\",\"width\":90,\"classes\":\"ui-ellipsis batch\",\"hidden\":true,\"title\":false,\"editable\":true,\"align\":\"left\",\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-ellipsis\"},\"defLabel\":\"批次\",\"defhidden\":true},{\"name\":\"prodDate\",\"label\":\"生產日期\",\"width\":90,\"hidden\":true,\"title\":false,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{},\"defLabel\":\"生產日期\",\"defhidden\":true},{\"name\":\"safeDays\",\"label\":\"保質期(天)\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"保質期(天)\",\"defhidden\":true},{\"name\":\"validDate\",\"label\":\"有效期至\",\"width\":90,\"hidden\":true,\"title\":false,\"align\":\"left\",\"defLabel\":\"有效期至\",\"defhidden\":true},{\"name\":\"qty\",\"label\":\"數量\",\"width\":80,\"align\":\"right\",\"formatter\":\"number\",\"formatoptions\":{\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"數量\"},{\"name\":\"price\",\"label\":\"銷售單價\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"銷售單價\",\"defhidden\":false},{\"name\":\"discountRate\",\"label\":\"折扣率(%)\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"integer\",\"editable\":true,\"defLabel\":\"折扣率(%)\",\"defhidden\":false},{\"name\":\"deduction\",\"label\":\"折扣額\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"折扣額\",\"defhidden\":false},{\"name\":\"amount\",\"label\":\"銷售金額\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"銷售金額\",\"defhidden\":false},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"},{\"name\":\"srcOrderEntryId\",\"label\":\"源單分錄ID\",\"width\":0,\"hidden\":true,\"defLabel\":\"源單分錄ID\",\"defhidden\":true},{\"name\":\"srcOrderId\",\"label\":\"源單ID\",\"width\":0,\"hidden\":true,\"defLabel\":\"源單ID\",\"defhidden\":true},{\"name\":\"srcOrderNo\",\"label\":\"源單號\",\"width\":120,\"fixed\":true,\"hidden\":true,\"defLabel\":\"源單號\",\"defhidden\":true}],\"colModel\":[[\"operating\",\" \",null,60],[\"goods\",\"商品\",null,300],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"price\",\"銷售單價\",false,100],[\"discountRate\",\"折扣率(%)\",false,70],[\"deduction\",\"折扣額\",false,70],[\"amount\",\"銷售金額\",false,100],[\"description\",\"備註\",null,150],[\"srcOrderEntryId\",\"源單分錄ID\",true,0],[\"srcOrderId\",\"源單ID\",true,0],[\"srcOrderNo\",\"源單號\",true,120]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('9', 'otherOutbound', 's:583:\"{\"grids\":{\"grid\":{\"colModel\":[[\"operating\",\" \",null,40],[\"goods\",\"商品\",null,320],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"batch\",\"批次\",true,90],[\"prodDate\",\"生產日期\",true,90],[\"safeDays\",\"保質期(天)\",true,90],[\"validDate\",\"有效期至\",true,90],[\"qty\",\"數量\",null,80],[\"price\",\"出庫單位成本\",false,100],[\"amount\",\"出庫成本\",false,100],[\"description\",\"備註\",null,150]],\"isReg\":true}},\"curTime\":1445235745000,\"modifyTime\":1445235745000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('10', 'purchaseOrder', 's:2682:\"{\"grids\":{\"grid\":{\"defColModel\":[{\"name\":\"operating\",\"label\":\" \",\"width\":60,\"fixed\":true,\"align\":\"center\",\"defLabel\":\" \"},{\"name\":\"goods\",\"label\":\"商品\",\"nameExt\":\"<span id=\\\"barCodeInsert\\\">掃瞄槍錄入</span>\",\"width\":300,\"classes\":\"goods\",\"editable\":true,\"defLabel\":\"商品\"},{\"name\":\"skuId\",\"label\":\"屬性ID\",\"hidden\":true,\"defLabel\":\"屬性ID\",\"defhidden\":true},{\"name\":\"skuName\",\"label\":\"屬性\",\"width\":100,\"classes\":\"ui-ellipsis\",\"hidden\":true,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"屬性\",\"defhidden\":true},{\"name\":\"mainUnit\",\"label\":\"單位\",\"width\":80,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"單位\"},{\"name\":\"unitId\",\"label\":\"單位Id\",\"hidden\":true,\"defLabel\":\"單位Id\",\"defhidden\":true},{\"name\":\"locationName\",\"label\":\"倉庫\",\"nameExt\":\"<small id=\\\"batchStorage\\\">(批量)</small>\",\"width\":100,\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"倉庫\"},{\"name\":\"qty\",\"label\":\"數量\",\"width\":80,\"align\":\"right\",\"formatter\":\"number\",\"formatoptions\":{\"decimalPlaces\":1},\"editable\":true,\"defLabel\":\"數量\"},{\"name\":\"price\",\"label\":\"購貨單價\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":1},\"editable\":true,\"edittype\":\"custom\",\"editoptions\":{\"trigger\":\"ui-icon-triangle-1-s\"},\"defLabel\":\"購貨單價\",\"defhidden\":false},{\"name\":\"discountRate\",\"label\":\"折扣率(%)\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"integer\",\"editable\":true,\"defLabel\":\"折扣率(%)\",\"defhidden\":false},{\"name\":\"deduction\",\"label\":\"折扣額\",\"hidden\":false,\"width\":70,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"折扣額\",\"defhidden\":false},{\"name\":\"amount\",\"label\":\"購貨金額\",\"hidden\":false,\"width\":100,\"fixed\":true,\"align\":\"right\",\"formatter\":\"currency\",\"formatoptions\":{\"showZero\":true,\"decimalPlaces\":2},\"editable\":true,\"defLabel\":\"購貨金額\",\"defhidden\":false},{\"name\":\"description\",\"label\":\"備註\",\"width\":150,\"title\":true,\"editable\":true,\"defLabel\":\"備註\"}],\"colModel\":[[\"operating\",\" \",null,60],[\"goods\",\"商品\",null,300],[\"skuId\",\"屬性ID\",true,null],[\"skuName\",\"屬性\",true,100],[\"mainUnit\",\"單位\",null,80],[\"unitId\",\"單位Id\",true,null],[\"locationName\",\"倉庫\",null,100],[\"qty\",\"數量\",null,80],[\"price\",\"購貨單價\",false,100],[\"discountRate\",\"折扣率(%)\",false,70],[\"deduction\",\"折扣額\",false,70],[\"amount\",\"購貨金額\",false,100],[\"description\",\"備註\",null,150]],\"isReg\":true}}}\";', 'yes');
INSERT INTO `ci_options` VALUES ('11', 'salesOrderList', 's:523:\"{\"grids\":{\"grid\":{\"colModel\":[[\"operating\",\"操作\",null,60],[\"billDate\",\"訂單日期\",null,100],[\"billNo\",\"訂單編號\",null,145],[\"transType\",\"業務類別\",null,100],[\"contactName\",\"客戶\",null,200],[\"totalAmount\",\"金額\",false,100],[\"totalQty\",\"數量\",null,80],[\"billStatusName\",\"訂單狀態\",null,100],[\"userName\",\"制單人\",null,80],[\"checkName\",\"審覈人\",false,80],[\"description\",\"備註\",null,200],[\"disEditable\",\"不可編輯\",null,null]],\"isReg\":true}},\"curTime\":1447057437000,\"modifyTime\":1447057437000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('12', 'puDetailNew', 's:536:\"{\"grids\":{\"grid\":{\"colModel\":[[\"date\",\"採購日期\",null,80],[\"billNo\",\"採購單據號\",null,200],[\"transType\",\"業務類別\",null,60],[\"buName\",\"供應商\",null,100],[\"invNo\",\"商品編號\",null,80],[\"invName\",\"商品名稱\",null,120],[\"spec\",\"規格型號\",null,120],[\"unit\",\"單位\",false,60],[\"location\",\"倉庫\",false,100],[\"qty\",\"數量\",null,100],[\"unitPrice\",\"單價\",false,120],[\"amount\",\"採購金額\",false,120],[\"billId\",\"\",null,0],[\"billType\",\"\",null,0]],\"isReg\":true}},\"curTime\":1440733035000,\"modifyTime\":1440733035000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('13', 'accountPayDetailNew', 'b:0;', 'yes');
INSERT INTO `ci_options` VALUES ('14', 'otherIncomeExpenseDetail', 's:368:\"{\"grids\":{\"grid\":{\"colModel\":[[\"date\",\"日期\",null,150],[\"billNo\",\"單據編號\",null,110],[\"transTypeName\",\"收支類別\",null,110],[\"typeName\",\"收支專案\",null,110],[\"amountIn\",\"收入\",null,120],[\"amountOut\",\"支出\",null,120],[\"contactName\",\"往來單位\",null,110],[\"desc\",\"摘要\",null,110]],\"isReg\":true}},\"curTime\":1440738089000,\"modifyTime\":1440738089000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('15', 'purchaseOrderList', 's:573:\"{\"grids\":{\"grid\":{\"colModel\":[[\"operating\",\"操作\",null,60],[\"billDate\",\"訂單日期\",null,100],[\"billNo\",\"訂單編號\",null,216],[\"transType\",\"業務類別\",null,100],[\"contactName\",\"供應商\",null,200],[\"totalAmount\",\"購貨金額\",false,100],[\"totalQty\",\"數量\",null,80],[\"billStatusName\",\"訂單狀態\",null,100],[\"deliveryDate\",\"交貨日期\",null,100],[\"userName\",\"制單人\",null,80],[\"checkName\",\"審覈人\",false,80],[\"description\",\"備註\",null,200],[\"disEditable\",\"不可編輯\",null,null]],\"isReg\":true}},\"curTime\":1446105838000,\"modifyTime\":1446105838000}\";', 'yes');
INSERT INTO `ci_options` VALUES ('16', 'salesOrder', 'b:0;', 'yes');

-- ----------------------------
-- Table structure for `ci_order`
-- ----------------------------
DROP TABLE IF EXISTS `ci_order`;
CREATE TABLE `ci_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buId` smallint(6) DEFAULT '0' COMMENT '供應商ID',
  `billNo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單據編號',
  `uid` smallint(6) DEFAULT '0',
  `userName` varchar(50) DEFAULT '' COMMENT '制單人',
  `transType` int(11) DEFAULT '0' COMMENT '150501購貨 150502退貨 150601銷售 150602退銷 150706其他入庫',
  `totalAmount` double DEFAULT '0' COMMENT '購貨總金額',
  `amount` double DEFAULT '0' COMMENT '折扣後金額',
  `rpAmount` double DEFAULT '0' COMMENT '本次付款',
  `billDate` date DEFAULT NULL COMMENT '單據日期',
  `description` varchar(100) DEFAULT '' COMMENT '備註',
  `arrears` double DEFAULT '0' COMMENT '本次欠款',
  `disRate` double DEFAULT '0' COMMENT '折扣率',
  `disAmount` double DEFAULT '0' COMMENT '折扣金額',
  `totalQty` double DEFAULT '0' COMMENT '總數量',
  `totalArrears` double DEFAULT '0',
  `billStatus` tinyint(1) DEFAULT '0' COMMENT '訂單狀態 ',
  `checkName` varchar(50) DEFAULT '' COMMENT '採購單審覈人',
  `totalTax` double DEFAULT '0',
  `totalTaxAmount` double DEFAULT '0',
  `checked` tinyint(1) DEFAULT '0' COMMENT '採購單狀態',
  `accId` tinyint(4) DEFAULT '0' COMMENT '結算賬戶ID',
  `billType` varchar(20) DEFAULT '' COMMENT 'PO採購訂單 OI其他入庫 PUR採購入庫 BAL初期餘額',
  `modifyTime` datetime DEFAULT NULL COMMENT '更新時間',
  `hxStateCode` tinyint(4) DEFAULT '0' COMMENT '0未付款  1部分付款  2全部付款',
  `transTypeName` varchar(20) DEFAULT '',
  `totalDiscount` double DEFAULT '0',
  `salesId` smallint(6) DEFAULT '0' COMMENT '銷售人員ID',
  `customerFree` double DEFAULT '0' COMMENT '客戶承擔費用',
  `hxAmount` double DEFAULT '0' COMMENT '本次覈銷金額',
  `hasCheck` double DEFAULT '0' COMMENT '已覈銷',
  `notCheck` double DEFAULT '0' COMMENT '未覈銷',
  `nowCheck` double DEFAULT '0' COMMENT '本次覈銷',
  `payment` double DEFAULT '0' COMMENT '本次預收款',
  `discount` double DEFAULT '0' COMMENT '整單折扣',
  `postData` text COMMENT '提交訂單明細 ',
  `locationId` varchar(255) DEFAULT '',
  `inLocationId` varchar(255) DEFAULT '' COMMENT '調入倉庫ID多個,分割',
  `outLocationId` varchar(255) DEFAULT '' COMMENT '調出倉庫ID多個,分割',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '1刪除  0正常',
  `deliveryDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accId` (`accId`),
  KEY `buId` (`buId`),
  KEY `salesId` (`salesId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_order
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_order_info`
-- ----------------------------
DROP TABLE IF EXISTS `ci_order_info`;
CREATE TABLE `ci_order_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '關聯ID',
  `buId` smallint(6) DEFAULT '0' COMMENT '供應商ID',
  `billNo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單據編號',
  `transType` int(11) DEFAULT '0' COMMENT '150501採購 150502退貨',
  `amount` double DEFAULT '0' COMMENT '購貨金額',
  `billDate` date DEFAULT NULL COMMENT '單據日期',
  `description` varchar(50) DEFAULT '' COMMENT '備註',
  `invId` int(11) DEFAULT '0' COMMENT '商品ID',
  `price` double DEFAULT '0' COMMENT '單價',
  `deduction` double DEFAULT '0' COMMENT '折扣額',
  `discountRate` double DEFAULT '0' COMMENT '折扣率',
  `qty` double DEFAULT '0' COMMENT '數量',
  `locationId` smallint(6) DEFAULT '0',
  `tax` double DEFAULT '0',
  `taxRate` double DEFAULT '0',
  `taxAmount` double DEFAULT '0',
  `unitId` smallint(6) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `skuId` int(11) DEFAULT '0',
  `entryId` tinyint(1) DEFAULT '1' COMMENT '區分調撥單  進和出',
  `transTypeName` varchar(25) DEFAULT '',
  `srcOrderEntryId` int(11) DEFAULT '0',
  `srcOrderId` int(11) DEFAULT '0',
  `srcOrderNo` varchar(25) DEFAULT '',
  `billType` varchar(20) DEFAULT '',
  `salesId` smallint(6) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0' COMMENT '1刪除 0正常',
  PRIMARY KEY (`id`),
  KEY `type` (`transType`),
  KEY `billdate` (`billDate`),
  KEY `invId` (`invId`) USING BTREE,
  KEY `transType` (`transType`),
  KEY `iid` (`iid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_order_info
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_staff`
-- ----------------------------
DROP TABLE IF EXISTS `ci_staff`;
CREATE TABLE `ci_staff` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `number` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0' COMMENT '0啟用  1禁用',
  `allowsms` tinyint(4) DEFAULT '0',
  `birthday` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `commissionrate` tinyint(4) DEFAULT '0',
  `creatorId` int(11) DEFAULT '0',
  `deptId` int(11) DEFAULT '0',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `empId` int(11) DEFAULT '0',
  `empType` tinyint(4) DEFAULT '1',
  `fullId` int(11) DEFAULT '0',
  `leftDate` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `mobile` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `parentId` smallint(6) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `userName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `number` (`number`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_staff
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_storage`
-- ----------------------------
DROP TABLE IF EXISTS `ci_storage`;
CREATE TABLE `ci_storage` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '導航欄目',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '欄目名稱',
  `locationNo` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0' COMMENT '狀態 0正常  1鎖定',
  `allowNeg` tinyint(4) DEFAULT '0',
  `deptId` int(11) DEFAULT '0',
  `empId` int(11) DEFAULT '0',
  `groupx` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `type` tinyint(4) DEFAULT '0',
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `isDelete` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `locationNo` (`locationNo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_storage
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_unit`
-- ----------------------------
DROP TABLE IF EXISTS `ci_unit`;
CREATE TABLE `ci_unit` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '客戶名稱',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `unitTypeId` smallint(6) DEFAULT '0',
  `default` tinyint(1) DEFAULT '0',
  `rate` tinyint(1) DEFAULT '0',
  `guid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_unit
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_unittype`
-- ----------------------------
DROP TABLE IF EXISTS `ci_unittype`;
CREATE TABLE `ci_unittype` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '客戶名稱',
  `status` tinyint(1) DEFAULT '1' COMMENT '狀態',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ci_unittype
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_verifica_info`
-- ----------------------------
DROP TABLE IF EXISTS `ci_verifica_info`;
CREATE TABLE `ci_verifica_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '關聯ID',
  `buId` smallint(6) DEFAULT '0' COMMENT '客戶ID',
  `billId` int(11) DEFAULT '0' COMMENT '銷售單號ID',
  `billNo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '單編號',
  `billType` varchar(20) DEFAULT '',
  `transType` varchar(50) DEFAULT '',
  `billDate` date DEFAULT NULL,
  `billPrice` double DEFAULT NULL,
  `nowCheck` double DEFAULT '0' COMMENT '本次覈銷',
  `hasCheck` double DEFAULT '0' COMMENT '已覈銷',
  `notCheck` double DEFAULT '0' COMMENT '未覈銷',
  `checked` tinyint(1) DEFAULT '0',
  `isDelete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_verifica_info
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_warehouse`
-- ----------------------------
DROP TABLE IF EXISTS `ci_warehouse`;
CREATE TABLE `ci_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invId` int(11) DEFAULT '0' COMMENT '商品ID',
  `highQty` double DEFAULT '0' COMMENT '供應商ID',
  `lowQty` double DEFAULT '0',
  `locationId` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invId` (`invId`) USING BTREE,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_warehouse
-- ----------------------------
