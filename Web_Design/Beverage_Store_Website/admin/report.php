<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drinkstore";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  //  die("Connection failed: " . mysqli_connect_error());
}

echo "Product Stock<br></br>";
$sql = "SELECT ProductID, ProductName, UnitsInStock FROM products";

	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		echo "<table><tr><th>Product ID</th><th>Name</th><th>Stock</th></tr>";
			while($row = $result->fetch_assoc())
			{
					echo "<tr><td>" . $row["ProductID"]. "</td><td> " . $row["ProductName"] . "</td><td>" . $row["UnitsInStock"] . "</td></tr>";
			}
		echo "</table>";
	}
	else
	{
		echo "0 results";
	}
	
	
	echo "<br></br>Order History<br></br>";
	$sql = "SELECT * FROM orderdetails";

	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		echo "<table><tr><th>Order ID</th><th>Product ID</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";
			while($row = $result->fetch_assoc())
			{
					echo "<tr><td>" . $row["OrderID"]. "</td><td> " . $row["ProductID"]
					. "</td><td>$" . $row["Price"] . "</td><td>" . $row["Quantity"] . "</td><td>$" . $row["Total"] . "</td></tr>";
			}
		echo "</table>";
	}
	else
	{
		echo "0 results";
	}



$conn->close();

?>

<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		table, th, tr, td {border: 1px solid blue;}
	</style>
</head>
<html>

</html>
