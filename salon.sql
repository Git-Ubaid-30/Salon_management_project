-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 05:39 PM
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
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_info` varchar(200) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL DEFAULT current_timestamp(),
  `status` enum('Approve','Approved','Completed','Cancelled') NOT NULL,
  `user_id` int(11) NOT NULL,
  `stylist_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `email`, `contact_info`, `appointment_date`, `appointment_time`, `status`, `user_id`, `stylist_id`, `service_id`) VALUES
(17, 'Ayan Ghanchi', 'ali@gmail.com', '785463868638', '2024-11-29', '10:01:12', 'Approved', 2, 17, 8),
(18, 'Ayan Ghanchi', 'ali@gmail.com', '123456789654', '2024-11-27', '09:35:52', 'Approved', 5, 23, 7),
(19, 'Ayan Ghanchi', 'ali@gmail.com', '0326374586976', '2024-11-27', '10:35:39', 'Approved', 5, 18, 9),
(20, 'Ayan Ghanchi', 'ali@gmail.com', '785463868638', '2024-12-02', '16:05:04', 'Approve', 2, 14, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `des` text NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `des`, `image`) VALUES
(47, 'Hare care', 'Hello', '1.webp'),
(48, 'Skin care', 'Hello', '6.webp'),
(49, 'Natural', 'Hello', '2.webp'),
(50, 'Blusher', 'Hello', '5.webp'),
(51, 'lip stick', 'Hello', '3.webp'),
(52, 'Face skin', 'Hello', '4.webp');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `user_id`, `name`, `email`, `note`) VALUES
(16, 5, 'hair product khan', 'zayan@gmail.com', 'vjoejwiojojvo'),
(17, 5, 'Ayan khan', 'zayan@gmail.com', 'dvjioojioj'),
(18, 5, 'ubaid khan', 'zayan@gmail.com', 'jveaojovj'),
(19, 5, 'food khan', 'zayan@gmail.com', 'kjadkjvikadj'),
(20, 5, 'food khan', 'zayan@gmail.com', 'eiahievhiahidvh'),
(21, 5, 'Ayan khan', 'ayan@gmail.com', '12visvvish'),
(22, 5, 'hair product khan', 'zayan@gmail.com', 's OJOJ OJ'),
(23, 5, 'food khan', 'zayan@gmail.com', 'ieihrihi'),
(24, 5, 'ubaid khan', 'zayan@gmail.com', 'heiahihvih'),
(25, 2, 'Ayan Ghanchi', 'ali@gmail.com', 'jkjiijiji');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `service_rating` decimal(2,1) NOT NULL,
  `product_rating` decimal(2,1) NOT NULL,
  `review` text NOT NULL,
  `tital` varchar(500) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `name`, `service_rating`, `product_rating`, `review`, `tital`, `email`) VALUES
(16, 2, 'ayan', 4.0, 3.0, '6', 'igiwirhih', 'aya@gmail.com'),
(17, 2, 'ayan', 2.0, 4.0, 'kvijsijriv', 'igiwirhih', 'ali@gmail.com'),
(18, 2, 'ayan', 3.0, 4.0, 'nkknknk', 'igiwirhih', 'ali@gmail.com'),
(19, 5, 'Zufra', 4.0, 3.0, 'htnf', 'Excellent', 'zufra@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `street_address2` varchar(255) DEFAULT NULL,
  `town` varchar(255) NOT NULL,
  `postcode` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `order_notes` text DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `first_name`, `last_name`, `street_address`, `street_address2`, `town`, `postcode`, `phone`, `email`, `order_notes`, `subtotal`, `shipping_cost`, `total_amount`, `payment_method`, `order_status`, `created_at`) VALUES
(31, 'Ayan', 'Ghanchi', 'zhshsh', '', 'lyari', '', '03222576674', 'ali@gmail.com', '', 121.00, 2.00, 123.00, 'Cash on Delivery', 'Pending', '2024-11-19 09:49:50'),
(32, 'Ayan', 'Ghanchi', 'zhshsh', '', 'lyari', '', '03222576674', 'ali@gmail.com', '', 3000.00, 2.00, 3002.00, 'Cash on Delivery', 'Pending', '2024-11-19 09:50:13'),
(34, 'Sir Muneeb', 'ullah', 'Aptech', '', 'Karachi', '', '', 'abc@gmail.com', '', 31800.00, 2.00, 31802.00, 'Cash on Delivery', 'Pending', '2024-11-30 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `user_name`, `user_email`, `product_id`, `product_name`, `product_price`, `product_qty`, `status`, `date_time`) VALUES
(47, 2, 'ali khan', 'ali@gmail.com', 23, 'hair care', 1000, 3, 'Scheduled', '2024-11-19 09:50:13'),
(52, 6, 'a', 'abc@gmail.com', 33, 'Scalp Treatments', 5000, 6, 'Scheduled', '2024-11-30 11:00:00'),
(53, 6, 'a', 'abc@gmail.com', 66, 'Anti-Aging Serums &amp; Toners', 300, 6, 'Scheduled', '2024-11-30 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `des` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `des`, `image`, `price`, `qty`, `rating`, `date`, `category_id`, `supplier_id`) VALUES
(23, 'GlowSkin Essentials', 'Gentle care for smooth, radiant, and healthy skin.', 'face.1.webp', 1000.00, 119, 4.0, '2024-11-06', 52, 18),
(29, 'Shampoo &amp; Conditioners', 'Cleansing and nourishing products that promote healthy, shiny hair with various formulas for different hair types.', 'hair.1.webp', 2000.00, -3, 4.0, '2024-11-23', 47, 10),
(30, 'Hair Repair &amp; Split End Solutions', 'Specialized treatments for repairing split ends, damaged strands, and overall hair health.', 'hair.2.webp', 1000.00, 35, 3.0, '2024-11-23', 47, 13),
(31, 'Curly Hair Care', 'Specially formulated products for curly, wavy, and textured hair to enhance natural curls and reduce frizz.', 'hair.3.webp', 600.00, 205, 4.0, '2024-11-23', 47, 14),
(32, 'Heat Protection Sprays', 'Shields hair from heat damage caused by styling tools while maintaining shine and smoothness.', 'hair.4.webp', 1000.00, 321, 5.0, '2024-11-23', 47, 12),
(33, 'Scalp Treatments', 'Solutions that address scalp concerns like dryness, dandruff, and itchiness, promoting a healthy scalp environment.', 'hair.5.webp', 5000.00, 397, 2.0, '2024-11-23', 47, 15),
(34, 'Hair Mousse &amp; Foams', 'Lightweight foam products that add volume, texture, and shape without weighing hair down.', 'hair.6.webp', 121.00, 300, 5.0, '2024-11-23', 47, 16),
(39, 'Hair Growth Products', 'Formulas that stimulate hair growth, prevent hair loss, and promote thicker, fuller hair.', 'hair.11.webp', 1000.00, 201, 3.0, '2024-11-23', 47, 11),
(40, 'Heat Sprays', 'Shields hair from heat damage caused by styling tools while maintaining shine and smoothness.', 'hair.12.webp', 100.00, 300, 4.0, '2024-11-23', 47, 12),
(41, 'Pure Radiance', 'Achieve glowing skin with premium, nourishing care.', 'face.2.webp', 1006.00, 200, 4.0, '2024-11-23', 52, 18),
(42, 'Fresh Face Care', 'Rejuvenate your skin with soft, hydrating essentials.', 'face.3.webp', 2000.00, 400, 4.0, '2024-11-23', 52, 19),
(43, 'Skin Bliss Collection', 'Revive your skin with our soothing, natural products.', 'face.4.webp', 1009.00, 400, 4.0, '2024-11-23', 52, 20),
(44, 'Radiant Charm', 'Unlock flawless beauty with deeply nourishing skin care.', 'face.9.webp', 10000.00, 200, 5.0, '2024-11-23', 52, 21),
(45, 'Luminous Touch', 'Bring out the natural glow of your skin every day.', 'face.11.webp', 1000.00, 100, 4.0, '2024-11-23', 52, 22),
(47, 'Luxe Lips', 'Vibrant, long-lasting colors for every mood and occasion.', 'lip.3.webp', 200.00, 200, 3.0, '2024-11-23', 51, 24),
(48, 'Velvet Pout', 'Smooth, creamy textures for bold, flawless lips.', 'lip.4.webp', 1000.00, 300, 4.0, '2024-11-23', 51, 25),
(49, 'Color Bloom', 'Express yourself with vivid, high-pigment shades.', 'lip.5.webp', 203.00, 200, 5.0, '2024-11-23', 51, 26),
(50, 'Lip Elegance', 'Luxurious, hydrating formulas for perfect lips.', 'lip.8.webp', 300.00, 100, 2.0, '2024-11-23', 51, 27),
(51, 'Bold &amp; Beautiful', 'Rich shades that empower your unique style.', 'lip.11.webp', 500.00, 200, 2.0, '2024-11-23', 51, 28),
(52, 'Kiss &amp; Glow', 'Nourishing lipsticks with a radiant finish.', 'lip.9.webp', 1020.00, 200, 5.0, '2024-11-23', 51, 29),
(53, 'Powder &amp; Cream Blushers', 'Versatile blushes offering smooth application for a natural flush of color.', 'blush.5.webp', 350.00, 100, 3.0, '2024-11-24', 50, 30),
(54, 'Long-Lasting Blushers', 'Gives a fresh, vibrant look that lasts all day with a lightweight and buildable formula.', 'blush.4.webp', 500.00, 200, 4.0, '2024-11-24', 50, 31),
(55, 'Natural Blush Powders', 'Provides a soft, natural blush with a matte finish, perfect for all skin types.', 'blush.2.webp', 400.00, 300, 3.0, '2024-11-24', 50, 32),
(56, 'Hydrating Liquid Blushers', 'Hydrates and adds a dewy finish with liquid blushes for a glowing, flushed look.', 'blush.9.webp', 670.00, 200, 4.0, '2024-11-24', 50, 33),
(57, 'Matte &amp; Shimmer Blushers', 'Combines matte and shimmer effects for a multidimensional and radiant finish.', 'blush.11.webp', 450.00, 100, 3.0, '2024-11-24', 50, 34),
(58, 'Professional Makeup Blushers', 'Offers professional-grade color payoff with a smooth and long-lasting formula.', 'blush.7.webp', 700.00, 400, 4.0, '2024-11-24', 50, 35),
(59, 'Organic Face Creams &amp; Scrubs', 'Gently removes impurities while moisturizing with all-natural organic ingredients.', 'other.1.webp', 500.00, 300, 3.0, '2024-11-24', 49, 36),
(60, 'Herbal Oils &amp; Serums', 'Nourishes and revitalizes skin with powerful herbal extracts to promote a healthy glow.', 'other.5.webp', 600.00, 100, 3.0, '2024-11-24', 49, 37),
(61, 'Plant-Based Shampoos &amp; Conditioners', 'Made with plant-derived ingredients to cleanse and hydrate hair naturally without harsh chemicals.', 'other.3.webp', 400.00, 200, 4.0, '2024-11-24', 49, 38),
(62, 'Natural Hair Masks &amp; Treatments', 'Strengthens and nourishes hair with natural ingredients to restore shine and health.', 'other.7.webp', 430.00, 300, 3.0, '2024-11-24', 50, 39),
(63, 'Organic Makeup &amp; Lip Balms', 'Provides a natural glow with organic makeup and soothing lip balms for all-day comfort.', 'other.12.webp', 750.00, 100, 4.0, '2024-11-24', 49, 40),
(64, 'Moisturizers &amp; Face Creams', 'Hydrates and nourishes skin with a rich formula to maintain smooth and youthful skin.', 'skin.2.webp', 890.00, 351, 3.0, '2024-11-24', 48, 42),
(65, 'Anti-Aging Serums &amp; Toners', 'Reduces fine lines and boosts skin elasticity with a blend of natural anti-aging ingredients.', 'skin.6.webp', 200.00, 250, 3.0, '2024-11-24', 48, 43),
(66, 'Anti-Aging Serums &amp; Toners', 'Helps diminish wrinkles and revitalizes skin, offering a more youthful and radiant appearance.', 'skin.7.webp', 300.00, 244, 4.0, '2024-11-24', 48, 43);

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `contact_info` varchar(200) NOT NULL,
  `shift_schedule` varchar(200) NOT NULL,
  `assigned_tasks` text NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`id`, `name`, `email`, `password`, `image`, `contact_info`, `shift_schedule`, `assigned_tasks`, `role_id`) VALUES
(6, 'Maryam', 'maryam@gmail.com', '12345678910', 'Maryam.jpeg', '12345678910', 'morning', 'For your services', 3),
(7, 'Nayab', 'nayab@gmail.com', '12345678910', 'Nayab.jpeg', '12345678910', 'Night', 'for your sevices', 3);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `admin` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `receptionist` int(11) NOT NULL,
  `stylist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `reminder_shown` tinyint(4) NOT NULL DEFAULT 1,
  `stylist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `des` text NOT NULL,
  `duration` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `image`, `price`, `des`, `duration`) VALUES
(3, 'Hair Styling', 'hair.avif', 7500.00, 'Revitalize your look with our expert hair styling services. Our experienced stylists use high-quality professional products like Moroccanoil, Kerastase, and L&#039;Oréal Professional to ensure long-lasting, beautiful results. Whether it&#039;s a precision cut, voluminous blowout, or intricate updo, we craft a style tailored to your face shape and personal preferences. Perfect for casual outings, corporate meetings, or glamorous events.', 'Night 11PM to 11AM'),
(4, 'Makeup', 'makeup.avif', 1200.00, 'Enhance your natural beauty with our professional makeup application. Using premium cosmetics from MAC, Huda Beauty, and Charlotte Tilbury, our artists create stunning looks customized to your skin type and occasion. From dewy daytime looks to bold evening glam, we focus on flawless blending and precise detailing to leave you looking camera-ready and radiant. Ideal for weddings, photoshoots, and formal gatherings.', 'Morning 2AM to 7AM'),
(7, 'Facial', 'facial.avif', 5000.00, 'Indulge in a luxurious facial treatment designed to cleanse, exfoliate, and rejuvenate your skin. We use products from trusted skincare brands like Dermalogica, La Roche-Posay, and Clinique, customized to your skin type. The session includes a deep cleansing, gentle exfoliation, a relaxing face massage, and a hydrating mask that leaves your skin glowing and refreshed. Suitable for all skin types, including sensitive and acne-prone skin.', 'Morning 6AM to 12AM'),
(8, 'Hair Coloring', 'hair-coloring.avif', 8000.00, 'Transform your hair with our expert coloring services. Whether you’re seeking natural highlights, vibrant hues, or a complete color change, we use ammonia-free dyes from Schwarzkopf, Wella Professionals, and Redken to ensure vibrant, damage-free results. Our colorists consult with you to find the perfect shade that complements your skin tone and style. Includes a post-color treatment for added shine and nourishment.', 'Evening 7PM to 12PM'),
(9, 'Manicure', 'manicure.avif', 3500.00, 'Pamper your hands with our deluxe manicure. This service includes shaping, buffing, cuticle care, and a soothing hand massage with nourishing creams like Olay Hand &amp; Nail or The Body Shop Hemp Hand Protector. We finish with your choice of nail polish from premium brands like OPI and Essie or opt for long-lasting gel polish for a flawless, chip-free finish. Perfect for maintaining healthy, beautiful nails.', 'Night 11PM to 2AM'),
(10, 'Pedicure', 'pedicure.avif', 4500.00, 'Treat your feet to a luxurious pedicure experience. We begin with a warm foot soak infused with essential oils to relax and soften the skin. Our specialists then exfoliate with a sugar scrub, smooth calluses, and shape your nails. A hydrating massage follows, using rich creams like Burt&#039;s Bees Coconut Foot Cream. The session ends with a high-quality polish application or gel finish for long-lasting shine. Ideal for relaxation and perfectly groomed feet.', 'Morning 5AM to 11AM');

-- --------------------------------------------------------

--
-- Table structure for table `stylists`
--

CREATE TABLE `stylists` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `des` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `contact_info` varchar(200) NOT NULL,
  `service_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `shift_schedule` varchar(200) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stylists`
--

INSERT INTO `stylists` (`id`, `name`, `email`, `password`, `des`, `image`, `contact_info`, `service_id`, `rating`, `commission_rate`, `shift_schedule`, `role_id`) VALUES
(14, 'Sara khan', 'sara@gmail.com', 'sara khan', 'Expert in bridal and event makeup, using top-tier brands for flawless results.', 'Stylist.2.jpg', '03567994638', 4, 4.0, 0.00, '4', 4),
(17, 'Ahmed', 'ahmed@gmail.com', '123456', 'Specializes in vibrant and natural hair colors with premium products.', 'stylist.3.webp', '8294759794', 8, 4.0, 312.50, '8', 4),
(18, 'Laiba', 'laiba@gmail.com', '123456', 'Provides relaxing manicures with precision and creative designs.', 'stylist.4.jpg', '8294759794', 9, 3.0, 136.72, '9', 4),
(20, 'Zufra', 'rudha@gmail.com', '123456', 'Offers basic foot care and relaxing pedicure services.', 'stylist.1.jpg', '8294759794', 10, 3.0, 175.78, '10', 4),
(21, 'Hania', 'hania@gmail.com', '123456', 'Specializes in restoring hair health and shine with advanced treatments and premium products.', 'stylist.5.jpg', '8294759794', 3, 4.0, 292.97, '3', 4),
(23, 'Aqsa', 'zeniya@gmail.com', '123456', 'Specialist in rejuvenating facials tailored to all skin types.', 'stylist.6.png', '8294759794', 7, 3.0, 195.31, '7', 4);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `product_salling` varchar(200) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `contact_info` varchar(200) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `product_salling`, `product_qty`, `contact_info`, `address`) VALUES
(10, 'Ayan', 'Shampoo &amp; Conditioners', -3, '87734979749', 'Karachi Lyari'),
(11, 'Ayan', 'Hair Growth Products', 201, '87734979749', 'karachi lyari'),
(12, 'Rahib', 'Heat Protection Sprays', 301, '87734979749', 'karachi lyari'),
(13, 'Ahmed', 'Hair Repair &amp; Split End Solutions', 31, '87734979749', 'karachi lyari'),
(14, 'Rahib', 'Curly Hair Care', 201, '87734979749', 'karachi lyari'),
(15, 'Ayan', 'Scalp Treatments', 396, '87734979749', 'karachi lyari'),
(16, 'Rahib', 'Hair Mousse &amp; Foams', 300, '87734979749', 'karachi lyari'),
(17, 'Ahmed', 'GlowSkin Essentials', 300, '87734979749', 'karachi lyari'),
(18, 'Rahib', 'Pure Radiance', 116, '87734979749', 'karachi yari'),
(19, 'Ali', 'Fresh Face Care', 400, '87734979749', 'karachi lyari'),
(20, 'Ali', 'Skin Bliss Collection', 400, '87734979749', 'karachi lyari'),
(21, 'Ali', 'Radiant Charm', 200, '87734979749', 'karachi lyari'),
(22, 'Ahsan', 'Luminous Touch', 3, '87734979749', 'karachi ltari'),
(23, 'Ahmed', 'Velvet Glow', 200, '87734979749', 'karachi lyari'),
(24, 'Ahsan', 'Luxe Lips', 200, '87734979749', 'karachi lyari'),
(25, 'Ahsan', 'Velvet Pout', 300, '87734979749', 'karachi lyari'),
(26, 'Ali', 'Color Bloom', 200, '87734979749', 'karachi lyari'),
(27, 'Ahsan', 'Lip Elegance', 100, '87734979749', 'karachi lyari'),
(28, 'Ahmed', 'Bold &amp; Beautiful', 200, '87734979749', 'karachi lyari'),
(29, 'Ahsan', 'Kiss &amp; Glow', 200, '87734979749', 'karachi lyari'),
(30, 'Kabir', 'Powder &amp; Cream Blushers', 100, '65674746434', 'Karachi Lyari'),
(31, 'Kabir', 'Long-Lasting Blushers', 200, '02764376459', 'Karachi Lyari'),
(32, 'Tahir', 'Natural Blush Powders', 300, '0276437645', 'Karachi Lyari'),
(33, 'Zubair', 'Hydrating Liquid Blushers', 200, '29348734956', 'Karachi Lyari'),
(34, 'Kabir', 'Matte &amp; Shimmer Blushers', 100, '0276437645', 'Karachi Lyari'),
(35, 'Ahmed', 'Professional Makeup Blushers', 400, '0276437645', 'Karachi Lyari'),
(36, 'Zafar', 'Organic Face Creams &amp; Scrubs', 300, '027643764599', 'Karachi Lyari'),
(37, 'Rahib', 'Herbal Oils &amp; Serums', 100, '02764376459', 'Karachi Lyari'),
(38, 'Kabir', 'Plant-Based Shampoos &amp; Conditioners', 200, '0276437645', 'Karachi Lyari'),
(39, 'Ahsan', 'Natural Hair Masks &amp; Treatments', 300, '87734979749', 'Karachi Lyari'),
(40, 'Ahsan', 'Organic Makeup &amp; Lip Balms', 100, '02764376459', 'Karachi Lyari'),
(42, 'Zayan', 'Moisturizers &amp; Face Creams', 351, '032787989676', 'Karachi Lyari'),
(43, 'Zayan', 'Anti-Aging Serums &amp; Toners', 244, '0276437645', 'Karachi Lyari'),
(44, 'Ahmed', 'Natural Face Wash &amp; Cleansers', 300, '02764376459', 'Karachi Lyari');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(1, 'admin123', 'admin@gmail.com', '1234', 1),
(2, 'ali khan', 'ali@gmail.com', '1234', 2),
(5, 'Zayan', 'zayan@gmail.com', '123', 2),
(6, 'a', 'abc@gmail.com', '123', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `stylist_id` (`stylist_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`user_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`product_id`),
  ADD KEY `u_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `products_ibfk_2` (`supplier_id`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stylist_id` (`stylist_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stylists`
--
ALTER TABLE `stylists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `stylists_ibfk_1` (`service_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `receptionists`
--
ALTER TABLE `receptionists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stylists`
--
ALTER TABLE `stylists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`stylist_id`) REFERENCES `stylists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD CONSTRAINT `schedule_list_ibfk_1` FOREIGN KEY (`stylist_id`) REFERENCES `stylists` (`id`);

--
-- Constraints for table `stylists`
--
ALTER TABLE `stylists`
  ADD CONSTRAINT `stylists_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
