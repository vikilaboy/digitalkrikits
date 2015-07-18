USE digitalkrikits;

CREATE TABLE `venueType` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `venueType` (`name`)
VALUES
	('Bars'),
	('Clubs'),
	('Hotels'),
	('Restaurants');


CREATE TABLE `venue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idVenueType` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `dateAdd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idVenueType` (`idVenueType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
