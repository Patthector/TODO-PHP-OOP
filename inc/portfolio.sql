-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2018 at 09:23 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_app_collections`
--

DROP TABLE IF EXISTS `todo_app_collections`;
CREATE TABLE `todo_app_collections` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_fatherCollection` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_app_collections`
--

INSERT INTO `todo_app_collections` (`id`, `name`, `description`, `id_user`, `created_date`, `id_fatherCollection`, `updated_date`) VALUES
(1, 'Unknow', 'Default Library', 1, '2018-05-30 14:53:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `todo_app_tags`
--

DROP TABLE IF EXISTS `todo_app_tags`;
CREATE TABLE `todo_app_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_app_tags`
--

INSERT INTO `todo_app_tags` (`id`, `name`) VALUES
(60, '#accuplacer'),
(61, '#mdc');

-- --------------------------------------------------------

--
-- Table structure for table `todo_app_todos`
--

DROP TABLE IF EXISTS `todo_app_todos`;
CREATE TABLE `todo_app_todos` (
  `id` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `description` text,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_collection` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_app_todos`
--

INSERT INTO `todo_app_todos` (`id`, `name`, `description`, `created_date`, `updated_date`, `id_collection`, `id_user`, `level`) VALUES
(64, 'English Preparation Exam', 'Start the FULL-TIME tranning for the english exam', '2018-06-03 13:43:55', '2018-06-03 21:40:26', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `todo_app_todo_tag`
--

DROP TABLE IF EXISTS `todo_app_todo_tag`;
CREATE TABLE `todo_app_todo_tag` (
  `id_tag` int(11) DEFAULT NULL,
  `id_todo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_app_todo_tag`
--

INSERT INTO `todo_app_todo_tag` (`id_tag`, `id_todo`) VALUES
(60, 64),
(61, 64);

-- --------------------------------------------------------

--
-- Table structure for table `todo_app_users`
--

DROP TABLE IF EXISTS `todo_app_users`;
CREATE TABLE `todo_app_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(500) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todo_app_users`
--

INSERT INTO `todo_app_users` (`id`, `first_name`, `last_name`, `password`) VALUES
(1, 'Pattor', '', 'thepassword');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_app_collections`
--
ALTER TABLE `todo_app_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `todo_app_tags`
--
ALTER TABLE `todo_app_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo_app_todos`
--
ALTER TABLE `todo_app_todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_collection` (`id_collection`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `todo_app_todo_tag`
--
ALTER TABLE `todo_app_todo_tag`
  ADD KEY `id_tag` (`id_tag`),
  ADD KEY `id_todo` (`id_todo`);

--
-- Indexes for table `todo_app_users`
--
ALTER TABLE `todo_app_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_app_collections`
--
ALTER TABLE `todo_app_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `todo_app_tags`
--
ALTER TABLE `todo_app_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `todo_app_todos`
--
ALTER TABLE `todo_app_todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `todo_app_users`
--
ALTER TABLE `todo_app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `todo_app_collections`
--
ALTER TABLE `todo_app_collections`
  ADD CONSTRAINT `todo_app_collections_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `todo_app_users` (`id`);

--
-- Constraints for table `todo_app_todos`
--
ALTER TABLE `todo_app_todos`
  ADD CONSTRAINT `todo_app_todos_ibfk_1` FOREIGN KEY (`id_collection`) REFERENCES `todo_app_collections` (`id`),
  ADD CONSTRAINT `todo_app_todos_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `todo_app_users` (`id`);

--
-- Constraints for table `todo_app_todo_tag`
--
ALTER TABLE `todo_app_todo_tag`
  ADD CONSTRAINT `todo_app_todo_tag_ibfk_1` FOREIGN KEY (`id_tag`) REFERENCES `todo_app_tags` (`id`),
  ADD CONSTRAINT `todo_app_todo_tag_ibfk_2` FOREIGN KEY (`id_todo`) REFERENCES `todo_app_todos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
