-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-09-2014 a las 08:18:26
-- Versión del servidor: 5.5.38-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `jqtree-cakephp-example`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=234 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `lft`, `rght`, `name`, `created`, `modified`) VALUES
(227, 228, 2, 5, 'Magazines', '2014-09-22 08:10:03', '2014-09-22 08:12:22'),
(228, NULL, 1, 12, 'Store', '2014-09-22 08:10:13', '2014-09-22 08:10:13'),
(229, 227, 3, 4, 'Books & Audible', '2014-09-22 08:10:43', '2014-09-22 08:12:25'),
(230, 228, 6, 11, 'Books', '2014-09-22 08:10:59', '2014-09-22 08:12:28'),
(231, 230, 9, 10, 'Children''s Books', '2014-09-22 08:11:18', '2014-09-22 08:12:30'),
(232, 230, 7, 8, 'Textbooks', '2014-09-22 08:11:31', '2014-09-22 08:12:34'),
(233, NULL, 13, 14, 'Movies, Music & Games', '2014-09-22 08:12:04', '2014-09-22 08:12:04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
