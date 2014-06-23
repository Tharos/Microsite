SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `content_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` mediumint(9) unsigned NOT NULL,
  `code` varchar(20) NOT NULL,
  `html` mediumtext,
  `ord` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`content_id`),
  UNIQUE KEY `page_id_code` (`page_id`,`code`),
  CONSTRAINT `content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `content`;
INSERT INTO `content` (`content_id`, `page_id`, `code`, `html`, `ord`) VALUES
(1,	1,	'main',	'<h1>Vítejte!</h1>\n<p>Přečtěte si více o našem produktu.</p>',	10),
(2,	2,	'main',	'<h1>Produkt</h1>\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium aliquam amet at consectetur cumque debitis dolorem fuga illum iusto maxime, molestiae mollitia perspiciatis quis repudiandae temporibus voluptatum? Illo, tempora.</p>\n\n<p>A autem doloremque esse ipsum labore odio quae, repellat! Accusantium autem laudantium provident quidem quos ratione recusandae reprehenderit voluptate. Aut, facilis, officiis.</p>',	10),
(3,	5,	'main',	'<h1>Welcome!</h1> <p>Read more about our amazing product.</p>',	10),
(4,	6,	'main',	'<h1>Product</h1>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium aliquam amet at consectetur cumque debitis dolorem fuga illum iusto maxime, molestiae mollitia perspiciatis quis repudiandae temporibus voluptatum? Illo, tempora.</p>\r\n\r\n<p>A autem doloremque esse ipsum labore odio quae, repellat! Accusantium autem laudantium provident quidem quos ratione recusandae reprehenderit voluptate. Aut, facilis, officiis.</p>',	10),
(5,	3,	'main',	'<h1>Kontaktuje nás!</h1>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In qui suscipit totam velit. Adipisci architecto debitis enim id iure labore maxime molestias, optio quae quas quis quod reprehenderit ut vitae!</p>',	10),
(6,	7,	'main',	'<h1>Contact us!</h1>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In qui suscipit totam velit. Adipisci architecto debitis enim id iure labore maxime molestias, optio quae quas quis quod reprehenderit ut vitae!</p>',	10),
(7,	3,	'secondary',	'<h2>Adresa</h2>\n\n<p>Commodi cum dolor dolore,<br>dolorum magni pariatur<br>porro quo vitae!</p>',	20),
(8,	7,	'secondary',	'<h2>Address</h2>\r\n\r\n<p>Commodi cum dolor dolore,<br>dolorum magni pariatur<br>porro quo vitae!</p>',	10);

DROP TABLE IF EXISTS `lang`;
CREATE TABLE `lang` (
  `lang_id` char(2) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `lang`;
INSERT INTO `lang` (`lang_id`) VALUES
('cz'),
('en');

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `page_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `lang_id` char(2) NOT NULL,
  `layout` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `webalizedName` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `ord` mediumint(8) unsigned DEFAULT NULL,
  `homepage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `visibleInMenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `lang_id_webalizedName` (`lang_id`,`webalizedName`),
  CONSTRAINT `page_ibfk_2` FOREIGN KEY (`lang_id`) REFERENCES `lang` (`lang_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `page`;
INSERT INTO `page` (`page_id`, `lang_id`, `layout`, `name`, `webalizedName`, `title`, `description`, `ord`, `homepage`, `visibleInMenu`) VALUES
(1,	'cz',	'homepage',	'Úvod',	'uvod',	'Ukázková Microsite',	'Ukázková Microsite',	10,	1,	1),
(2,	'cz',	'default',	'Produkt',	'produkt',	NULL,	'Podívejte se, jak je náš produkt dobrý',	20,	0,	1),
(3,	'cz',	'twoColumns',	'Kontakt',	'kontakt',	NULL,	NULL,	30,	0,	1),
(5,	'en',	'homepage',	'Home',	'home',	'Example of microsite',	'Example of microsite',	10,	1,	1),
(6,	'en',	'default',	'Product',	'product',	NULL,	'See how good is our product',	20,	0,	1),
(7,	'en',	'twoColumns',	'Contact',	'contact',	NULL,	NULL,	30,	0,	1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `user`;
INSERT INTO `user` (`user_id`, `username`, `password`) VALUES
(1,	'admin',	'$2y$10$cx8ritIo8hAh0S54cuaou.HRarWPXU1xeyoHZ.v674ZmMfIt2dw5e');
