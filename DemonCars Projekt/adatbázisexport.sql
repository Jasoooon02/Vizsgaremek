-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Gép: 172.17.0.1:3306
-- Létrehozás ideje: 2025. Ápr 16. 12:59
-- Kiszolgáló verziója: 8.0.32-24
-- PHP verzió: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `demoncars_db`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `engine` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cars`
--

INSERT INTO `cars` (`id`, `name`, `engine`, `price`) VALUES
(1, 'Golf MK4', 'Benzin 1.4', 1895000),
(2, 'Golf MK4', 'Dízel 1.9 TDI', 2095000),
(3, 'Audi R8', 'Benzin V8', 10890000),
(4, 'Audi R8', 'Benzin V10', 12895000),
(5, 'Bugatti Chiron', 'Benzin W16', 1190670000),
(7, 'Dodge Charger', 'Benzin V8', 5980000),
(8, 'Dodge Charger', 'Benzin V8 Supercharger', 6200000),
(9, 'Golf MK6', 'Benzin 1.2', 17210000),
(10, 'Golf MK6', 'Dízel 1.4', 18960000),
(11, 'BMW E39', 'Benzin 2.0', 20780000),
(12, 'BMW E39', 'Dízel 2.0', 22110000),
(13, 'BMW E46', 'Benzin 1.6', 29610000),
(14, 'BMW E46', 'Dízel 2.0', 31235000),
(15, 'Golf MK4', 'Benzin 1.6', 1985000),
(16, 'Golf MK4', 'Benzin 3.2 V6', 2985000),
(17, 'Golf MK6', 'Benzin 1.4', 18460000),
(18, 'Golf MK6', 'Benzin 1.6', 19105000),
(19, 'Golf MK6', 'Benzin 1.8', 19975000),
(20, 'Golf MK6', 'Benzin 2.0', 20740000),
(21, 'Golf MK6', 'Benzin 2.5', 22195000),
(22, 'Golf MK6', 'Dízel 1.6', 20695000),
(23, 'BMW E39', 'Benzin 2.2', 21925000),
(24, 'BMW E39', 'Benzin 3.5', 22490000),
(25, 'BMW E39', 'Benzin 4.9', 23995000),
(26, 'BMW E39', 'Dízel 2.5', 24555000),
(27, 'BMW E46', 'Dízel 3.0', 32560000),
(28, 'BMW E46', 'Benzin 2.0', 30755000),
(30, 'Pagani Huayra', 'Benzin V12 ', 895400000),
(31, 'Pagani Huayra', 'Benzin V12 Twin Turbo', 985980000),
(32, 'LaFerrari', 'Benzin 6.3 V12 ', 1340890000),
(33, 'Lamborghini Huracan STO', 'Benzin 5.2 V10', 150450000),
(34, 'Aston Martin Valkyrie', 'Benzin 6.5 V12', 680950000),
(35, 'Ford Shelby Cobra', 'Benzin 6.4 V8', 78960000),
(36, 'Ford Mustang Fastback', 'Benzin V8', 43380000),
(37, 'Plymouth Road Runner', 'Benzin 6.3 V8', 30230000),
(38, 'Plymouth Road Runner', 'Benzin 7.0 V8', 32975000),
(39, 'Plymouth Road Runner', 'Benzin 7.2 V8', 34995000),
(40, 'Ford Focus MK2', 'Benzin 1.4', 1775000),
(41, 'Ford Focus MK2', 'Benzin 1.6', 1915000),
(42, 'Ford Focus MK2', 'Benzin 1.8', 2285000),
(43, 'Ford Focus MK2', 'Dízel 1.8 TDI', 2765000),
(44, 'Ford Focus MK2', 'Benzin 2.0', 2960000),
(45, 'Ford Mustang Dark Horse', 'Benzin 5.0 V8', 130200000),
(46, 'Porsche 911 GT3', 'benzin Flat Six', 85560000),
(47, 'Chevrolet Corvette C8', 'benzin 5.5 V8', 29390000),
(48, 'Chevrolet Corvette C8', 'benzin 6.2 V8', 32470000),
(49, 'BMW M4 F82', 'benzin 3.0 twin-turbo I6', 38550000),
(50, 'Volkswagen Scirocco III', 'benzin 1.4 TSI', 5955000),
(51, 'Volkswagen Scirocco III', 'benzin 2.0 TSI', 6590000),
(52, 'Volkswagen Scirocco III', 'benzin 2.0 TDI', 7400000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `total_price` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `address`, `phone`, `payment_method`, `total_price`, `created_at`, `status`) VALUES
(53, 'Kelemen János', 'kelemenjanos400@gmail.com', 'Alkotmány utca 7', '06203430424', 'kártya', 85560000, '2025-03-31 08:11:24', 'Feldolgozás alatt'),
(54, 'Kelemen János', 'kelemenjanos400@gmail.com', 'Alkotmány utca 7', '06203430424', 'készpénz', 85560000, '2025-03-31 08:21:45', 'Kész'),
(55, 'Teszt Elek', 'teszt.elek@gmail.com', 'rét utca 42', '06 30 732 5678', 'paypal', 171120000, '2025-04-15 19:13:53', 'Feldolgozás alatt'),
(56, 'Teszt Elek', 'teszt.elek@gmail.com', 'rét utca 42', '06 30 732 5678', 'paypal', 85560000, '2025-04-15 20:24:55', 'Feldolgozás alatt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `car_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `engine` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `car_name`, `color`, `engine`, `price`) VALUES
(108, 53, 'Porsche 911 GT3', 'Fehér', 'benzin Flat Six', 85560000.00),
(109, 54, 'Porsche 911 GT3', 'Fehér', 'benzin Flat Six', 85560000.00),
(110, 55, 'Porsche 911 GT3', 'Fehér', 'benzin Flat Six', 85560000.00),
(111, 55, 'Porsche 911 GT3', 'Fehér', 'benzin Flat Six', 85560000.00),
(112, 56, 'Porsche 911 GT3', 'Fehér', 'benzin Flat Six', 85560000.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `otp` int NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `otp`, `expires_at`) VALUES
(11, 'kelemenjanos400@gmail.com', 896130, '2025-03-31 12:10:58'),
(12, 'kelemenjanos400@gmail.com', 181183, '2025-03-31 12:11:12'),
(13, 'kelemenjanos400@gmail.com', 895788, '2025-03-31 16:59:59'),
(14, 'kelemenjanos400@gmail.com', 572946, '2025-04-01 14:16:19'),
(15, 'teszt.elek@gmail.com', 439096, '2025-04-15 21:52:17'),
(16, 'teszt.elek@gmail.com', 546263, '2025-04-15 21:56:36'),
(17, 'teszt.elek@gmail.com', 351837, '2025-04-15 21:57:16'),
(18, 'teszt.elek@gmail.com', 697937, '2025-04-15 22:00:09'),
(19, 'teszt.elek@gmail.com', 100405, '2025-04-15 22:09:01');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_admin`) VALUES
(5, 'admin', '$2y$10$yVb9LMIfJlQ5nxXvVlYT/u7SQhUKXpVsxhiwnAOge1RxUyVk0XgQO', 'kelemenjanos400@gmail.com', 1),
(7, 'bazsi', '$2y$10$yPY5apkgKSOlKfxwSWooUOBtc0lW1meEm3hyf2.Zl0L.mzpj5QFVe', 'gasparbalazs06@gmail.com', 0),
(16, 'sziajani', '$2y$10$irlNM4C/PXizEkFQx3XiLu/WOd5I5Oof7hwVfsnwgfdJm4ymDgAeW', 'vidflowsupp@gmail.com', 0),
(17, 'Tlevi2020', '$2y$10$aAesM54kHUoI1idoijGW.uFDEea0LcIn4Gj7LoCZcSqH2skk0dwWu', 'takacs.exsample@gmail.com', 0),
(26, 'tesztadmin', '$2y$10$ZT4fulfySi82IYVLY/YFkO47nf3wejO7yTzMhBA0eYRGbrbgqA5rW', 'kelemenj.20d@acsjszki.hu', 1),
(28, 'birobarna', '$2y$10$idt5KP.sW0i1r.mRtlaEqOTq0JtRTMO4kYnOUi6mEAv2bBqN5xbPe', 'birobarna1@asdasd.com', 0),
(29, 'asd', '$2y$10$raPgc2RtBie6XUEbGG05U.i//jN/AS.WfPwUADUTTpd8KRgcLzQXu', 'kelemenvok22@gmail.com', 0),
(33, 'Teszt Elek', '$2y$10$NMWpqAbEQ.JcZU.h679bg.R9ZOLpdgnVQSBt6xKlOIhqfwL2GX8MW', 'teszt.elek@gmail.com', 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- A tábla indexei `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT a táblához `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT a táblához `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
