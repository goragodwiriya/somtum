-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2018 at 12:01 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 5.6.38-3+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `gcms_index`
--

CREATE TABLE `gcms_index` (
  `id` int(11) UNSIGNED NOT NULL,
  `page` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(149) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(149) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gcms_index`
--

INSERT INTO `gcms_index` (`id`, `page`, `title`, `description`, `detail`, `keywords`) VALUES
(1, 'home', 'โรงเรียนมีความประสงค์จะ สอบราคาซื้อครุภัณฑ์คอมพิวเตอร', 'ประกาศโรงเรียนมีความประสงค์จะ สอบราคาซื้อครุภัณฑ์คอมพิวเตอร์และอุปกรณ์ต่อพ่วง', 'ประกาศโรงเรียนมีความประสงค์จะ สอบราคาซื้อครุภัณฑ์คอมพิวเตอร์และอุปกรณ์ต่อพ่วง คลิกดูรายละเอียด', 'โรงเรียนมีความประสงค์จะ_สอบราคาซื้อครุภัณฑ์คอมพิวเตอร์และอุปกรณ์ต่อพ่วง'),
(2, 'about', 'ให้ ร.ร. ตรวจสอบการยืนยันข้อมูล DMC ข้อมูล ณ วันที่ 16 มิ.ย. 57', 'ให้ ร.ร. ตรวจสอบสถานะการยืนยันข้อมูลของโรงเรียนในเขต ข้อมูล ณ วันที่ 16 มิ.ย. 57', 'ให้ ร.ร. ตรวจสอบสถานะการยืนยันข้อมูลของโรงเรียนในเขต ข้อมูล ณ วันที่ 16 มิ.ย. 57 และให้ ร.ร. ยืนยันให้แล้วเสร็จภายในวันที่ 18 มิ.ย. 57', 'ให้_ร_ร_ตรวจสอบการยืนยันข้อมูล_dmc_ข้อมูล_ณ_วันที่_16_มิ_ย_57');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
