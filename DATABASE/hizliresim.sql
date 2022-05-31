-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 May 2022, 23:22:28
-- Sunucu sürümü: 10.1.37-MariaDB
-- PHP Sürümü: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hizliresim`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `collective`
--

CREATE TABLE `collective` (
  `id` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `image` varchar(150) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `content` text COLLATE utf8_turkish_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '1',
  `ip` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `browser` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `type_of_notification` int(11) NOT NULL,
  `title_html` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `body_html` text COLLATE utf8_turkish_ci NOT NULL,
  `href` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification_type`
--

CREATE TABLE `notification_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `share`
--

CREATE TABLE `share` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `folder` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `content` text COLLATE utf8_turkish_ci NOT NULL,
  `isPass` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(150) COLLATE utf8_turkish_ci DEFAULT NULL,
  `share_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) NOT NULL,
  `stype` int(11) NOT NULL DEFAULT '0',
  `broadcast_type` int(11) NOT NULL,
  `total_byte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `share_broadcast`
--

CREATE TABLE `share_broadcast` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `share_broadcast`
--

INSERT INTO `share_broadcast` (`id`, `name`) VALUES
(0, 'Sınırsız'),
(2, '30 dakika sonra sil'),
(3, '2 saat sonra sil '),
(4, '1 gün sonra sil'),
(5, '1 hafta sonra sil'),
(6, '1 ay sonra sil'),
(7, 'Görüntülendikten sonra sil');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `share_report`
--

CREATE TABLE `share_report` (
  `id` int(11) NOT NULL,
  `shareid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `content` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `ip` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `browser` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `isRead` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `share_report_type`
--

CREATE TABLE `share_report_type` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `share_report_type`
--

INSERT INTO `share_report_type` (`id`, `name`) VALUES
(2, 'Terorizm'),
(3, 'Cinsellik'),
(4, 'Dini Değerler'),
(5, 'Şiddet'),
(6, 'Diğer');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `share_type`
--

CREATE TABLE `share_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `explanation` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `share_type`
--

INSERT INTO `share_type` (`id`, `name`, `explanation`) VALUES
(1, 'YAYINDA', 'Resim paylaşımda.'),
(2, 'KULLANICI_GİZLEDİ', 'Resim paylaşım dışında'),
(3, 'KULLANICI_SİLDİ', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `action_type` enum('DB','MAIL','FILE_MOVE','INVALID_SHARE_PARAM') COLLATE utf8_turkish_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isRead` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_turkish_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `activekey` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `avatar` varchar(120) COLLATE utf8_turkish_ci DEFAULT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL,
  `type` enum('USER','GUEST') COLLATE utf8_turkish_ci NOT NULL,
  `authkey` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_settings`
--

CREATE TABLE `user_settings` (
  `userid` int(11) NOT NULL,
  `secrecy` text COLLATE utf8_turkish_ci NOT NULL,
  `notification` text COLLATE utf8_turkish_ci NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `shareid` (`shareid`);

--
-- Tablo için indeksler `collective`
--
ALTER TABLE `collective`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `shareid` (`shareid`);

--
-- Tablo için indeksler `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shareid` (`shareid`),
  ADD KEY `userid` (`userid`);

--
-- Tablo için indeksler `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `share_broadcast`
--
ALTER TABLE `share_broadcast`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `share_report`
--
ALTER TABLE `share_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shareid` (`shareid`),
  ADD KEY `typeid` (`typeid`),
  ADD KEY `shareid_2` (`shareid`),
  ADD KEY `userid` (`userid`);

--
-- Tablo için indeksler `share_report_type`
--
ALTER TABLE `share_report_type`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `share_type`
--
ALTER TABLE `share_type`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`userid`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `collective`
--
ALTER TABLE `collective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `share`
--
ALTER TABLE `share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `share_broadcast`
--
ALTER TABLE `share_broadcast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `share_report`
--
ALTER TABLE `share_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `share_report_type`
--
ALTER TABLE `share_report_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `share_type`
--
ALTER TABLE `share_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
