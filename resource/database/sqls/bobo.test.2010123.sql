/*
 Navicat Premium Data Transfer

 Source Server         : localhost-root
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : bobo.test

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 23/01/2021 23:17:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blogs
-- ----------------------------
DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `viewed_count` int(11) NOT NULL DEFAULT 0,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_user` int(11) NOT NULL DEFAULT 0,
  `updated_user` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of blogs
-- ----------------------------
INSERT INTO `blogs` VALUES (1, 'blog001', 8, 'blog001 content', 5, 5, 1611306077, 1611306077);
INSERT INTO `blogs` VALUES (3, 'blog003', 0, 'blog003 content', 5, 5, 1611306239, 1611306239);
INSERT INTO `blogs` VALUES (4, 'blog004', 18, 'blog004 content', 5, 5, 1611414930, 1611414930);
INSERT INTO `blogs` VALUES (5, 'blog005', 0, 'blog005 content', 5, 5, 1611414942, 1611414942);
INSERT INTO `blogs` VALUES (6, 'blog006', 0, 'blog006 content', 3, 3, 1611414990, 1611414990);
INSERT INTO `blogs` VALUES (7, 'blog007', 0, 'blog007 content', 3, 3, 1611415002, 1611415002);

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES (1, 'William');
INSERT INTO `test` VALUES (2, 'williamning');
INSERT INTO `test` VALUES (3, 'williamning1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'foo123', '123456', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'foo123', '123456', NULL, NULL, NULL);
INSERT INTO `users` VALUES (3, 'williamning1', '14e1b600b1fd579f47433b88e8d85291', '1158885641@qq.com', 1611374185, 1611374185);
INSERT INTO `users` VALUES (4, 'williamning2', '14e1b600b1fd579f47433b88e8d85291', '1158885641@qq.com', 1611374192, 1611374192);
INSERT INTO `users` VALUES (5, 'williamning3', '14e1b600b1fd579f47433b88e8d85291', '1158885641@qq.com', 1611374197, 1611374197);

SET FOREIGN_KEY_CHECKS = 1;
