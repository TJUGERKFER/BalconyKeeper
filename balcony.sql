-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-04-06 18:23:24
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `balcony`
--

-- --------------------------------------------------------

--
-- 表的结构 `balcony_table`
--

CREATE TABLE `balcony_table` (
  `pot_id` int(11) NOT NULL,
  `pot_temp` int(11) NOT NULL,
  `pot_humi` int(11) NOT NULL,
  `pot_command` text NOT NULL,
  `waterthreshold` int(11) NOT NULL,
  `autocommand` text NOT NULL,
  `fertilizedelay` bigint(20) NOT NULL,
  `lastfertilizetime` bigint(20) NOT NULL,
  `musicdelay` int(11) NOT NULL,
  `lastmusictime` bigint(20) NOT NULL,
  `air_humi` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `balcony_table`
--

INSERT INTO `balcony_table` (`pot_id`, `pot_temp`, `pot_humi`, `pot_command`, `waterthreshold`, `autocommand`, `fertilizedelay`, `lastfertilizetime`, `musicdelay`, `lastmusictime`, `air_humi`) VALUES
(1, 0, 4095, 'none', -1, 'none', 86400, 1608814046, 1000000, 1608010578, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
