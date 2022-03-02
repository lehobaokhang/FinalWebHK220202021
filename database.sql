-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 03:11 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_web`
--
CREATE DATABASE IF NOT EXISTS `database_web` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `database_web`;

-- --------------------------------------------------------

--
-- Table structure for table `app_censorship`
--

CREATE TABLE `app_censorship` (
  `app_id` int(11) NOT NULL,
  `admin_confirm` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_comment`
--

CREATE TABLE `app_comment` (
  `id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_info`
--

CREATE TABLE `app_info` (
  `app_id` int(10) NOT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `kind_id` int(11) DEFAULT NULL,
  `app_name_dev` varchar(255) DEFAULT NULL,
  `app_rate` float DEFAULT 0,
  `short_describe` text DEFAULT NULL,
  `detail_describe` longtext DEFAULT NULL,
  `app_downloads` int(21) DEFAULT 0,
  `app_price` int(51) DEFAULT NULL,
  `app_status` int(11) DEFAULT NULL,
  `app_upload` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_info`
--

INSERT INTO `app_info` (`app_id`, `app_name`, `kind_id`, `app_name_dev`, `app_rate`, `short_describe`, `detail_describe`, `app_downloads`, `app_price`, `app_status`, `app_upload`) VALUES
(1, 'Facebook', 1, 'Facebook', 4.9, 'Cập nhật thông tin từ bạn bè nhanh chóng hơn bao giờ hết.', 'Giờ bạn có thể truy cập sớm phiên bản Facebook dành cho Android tiếp theo bằng cách trở thành người dùng thử beta. Tìm hiểu cách thức đăng ký, gửi phản hồi và rời khỏi chương trình tại Trung tâm trợ giúp của chúng tôi', 1123847219, 0, 1, 1),
(2, 'Excel', 3, 'Microsoft', 4.1, 'Ứng dụng bảng tính Excel mạnh mẽ giúp bạn tạo, xem, chỉnh sửa cũng như chia sẻ tệp với người khác nhanh chóng và dễ dàng', 'Ứng dụng này được cung cấp bởi Microsoft hoặc một nhà phát hành ứng dụng bên thứ ba và tuân theo điều khoản về quyền riêng tư cũng như các điều khoản và điều kiện riêng', 2, 0, 1, 1),
(3, 'PDF', 3, 'Microsoft', 3.7, 'Một ứng dụng đọc các file PDF', 'Bạn có thể xem được các file PDF thông qua ứng dụng này', 187592, 0, 1, 1),
(4, 'Word', 3, 'Microsoft', 4, 'Ứng dụng Word đáng tin cậy giúp bạn tạo, chỉnh sửa, xem và chia sẻ tệp với người khác một cách nhanh chóng và dễ dàng', 'Ứng dụng này được cung cấp bởi Microsoft hoặc một nhà phát hành ứng dụng bên thứ ba và tuân theo điều khoản về quyền riêng tư cũng như các điều khoản và điều kiện riêng', 17482058, 0, 1, 1),
(5, 'Among Us', 2, 'Among Us\r\nInnersloth LLC', 4.2, 'Một trò chơi có tên Among Us', 'Trò chơi tên Among Us khá thịnh hành', 1895284, 0, 1, 1),
(6, 'King Chess', 2, 'Chess', 2.1, 'Trò chơi mô phỏng cờ vua', 'Các nước cờ của AI có thể khiến bạn gặp khó khăn', 1123847220, 0, 1, 1),
(7, 'PUBG', 2, 'VNG', 4.4, 'PUBG Mobile - PLAYERUNKNOWN\'S BATTLEGROUNDS MOBILE', 'Là game bắn súng sinh tồn được yêu thích trên toàn thế giới do Tencent & BlueHole nghiên cứu, phát triển và đã được phát hành chính thức tại Việt Nam, duy nhất bởi VNG.', 104927524, 100000, 1, 1),
(8, 'Slither.io', 2, 'Slither', 1.3, 'Slither.io', 'Game Slither.io', 198424, 0, 1, 1),
(9, 'Hitman Sniper', 2, 'VNG', 1.1, 'Xạ Thủ Đánh Thuê', 'Vào vai Agent 47 trong Hitman Sniper và khám phá những trải nghiệm bắn tỉa hấp dẫn nhất trên di động.', 19250, 9000, 1, 1),
(10, 'Minecraft', 2, 'Microsoft', 3.2, 'Game Minecraft', 'Game về những khối lập phương', 19852, 100000, 1, 1),
(11, 'Minibus Simulator', 2, 'VNG', 4.3, 'Game tên Minibus Simulator', 'Minibus Simulator Vietnam có thể nói là một phiên bản có đồ họa lột xác hoàn toàn mới. Với nhiều tính năng thú vị, khắc phục nhiều lỗi, được tối ưu hóa, cải thiện để đạt hiệu suất FPS cao nhất', 12895, 11, 1, 1),
(12, 'Real Flight Simulator', 2, 'Google', 3, 'Game mô phỏng', 'Cho bạn cảm giác đang lái một chiếc máy bay', 12987, 1000000, 1, 1),
(13, 'Messenger', 1, 'Facebook', 5, 'Nhắn tin và gọi video miễn phí', 'Tụ họp bên nhau mọi lúc bằng ứng dụng giao tiếp đa năng, miễn phí* của chúng tôi, hoàn chỉnh với các tính năng nhắn tin, gọi thoại, gọi video và nhóm chat video không giới hạn. Dễ dàng đồng bộ tin nhắn và danh bạ với điện thoại Android, đồng thời kết nối với mọi người ở mọi nơi.\r\n', 184928572, 0, 1, 1),
(14, 'Google Meet', 1, 'Google', 4.4, 'Ứng Dụng Google Meet', 'Một ứng dụng họp và học tập online', 1847294, 0, 1, 1),
(15, 'Zoom', 1, 'Zoom', 4.4, 'Ứng Dụng Zoom', 'Một ứng dụng họp và học tập online', 19482, 0, 1, 1),
(16, 'Camera Pro', 1, 'Google', 3.4, 'Ứng dụng Camera Pro', 'Một ứng dụng hỗ trợ cho camera của bạn', 12215, 29000, 1, 1),
(17, 'IELTS PRACTICE PRO', 1, 'Google', 3.2, 'Ứng dụng về ôn tập IELTS', 'Giúp bạn ôn tập thi IELTS', 1985, 999000, 1, 1),
(18, 'MX Player', 1, 'Google', 4.8, 'Ứng dụng MX Player', 'Ứng dụng phát video trong thiết bị của bạn', 198, 99000, 1, 1),
(19, 'QR Scan', 1, 'QR', 4, 'Ứng dụng QR Scan', 'Ứng dụng quét vào tạo mã QR', 1, 59000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `create_money`
--

CREATE TABLE `create_money` (
  `id` int(11) NOT NULL,
  `option_money` int(11) NOT NULL,
  `seri` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `date_create_money` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `create_money`
--

INSERT INTO `create_money` (`id`, `option_money`, `seri`, `exp`, `date_create_money`) VALUES
(1, 50000, 1183524709, 1, '19-05-2021'),
(2, 50000, 1344798640, 1, '19-05-2021'),
(3, 100000, 1221720024, 1, '19-05-2021'),
(4, 100000, 1947371988, 1, '19-05-2021'),
(5, 200000, 1738411840, 1, '19-05-2021'),
(6, 200000, 1601808104, 1, '19-05-2021'),
(7, 500000, 1479618487, 1, '19-05-2021'),
(8, 500000, 1464534895, 1, '19-05-2021');

-- --------------------------------------------------------

--
-- Table structure for table `download_info`
--

CREATE TABLE `download_info` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_dev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(10) NOT NULL,
  `seri` int(10) NOT NULL,
  `exp` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birth` date NOT NULL,
  `money` int(15) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activate_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `first_name`, `last_name`, `address`, `birth`, `money`, `password`, `activate_token`, `level`) VALUES
('admin@gmail.com', 'admin@gmail.com', 'admin', 'admin', 'admin', '2021-05-29', 0, '$2y$10$q2MSYXqb4/bJXBsc0zD4sOwv5XxNWfAFqbtZAk/52/k7GnmWnLsaG', '1d13db03348cf5b6d7333564f88abf21', 0),
('dev@gmail.com', 'dev@gmail.com', 'Dev', 'Dev', 'dev@gmail.com', '2021-05-19', 0, '$2y$10$nTiXau4KzTOytIkugh0v7O/4OvKrQgiP.yddRNjpdW2Hl0lt6QKNe', '39950b1bf966b968a9785db2f0ffe6e1', 1),
('user@gmail.com', 'user@gmail.com', 'User', 'User', 'User', '2021-05-19', 0, '$2y$10$HBQ1eviHb43Hwm/jBl.nKeDYJTke95RnWIfNXBz2X7kvOVAPqEYBO', 'ff10766672ddd3dc361f5d7655e40c51', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_comment`
--
ALTER TABLE `app_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_info`
--
ALTER TABLE `app_info`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `create_money`
--
ALTER TABLE `create_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `download_info`
--
ALTER TABLE `download_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_comment`
--
ALTER TABLE `app_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `create_money`
--
ALTER TABLE `create_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `download_info`
--
ALTER TABLE `download_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
