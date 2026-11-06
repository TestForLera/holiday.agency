-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 06 2026 г., 17:15
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `hero_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `heroes`
--

CREATE TABLE `heroes` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `heroes`
--

INSERT INTO `heroes` (`id`, `service_id`, `name`, `description`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Капибара', NULL, 'img/2.jpg', 1, 0, NULL, NULL),
(2, 1, 'Чебурашка', NULL, NULL, 1, 0, NULL, NULL),
(3, 1, 'Зайка', NULL, NULL, 1, 0, NULL, NULL),
(4, 1, 'Лабубу', NULL, NULL, 1, 0, NULL, NULL),
(5, 1, 'Котик', NULL, NULL, 1, 0, NULL, NULL),
(6, 1, 'Куроми', NULL, NULL, 1, 0, NULL, NULL),
(7, 1, 'Розовый мишка', NULL, NULL, 1, 0, NULL, NULL),
(8, 1, 'Белый мишка', NULL, NULL, 1, 0, NULL, NULL),
(9, 4, 'Коржик', NULL, NULL, 1, 0, NULL, NULL),
(10, 4, 'Карамелька', NULL, NULL, 1, 0, NULL, NULL),
(11, 4, 'Соник', NULL, NULL, 1, 0, NULL, NULL),
(12, 4, 'Принцесса единорогов', NULL, NULL, 1, 0, NULL, NULL),
(13, 4, 'Лабубу', NULL, NULL, 1, 0, NULL, NULL),
(14, 4, 'Капи‑ведущая', NULL, NULL, 1, 0, NULL, NULL),
(15, 4, 'Игра в кальмара', NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_29_115013_create_settings_table', 1),
(6, '2026_04_29_115014_create_slaider_table', 1),
(7, '2026_04_29_120259_create_items_table', 2),
(8, '2026_04_29_120301_create_reviews_table', 2),
(9, '2026_04_29_122018_create_services_table', 3),
(10, '2026_04_29_122019_create_service_features_table', 3),
(11, '2026_04_29_122020_create_heroes_table', 3),
(12, '2026_04_29_122021_create_packages_table', 3),
(13, '2026_10_21_083030_add_role_to_users_table', 4),
(14, '2026_10_21_085817_add_phone_to_users_table', 5),
(15, '2026_11_03_000001_create_orders_table', 6),
(16, '2026_11_03_000002_create_favorites_table', 6),
(17, '2026_11_03_000003_extend_settings_and_reviews', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) NOT NULL,
  `discount_percent` int NOT NULL,
  `services_json` json NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `packages`
--

INSERT INTO `packages` (`id`, `title`, `description`, `original_price`, `discounted_price`, `discount_percent`, `services_json`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Час счастья', 'Анимационная программа 45 минут + Экспресс‑поздравление от ростовой куклы. Два формата праздника в одном заказе!', '7000.00', '5500.00', 21, '[4, 1]', 1, 0, NULL, NULL),
(2, 'Анимация + Неоновое шоу в подарок', 'При заказе анимационной программы (45 минут) + экспресс‑поздравления дарим неоновое шоу!', '6000.00', '6000.00', 0, '[4, 1]', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `rating` int NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `discount_percent` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `duration`, `price`, `discounted_price`, `discount_percent`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Экспресс‑поздравление от ростовой куклы', '10–15 минут ярких эмоций. Ростовая кукла появляется неожиданно, обнимает, танцует, вручает подарок или шары, делает фото.', '10–15 минут', '3000.00', '2550.00', 15, 1, 0, NULL, NULL),
(2, 'Выездная анимационная программа (15 минут)', 'Праздник там, где вы! Аниматоры приезжают к вам домой, в кафе, в парк или в банкетный зал.', '15 минут', '3500.00', '3010.00', 14, 1, 0, NULL, NULL),
(3, 'Выездная анимационная программа (30 минут)', 'Праздник там, где вы! Аниматоры приезжают к вам домой, в кафе, в парк или в банкетный зал.', '30 минут', '4000.00', '3480.00', 13, 1, 0, NULL, NULL),
(4, 'Выездная анимационная программа (45 минут)', 'Праздник там, где вы! Аниматоры приезжают к вам домой, в кафе, в парк или в банкетный зал.', '45 минут', '4500.00', '3960.00', 12, 1, 0, NULL, NULL),
(5, 'Выездная анимационная программа (60 минут)', 'Праздник там, где вы! Аниматоры приезжают к вам домой, в кафе, в парк или в банкетный зал.', '60 минут', '5000.00', '4450.00', 11, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `service_features`
--

CREATE TABLE `service_features` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `feature_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `service_features`
--

INSERT INTO `service_features` (`id`, `service_id`, `feature_text`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Приезжаем со своей колонкой — качественный и громкий звук гарантирован.', 0, NULL, NULL),
(2, 1, 'На выбор 3–4 ваших любимых песни.', 0, NULL, NULL),
(3, 1, 'Чистые костюмы.', 0, NULL, NULL),
(4, 1, 'Опытный аниматор, который умеет танцевать, играть и заряжать энергией.', 0, NULL, NULL),
(5, 1, 'Фото и видео на наше устройство в подарок!', 0, NULL, NULL),
(6, 1, 'Все материалы мы отправляем вам после праздника.', 0, NULL, NULL),
(7, 4, 'Выезд 1 аниматора в костюме на выбор.', 0, NULL, NULL),
(8, 4, 'Игровая программа под ваш запрос (активная, спокойная, с конкурсами или танцами).', 0, NULL, NULL),
(9, 4, 'Интерактив с детьми на протяжении всего времени.', 0, NULL, NULL),
(10, 4, 'Неоновое, серебряное шоу или аквагрим — по договорённости.', 0, NULL, NULL),
(11, 4, 'Приезжаем со своей колонкой.', 0, NULL, NULL),
(12, 4, 'Чистые костюмы.', 0, NULL, NULL),
(13, 4, 'Опытный аниматор.', 0, NULL, NULL),
(14, 4, 'Фото и видео в подарок.', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `hero_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Поздравление ростовой куклы в Челябинске',
  `hero_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'лучший подарок 2025',
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promo_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promo_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `why_us_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `why_us_text` text COLLATE utf8mb4_unicode_ci,
  `main_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `hero_title`, `hero_subtitle`, `hero_image`, `promo_code`, `promo_text`, `created_at`, `updated_at`, `why_us_title`, `why_us_text`, `main_text`) VALUES
(2, 'Поздравление ростовой куклы в Челябинске', 'лучший подарок 2026', NULL, NULL, NULL, '2026-04-29 11:56:37', '2026-11-03 04:38:30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `slaider`
--

CREATE TABLE `slaider` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `slaider`
--

INSERT INTO `slaider` (`id`, `title`, `text`, `image_path`, `created_at`, `updated_at`, `sort_order`) VALUES
(1, 'Капибара', NULL, '/img/2.jpg', NULL, NULL, 0),
(2, 'Чебурашка', NULL, 'img/cheba.png', '2026-11-03 07:41:13', '2026-11-03 07:41:13', 0),
(3, 'Мишка', NULL, 'img/мишка.png', '2026-11-03 07:41:13', '2026-11-03 07:41:13', 0),
(4, 'Капибара', NULL, 'img/капи.png', '2026-11-03 07:41:13', '2026-11-03 07:41:13', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Администратор', 'admin@bk.ru', '89080703342', NULL, '1234', 'admin', NULL, '2026-10-21 10:38:47', '2026-10-21 10:38:47'),
(6, 'Валерия', 'lerra.nesterchuk@yandex.ru', '+79087000265', NULL, '$2y$12$RfsETAM6JqTlhNwAKMcfluRhB6.IWSBKsIuv784DvJX26OZmfHZK2', 'user', NULL, '2026-11-03 04:32:47', '2026-11-03 04:32:47'),
(7, 'Admin', 'admin@test.ru', '89000000000', NULL, '$2y$12$0QazxMgiktAJ5K0004eQp.vObM4W6gdWTZrkDJ3qzaHONp6z1X5zG', 'admin', NULL, '2026-11-03 04:37:04', '2026-11-03 04:37:04');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_package_id_foreign` (`package_id`),
  ADD KEY `favorites_service_id_foreign` (`service_id`),
  ADD KEY `favorites_hero_id_foreign` (`hero_id`);

--
-- Индексы таблицы `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `heroes_service_id_foreign` (`service_id`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_package_id_foreign` (`package_id`),
  ADD KEY `orders_service_id_foreign` (`service_id`);

--
-- Индексы таблицы `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_features`
--
ALTER TABLE `service_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_features_service_id_foreign` (`service_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `slaider`
--
ALTER TABLE `slaider`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `service_features`
--
ALTER TABLE `service_features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `slaider`
--
ALTER TABLE `slaider`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_hero_id_foreign` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `favorites_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `favorites_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `heroes`
--
ALTER TABLE `heroes`
  ADD CONSTRAINT `heroes_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `service_features`
--
ALTER TABLE `service_features`
  ADD CONSTRAINT `service_features_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
