-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 18, 2025 lúc 05:19 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `test`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bep`
--

CREATE TABLE `bep` (
  `id` int(50) NOT NULL,
  `id_khachhang` int(50) NOT NULL,
  `anhmon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tenmon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `soluong` int(50) NOT NULL,
  `ngay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `bep`
--

INSERT INTO `bep` (`id`, `id_khachhang`, `anhmon`, `tenmon`, `soluong`, `ngay`) VALUES
(1, 1976, '4902102035415.jpg', 'N??c cam fanta', 1, '2025-05-15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `img` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` int(50) NOT NULL,
  `quantity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `congthuc`
--

CREATE TABLE `congthuc` (
  `id` int(100) NOT NULL,
  `id_monan` int(50) NOT NULL,
  `id_nguyenlieu` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `soluong` int(100) NOT NULL,
  `donvi` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `congthuc`
--

INSERT INTO `congthuc` (`id`, `id_monan`, `id_nguyenlieu`, `soluong`, `donvi`) VALUES
(167, 31, '13', 40, 'gram'),
(168, 31, '9', 30, 'ml'),
(169, 31, '11', 20, 'gram'),
(170, 31, '26', 20, 'gram'),
(171, 31, '12', 20, 'gram'),
(172, 40, '13', 20, 'gram'),
(173, 40, '25', 20, 'ml'),
(174, 40, '10', 20, 'ml'),
(175, 40, '16', 20, 'gram'),
(176, 40, '15', 20, 'gram'),
(177, 39, '24', 20, 'gram'),
(178, 39, '9', 30, 'ml'),
(179, 39, '11', 20, 'gram'),
(180, 39, '12', 20, 'gram'),
(181, 33, '14', 30, 'gram'),
(182, 33, '10', 20, 'ml'),
(183, 33, '9', 20, 'ml'),
(184, 33, '26', 20, 'gram'),
(185, 33, '15', 20, 'gram'),
(186, 33, '16', 20, 'gram'),
(187, 34, '18', 30, 'gram'),
(188, 34, '10', 20, 'ml'),
(189, 34, '9', 20, 'ml'),
(190, 34, '11', 20, 'gram'),
(191, 34, '19', 20, 'ml'),
(192, 34, '12', 20, 'gram'),
(193, 35, '20', 20, 'gram'),
(194, 35, '9', 20, 'ml'),
(195, 35, '10', 20, 'ml'),
(196, 35, '11', 20, 'gram'),
(197, 35, '21', 20, 'gram'),
(198, 35, '12', 20, 'gram'),
(199, 32, '8', 30, 'gram'),
(200, 32, '9', 20, 'ml'),
(201, 32, '10', 20, 'ml'),
(202, 32, '11', 20, 'gram'),
(203, 32, '26', 20, 'gram'),
(204, 38, '22', 20, 'gram'),
(205, 38, '9', 20, 'ml'),
(206, 38, '10', 20, 'ml'),
(207, 38, '11', 20, 'gram'),
(208, 38, '12', 20, 'gram');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanhthu`
--

CREATE TABLE `doanhthu` (
  `id` int(50) NOT NULL,
  `mon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `soluongban` int(50) NOT NULL,
  `tongtien` int(50) NOT NULL,
  `dongia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `id` int(100) NOT NULL,
  `idkhachhang` int(100) NOT NULL,
  `anhmon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tenmon` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `somon` int(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `total` int(50) NOT NULL,
  `cost` int(100) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `id` int(100) NOT NULL,
  `id_khachhang` int(11) NOT NULL,
  `tensp` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `soluong` int(100) NOT NULL,
  `tongtien` int(100) NOT NULL,
  `ngaydat` date NOT NULL,
  `giasp` int(11) NOT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`id`, `id_khachhang`, `tensp`, `soluong`, `tongtien`, `ngaydat`, `giasp`, `payment_method`) VALUES
(38, 91748, 'Nước cam fanta', 50, 1000000, '2025-05-14', 20000, ''),
(39, 63474, 'pepsi', 1, 35000, '2025-05-15', 15000, ''),
(40, 63474, 'Nước cam fanta', 1, 35000, '2025-05-15', 20000, ''),
(41, 63474, 'pepsi', 1, 35000, '2025-05-15', 15000, ''),
(42, 63474, 'Nước cam fanta', 1, 35000, '2025-05-15', 20000, ''),
(43, 11795, 'Nước cam fanta', 3, 60000, '2025-05-15', 20000, ''),
(44, 11795, 'Nước cam fanta', 3, 60000, '2025-05-15', 20000, ''),
(45, 63474, 'pepsi', 1, 35000, '2025-05-15', 15000, ''),
(46, 63474, 'Nước cam fanta', 1, 35000, '2025-05-15', 20000, ''),
(47, 2063, 'Nước cam fanta', 1, 20000, '2025-05-20', 20000, ''),
(48, 24234, 'pepsi', 1, 15000, '2025-05-30', 15000, ''),
(49, 63474, 'pepsi', 1, 15000, '2025-05-15', 15000, ''),
(50, 63474, 'Nước cam fanta', 1, 20000, '2025-05-15', 20000, ''),
(51, 2063, 'Nước cam fanta', 1, 20000, '2025-05-20', 20000, ''),
(55, 91788, 'Trà sữa truyền thống', 1, 100000, '2025-06-04', 50000, NULL),
(56, 91788, 'Trà sữa thái xanh', 1, 100000, '2025-06-04', 50000, NULL),
(57, 91788, 'Trà sữa truyền thống', 1, 50000, '2025-06-04', 50000, 'Tiền mặt'),
(58, 91788, 'Trà sữa thái xanh', 1, 50000, '2025-06-04', 50000, 'Tiền mặt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `main_menu`
--

CREATE TABLE `main_menu` (
  `id` int(100) NOT NULL,
  `product_img` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(50) NOT NULL,
  `product_quantity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int(50) NOT NULL,
  `anh` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ten` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id`, `anh`, `ten`, `gia`) VALUES
(31, '409664.jpg', 'Trà sữa truyền thống', 50000),
(32, 'Tra-thai-xanh-08111.jpg', 'Trà sữa thái xanh', 50000),
(33, 'cach-lam-tra-sua-matcha-kem-cheese-jpeg.webp', 'Trà sữa Matcha', 50000),
(34, 'cach-lam-tra-sua-socola-4.jpg', 'Trà sữa socola', 50000),
(35, '57d3ad_eb3fc685e016483bbf860c01f0fdb13f~mv2.png', 'Trà sữa hoa nhài', 50000),
(38, 'o3_f14456eb3eb445f29cc9ee3f8e35e7a8_grande.webp', 'Trà sữa ô long', 50000),
(39, 'trà-sữa-Pozaa-31.jpg', 'Hồng trà sữa', 50000),
(40, 'cach-lam-tra-sua-dau-5.jpg.webp', 'Trà sữa dâu', 50000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguyenlieu`
--

CREATE TABLE `nguyenlieu` (
  `id` int(50) NOT NULL,
  `ten` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `donvi` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gia` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `nguyenlieu`
--

INSERT INTO `nguyenlieu` (`id`, `ten`, `donvi`, `gia`) VALUES
(8, 'trà thái xanh', 'gram', 200),
(9, 'sữa đặc ', 'ml', 200),
(10, 'sữa tươi', 'ml', 300),
(11, 'đường', 'gram', 200),
(12, 'trân châu đen', 'gram', 500),
(13, 'trà đen', 'gram', 200),
(14, 'Bột matcha', 'gram', 300),
(15, 'Trân châu trắng', 'gram', 300),
(16, ' thạch rau câu', 'gram', 200),
(18, 'Bột cacao', 'gram', 300),
(19, 'kem cheese', 'ml', 400),
(20, 'Trà nhài', 'gram', 300),
(21, 'Thạch nha đam', 'gram', 300),
(22, 'Trà ô long', 'gram', 500),
(23, 'thạch củ năng', 'gram', 200),
(24, 'Hồng trà', 'gram', 300),
(25, 'siro dâu', 'ml', 200),
(26, 'Đá', 'gram', 100);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhapkho`
--

CREATE TABLE `nhapkho` (
  `id` int(50) NOT NULL,
  `id_nguyenlieu` int(50) NOT NULL,
  `soluong` int(100) NOT NULL,
  `ngay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `nhapkho`
--

INSERT INTO `nhapkho` (`id`, `id_nguyenlieu`, `soluong`, `ngay`) VALUES
(30, 8, 2000, '2025-05-30'),
(31, 9, 10000, '2025-05-30'),
(32, 10, 10000, '2025-05-30'),
(33, 11, 10000, '2025-05-30'),
(34, 12, 10000, '2025-05-30'),
(35, 13, 10000, '2025-05-30'),
(36, 14, 20000, '2025-05-30'),
(37, 15, 10000, '2025-05-30'),
(38, 16, 10000, '2025-05-30'),
(39, 18, 10000, '2025-05-30'),
(40, 19, 20000, '2025-05-30'),
(41, 20, 10000, '2025-05-30'),
(42, 21, 10000, '2025-05-30'),
(43, 22, 10000, '2025-05-30'),
(44, 23, 10000, '2025-05-30'),
(45, 24, 10000, '2025-05-30'),
(46, 25, 10000, '2025-05-30'),
(47, 26, 100000, '2025-05-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `phone`, `email`) VALUES
(4, 'duong123', '123456', 'duong', '0355463704', 'tung8c2004@gmail.com'),
(7, 'tung22072004', '12345', 'nguyễn hữu tùng', '0355463704', 'tung8c2004@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bep`
--
ALTER TABLE `bep`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `congthuc`
--
ALTER TABLE `congthuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `doanhthu`
--
ALTER TABLE `doanhthu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `main_menu`
--
ALTER TABLE `main_menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhapkho`
--
ALTER TABLE `nhapkho`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bep`
--
ALTER TABLE `bep`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT cho bảng `congthuc`
--
ALTER TABLE `congthuc`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT cho bảng `doanhthu`
--
ALTER TABLE `doanhthu`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `main_menu`
--
ALTER TABLE `main_menu`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `nhapkho`
--
ALTER TABLE `nhapkho`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
