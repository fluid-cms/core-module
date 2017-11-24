ALTER TABLE `core_setting`
CHANGE `ID` `id` int(11) NOT NULL AUTO_INCREMENT FIRST,
CHANGE `value` `value` text COLLATE 'utf8_czech_ci' NULL AFTER `variable`,
CHANGE `default_value` `default_value` text COLLATE 'utf8_czech_ci' NULL AFTER `value`,
CHANGE `description` `description` text COLLATE 'utf8_czech_ci' NULL AFTER `type`,
CHANGE `options` `options` varchar(255) COLLATE 'utf8_czech_ci' NULL AFTER `description`,
ADD `secured` int(1) NOT NULL DEFAULT '0',
ADD `nullable` int(1) NOT NULL DEFAULT '0' AFTER `secured`;

ALTER TABLE `core_setting` ADD UNIQUE `variable` (`variable`);