SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(120) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `wydzial` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `uprawnienia` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `cookie_logkey` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `cookie_logkey_timeout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `wydzial` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `kierownik` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

COMMIT;