-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2018 at 02:29 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resina_chemicals`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `item_id` int(11) NOT NULL,
  `item_product_id` int(11) NOT NULL COMMENT 'Product ID',
  `bill_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `hsn_code` varchar(30) NOT NULL,
  `item_quantity_unit` varchar(50) NOT NULL COMMENT 'this is combination of quantity and unit of product',
  `item_rate` varchar(50) NOT NULL,
  `bill_quantity` varchar(50) NOT NULL,
  `bill_rate` varchar(50) NOT NULL,
  `bill_unit` varchar(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1= deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bill_master`
--

CREATE TABLE `bill_master` (
  `bill_id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `bill_date` date NOT NULL,
  `tax_rate` varchar(50) NOT NULL COMMENT 'bill_igst',
  `bill_cgst` varchar(50) NOT NULL,
  `bill_sgst` varchar(50) NOT NULL,
  `bill_igst` varchar(50) NOT NULL,
  `bill_subTotal` varchar(50) NOT NULL,
  `bill_total` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `forwardTo_customer_id` int(11) NOT NULL,
  `challan_no` varchar(50) NOT NULL,
  `challan_date` date DEFAULT NULL,
  `dm_no` varchar(50) NOT NULL,
  `dm_date` date DEFAULT NULL,
  `lr_or_mr_no` varchar(50) NOT NULL,
  `lr_or_mr_date` date DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1= deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `state_code` varchar(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_password` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `alt_mobile` varchar(15) NOT NULL,
  `location_lat` varchar(30) NOT NULL,
  `location_lang` varchar(30) NOT NULL,
  `aaded_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0' COMMENT '0=active, 1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gendar` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(30) NOT NULL,
  `pin` varchar(12) NOT NULL,
  `state_code` int(50) NOT NULL COMMENT 'used for billing',
  `gst_in_number` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `alt_mobile` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `added_by` int(1) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_img_name` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1= deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `attribute_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `hsn_code` varchar(100) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `rate` varchar(20) NOT NULL,
  `is_offer_avilable` int(1) NOT NULL DEFAULT '0' COMMENT '0=no offer, 1=offer valued',
  `offer_rate` varchar(50) NOT NULL COMMENT 'if offer value = 1 then this rate will be applied',
  `effective_from_date` date DEFAULT NULL,
  `effective_till_date` date DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock_qty` varchar(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0' COMMENT '0=active, 1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1=admin, 2=normalUser',
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL COMMENT '0=active, 1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `user_type`, `username`, `password`, `email`, `mobile`, `added_by`, `added_on`, `deleted`) VALUES
(1, 'Vivek', 'kanoje', 1, 'Vivekkanoje', '46f29d4b1a2f7bb36d6a354da9a210eb06a9adc7733f31e381dcd3a02b61ce9574e1de24ce64485df66db447736e588da9568cb335d8281b972674011f78d714aRlvjIDxfCeS3d4e8dpSORIKlwt9jqQPpMloyCLRrn4=', 'vivekkanoje1989@gmail.com', '9595926091', 1, '2018-12-12 16:41:41', 0),
(2, 'Tushar', 'Kohale', 2, 'Tushar.kohale', 'b900ece7d0ce4341c107c88df10c15cb7f4234185b12b74d3ce0797bd8f65972aa8c35ba62962fef623d07159b02bcb5ce7ee5ae912a023e612d329e3fc60d2elntkSu6U3VDv0v1vyY+zk+oZrY9pJwZgoPP21WxW0bg=', 'tukohale@gmail.com', '9898786767', 0, '2018-12-12 16:41:41', 1),
(3, 'Naresh', 'Talathi', 0, 'Naresh', 'df51f7a3f442215066e905149d20b62ec0f11b6961788adebc619063c02388b3ed174e61d7a731b514ad9b646aaef3fc11895f859f29eafc4697b984bde626a2Ogdoq0n1RxKFajARmzVRJAoE6QvRQHJy6mIx+1WboVQ=', 'naresh@tmail.com', '9595959933', 1, '2018-12-12 16:43:12', 0),
(4, 'Naresh', 'Talathi', 0, 'Naresh', 'a57193b65e7cfb5eb99cdeda09180173a21527fb716c0316f19571c38e5cc33dc1edac958d3578065065a1e1d6f196f327c3481912b196c1db8ab61a52415438xWLi5V6togfjxuknhVHhlo29xKOTVDLX69k7xpAe+1E=', 'naresh@tmail.com', '9595959933', 1, '2018-12-12 16:43:46', 1),
(5, 'Jageshwar', 'Gaydhane', 1, 'Jagya', 'cf0995576a654c3ea331c9fac039940ab6cbfb9f574f5ac82f49e47cb10e0b5e77e1ccf1534b8085d0437472c4c2fc24365ac93c2250b3294a20a59d3e13ef02P4MtRKz6NH33s78zsSpUOlN0QICFJhqZjWbc5KUrLos=', 'jagya@gmail.com', '98979879', 1, '2018-12-12 16:48:04', 1),
(6, 'Jogendar', 'ZadopSha', 1, 'Jogendar', '9e96caf1cae442e5c305b331d9c91ef4f5748256452c4c3b4afb219cc3ed52ea17ae4cc9c05b085ae9233e3879243349799ff02ec4cb5c7be181b2f24c834afdRlp1euxaXVsSjUEUynnt0UL1XvEeoIt4TdWFRlffHkc=', 'jogendat@tmail.com', '9595959993', 5, '2018-12-12 17:02:39', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD KEY `item_id_2` (`item_id`,`bill_id`,`added_by`),
  ADD KEY `item_product_id` (`item_product_id`);

--
-- Indexes for table `bill_master`
--
ALTER TABLE `bill_master`
  ADD PRIMARY KEY (`bill_id`),
  ADD UNIQUE KEY `bill_id` (`bill_id`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `customer_id_2` (`customer_id`),
  ADD KEY `state_code` (`state_code`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `product_id_2` (`product_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`attribute_id`),
  ADD UNIQUE KEY `attribute_id` (`attribute_id`),
  ADD KEY `attribute_id_2` (`attribute_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD UNIQUE KEY `stock_id` (`stock_id`),
  ADD KEY `stock_id_2` (`stock_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_master`
--
ALTER TABLE `bill_master`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
