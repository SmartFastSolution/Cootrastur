/*
 Navicat Premium Data Transfer

 Source Server         : Transporte 
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : transporte

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 10/10/2021 02:22:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank`  (
  `id` int NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES (1, 'Banco Pinchincha', NULL, NULL);
INSERT INTO `bank` VALUES (2, 'Banco Guayaquil', NULL, NULL);

-- ----------------------------
-- Table structure for charges
-- ----------------------------
DROP TABLE IF EXISTS `charges`;
CREATE TABLE `charges`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type_charges` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `value` decimal(32, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of charges
-- ----------------------------
INSERT INTO `charges` VALUES (1, 'Cobro Inicio', 'P', 17.00, '2021-10-09 17:04:58', '2021-10-09 17:13:59', 'activo');
INSERT INTO `charges` VALUES (2, 'Cobro Final', 'V', 35.50, '2021-10-09 17:10:35', '2021-10-09 17:10:35', 'activo');

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 120 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES (1, 'Cuenca', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (2, 'Gualaceo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (3, 'Paute', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (4, 'Sigsig', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (5, 'Girón', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (6, 'San Fernando', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (7, 'Santa Isabel', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (8, 'Pucará', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (9, 'Nabón', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (10, 'Isabela', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (11, 'Santa Cruz', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (12, 'Puerto Baquerizo Moreno', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (13, 'Puerto Ayora', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (14, 'Cañar', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (15, 'Biblián', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (16, 'Azogue', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (17, 'La Troncal', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (18, 'Guaranda', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (19, 'San Miguel de Bolívar', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (20, 'Caluma', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (21, 'Chillanes', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (22, 'Echeandía', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (23, 'Chimbo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (24, 'Mira', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (25, 'Bolívar', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (26, 'Tulcan', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (27, 'El Angel', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (28, 'Huaca', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (29, 'Julio Andrade', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (30, 'La Paz', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (31, 'San Gabriel', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (32, 'Riobamba', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (33, 'Guano', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (34, 'Chambo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (35, 'Colta', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (36, 'Penipe', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (37, 'Guamote', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (38, 'Pallatanga', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (39, 'Alausí', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (40, 'Chumchi', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (41, 'Cumandá', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (42, 'Cajabamba', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (43, 'Huigra', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (44, 'Saquisilí', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (45, 'Latacunga', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (46, 'Pujilí', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (47, 'Salcedo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (48, 'Sigchos', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (49, 'La Maná', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (50, 'Guayaquil', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (51, 'Daule', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (52, 'Duran', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (53, 'El Empalme', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (54, 'Santa Elena', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (55, 'La Libertad', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (56, 'Salinas', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (57, 'Loja', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (58, 'Maraca', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (59, 'Catamayo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (60, 'Cariamanga', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (61, 'Celia', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (62, 'Macas', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (63, 'Gualaquiza', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (64, 'Limon Indanza', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (65, 'Santiago', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (66, 'Sucua', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (67, 'Ibarra', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (68, 'Ambuqui', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (69, 'Atuntaqui', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (70, 'Cotacachi', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (71, 'Otavalo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (72, 'Babahoyo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (73, 'Buena Fe', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (74, 'Pueblo Viejo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (75, 'Quevedo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (76, 'Ventanas', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (77, 'Portoviejo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (78, 'Bahia de Caraquez', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (79, 'Chone', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (80, 'El Carmen', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (81, 'Jipijapa', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (82, 'Tena', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (83, 'Archidona', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (84, 'Baeza', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (85, 'EL Chaco', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (86, 'Carlos Julio Arosemena Tola', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (87, 'Francisco De Orellana', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (88, 'La Joya De Los Sachas', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (89, 'Loreto', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (90, 'Nuevo Rocafuerte', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (91, 'Puyo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (92, 'Mera', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (93, 'Palora', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (94, 'Shell', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (95, 'Arajuno', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (96, 'Santo Domingo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (97, 'Alluriquin', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (98, 'Luz de América', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (99, 'Valle Hermoso', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (100, 'Quito', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (101, 'Cayambe', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (102, 'Conocoto', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (103, 'Cumbaya', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (104, 'Mchachi', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (105, 'Nueva Loja', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (106, 'Gonzalo Pizarro', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (107, 'Putumayo', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (108, 'Shushufindi', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (109, 'Sucumbios', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (110, 'Ambato', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (111, 'Baños', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (112, 'Cevallos', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (113, 'Izama', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (114, 'Mocha', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (115, 'Zamora', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (116, 'Chinchipe', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (117, 'Nangaritza', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (118, 'Yacuambi', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `cities` VALUES (119, 'Yantzaza', '2021-09-10 04:22:10', '2021-09-10 04:22:10');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2011_09_10_044327_create_cities_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2021_06_06_025717_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (6, '2021_06_15_160913_create_posts_table', 1);
INSERT INTO `migrations` VALUES (7, '2021_07_12_205941_create_documents_table', 1);
INSERT INTO `migrations` VALUES (8, '2021_07_28_165951_create_user_empresas_table', 1);
INSERT INTO `migrations` VALUES (9, '2021_07_29_113511_create_user_tarjetas_table', 1);
INSERT INTO `migrations` VALUES (10, '2021_07_31_001209_create_tiposervicios_table', 1);
INSERT INTO `migrations` VALUES (11, '2021_07_31_001210_create_tipoplans_table', 1);
INSERT INTO `migrations` VALUES (12, '2021_07_31_011722_create_services_table', 1);
INSERT INTO `migrations` VALUES (13, '2021_08_01_115655_create_subservices_table', 1);
INSERT INTO `migrations` VALUES (14, '2021_08_01_115660_create_plans_table', 1);
INSERT INTO `migrations` VALUES (15, '2021_08_06_105720_create_shops_table', 1);
INSERT INTO `migrations` VALUES (16, '2021_08_18_151030_create_tipocuentas_table', 1);
INSERT INTO `migrations` VALUES (17, '2021_08_18_174917_create_plancontables_table', 1);
INSERT INTO `migrations` VALUES (18, '2021_08_20_115311_create_impuestos_table', 1);
INSERT INTO `migrations` VALUES (19, '2021_08_20_182528_create_proyeccions_table', 1);
INSERT INTO `migrations` VALUES (29, '2021_09_10_180146_create_interaccions_table', 4);
INSERT INTO `migrations` VALUES (30, '2021_08_10_094916_create_tipotransaccion_table', 5);
INSERT INTO `migrations` VALUES (31, '2021_08_10_114006_create_transacciondiaria_table', 5);
INSERT INTO `migrations` VALUES (32, '2021_09_15_020701_create_razoncorrientes_table', 6);
INSERT INTO `migrations` VALUES (33, '2021_09_18_175753_create_documentos_interaccions_table', 7);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 1);
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 14);
INSERT INTO `model_has_roles` VALUES (3, 'App\\User', 10);
INSERT INTO `model_has_roles` VALUES (5, 'App\\User', 9);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 2);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 3);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 4);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 5);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 6);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 7);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 8);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 11);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 12);
INSERT INTO `model_has_roles` VALUES (8, 'App\\User', 13);

-- ----------------------------
-- Table structure for partner
-- ----------------------------
DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_trans` decimal(32, 0) NOT NULL,
  `identification` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date NULL DEFAULT NULL,
  `date_begin` date NOT NULL,
  `line` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `license_plate` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `year_vehicle` year NULL DEFAULT NULL,
  `chasis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `motor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name_partner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address_partner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `account_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `driver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `code_trans`, `identification`, `email`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of partner
-- ----------------------------
INSERT INTO `partner` VALUES (21, 5237, '0932027378', '1995-09-10', '2021-09-10', 'N/A', 'GSA-4314', 2000, '56737', 'ghghdfghdh', 'Mike Palma Pino', 'Urdesa Norte', '0960558214', '0960558214', 'miketk@gmail.com', 'Banco Pichincha', '576234626', 'Bryan Poveda', 'Ahorro', 'activo', NULL, '2021-10-10 02:17:22');
INSERT INTO `partner` VALUES (22, 35757, '0960558210', '1996-09-10', '2021-09-10', 'N/A', 'GSA-4356', 2005, '6737', '6846', 'Wacho Palma', 'Urdesa Norte', NULL, '0960558214', 'miketkpp@gmail.com', 'Banco Bolivariano', '55737357', 'Juan Toral', 'Corriente', 'activo', NULL, NULL);
INSERT INTO `partner` VALUES (23, 86235357, '0999761237', '1990-09-10', '2021-09-10', 'N/A', 'GSA-9832', 2003, '6838', '58684', 'Julio Palma', 'Urdesa Norte', '0960558454', NULL, 'mpalma@gmail.com', 'Banco Guayaquil', '53753735735', 'Joel Vera', 'Ahorro', 'activo', NULL, NULL);

-- ----------------------------
-- Table structure for partner_aditional
-- ----------------------------
DROP TABLE IF EXISTS `partner_aditional`;
CREATE TABLE `partner_aditional`  (
  `id_partner` int NULL DEFAULT NULL,
  `type_vehicule` decimal(32, 0) NULL DEFAULT NULL,
  `payment_aditional` decimal(32, 2) NULL DEFAULT NULL,
  `safe_vehicule` decimal(32, 2) NULL DEFAULT NULL,
  `ptmo` decimal(32, 2) NULL DEFAULT NULL,
  `saving` decimal(32, 2) NULL DEFAULT NULL,
  `other` decimal(32, 2) NULL DEFAULT NULL,
  `iess` decimal(32, 2) NULL DEFAULT NULL,
  `garage` decimal(32, 2) NULL DEFAULT NULL,
  `cleaning` decimal(32, 2) NULL DEFAULT NULL,
  `penalty_fee` decimal(32, 2) NULL DEFAULT NULL,
  `safe_internal` decimal(32, 2) NULL DEFAULT NULL,
  `store` decimal(32, 2) NULL DEFAULT NULL,
  `membership` decimal(32, 2) NULL DEFAULT NULL,
  `sensor` decimal(32, 2) NULL DEFAULT NULL,
  `satellite` decimal(32, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `id_partner`(`id_partner`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of partner_aditional
-- ----------------------------
INSERT INTO `partner_aditional` VALUES (21, 1, 45.00, 86.00, 9.00, 96.00, 8.00, 66.00, 3.50, 3.50, 3.50, 3.50, 3.50, 3.50, 673.00, 8.00, NULL, NULL);
INSERT INTO `partner_aditional` VALUES (22, 2, 7.00, 7.00, 7.00, 6.00, 342.00, 3.00, 45.70, 45.70, 45.70, 45.70, 45.70, 45.70, 6737.00, 6.00, NULL, NULL);
INSERT INTO `partner_aditional` VALUES (23, 1, 345.00, 8.00, 5.00, 44.00, 7.00, 8.00, 3.40, 3.40, 3.40, 3.40, 3.40, 3.40, 735673.00, 8.00, NULL, NULL);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'administracion', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (2, 'mantenimientos', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (3, 'compra', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (4, 'roles', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (5, 'usuarios', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (6, 'm-tipoplan', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (7, 'm-plan', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (8, 'm-tiposervicio', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (9, 'm-servicio', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (10, 'm-subservicio', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (11, 'm-tipocuenta', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (12, 'm-plancontable', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (13, 'm-impuesto', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (14, 'm-proyecciones', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (15, 'c-servicios', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (16, 'c-misservicios', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (17, 'c-admtienda', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (18, 'c-miadmtienda', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `permissions` VALUES (19, 'm-proveedores', 'web', '2021-10-06 12:42:30', '2021-10-06 12:42:32');
INSERT INTO `permissions` VALUES (20, 'm-socios', 'web', '2021-10-08 19:17:14', '2021-10-08 19:17:17');
INSERT INTO `permissions` VALUES (21, 'm-cobros', 'web', '2021-10-09 15:59:11', '2021-10-09 15:59:14');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (3, 3);
INSERT INTO `role_has_permissions` VALUES (3, 5);
INSERT INTO `role_has_permissions` VALUES (3, 8);
INSERT INTO `role_has_permissions` VALUES (15, 8);
INSERT INTO `role_has_permissions` VALUES (16, 8);
INSERT INTO `role_has_permissions` VALUES (17, 3);
INSERT INTO `role_has_permissions` VALUES (17, 5);
INSERT INTO `role_has_permissions` VALUES (18, 3);
INSERT INTO `role_has_permissions` VALUES (18, 5);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name`, `guard_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'super-admin', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (2, 'admin', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (3, 'contador', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (4, 'financiero', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (5, 'marketing', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (6, 'abogado', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (7, 'invitado', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');
INSERT INTO `roles` VALUES (8, 'cliente', 'web', '2021-09-10 04:22:10', '2021-09-10 04:22:10');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `identification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `plazos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `line` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `key_advance` decimal(32, 0) NULL DEFAULT NULL,
  `key_supplier` decimal(32, 0) NULL DEFAULT NULL,
  `autorization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `identification`, `code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` bigint UNSIGNED NULL DEFAULT NULL,
  `domicilio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha_n` date NULL DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `genero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `edad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'activo',
  `access_at` timestamp(0) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  UNIQUE INDEX `users_cedula_unique`(`cedula`) USING BTREE,
  INDEX `users_city_id_foreign`(`city_id`) USING BTREE,
  CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (7, 'Esteban Carlos Macias', '0954623101', 'esteban@hotmail.com', NULL, '$2y$10$39Td0lr7q.gYojPyKP5TVu4n3QeXZ0FZhRXj/pJ2HcZjFwyPv4F.6', 42, 'COOP ABC DED FF', '2021-09-24', '0987451201', 'Masculino', '25', NULL, 'inactivo', '2021-09-16 08:45:17', NULL, '2021-09-10 05:19:52', '2021-09-29 20:38:53');
INSERT INTO `users` VALUES (8, 'Cliente Prueba 2', NULL, 'clienteprueba@hotmail.com', NULL, '$2y$10$g7bNGp5F6CgHdZBK5YfKP.YZos1z/x/lzlQhAJrQbO86osDeN7vxu', 50, NULL, NULL, NULL, 'Masculino', NULL, NULL, 'activo', '2021-09-10 08:48:31', NULL, '2021-09-10 05:22:59', '2021-09-16 08:43:45');
INSERT INTO `users` VALUES (9, 'Especialista Marketing', NULL, 'especialistamarketing@hotmail.com', NULL, '$2y$10$EC2HkR0rO/cidVDYlg6nRumJ4F3MTGW/g6CANFkkLecEXJ2tLhPp2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'activo', NULL, NULL, '2021-09-16 08:43:08', '2021-09-16 08:43:08');
INSERT INTO `users` VALUES (10, 'Asesor Contable ', NULL, 'especialistacontable@hotmail.com', NULL, '$2y$10$.FhfFz97XuBDX7cLg3BcuOHnwT4abtbBStcuyvXFV9QS5vmv0KeI6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'activo', '2021-10-06 09:14:52', NULL, '2021-09-16 08:43:26', '2021-10-06 09:14:52');
INSERT INTO `users` VALUES (11, 'Gregorio Avil', NULL, 'gregorio745@hotmail.com', NULL, '$2y$10$NMZazZhP0MYAeUQxSJf98OStLbK31ZYkhT0FhBPCDDa3Tmmg/YR7y', 50, NULL, NULL, NULL, 'Masculino', NULL, NULL, 'activo', NULL, NULL, '2021-09-23 13:23:56', '2021-09-23 13:23:56');
INSERT INTO `users` VALUES (12, 'Luis López', NULL, 'luisefrain1985@gmail.com', NULL, '$2y$10$az/uWr7zlQoljdEGdZcIX.AR3qzWZ6mVOhQfZYP8RmLpAYKi7Okk2', 50, NULL, NULL, NULL, 'Masculino', NULL, NULL, 'activo', '2021-10-01 09:20:58', NULL, '2021-09-23 13:25:58', '2021-10-01 09:20:58');
INSERT INTO `users` VALUES (13, 'ALEX PLUAS', NULL, 'apluas1994@com', NULL, '$2y$10$uuSqPLLN4nO6lZrjgCluTef5/pDdb14YwTp4747aFiKB7LfrEg5Vq', 50, NULL, NULL, NULL, 'Masculino', NULL, NULL, 'activo', NULL, NULL, '2021-09-30 14:49:04', '2021-09-30 14:49:04');
INSERT INTO `users` VALUES (14, 'Mike Palma', NULL, 'miketkpp@gmail.com', NULL, '$2y$10$FL8ak6rt5R0q8cF1100LMeFBvpWcXlW5lot9K1bC9jU1oIC1FFexe', 50, NULL, NULL, NULL, 'Masculino', NULL, NULL, 'activo', '2021-10-09 17:49:36', NULL, '2021-10-06 12:26:22', '2021-10-09 17:49:36');

SET FOREIGN_KEY_CHECKS = 1;
