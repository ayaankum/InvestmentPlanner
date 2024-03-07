-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 12, 2022 at 10:36 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `investments`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `neg_expo` (INOUT `var` DECIMAL(10,4))  BEGIN
SET var = POW(var,-1/3);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fd`
--

CREATE TABLE `fd` (
  `fd_id` int(11) NOT NULL,
  `bank_name` varchar(70) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fd_prin` decimal(10,2) DEFAULT NULL,
  `fd_rate` decimal(10,2) DEFAULT NULL,
  `fd_dur` int(11) DEFAULT NULL,
  `compounding` int(11) DEFAULT 1,
  `fd_return` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Triggers `fd`
--
DELIMITER $$
CREATE TRIGGER `fd_BEFORE_INSERT` BEFORE INSERT ON `fd` FOR EACH ROW BEGIN
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c DECIMAL(10,4);
DECLARE d DECIMAL(10,4);
DECLARE e DECIMAL(10,4);
DECLARE f DECIMAL(10,4);
SET d=1;
SET c = NEW.compounding * NEW.fd_dur;
SET f = NEW.fd_rate / 100;
SET a = f / NEW.compounding;
SET b = 1 + a;
SET d  = POW(b,c);
SET NEW.fd_return = NEW.fd_prin * d;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `fd_BEFORE_UPDATE` BEFORE UPDATE ON `fd` FOR EACH ROW BEGIN
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c DECIMAL(10,4);
DECLARE d DECIMAL(10,4);
DECLARE e DECIMAL(10,4);
DECLARE f DECIMAL(10,4);
SET d=1;
SET c = NEW.compounding * NEW.fd_dur;
SET f = NEW.fd_rate / 100;
SET a = f / NEW.compounding;
SET b = 1 + a;
SET d  = POW(b,c);
SET NEW.fd_return = NEW.fd_prin * d;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ppf`
--

CREATE TABLE `ppf` (
  `ppf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(70) NOT NULL,
  `ppf_prin` decimal(10,2) DEFAULT NULL,
  `ppf_rate` decimal(10,2) DEFAULT NULL,
  `ppf_year` decimal(10,2) DEFAULT 15.00,
  `ppf_return` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `ppf`
--
DELIMITER $$
CREATE TRIGGER `ppf_BEFORE_INSERT` BEFORE INSERT ON `ppf` FOR EACH ROW BEGIN
DECLARE si DECIMAL(10,2);
DECLARE i DECIMAL(10,2);
DECLARE t DECIMAL(10,2);
DECLARE a DECIMAL(10,2);
DECLARE p int;
DECLARE r DECIMAL(10,2);
SET p=NEW.ppf_prin;
SET r=NEW.ppf_rate;
SET i=0;
SET si=0;
SET a=0;
SET t=NEW.ppf_year-1;
WHILE i<t DO
    BEGIN
        SET si=p*r;
        SET si=si/100;
        SET a=p+si;
        SET a=a+5000;
        SET i=i+1;
        SET p=a;
    END;
    END WHILE;
SET si=p*r;
SET si=si/100;
SET a=p+si;
SET NEW.ppf_return=a;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ppf_BEFORE_UPDATE` BEFORE UPDATE ON `ppf` FOR EACH ROW BEGIN
DECLARE si DECIMAL(10,2);
DECLARE i DECIMAL(10,2);
DECLARE t DECIMAL(10,2);
DECLARE a DECIMAL(10,2);
DECLARE p int;
DECLARE r DECIMAL(10,2);
SET p=NEW.ppf_prin;
SET r=NEW.ppf_rate;
SET i=0;
SET si=0;
SET a=0;
SET t=NEW.ppf_year-1;
WHILE i<t DO
    BEGIN
        SET si=p*r;
        SET si=si/100;
        SET a=p+si;
        SET a=a+5000;
        SET i=i+1;
        SET p=a;
    END;
    END WHILE;
SET si=p*r;
SET si=si/100;
SET a=p+si;
SET NEW.ppf_return=a;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `rd`
--

CREATE TABLE `rd` (
  `rd_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `rd_prin` decimal(10,2) DEFAULT NULL,
  `rd_tenure` decimal(10,2) DEFAULT NULL,
  `rd_rate` decimal(10,2) DEFAULT NULL,
  `rd_return` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `rd`
--
DELIMITER $$
CREATE TRIGGER `rd_BEFORE_INSERT` BEFORE INSERT ON `rd` FOR EACH ROW BEGIN
DECLARE i DECIMAL(10,4);
DECLARE n INT;
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c DECIMAL(10,6);
DECLARE d DECIMAL(10,6);
DECLARE p DECIMAL(10,4);
SET p = NEW.rd_prin;
SET n = NEW.rd_tenure*4;
SET i=NEW.rd_rate/400;
SET i=1+i;
SET a = POW(i,n);
SET d=i;
CALL neg_expo(d);
SET c=1-d;
SET b=a-1;
SET b=b*p;
SET NEW.rd_return = b/c;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `rd_BEFORE_UPDATE` BEFORE UPDATE ON `rd` FOR EACH ROW BEGIN
DECLARE i DECIMAL(10,4);
DECLARE n INT;
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c DECIMAL(10,6);
DECLARE d DECIMAL(10,6);
DECLARE p DECIMAL(10,4);
SET p = NEW.rd_prin;
SET n = NEW.rd_tenure*4;
SET i=NEW.rd_rate/400;
SET i=1+i;
SET a = POW(i,n);
SET d= POW(i,-1/3);
SET c=1-d;
SET b=a-1;
SET b=b*p;
SET NEW.rd_return = b/c;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_name` varchar(45) NOT NULL,
  `open_price` decimal(10,2) DEFAULT NULL,
  `close_price` decimal(10,2) DEFAULT NULL,
  `dividend` decimal(10,2) DEFAULT NULL,
  `stock_return` decimal(10,2) DEFAULT NULL,
  `volume` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `stocks`
--
DELIMITER $$
CREATE TRIGGER `stocks_BEFORE_INSERT` BEFORE INSERT ON `stocks` FOR EACH ROW BEGIN
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c INT;
SET a= NEW.close_price - NEW.open_price;
SET b= a/NEW.open_price;
SET c= b*100;
SET NEW.stock_return = c + NEW.dividend;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stocks_BEFORE_UPDATE` BEFORE UPDATE ON `stocks` FOR EACH ROW BEGIN
DECLARE a DECIMAL(10,4);
DECLARE b DECIMAL(10,4);
DECLARE c INT;
SET a= NEW.close_price - NEW.open_price;
SET b= a/NEW.open_price;
SET c= b*100;
SET NEW.stock_return = c + NEW.dividend;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fd`
--
ALTER TABLE `fd`
  ADD PRIMARY KEY (`fd_id`),
  ADD KEY `userId_idx` (`user_id`);

--
-- Indexes for table `ppf`
--
ALTER TABLE `ppf`
  ADD PRIMARY KEY (`ppf_id`),
  ADD KEY `userIdppf_idx` (`user_id`);

--
-- Indexes for table `rd`
--
ALTER TABLE `rd`
  ADD PRIMARY KEY (`rd_id`),
  ADD KEY `userIdrd_idx` (`user_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `userId_idx` (`user_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fd`
--
ALTER TABLE `fd`
  MODIFY `fd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ppf`
--
ALTER TABLE `ppf`
  MODIFY `ppf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rd`
--
ALTER TABLE `rd`
  MODIFY `rd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fd`
--
ALTER TABLE `fd`
  ADD CONSTRAINT `userIdfd` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ppf`
--
ALTER TABLE `ppf`
  ADD CONSTRAINT `userIdppf` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rd`
--
ALTER TABLE `rd`
  ADD CONSTRAINT `userIdrd` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `userIdstk` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
