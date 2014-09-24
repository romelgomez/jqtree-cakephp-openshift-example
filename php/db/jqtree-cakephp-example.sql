-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-09-2014 a las 23:46:38
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
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `lft`, `rght`, `name`, `created`, `modified`) VALUES
('54224311-6570-4ffc-8809-04fe7f000009', NULL, 1, 8, 'Books & Audible', '2014-09-23 23:35:37', '2014-09-23 23:44:00'),
('54224322-4b3c-41d2-96e6-04ff7f000009', '54224326-5580-417d-a45d-04ff7f000009', 5, 6, 'Best Sellers', '2014-09-23 23:35:54', '2014-09-23 23:45:31'),
('54224326-5580-417d-a45d-04ff7f000009', '54224311-6570-4ffc-8809-04fe7f000009', 2, 7, 'Books', '2014-09-23 23:35:58', '2014-09-23 23:45:35'),
('54224327-d248-4416-bb86-04ff7f000009', '54224326-5580-417d-a45d-04ff7f000009', 3, 4, 'Kindle Books', '2014-09-23 23:35:59', '2014-09-23 23:45:01'),
('54224578-b940-4385-8c76-0c7d7f000009', NULL, 9, 10, 'Electronics & Computers', '2014-09-23 23:45:52', '2014-09-23 23:45:52'),
('54224582-7080-4563-8cf8-04fe7f000009', NULL, 11, 12, 'Home, Garden & Tools', '2014-09-23 23:46:02', '2014-09-23 23:46:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
