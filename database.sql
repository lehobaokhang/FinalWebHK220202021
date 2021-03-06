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
(1, 'Facebook', 1, 'Facebook', 4.9, 'C???p nh???t th??ng tin t??? b???n b?? nhanh ch??ng h??n bao gi??? h???t.', 'Gi??? b???n c?? th??? truy c???p s???m phi??n b???n Facebook d??nh cho Android ti???p theo b???ng c??ch tr??? th??nh ng?????i d??ng th??? beta. T??m hi???u c??ch th???c ????ng k??, g???i ph???n h???i v?? r???i kh???i ch????ng tr??nh t???i Trung t??m tr??? gi??p c???a ch??ng t??i', 1123847219, 0, 1, 1),
(2, 'Excel', 3, 'Microsoft', 4.1, '???ng d???ng b???ng t??nh Excel m???nh m??? gi??p b???n t???o, xem, ch???nh s???a c??ng nh?? chia s??? t???p v???i ng?????i kh??c nhanh ch??ng v?? d??? d??ng', '???ng d???ng n??y ???????c cung c???p b???i Microsoft ho???c m???t nh?? ph??t h??nh ???ng d???ng b??n th??? ba v?? tu??n theo ??i???u kho???n v??? quy???n ri??ng t?? c??ng nh?? c??c ??i???u kho???n v?? ??i???u ki???n ri??ng', 2, 0, 1, 1),
(3, 'PDF', 3, 'Microsoft', 3.7, 'M???t ???ng d???ng ?????c c??c file PDF', 'B???n c?? th??? xem ???????c c??c file PDF th??ng qua ???ng d???ng n??y', 187592, 0, 1, 1),
(4, 'Word', 3, 'Microsoft', 4, '???ng d???ng Word ????ng tin c???y gi??p b???n t???o, ch???nh s???a, xem v?? chia s??? t???p v???i ng?????i kh??c m???t c??ch nhanh ch??ng v?? d??? d??ng', '???ng d???ng n??y ???????c cung c???p b???i Microsoft ho???c m???t nh?? ph??t h??nh ???ng d???ng b??n th??? ba v?? tu??n theo ??i???u kho???n v??? quy???n ri??ng t?? c??ng nh?? c??c ??i???u kho???n v?? ??i???u ki???n ri??ng', 17482058, 0, 1, 1),
(5, 'Among Us', 2, 'Among Us\r\nInnersloth LLC', 4.2, 'M???t tr?? ch??i c?? t??n Among Us', 'Tr?? ch??i t??n Among Us kh?? th???nh h??nh', 1895284, 0, 1, 1),
(6, 'King Chess', 2, 'Chess', 2.1, 'Tr?? ch??i m?? ph???ng c??? vua', 'C??c n?????c c??? c???a AI c?? th??? khi???n b???n g???p kh?? kh??n', 1123847220, 0, 1, 1),
(7, 'PUBG', 2, 'VNG', 4.4, 'PUBG Mobile - PLAYERUNKNOWN\'S BATTLEGROUNDS MOBILE', 'L?? game b???n s??ng sinh t???n ???????c y??u th??ch tr??n to??n th??? gi???i do Tencent & BlueHole nghi??n c???u, ph??t tri???n v?? ???? ???????c ph??t h??nh ch??nh th???c t???i Vi???t Nam, duy nh???t b???i VNG.', 104927524, 100000, 1, 1),
(8, 'Slither.io', 2, 'Slither', 1.3, 'Slither.io', 'Game Slither.io', 198424, 0, 1, 1),
(9, 'Hitman Sniper', 2, 'VNG', 1.1, 'X??? Th??? ????nh Thu??', 'V??o vai Agent 47 trong Hitman Sniper v?? kh??m ph?? nh???ng tr???i nghi???m b???n t???a h???p d???n nh???t tr??n di ?????ng.', 19250, 9000, 1, 1),
(10, 'Minecraft', 2, 'Microsoft', 3.2, 'Game Minecraft', 'Game v??? nh???ng kh???i l???p ph????ng', 19852, 100000, 1, 1),
(11, 'Minibus Simulator', 2, 'VNG', 4.3, 'Game t??n Minibus Simulator', 'Minibus Simulator Vietnam c?? th??? n??i l?? m???t phi??n b???n c?? ????? h???a l???t x??c ho??n to??n m???i. V???i nhi???u t??nh n??ng th?? v???, kh???c ph???c nhi???u l???i, ???????c t???i ??u h??a, c???i thi???n ????? ?????t hi???u su???t FPS cao nh???t', 12895, 11, 1, 1),
(12, 'Real Flight Simulator', 2, 'Google', 3, 'Game m?? ph???ng', 'Cho b???n c???m gi??c ??ang l??i m???t chi???c m??y bay', 12987, 1000000, 1, 1),
(13, 'Messenger', 1, 'Facebook', 5, 'Nh???n tin v?? g???i video mi???n ph??', 'T??? h???p b??n nhau m???i l??c b???ng ???ng d???ng giao ti???p ??a n??ng, mi???n ph??* c???a ch??ng t??i, ho??n ch???nh v???i c??c t??nh n??ng nh???n tin, g???i tho???i, g???i video v?? nh??m chat video kh??ng gi???i h???n. D??? d??ng ?????ng b??? tin nh???n v?? danh b??? v???i ??i???n tho???i Android, ?????ng th???i k???t n???i v???i m???i ng?????i ??? m???i n??i.\r\n', 184928572, 0, 1, 1),
(14, 'Google Meet', 1, 'Google', 4.4, '???ng D???ng Google Meet', 'M???t ???ng d???ng h???p v?? h???c t???p online', 1847294, 0, 1, 1),
(15, 'Zoom', 1, 'Zoom', 4.4, '???ng D???ng Zoom', 'M???t ???ng d???ng h???p v?? h???c t???p online', 19482, 0, 1, 1),
(16, 'Camera Pro', 1, 'Google', 3.4, '???ng d???ng Camera Pro', 'M???t ???ng d???ng h??? tr??? cho camera c???a b???n', 12215, 29000, 1, 1),
(17, 'IELTS PRACTICE PRO', 1, 'Google', 3.2, '???ng d???ng v??? ??n t???p IELTS', 'Gi??p b???n ??n t???p thi IELTS', 1985, 999000, 1, 1),
(18, 'MX Player', 1, 'Google', 4.8, '???ng d???ng MX Player', '???ng d???ng ph??t video trong thi???t b??? c???a b???n', 198, 99000, 1, 1),
(19, 'QR Scan', 1, 'QR', 4, '???ng d???ng QR Scan', '???ng d???ng qu??t v??o t???o m?? QR', 1, 59000, 1, 1);

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
