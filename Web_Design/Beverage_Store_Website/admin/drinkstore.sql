-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2018 at 05:02 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drinkstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

create database drinkstore;

use drinkstore;

CREATE TABLE `customers` (
  `CustomerID` int(5) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `CityStateZIP` varchar(70) NOT NULL,
  `username` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `FirstName`, `LastName`, `Email`, `Password`, `Address`, `CityStateZIP`, `username`) VALUES
(1, 'Jane', 'Doe', 'Jane@Doe.com', 'Jane@123', '343 jane street', 'janeville, GA, 34344', 'janedoe'),
(3, 'Bob', 'Bobson', 'bobson@bob.com', 'Bobson@123', '232 bob lane dr.', 'bobville, GA, 34343', 'bobrocks'),
(4, 'Debby', 'Lynn', 'dlynn@yahoo.com', 'Debby@321', '232 debby lane', 'debberson, GA, 34345', 'debdeb');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` int(5) NOT NULL,
  `ProductID` int(5) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Quantity` int(50) NOT NULL,
  `Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Price`, `Quantity`, `Total`) VALUES
(1, 2, '5.99', 4, '23.96'),
(1, 11, '2.00', 3, '6.00'),
(2, 2, '5.99', 5, '29.95'),
(2, 3, '0.00', 1, '0.00'),
(2, 5, '0.00', 2, '0.00'),
(2, 6, '4.99', 2, '9.98'),
(2, 7, '5.99', 2, '11.98'),
(2, 9, '0.00', 1, '0.00'),
(2, 10, '1.98', 1, '0.00'),
(2, 13, '2.99', 2, '5.98');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(5) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `UnitsInStock` int(50) NOT NULL,
  `ProductDescription` varchar(500) DEFAULT NULL,
  `ProductImage` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `UnitPrice`, `Size`, `UnitsInStock`, `ProductDescription`, `ProductImage`) VALUES
(2, 'Blue Milk', '5.99', '22oz', 88, 'Classic, Refreshing Bantha Milk', 'bluemilk.jpeg'),
(3, 'Buzzz Cola', '2.97', '10oz', 98, 'The preferred drink of rebellious youth and mindless drones.', 'buzzzcola.jpeg'),
(5, 'Dark Planet Cola', '7.50', '32oz', 12, 'Your favorite cola from Planet Baab. 800% sugar!', 'darkplanetcola.jpeg'),
(6, 'Fizzy Bubblech', '4.99', '16oz', 18, 'The soda in the strange bottle.', 'fizzybubblech.jpeg'),
(7, 'Slurm', '5.99', '16oz', 55, 'Try to not drink it. We dare you.', 'slurm.jpg'),
(9, 'Spr&uuml;nt', '2.01', '18oz', 25, 'So good it\'s illegal.', 'sprunt.jpeg'),
(10, 'Pitt Cola', '1.98', '16oz', 64, 'Peach soda. The classic straight from Gravity Falls, OR.', 'pittcola.jpg'),
(11, 'Nuka-Cola', '2.00', '14oz', 91, 'Zap That Thirst!', 'nukecola.jpg'),
(12, 'Lacasa', '1.98', '12oz', 43, 'Ozzian Nectar. Easy to drink!', 'lacasa.jpeg'),
(13, 'Frobscottle', '2.99', '16oz', 14, 'Vanilla soda that\'ll make you whizzpop!', 'frobscottle.jpg'),
(14, 'Nuka-Cola Quantum', '3.89', '16oz', 11, 'Twice the calories, twice the carbohydrates, twice the caffine, and twice the taste! The mild radioactive stronium isotope makes it glow blue! Plus, 18 fruit flavors!', 'quantum.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
