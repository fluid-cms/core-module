DROP TABLE IF EXISTS `core_acl`;
CREATE TABLE IF NOT EXISTS `core_acl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namespace` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `resource` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `privilege` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


ALTER TABLE `core_acl` ADD INDEX `core_acl_namespace` (`namespace`);
ALTER TABLE `core_acl` ADD INDEX `core_acl_role` (`role`);
ALTER TABLE `core_acl` ADD INDEX `core_acl_resource` (`resource`);
ALTER TABLE `core_acl` ADD INDEX `core_acl_privilege` (`privilege`);
ALTER TABLE `core_acl` ADD UNIQUE `core_acl_all` (`namespace`, `role`, `resource`, `privilege`);