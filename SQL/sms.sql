SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `flags` (
  `flag_id` int(11) NOT NULL,
  `flag` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `flagDesc` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float(11,2) NOT NULL,
  `server` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `flag_history` (
  `flag_id` int(11) NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `dateBought` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateExpire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `server` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `password_keys` (
  `key_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password_key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `expireDate` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `servers` (
  `server_id` int(11) NOT NULL,
  `csbans_id` int(11) NOT NULL,
  `shortname` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sms_settings` (
  `template` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `site_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `md5_enc` int(11) NOT NULL,
  `reloadadmins` int(11) NOT NULL,
  `servID1` int(11) NOT NULL,
  `servID2` int(11) NOT NULL,
  `servID3` int(11) NOT NULL,
  `servID4` int(11) NOT NULL,
  `balance1` float(11,2) NOT NULL,
  `balance2` float(11,2) NOT NULL,
  `balance3` float(11,2) NOT NULL,
  `balance4` float(11,2) NOT NULL,
  `allow_sms` int(11) NOT NULL DEFAULT 1,
  `allow_paypal` int(11) NOT NULL DEFAULT 0,
  `unban_price` float(11,2) NOT NULL,
  `paypal_type` int(11) NOT NULL,
  `paypal_logs` int(11) NOT NULL,
  `paypal_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `settings` (`template`, `language`, `site_title`, `md5_enc`, `reloadadmins`, `servID1`, `servID2`, `servID3`, `servID4`, `balance1`, `balance2`, `balance3`, `balance4`) VALUES
('bootstrap', 'en', 'Testing', 0, 1, 29, 0, 0, 0, 1.20, 0.00, 0.00, 0.00);

CREATE TABLE `sms_codes` (
  `sms_code_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `balance` float(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sms_text` (
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `home` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sms_settings` (`template`, `language`, `site_title`, `md5_enc`, `reloadadmins`, `servID1`, `servID2`, `servID3`, `servID4`, `balance1`, `balance2`, `balance3`, `balance4`, `allow_sms`, `allow_paypal`, `unban_price`, `paypal_type`, `paypal_logs`, `paypal_email`) VALUES
('bootstrap', 'en', 'Counter-Strike SMS CMS by JustyleR', 1, 1, 29, 0, 0, 0, 1.20, 0.00, 0.00, 0.00, 1, 0, 5.00, 0, 0, '');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nicknamePass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `balance` float(11,2) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `ipAdress` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `registerDate` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `flags`
  ADD PRIMARY KEY (`flag_id`);

ALTER TABLE `flag_history`
  ADD PRIMARY KEY (`flag_id`);

ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `password_keys`
  ADD PRIMARY KEY (`key_id`);

ALTER TABLE `servers`
  ADD PRIMARY KEY (`server_id`);

ALTER TABLE `sms_codes`
  ADD PRIMARY KEY (`sms_code_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `flags`
  MODIFY `flag_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flag_history`
  MODIFY `flag_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `password_keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `servers`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sms_codes`
  MODIFY `sms_code_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
