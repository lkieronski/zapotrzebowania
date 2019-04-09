SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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

INSERT INTO `uzytkownicy` (`nazwa`, `email`, `haslo`, `imie`, `nazwisko`, `wydzial`, `uprawnienia`, `cookie_logkey`, `cookie_logkey_timeout`) VALUES
('admin', 'admin', '$2y$10$re.lK.rhjpFcNphPwWRKjeh8cVAyVtzq0aoukiAD7GPNIuGdc4wje', 'admin', 'admin', 'admin', 'user;admin', '', '');

CREATE TABLE `wydzial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `wydzial` (`nazwa`) VALUES ('admin');
COMMIT;