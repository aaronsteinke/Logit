-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 24. Nov 2011 um 20:03
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `logitdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pic`
--

CREATE TABLE IF NOT EXISTS `pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(6) NOT NULL,
  `pic_ident` varchar(45) NOT NULL,
  `lat_ns` char(1) NOT NULL,
  `lat` float NOT NULL,
  `long_ns` char(1) NOT NULL,
  `long` float NOT NULL,
  `height` int(11) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  `date_shot` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `profilepic` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `reg_time` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `hits` int(11) NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `lastname`, `firstname`, `sex`, `profilepic`, `password`, `email`, `reg_time`, `last_login`, `hits`, `birthday`) VALUES
(4, 'fab', 'test', 'test', 1, 'nicht vorhanden!', '098f6bcd4621d373cade4e832627b4f6', 'deax05@gmail.com', '2011-11-11 17:11:28', '2011-11-11 17:11:28', 0, '2011-01-01'),
(5, 'PEter', 'test', 'test', 1, 'nicht vorhanden!', '51dc30ddc473d43a6011e9ebba6ca770', 'Peter@web.de', '2011-11-15 19:23:04', '2011-11-15 19:23:04', 0, '2011-01-01'),
(6, 'blabla', 'test', 'test', 1, 'nicht vorhanden!', '098f6bcd4621d373cade4e832627b4f6', 'blabla@web.de', '2011-11-15 19:23:55', '2011-11-15 19:23:55', 0, '2011-01-01'),
(7, 'Aaron', 'test', 'test', 1, 'nicht vorhanden!', 'e22a63fb76874c99488435f26b117e37', 'a@ronsteinke.de', '2011-11-15 19:31:42', '2011-11-15 19:31:42', 0, '1988-01-11'),
(8, 'test', 'test', 'test', 1, 'nicht vorhanden!', '098f6bcd4621d373cade4e832627b4f6', 'test@web.de', '2011-11-16 17:55:37', '2011-11-16 17:55:37', 0, '2011-01-01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
