-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2022 г., 13:36
-- Версия сервера: 5.7.29
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cut_url`
--

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `long_link` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_link` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES
(11, 2, 'goole.re', 'sd', 0),
(22, 2, 'http://google.ru', 'g', 0),
(71, 1, 'http://google.ru', 'yo8ln0', 0),
(72, 1, 'http://vk.com', 'lszuim', 0),
(75, 1, 'https://www.googldffddsdgfdgs', 'xgk03t', 1),
(76, 1, 'https://www.google.by/', 't6fvpz', 0),
(77, 1, 'https://www.google.by', '-lfbvy', 1),
(78, 1, 'https://question-it.com/questions/5016421/kak-ja-mogu-vvesti-neskolko-uslovij-v-operator-like', 'vdhk3l', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`) VALUES
(1, 'ques', '$2y$10$3SaqCHHQZzW3P4qMz9lhqOsv./M2ZoezNmaz2wCd/EGBm4yqzJhxy'),
(2, 'Ques2', '123465'),
(3, 'log', '123'),
(4, 'login', '1111'),
(5, 'login2', 'b59c67bf196a4758191e42f76670ceba'),
(6, 'login3', 'b59c67bf196a4758191e42f76670ceba'),
(7, 'login 3', '698d51a19d8a121ce581499d7b701668'),
(8, 'login_4', '$2y$10$.7aEtZMCsmLVZqtNvz9Ga.5w8psCYpviyq/6xHSiz8wndAUma8Lqi'),
(9, 'login_5', '$2y$10$6v0kMr9xiGd5qkTQIHwC0OyE217HNpcE.fIbM8hdm7TjfqSUYJqF6'),
(10, 'user', '$2y$10$LktOljMmTIpkSWaXway.EOyCLtNI1zzB2xeUH5jr9FzZfm7FztCNq'),
(11, 'user2', '$2y$10$x/4.Osz6l.lmd3X.bBkt/eIxBxFw3.buCYyXlpEQBeTHlr9cIoQIq'),
(12, 'user3', '$2y$10$.Qeq35B5.UfQbFySNepVA.yoY6BdqJBNBS9G.BOPgtMZmSnq0DjTq'),
(13, 'user4', '$2y$10$3SaqCHHQZzW3P4qMz9lhqOsv./M2ZoezNmaz2wCd/EGBm4yqzJhxy'),
(14, 'quesss', '$2y$10$EG1HvYTKS9c6DMV8nT4s8O1BuXy3DZvGb2r/GqUIxDq3FMslnAaVK');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_link` (`short_link`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
