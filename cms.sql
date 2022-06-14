-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 25 2022 г., 09:13
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
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_check` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `date`, `is_check`, `user_id`, `post_id`) VALUES
(1, 'Тестовый комментарий к первому посту от админа', '2022-03-25 01:14:14', 1, 1, 1),
(2, 'Второй текстовый комментарий к первой статье', '2022-03-25 05:57:36', 1, 3, 1),
(39, 'любой коммент от админа', '2022-04-09 02:46:02', 1, 1, 6),
(40, 'коммент от менеджера', '2022-04-09 02:56:47', 1, 2, 6),
(41, 'Коммент от Ваньки', '2022-04-09 10:41:12', 1, 3, 6),
(69, 'Комментарий от Петра\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(80, 'Комментарий от Петра 2\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(81, 'Комментарий от Петра 3\r\n', '2022-04-12 12:22:47', 1, 4, 6),
(84, 'Комментарий от Петра 6\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(85, 'Комментарий от Петра 7\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(88, 'Комментарий от Петра 10\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(89, 'Комментарий от Петра 11\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(90, 'Комментарий от Петра 12\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(91, 'Комментарий от Петра 13\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(92, 'Комментарий от Петра 14\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(93, 'Комментарий от Петра 15\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(94, 'Комментарий от Петра 16\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(95, 'Комментарий от Петра 17\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(96, 'Комментарий от Петра 18\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(97, 'Комментарий от Петра 19\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(98, 'Комментарий от Петра 20\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(100, 'Комментарий от Петра 22\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(101, 'Комментарий от Петра 23\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(102, 'Комментарий от Петра 24\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(103, 'Комментарий от Петра 25\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(104, 'Комментарий от Петра 26\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(105, 'Комментарий от Петра 27\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(106, 'Комментарий от Петра 28\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(107, 'Комментарий от Петра 29\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(108, 'Комментарий от Петра 30\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(109, 'Комментарий от Петра 31\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(110, 'Комментарий от Петра 32\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(111, 'Комментарий от Петра 33\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(112, 'Комментарий от Петра 34\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(113, 'Комментарий от Петра 35\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(114, 'Комментарий от Петра 36\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(115, 'Комментарий от Петра 37\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(116, 'Комментарий от Петра 38\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(117, 'Комментарий от Петра 39\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(118, 'Комментарий от Петра 40\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(119, 'Комментарий от Петра 41\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(120, 'Комментарий от Петра 42\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(121, 'Комментарий от Петра 43\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(122, 'Комментарий от Петра 44\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(123, 'Комментарий от Петра 45\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(124, 'Комментарий от Петра 46\r\n', '2022-04-12 12:22:47', 0, 4, 6),
(125, 'Комментарий от Петра 47\r\n', '2022-04-12 12:22:47', 0, 4, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'Администратор', 'полный доступ к админке'),
(2, 'Контент менеджер', 'может изменять/создавать статьи и модерирует комментарии к ним'),
(3, 'Зарегистрированный пользователь', 'может оставлять комментарии');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `recipients` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `date`, `recipients`, `subject`, `message`, `headers`) VALUES
(2, '2022-04-22 21:45:58', 'semho@yandex.ru, asdb@asdsd.ru, semho1@yandex.ru, asdb1@asdsd.ru, semho2@yandex.ru, asdb2@asdsd.ru, semho3@yandex.ru, asdb3@asdsd.ru, semho4@yandex.ru, asdb4@asdsd.ru, semho5@yandex.ru, asdb5@asdsd.ru, semho6@yandex.ru, asdb6@asdsd.ru, admin@mail.ru, manager@mail.ru, some@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some@mail.ru, some2@mail.ru, some@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru, some2@mail.ru', 'На сайте добавлена новая запись: \"Двенадцатая статья\"', '\r\n        <html>\r\n            <head>\r\n                <title>Двенадцатая статья</title>\r\n            </head>\r\n            <body>\r\n                <table>\r\n                    <tr>\r\n                        <td>Новая статья: \"Двенадцатая статья\"</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Краткое описание</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>\r\n                            <a href=\'http://localhost:8080/posts/14\'>Читать</a>\r\n                        </td>\r\n                    </tr>\r\n                    <tr style=\'height:20px\'><td></td></tr>\r\n                    <tr style=\'border-bottom:1px dotted grey\'>\r\n                        <td colspan=\'100%\'></td>\r\n                    </tr>\r\n                    <tr style=\'height:20px\'><td></td></tr>\r\n                    <tr>\r\n                        <td>\r\n                            <a href=\'http://localhost:8080/unsubscribe\'>Отписаться от рассылки</a>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </body>\r\n        </html>\r\n        ', 'MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `mailings`
--

CREATE TABLE `mailings` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mailings`
--

INSERT INTO `mailings` (`id`, `email`) VALUES
(1, 'semho@yandex.ru'),
(9, 'semho1@yandex.ru'),
(10, 'asdb1@asdsd.ru'),
(11, 'semho2@yandex.ru'),
(12, 'asdb2@asdsd.ru'),
(13, 'semho3@yandex.ru'),
(14, 'asdb3@asdsd.ru'),
(17, 'semho5@yandex.ru'),
(18, 'asdb5@asdsd.ru'),
(19, 'semho6@yandex.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `text`, `slug`) VALUES
(3, 'Правила пользования сайтом', 'Тут должен быть какой-то текст о правилах пользования сайтом.', 'pravila-polzovaniya-saitom');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `name`, `description`, `text`, `img`, `date`) VALUES
(1, 'Первый пост', 'Краткое описание первого поста', 'Текст статьи', 'img1.jpg', '2022-03-24 01:40:35'),
(2, 'Второй пост', 'Краткое описание второго поста', 'Текст статьи', 'img3.jpg', '2022-03-24 01:41:35'),
(3, 'Третий пост', 'Краткое описание', 'Текст', 'img4.jpg', '2022-03-24 02:48:30'),
(4, 'Четвертый пост', 'Краткое описание', 'Текст', 'img5.jpg', '2022-03-24 02:48:35'),
(5, 'Пятый пост', 'Краткое описание', 'Текст', 'img2.jpg', '2022-03-24 02:49:08'),
(6, 'Шестой пост', 'Краткое описание', 'Полный текст статьи', 'img6.jpg', '2022-03-24 13:18:47'),
(7, 'Седьмой пост', 'Краткое описание', 'Полный текст статьи', '28f2fdabdfb5fc2e7d23ee0ea85364be.jpg', '2022-04-18 13:18:47'),
(8, 'Восьмая статья', 'Краткое описание восьмой статьи', 'Подробное описание', '367f24950e05ac434639376e13264c27.jpeg', '2022-04-18 14:26:42'),
(9, 'Девятая статья', 'Краткое описание', 'подробнее', '0a41dda655439992f7883b28d7ce68ff.jpg', '2022-04-20 13:55:48'),
(10, 'Десятая статья', 'Краткое описание', 'Подробно', 'af1c60a99117371b5a8d5aa505e6628c.jpg', '2022-04-20 13:56:57'),
(11, 'Одиннадцатая статья', 'Краткое описание', 'Подробно', '8adf07db1cb3a5dd460f8616b70ec7df.jpg', '2022-04-20 14:00:04'),
(14, 'Двенадцатая статья 2022 года', 'Краткое описание', 'Какой то текст', 'd2334277c7a3bf8bc7bfe8693b203011.jpg', '2022-04-22 14:45:58');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` bigint(20) NOT NULL,
  `const` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `const`) VALUES
(1, 'Количество статей на одной странице', 6, 'COUNT_POSTS');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '3',
  `subscription` tinyint(4) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `avatar`, `email`, `password`, `group_id`, `subscription`, `description`) VALUES
(1, 'Admin', 'avatar_1.jpg', 'admin@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 1, 1, 'Описание админа'),
(2, 'Менеджер', 'avatar_2.jpg', 'manager@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 2, 1, 'Описание менеджера'),
(3, 'Иван', 'avatar_3.png', 'some@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Написал что-то о себе'),
(4, 'Петр', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(5, 'Петр копия', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(6, 'Петр копия еще одна', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(7, 'Петр копия еще одна 2', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(8, 'Петр копия еще одна 3', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(9, 'Петр копия еще одна 4', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(13, 'Иван2', 'avatar_3.png', 'some@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 0, 'Написал что-то о себе'),
(14, 'Петрa2', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(15, 'Петрa3', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(16, 'Петрa3', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(17, 'Иван4', 'avatar_3.png', 'some@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Написал что-то о себе'),
(18, 'Петрa4', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(19, 'Иван5', 'avatar_3.png', 'some@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Написал что-то о себе'),
(20, 'Петрa5', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(21, 'Петрa6', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(22, 'Петрa7', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(23, 'Петрa8', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра'),
(24, 'Петрa9', 'avatar_4.gif', 'some2@mail.ru', '$2y$10$eS2YD3zGE8pyvkWbGv/WAOxADxinzmXSoR9Txx1jG55jHE1e7PeFu', 3, 1, 'Описание Петра');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_user_id` (`user_id`),
  ADD KEY `c_post_id` (`post_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mailings`
--
ALTER TABLE `mailings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_group_id` (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mailings`
--
ALTER TABLE `mailings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `c_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `c_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `c_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
