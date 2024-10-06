-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 07 2024 г., 01:32
-- Версия сервера: 8.0.29
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id` int NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(2, 'Кадровый отдел'),
(8, 'Технологический'),
(1, 'Финансовый отдел');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `id` int NOT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `department_id` int NOT NULL,
  `dayOfWeek` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`id`, `startTime`, `endTime`, `department_id`, `dayOfWeek`) VALUES
(56, '13:35:09', '16:35:09', 2, 'Понедельник'),
(58, '14:00:00', '17:00:00', 1, 'Понедельник'),
(60, '00:00:00', '00:00:00', 2, 'Вторник'),
(61, '00:00:00', '00:00:00', 2, 'Четверг'),
(62, '00:00:00', '00:00:00', 8, 'Понедельник'),
(63, '14:00:00', '23:00:00', 8, 'Пятница');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `department_id` int NOT NULL,
  `created_by` int NOT NULL,
  `assigned_to` int DEFAULT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `department_id`, `created_by`, `assigned_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Задание 1', 'Описание задания 1', 1, 11, 9, 'Выполняется', '2024-10-06 20:58:10', '2024-10-07 02:29:23'),
(2, 'Задание 2', 'Описание задания 2', 1, 11, 9, 'Выполняется', '2024-10-06 20:58:10', '2024-10-07 02:29:02'),
(3, 'Задание 3', 'Описание задания 3', 2, 11, NULL, 'Ожидает', '2024-10-06 20:58:10', '2024-10-06 20:58:10'),
(4, 'Задание 4', 'Описание задания 4', 2, 11, 17, 'Ожидает', '2024-10-06 20:58:10', '2024-10-06 20:58:10'),
(5, 'Задание 5', 'Описание задания 5', 2, 11, 24, 'Ожидает', '2024-10-06 20:58:10', '2024-10-06 20:58:10'),
(6, 'Задание 6', 'Описание задания 6', 1, 11, 24, 'Ожидает', '2024-10-06 20:58:10', '2024-10-06 20:58:10'),
(7, 'Сделать лабу', 'Аутентификация, фильтрация отображаемых данных, взаимодействие пользователей', 1, 26, 9, 'Выполняется', '2024-10-07 00:02:27', '2024-10-07 02:06:05'),
(8, 'Тестовое задание', 'два плюс два равно', 2, 11, NULL, 'Ожидает', '2024-10-07 01:43:20', '2024-10-07 01:43:20'),
(9, 'Тестовое задание', 'чисти чисти', 1, 26, 9, 'Выполняется чисти чисти', '2024-10-07 01:44:10', '2024-10-07 02:29:58');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `department_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`, `department_id`) VALUES
(9, 'Дима', '1234', 'сотрудник', 1),
(11, 'Luncent', '1234', 'начальник отдела', 2),
(16, 'admin', 'admin', 'admin', NULL),
(17, 'Паша', '1234', 'сотрудник', 2),
(24, 'Anrew', '1234', 'сотрудник', 2),
(25, 'Boss', '1234', 'начальник отдела', 8),
(26, 'FBoss', '1234', 'начальник отдела', 1),
(27, 'Worker1', '1234', 'сотрудник', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departmentName` (`department_id`,`dayOfWeek`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`,`department_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
