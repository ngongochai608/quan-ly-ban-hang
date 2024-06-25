-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th6 24, 2024 lúc 09:50 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlybanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_05_12_095758_create_qlbh_users', 2),
(3, '2024_05_20_112751_create_qlbh_users', 3),
(4, '2024_05_20_113054_create_qlbh_users', 4),
(5, '2024_05_20_124614_create_qlbh_products', 5),
(6, '2024_05_22_084738_create_qlbh_products', 6),
(7, '2024_05_23_101250_create_qlbh_category_product', 7),
(8, '2024_05_26_093106_create_qlbh_table', 8),
(9, '2024_05_27_043635_create_qlbh_invoice', 9),
(10, '2024_05_29_124203_create_qlbh_invoice', 10),
(11, '2024_05_29_125126_create_qlbh_table', 11),
(12, '2024_05_31_083449_create_qlbh_invoice', 12),
(13, '2024_06_01_190711_create-qlbh-invoice', 13);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlbh_category_product`
--

CREATE TABLE `qlbh_category_product` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlbh_category_product`
--

INSERT INTO `qlbh_category_product` (`category_id`, `category_name`, `category_status`, `created_at`, `updated_at`) VALUES
(2, 'Nước Uống', '1', NULL, NULL),
(3, 'sốt trứng muối', '1', NULL, NULL),
(4, 'sốt phô mai', '1', NULL, NULL),
(5, 'sốt sa tế', '1', NULL, NULL),
(6, 'đồ nướng', '1', NULL, NULL),
(7, 'gỏi', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlbh_invoice`
--

CREATE TABLE `qlbh_invoice` (
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `invoice_name` varchar(255) NOT NULL,
  `invoice_table_id` varchar(255) NOT NULL,
  `invoice_info` varchar(255) NOT NULL,
  `invoice_status` varchar(255) NOT NULL,
  `invoice_discount_value` varchar(255) NOT NULL,
  `invoice_discount_type` varchar(255) NOT NULL,
  `invoice_total_price_discount` varchar(255) NOT NULL,
  `invoice_total_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlbh_invoice`
--

INSERT INTO `qlbh_invoice` (`invoice_id`, `invoice_name`, `invoice_table_id`, `invoice_info`, `invoice_status`, `invoice_discount_value`, `invoice_discount_type`, `invoice_total_price_discount`, `invoice_total_price`, `created_at`, `updated_at`) VALUES
(1, '5cVE33sIgt4qpV9iGCnu', '1', '{\"37\":2,\"38\":2,\"39\":1,\"40\":1,\"41\":2,\"42\":1,\"44\":1}', 'paid', '10', 'percent', '460000', '414000', '2024-06-01 12:10:58', NULL),
(2, 'tJunZakzPhIP6ptJ2vsp', '1', '{\"37\":2,\"38\":2,\"39\":1,\"40\":1,\"41\":2,\"42\":1,\"44\":1}', 'paid', '10', 'percent', '460000', '414000', '2024-06-03 04:55:32', NULL),
(3, 'RBgrnO1Tri7xZhJQ8rIF', '1', '{\"37\":2,\"38\":2,\"39\":1,\"40\":1,\"41\":2,\"42\":1,\"44\":1}', 'paid', '10', 'percent', '460000', '414000', '2024-06-03 04:57:34', NULL),
(4, 'NnVOBbhZ8Uxzf3npnqR5', '1', '{\"37\":2,\"38\":2,\"39\":1,\"40\":1,\"41\":2,\"42\":1,\"44\":1}', 'paid', '10', 'percent', '460000', '414000', '2024-06-05 02:32:41', NULL),
(5, 'lb0m3XYgTPa6u8yZFlL0', '1', '{\"37\":2}', 'paid', '', '', '', '100000', '2024-06-08 03:14:33', NULL),
(6, 'OFoPEiiCcE0XZhR3U11W', '1', '{\"38\":2}', 'paid', '', '', '', '100000', '2024-06-08 03:22:53', NULL),
(7, 'jluoZQ1iZvM42uPoey20', '1', '{\"37\":2,\"41\":6}', 'paid', '', '', '', '160000', '2024-06-10 04:46:50', NULL),
(8, 'QHruIIHSRUOkVoo1fHz6', '1', '{\"37\":1,\"38\":1,\"39\":1,\"40\":1,\"41\":3,\"42\":3}', 'paid', '', '', '', '430000', '2024-06-15 05:51:57', NULL),
(9, 'osXVRjOygtXMrXKSesys', '1', '{\"37\":2}', 'paid', '', '', '', '100000', '2024-06-20 04:17:02', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlbh_products`
--

CREATE TABLE `qlbh_products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_category_id` varchar(255) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlbh_products`
--

INSERT INTO `qlbh_products` (`product_id`, `product_name`, `product_image`, `product_price`, `product_category_id`, `product_status`, `created_at`, `updated_at`) VALUES
(37, 'ốc hương sốt trứng muối', '', '50000', '3', '', NULL, NULL),
(38, 'ốc hương sốt phô mai', '', '50000', '4', '', NULL, NULL),
(39, 'ốc hương sốt sa tế', '', '50000', '5', '', NULL, NULL),
(40, 'hầu nướng', '', '70000', '6', '', NULL, NULL),
(41, 'nước pepsi', '', '10000', '2', '', NULL, NULL),
(42, 'ốc móng tay sốt trứng muối', '', '60000', '3', '', NULL, NULL),
(43, 'ốc móng tay sốt phô mai', '', '60000', '4', '', NULL, NULL),
(44, 'ốc móng tay sốt sa tế', '', '60000', '5', '', NULL, NULL),
(45, 'gỏi bạch tuộc', '', '75000', '7', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlbh_table`
--

CREATE TABLE `qlbh_table` (
  `table_id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_invoice_id` varchar(255) NOT NULL,
  `table_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlbh_table`
--

INSERT INTO `qlbh_table` (`table_id`, `table_name`, `table_invoice_id`, `table_status`, `created_at`, `updated_at`) VALUES
(1, '01', '9', 'empty', NULL, NULL),
(2, '02', '', 'empty', NULL, NULL),
(3, '03', '', 'empty', NULL, NULL),
(4, '04', '', 'empty', NULL, NULL),
(5, '05', '', 'empty', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlbh_users`
--

CREATE TABLE `qlbh_users` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_phone` varchar(255) NOT NULL,
  `admin_role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlbh_users`
--

INSERT INTO `qlbh_users` (`admin_id`, `admin_username`, `admin_password`, `admin_phone`, `admin_role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '0969710597', 'admin', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `qlbh_category_product`
--
ALTER TABLE `qlbh_category_product`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `qlbh_invoice`
--
ALTER TABLE `qlbh_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Chỉ mục cho bảng `qlbh_products`
--
ALTER TABLE `qlbh_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `qlbh_table`
--
ALTER TABLE `qlbh_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Chỉ mục cho bảng `qlbh_users`
--
ALTER TABLE `qlbh_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `qlbh_users_admin_username_unique` (`admin_username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `qlbh_category_product`
--
ALTER TABLE `qlbh_category_product`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `qlbh_invoice`
--
ALTER TABLE `qlbh_invoice`
  MODIFY `invoice_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `qlbh_products`
--
ALTER TABLE `qlbh_products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `qlbh_table`
--
ALTER TABLE `qlbh_table`
  MODIFY `table_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `qlbh_users`
--
ALTER TABLE `qlbh_users`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
