-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 28 2021 г., 17:06
-- Версия сервера: 5.7.30-33
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cd03306_admin123`
--

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `new` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lasttable` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastkeys` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `lasttable`, `lastkeys`) VALUES
(1, '', 'table/test.csv');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `info1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info2` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info3` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info4` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info6` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info7` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info8` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info9` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info10` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info11` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info12` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info13` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info14` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info15` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info16` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info17` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
