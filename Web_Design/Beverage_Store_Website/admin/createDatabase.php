<!DOCTYPE html>
<html>
<head>

<?php
/***************************************************
* Rachel Gooding
* Tyler Moon
* Wyatt Thomas
* Final Project
* CSCI 3000-DC
* Dr. Cueva Parra
* 
* TEMPLATE
***************************************************/

$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

$sql = "CREATE DATABASE drinkstore";
if($conn->query($sql) === true)
{
	echo "Database created successfully"  . "</br>";
}
else { echo "Error creating database: " . $conn->error . "</br>";}

$sql = "USE drinkstore";

if($conn->query($sql) === true)
{
	echo "Connected to drinkstore" . "</br>";
}
else { echo "Error finding DB: " . $conn->error . "</br>";}


if($conn->connect_error)
{
	die("Connection Failed. " . $conn->connect_error);
}
echo "Connection Successful</br>";

$sql = "CREATE TABLE `customers` (
  `CustomerID` int(5) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `CityStateZIP` varchar(70) NOT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	
if($conn->query($sql) === true)
{
	echo "Customers table created successfully"  . "</br>";
}
else { echo "Error creating table: " . $conn->error . "</br>";}


$sql = "INSERT INTO `customers` (`CustomerID`, `FirstName`, `LastName`, `Email`, `Password`, `Address`, `CityStateZIP`, `username`) VALUES
(1, 'Jane', 'Doe', 'Jane@Doe.com', 'Jane@123', '343 jane street', 'janeville, GA, 34344', 'janedoe'),
(3, 'Bob', 'Bobson', 'bobson@bob.com', 'Bobson@123', '232 bob lane dr.', 'bobville, GA, 34343', 'bobrocks'),
(4, 'Debby', 'Lynn', 'dlynn@yahoo.com', 'Debby@321', '232 debby lane', 'debberson, GA, 34345', 'debdeb')";
	
if($conn->query($sql) === true)
{
	echo "Inserts into customers table created successfully"  . "</br>";
}
else { echo "Error inserting: " . $conn->error . "</br>";}


$sql = "CREATE TABLE `orderdetails` (
  `OrderID` int(5) NOT NULL,
  `ProductID` int(5) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Quantity` int(50) NOT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	
if($conn->query($sql) === true)
{
	echo "Orderdetails table created successfully"  . "</br>";
}
else { echo "Error creating table: " . $conn->error . "</br>";}


$sql = "CREATE TABLE `products` (
  `ProductID` int(5) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `UnitsInStock` int(50) NOT NULL,
  `ProductDescription` varchar(500) DEFAULT NULL,
  `ProductImage` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	
if($conn->query($sql) === true)
{
	echo "Products table created successfully"  . "</br>";
}
else { echo "Error creating table: " . $conn->error . "</br>";}


$sql = "INSERT INTO `products` (`ProductID`, `ProductName`, `UnitPrice`, `Size`, `UnitsInStock`, `ProductDescription`, `ProductImage`) VALUES
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
(14, 'Nuka-Cola Quantum', '3.89', '16oz', 11, 'Twice the calories, twice the carbohydrates, twice the caffine, and twice the taste! The mild radioactive stronium isotope makes it glow blue! Plus, 18 fruit flavors!', 'quantum.jpg')";
	
if($conn->query($sql) === true)
{
	echo "Inserts into customers table created successfully"  . "</br>";
}
else { echo "Error inserting: " . $conn->error . "</br>";}




$sql = "ALTER TABLE `customers`
  MODIFY `CustomerID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;";
	
if($conn->query($sql) === true)
{
	echo "Table altered"  . "</br>";
}
else { echo "Error creating table: " . $conn->error . "</br>";}


$sql = "ALTER TABLE `products`
  MODIFY `ProductID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15";
	
if($conn->query($sql) === true)
{
	echo "Table altered"  . "</br>";
}
else { echo "Error creating table: " . $conn->error . "</br>";}

$conn->close();
?>

</body>
</html>