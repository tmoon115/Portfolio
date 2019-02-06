<?php
session_start();

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

/*
This is a team project. You should work with your teammates to create a responsive website using your own styling and content. 
The website will be an online store for selling beverages.
You must consider at least the following requirements:
•A home page describing the business and the products you are selling ( 25 points)
•A shopping cart (25 points)
•Customer Sign-in (25 points)
•Payment and inventory processing (30 points)
•A database containing one table with at least 10 products (25 points)
•A second table of customers. You can add more tables if necessary for performing all the activities requested (25 points)
•Entry and report of the inventory (25 points)
The presentation of the project, including a demonstration of how the website operates, is worth 20 points.
*/



?>
<!DOCTYPE html>
<html>
<title>Sovereign Soda Supply</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-indigo.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
a.active{color:yellow;}
table, th, tr, td {border: 1px solid blue; width: 100%; height:auto; text-align: center;}
</style>
<body class="w3-theme-l1">

<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left w3-black" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()"
  class="w3-button w3-right w3-jumbo" style="">&times;</a>
  <a href="#home" onclick="w3_close()" class="w3-bar-item w3-button">Home</a>
  <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
</nav>
<!-- Top menu -->
<header class="w3-theme w3-padding">
  <div class="w3-deep-blue w3-xlarge w3-bar" style="">
    <div class="w3-button w3-padding-16 w3-left w3-bar-item w3-hide-large w3-hide-medium" onclick="w3_open()"><i class="fas fa-bars"></i></div>
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Checkout.php">Cart</a></div> 
	
	<?php
	if(isset($_SESSION["loggedIn"]))
	{
				echo '<div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item w3-button"><a href="Logout.php">Logout</a></div>';
	echo '<div class="w3-right w3-large w3-padding-16 w3-bar-item">';
		echo 'Hello, ' . $_SESSION['username'];
		echo '</div>';
	}
	else
	{
		echo '<div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Login.php">Login</a></div>';
		echo '<div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Register.php">Register</a></div>';
	}
	?>	
    
    <div class="w3-padding-16 w3-bar-item"><a href="index.php">Sovereign Soda Supply</a></div>
  </div>
</header>
<!-- !PAGE CONTENT! -->
<main class="w3-main w3-content w3-padding w3-white" style="max-width:1200px">

	<h1 class="w3-jumbo w3-theme"> Your Cart:</h1>
	<br></br>
	<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "drinkstore";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$conn2 = mysqli_connect($servername, $username, $password, $dbname);

	$sql = "SELECT products.ProductName, products.ProductID, products.UnitPrice, orderdetails.Quantity, orderdetails.Total 
			FROM products,orderdetails WHERE products.ProductID = orderdetails.ProductID AND orderdetails.OrderID = '".$_SESSION['orderID']."'";
	$grandTotal = 0.00;
	$result = $conn->query($sql);
	
	echo "<table><tr><th>Product Name</th><th>Product ID</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";
	foreach($result as $row){
		echo "<tr><td>" . $row["ProductName"]. "</td><td> " . $row["ProductID"] . "</td><td>$" . $row["UnitPrice"] 
					. "</td><td>" . $row["Quantity"] . "</td><td>$" . $row['Quantity']*$row['UnitPrice'] ."</td></tr>";
		$grandTotal += $row['Quantity']*$row['UnitPrice'];
	}
	echo "</table>";
	
	$sql = "SELECT Total FROM orderdetails";
	
	$result = $conn->query($sql);
	
	if($result->num_rows > 0)
	{
		echo "<br><p class='w3-xxlarge w3-text-indigo'>GRAND TOTAL:  $" . $grandTotal . "</p>";
	}
	else
	{
		echo "<br><p class='w3-xxlarge w3-text-indigo'> GRAND TOTAL: N/A </p>";
	}

	?>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
		<input class="w3-button w3-theme w3-xlarge" type="submit" value="Continue Shopping" name="back">
		<input class="w3-button w3-theme w3-xlarge" type="submit" value="Checkout" name="checkedout">
	</form>
	
	
	<?php
		if(!empty($_POST["checkedout"]))
		{
			$success = false;
			if(isset($_SESSION["loggedIn"]))
			{
				$sql = "SELECT Quantity, ProductID FROM orderdetails WHERE orderdetails.OrderID = '".$_SESSION['orderID']."'";

				$result = $conn->query($sql);
				
				$stmt = $conn2->prepare("UPDATE products,orderdetails SET UnitsInStock = UnitsInStock - ? WHERE products.ProductID = orderdetails.ProductID AND orderdetails.OrderID = ? AND orderdetails.ProductID = ?");
						
				$stmt->bind_param('iii', $rowQuantity, $id, $productID);

				if($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
					{
						$rowQuantity = $row["Quantity"];
						$productID = $row["ProductID"];
						$id = $_SESSION['orderID'];
						
						if($stmt->execute() === true)
						{
							$success = true;
						}
						else
							$success = false;
					}
					if($success === true)
						echo "<p class='w3-button w3-theme w3-xlarge'>Thank you for your purchase. An E-mail confirmation will be sent to you.</p>";
					else
						echo "Error Communicating with our Database: Try again later.";
					
					unset($_SESSION["orderID"]);
				}
				else
				{
					echo "Error: Try Again Later";
				}
			}
			else
			{
				$_SESSION["redirectLogin"] = true;
				echo "<script type='text/javascript'>";
					echo "window.location = 'Login.php'";
				echo "</script>";
			}
		}
		
		if(!empty($_POST["back"]))
		{
			echo "<script type='text/javascript'>";
				echo "window.location = 'index.php'";
			echo "</script>";
		}
	?>
</main>
  <footer class="w3-row-padding w3-theme-l2" style="">
    <div class="">
      <p>A fictitious company by Tyler Moon, Wyatt Thomas, and Rachel Gooding.<br>
		&copy; 2018</p>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  

  </footer>

<!-- End page content -->


<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>

</body>
</html>












