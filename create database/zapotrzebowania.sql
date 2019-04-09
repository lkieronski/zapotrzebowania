SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `kategoria` (`nazwa`) VALUES
('PozostaÅ‚e');

CREATE TABLE `produkt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategoria` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `nazwa` varchar(240) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `wydzial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `kierownik` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `zapotrzebowanie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zapotrzebowanie_nr` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `produkt` varchar(240) COLLATE utf8_polish_ci NOT NULL,
  `ilosc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `zapotrzebowanie_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zapotrzebowanie_nr` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `wydzial` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `skladajacy` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `data_dodania` datetime NOT NULL,
  `termin_realizacji` date NOT NULL,
  `szacowany_koszt` tinyint(4) NOT NULL,
  `pozostale_informacje` text COLLATE utf8_polish_ci NOT NULL,
  `akceptacja` tinyint(1) NOT NULL,
  `akceptacja_s` tinyint(1) NOT NULL,
  `przyjety_do_realizacji` tinyint(1) NOT NULL,
  `zrealizowane` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `zapotrzebowanie_nr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numer` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

COMMIT;

