DROP TABLE IF EXISTS `core_setting`;
CREATE TABLE IF NOT EXISTS `core_setting` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `variable` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `value` text COLLATE utf8_czech_ci NOT NULL,
  `default_value` text COLLATE utf8_czech_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `options` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `core_setting` (`variable`, `value`, `default_value`, `type`, `description`, `options`) VALUES
  ('core.meta.title', 'Title', 'Title', 'string', 'Titulek dokumentu (stránky)', ''),
  ('core.meta.description', 'Description', 'Description', 'string', 'Stručný popis stránek', ''),
  ('core.meta.keywords', 'Your,keywords,here', 'Your,keywords,here', 'string', 'Klíčová slova oddělená čárkami', ''),
  ('core.meta.author', 'Grape SC, a.s.', 'Grape SC, a.s.', 'string', 'Autor prezentace', '');