-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 26 2017 г., 07:46
-- Версия сервера: 5.7.14
-- Версия PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chess`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chess_pieces_name`
--

CREATE TABLE `chess_pieces_name` (
  `id` int(1) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `chess_pieces_name`
--

INSERT INTO `chess_pieces_name` (`id`, `name`) VALUES
(1, 'king'),
(2, 'queen'),
(3, 'bishop'),
(4, 'knight'),
(5, 'rook'),
(6, 'pawn');

-- --------------------------------------------------------

--
-- Структура таблицы `game_info`
--

CREATE TABLE `game_info` (
  `a8` int(3) DEFAULT NULL,
  `b8` int(3) DEFAULT NULL,
  `c8` int(3) DEFAULT NULL,
  `d8` int(3) DEFAULT NULL,
  `e8` int(3) DEFAULT NULL,
  `f8` int(3) DEFAULT NULL,
  `g8` int(3) DEFAULT NULL,
  `h8` int(3) DEFAULT NULL,
  `a7` int(3) DEFAULT NULL,
  `b7` int(3) DEFAULT NULL,
  `c7` int(3) DEFAULT NULL,
  `d7` int(3) DEFAULT NULL,
  `e7` int(3) DEFAULT NULL,
  `f7` int(3) DEFAULT NULL,
  `g7` int(3) DEFAULT NULL,
  `h7` int(3) DEFAULT NULL,
  `a6` int(3) DEFAULT NULL,
  `b6` int(3) DEFAULT NULL,
  `c6` int(3) DEFAULT NULL,
  `d6` int(3) DEFAULT NULL,
  `e6` int(3) DEFAULT NULL,
  `f6` int(3) DEFAULT NULL,
  `g6` int(3) DEFAULT NULL,
  `h6` int(3) DEFAULT NULL,
  `a5` int(3) DEFAULT NULL,
  `b5` int(3) DEFAULT NULL,
  `c5` int(3) DEFAULT NULL,
  `d5` int(3) DEFAULT NULL,
  `e5` int(3) DEFAULT NULL,
  `f5` int(3) DEFAULT NULL,
  `g5` int(3) DEFAULT NULL,
  `h5` int(3) DEFAULT NULL,
  `a4` int(3) DEFAULT NULL,
  `b4` int(3) DEFAULT NULL,
  `c4` int(3) DEFAULT NULL,
  `d4` int(3) DEFAULT NULL,
  `e4` int(3) DEFAULT NULL,
  `f4` int(3) DEFAULT NULL,
  `g4` int(3) DEFAULT NULL,
  `h4` int(3) DEFAULT NULL,
  `a3` int(3) DEFAULT NULL,
  `b3` int(3) DEFAULT NULL,
  `c3` int(3) DEFAULT NULL,
  `d3` int(3) DEFAULT NULL,
  `e3` int(3) DEFAULT NULL,
  `f3` int(3) DEFAULT NULL,
  `g3` int(3) DEFAULT NULL,
  `h3` int(3) DEFAULT NULL,
  `a2` int(3) DEFAULT NULL,
  `b2` int(3) DEFAULT NULL,
  `c2` int(3) DEFAULT NULL,
  `d2` int(3) DEFAULT NULL,
  `e2` int(3) DEFAULT NULL,
  `f2` int(3) DEFAULT NULL,
  `g2` int(3) DEFAULT NULL,
  `h2` int(3) DEFAULT NULL,
  `a1` int(3) DEFAULT NULL,
  `b1` int(3) DEFAULT NULL,
  `c1` int(3) DEFAULT NULL,
  `d1` int(3) DEFAULT NULL,
  `e1` int(3) DEFAULT NULL,
  `f1` int(3) DEFAULT NULL,
  `g1` int(3) DEFAULT NULL,
  `h1` int(3) DEFAULT NULL,
  `id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `game_log`
--

CREATE TABLE `game_log` (
  `id` int(10) NOT NULL,
  `game_info_id` int(10) NOT NULL,
  `turn` int(10) DEFAULT NULL,
  `game_is_ended` tinyint(1) NOT NULL DEFAULT '0',
  `player` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chess_pieces_name`
--
ALTER TABLE `chess_pieces_name`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `game_info`
--
ALTER TABLE `game_info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `game_log`
--
ALTER TABLE `game_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chess_pieces_name`
--
ALTER TABLE `chess_pieces_name`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `game_info`
--
ALTER TABLE `game_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `game_log`
--
ALTER TABLE `game_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
