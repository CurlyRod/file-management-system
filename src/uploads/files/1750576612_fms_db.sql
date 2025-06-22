-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 10:53 AM
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
-- Database: `fms_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateFolder` (IN `in_user_id` INT, IN `in_folder_name` VARCHAR(100), IN `in_parent_folder_id` INT)   BEGIN  
INSERT INTO folders(user_id, folder_name, parent_folder_id) VALUES(in_user_id,in_folder_name,in_parent_folder_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteFilesById` (IN `filesId` INT)   BEGIN 
DELETE FROM files WHERE id = filesId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUserById` (IN `userId` INT)   BEGIN
    DELETE FROM user_acc WHERE id = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllFilesByID` ()   BEGIN 
SELECT firstname, middlename, lastname, files.id as fileID, files.original_name, files.file_type,files.filename,files.file_path,files.date_created  FROM user_acc AS AC
	INNER JOIN files ON files.user_id = AC.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllFolders` ()   BEGIN
    SELECT * FROM folders;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllResolvedTicket` ()   BEGIN 
SELECT firstname, middlename, lastname, files.id as fileID, files.original_name, files.file_type,files.filename,files.file_path,files.date_created  FROM user_acc AS AC
	INNER JOIN resolved_tickets as files ON files.user_id = AC.id 
    WHERE AC.role = 2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllUserFiles` ()   BEGIN 
 SELECT * FROM files;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllUsers` ()   BEGIN
    SELECT * FROM user_acc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFilePathByID` (IN `fileId` INT)   BEGIN 
SELECT original_name , file_path FROM files WHERE id = fileID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserById` (IN `in_user_id` INT)   BEGIN
    SELECT *
    FROM user_acc
    WHERE id = in_user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterUser` (IN `in_firstname` VARCHAR(50), IN `in_middlename` VARCHAR(50), IN `in_lastname` VARCHAR(50), IN `in_email` VARCHAR(100), IN `in_password_hash` VARCHAR(255), IN `in_role` VARCHAR(50))   BEGIN
    INSERT INTO user_acc (
        firstname, middlename, lastname, email, password_hash, role
    ) VALUES (
        in_firstname, in_middlename, in_lastname, in_email, in_password_hash, in_role
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SaveFiles` (IN `in_filename` VARCHAR(255), IN `in_file_path` VARCHAR(255), IN `in_user_id` INT)   BEGIN
    INSERT INTO files(filename, file_path, user_id) VALUES (in_filename, in_file_path, in_user_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SaveFilesByUser` (IN `in_filename` VARCHAR(255), IN `in_file_path` VARCHAR(255), IN `in_user_id` INT, IN `in_file_type` VARCHAR(100), IN `in_original_name` VARCHAR(255))   BEGIN
    INSERT INTO files (filename, file_path, user_id, file_type, original_name)
    VALUES (in_filename, in_file_path, in_user_id, in_file_type, in_original_name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SaveResolvedTickets` (IN `in_filename` VARCHAR(255), IN `in_file_path` VARCHAR(255), IN `in_user_id` INT, IN `in_file_type` VARCHAR(100), IN `in_original_name` VARCHAR(255))   BEGIN
    INSERT INTO resolved_tickets (filename, file_path, user_id, file_type, original_name)
    VALUES (in_filename, in_file_path, in_user_id, in_file_type, in_original_name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUser` (IN `in_id` INT, IN `in_firstname` VARCHAR(100), IN `in_middlename` VARCHAR(100), IN `in_lastname` VARCHAR(100), IN `in_email` VARCHAR(255), IN `in_role` INT)   BEGIN
    UPDATE user_acc
    SET firstname = in_firstname,
        middlename = in_middlename,
        lastname = in_lastname,
        email = in_email,
        role = in_role
    WHERE id = in_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `parent_folder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '0-Super Admin,1 Admin, 2 client',
  `folder_name` varchar(100) NOT NULL,
  `parent_folder_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `user_id`, `folder_name`, `parent_folder_id`, `date_created`) VALUES
(1, 3, 'Sample Folder', 0, '2025-06-04 23:39:02'),
(2, 3, 'Sample  1', 0, '2025-06-05 00:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `resolved_tickets`
--

CREATE TABLE `resolved_tickets` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_acc`
--

CREATE TABLE `user_acc` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  `status_acc` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_acc`
--

INSERT INTO `user_acc` (`id`, `email`, `password_hash`, `firstname`, `middlename`, `lastname`, `role`, `status_acc`, `date_created`) VALUES
(3, 'sas@gmail.com', '$2y$10$83bB2tz86rxTVY8fqMFgG.VMCxGmrLCHRrvpCYBRzrwGx6f4aiYF.', 'sasass', 'sas', 'asa', 2, 0, '2025-06-04 00:29:10'),
(7, 'sas@gmail.com', '$2y$10$ExpslLG8kKOxOClDN8g1pONU922QImwABw.hkJh4TTxyRgIUyKvru', 'sasa', 'sas', 'asa', 1, 0, '2025-06-04 00:29:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resolved_tickets`
--
ALTER TABLE `resolved_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_acc`
--
ALTER TABLE `user_acc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resolved_tickets`
--
ALTER TABLE `resolved_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_acc`
--
ALTER TABLE `user_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
