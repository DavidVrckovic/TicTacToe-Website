-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 06:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tictactoe`
--

-- --------------------------------------------------------

--
-- Table structure for table `ultimatetictactoe_games`
--

CREATE TABLE `ultimatetictactoe_games` (
  `game_id` char(32) NOT NULL,
  `user_x_id` int(10) UNSIGNED DEFAULT NULL,
  `user_x_last_online` datetime DEFAULT NULL,
  `user_o_id` int(10) UNSIGNED DEFAULT NULL,
  `user_o_last_online` datetime DEFAULT NULL,
  `user_x_score` int(10) UNSIGNED DEFAULT NULL,
  `user_o_score` int(10) UNSIGNED DEFAULT NULL,
  `game_start_time` datetime DEFAULT NULL,
  `game_end_time` datetime DEFAULT NULL,
  `game_state` longtext DEFAULT NULL CHECK (json_valid(`game_state`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `ultimatetictactoe_games`
--

INSERT INTO `ultimatetictactoe_games` (`game_id`, `user_x_id`, `user_x_last_online`, `user_o_id`, `user_o_last_online`, `user_x_score`, `user_o_score`, `game_start_time`, `game_end_time`, `game_state`) VALUES
('49030ad042782acb5bc34da4636fed79', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_username` varchar(64) NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` char(69) NOT NULL,
  `user_last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `user_reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_email`, `user_password`, `user_last_login`, `user_reg_date`) VALUES
(1, 'David', 'dvrckovi1@tvz.hr', '$SHA#efa6947038cb0cfe92c9d6391a908dbd95c33c439a5ae4ca2185366ddd140aa9', '2025-08-09 14:26:00', '2025-07-27 22:01:04'),
(2, 'David2', 'dvrckovi1+test@tvz.hr', '$SHA#efa6947038cb0cfe92c9d6391a908dbd95c33c439a5ae4ca2185366ddd140aa9', '2025-08-09 14:29:36', '2025-07-27 22:19:23'),
(3, 'David3', 'dvrckovi1+test2@tvz.hr', '$SHA#efa6947038cb0cfe92c9d6391a908dbd95c33c439a5ae4ca2185366ddd140aa9', '2025-08-09 14:22:57', '2025-08-05 17:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `session_token` char(73) NOT NULL,
  `session_create_date` datetime NOT NULL DEFAULT current_timestamp(),
  `session_expire_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`session_id`, `user_id`, `session_token`, `session_create_date`, `session_expire_date`) VALUES
(1, 1, '$RB#$SHA#fe3c29606d6eeaba6be2b27243a9305c694795c0affe7396ef5d9e6baa3d3027', '2025-08-12 15:34:27', '2025-09-11 15:34:27'),
(2, 2, '$RB#$SHA#6b82fc01c3d6dfdb41105cb9a0ea270034b18eec04bf75ba6b2f7f9a50ba36e2', '2025-08-12 15:38:30', '2025-09-11 15:38:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ultimatetictactoe_games`
--
ALTER TABLE `ultimatetictactoe_games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_username` (`user_username`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `session_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
