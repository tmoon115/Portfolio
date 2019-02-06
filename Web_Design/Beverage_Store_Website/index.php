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
DONE
•A home page describing the business and the products you are selling ( 25 points)
•A database containing one table with at least 10 products (25 points)
•A second table of customers. You can add more tables if necessary for performing all the activities requested (25 points)
•Entry and report of the inventory (25 points)
•Customer Sign-in (25 points)
•A shopping cart (25 points)




This is a team project. You should work with your teammates to create a responsive website using your own styling and content. 
The website will be an online store for selling beverages.
You must consider at least the following requirements:

•Payment and inventory processing (30 points)

The presentation of the project, including a demonstration of how the website operates, is worth 20 points.
*/


/*
Collect info from database
	Use loop to create all products

*/
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


//get all products
$sql = "SELECT * FROM products";
$products = $conn->query($sql);


if(!isset($_SESSION['orderID'])){
		$sql = "SELECT max(OrderID) FROM orderdetails";
		
		$orderIDArr = $conn->query($sql)->fetch_assoc();
		$_SESSION['orderID'] = $orderIDArr["max(OrderID)"] + 1;

	}
if(isset($_SESSION['orderID']))
{
	$sql = "SELECT ProductID FROM orderdetails WHERE OrderID = '".$_SESSION['orderID']."'";
	$selected = $conn->query($sql);
	$inCart = array();
	foreach($selected as $item){
		array_push($inCart, $item['ProductID']);
}
}



if(!empty($_POST)){
	

	$stockError = "";
	$sql = "SELECT * FROM products WHERE ProductID = '".$_POST['productID']."'";
	$productInfo = $conn->query($sql)->fetch_assoc();
	
	$orderID = $_SESSION['orderID'];

	$productID = $productInfo['ProductID'];
	
	$price = $productInfo['UnitPrice'];
	$total = 0.00;
	$inStock = $productInfo['UnitsInStock'];
	
	settype($productID, "int") ;
	if(in_array($productID,$inCart)){
		$sql = "SELECT Quantity FROM orderdetails WHERE ProductID = '".$productInfo['ProductID']."' AND OrderID = '".$_SESSION['orderID']."';";
		$quantity = $conn->query($sql)->fetch_assoc();
		$quantity = $quantity['Quantity'] ;
		settype($quantity, "int");
		if($_POST['changeQuantity'] === "-")
		{
			if(isset(($_POST['amount'])) && is_int($_POST['amount'])  && ($_POST['amount']) > 0)
			{
				if($_POST['amount'] > $quantity)
					echo "<script>alert('You only have ' + $quantity + ' in your cart.');</script>";
				else
					$quantity = $quantity - $_POST['amount'];
			}
			else
			{
				if($quantity - 1 < 0)
					echo "<script>alert('You only have ' + $quantity + ' in your cart.');</script>";
				else
					$quantity = $quantity - 1;
			}
		}
		else if($_POST['changeQuantity'] === "+")
		{
			if(isset($_POST['amount']) && is_int($_POST['amount']) && ($_POST['amount']) > 0)
			{
				if($_POST['amount'] > $inStock-$quantity)
					echo "<script>alert('There are only ' + $inStock + ' left in stock!');</script>";
				else
					$quantity = $quantity + $_POST['amount'];
			}
			else
			{
				if($quantity + 1 > $inStock-$quantity)
					echo "<script>alert('There is only ' + $inStock + ' left in stock!');</script>";
				else
					$quantity = $quantity + 1;
			}
			
		}

		if($quantity == 0){
			$sql = "DELETE FROM orderdetails WHERE ProductID = '".$productID."' AND OrderID = '".$orderID."'";
			$conn->query($sql);	
		}
		else{
			$sql = "UPDATE orderdetails SET Quantity = ".$quantity.", Total = ".$price." * ".$quantity.", Price = ".$price." WHERE ProductID = ".$productID." AND OrderID = ".$orderID."";
			$conn->query($sql);
		}


	}
	else{
		$quantity = 1;
		$sql = "INSERT INTO orderdetails (OrderID, ProductID, Price, Quantity, Total) VALUES (".$orderID.", ".$productID.", ".$price.", ".$quantity.", ".$price.")";
		array_push($inCart, $productID);  //FIXES +- LAG
		
		
	}
	
	
	if ($conn->query($sql) === TRUE) {
		
	} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	
}


$conn->close();


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
img {width:200px; height:350px;}
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
    <div class="w3-button w3-padding-16 w3-left w3-bar-item" onclick="w3_open()"><i class="fas fa-bars"></i></div>
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
<main class="w3-main w3-content w3-padding w3-white" style="max-width:1500px">

   <?php
	  $rows = 0;
	  
   if ($products->num_rows > 0) {
    // output data of each row
    while($row = $products->fetch_assoc()) {
		if($rows%4 == 0){
			echo '<div class="w3-row-padding w3-container w3-cell-row w3-center productrow" style="margin-bottom: 2em;">';
		}
	?>
       <div class="w3-padding w3-cell w3-display-container w3-container productInfo w3-round w3-mobile" style="width: 25%">
      <?php 
		if(is_null($row["ProductImage"])){
		?>
      <img src="images/placeholder.png" alt="Image Placeholder" style="width:100%">
      <?php
		}
		else{
			echo '<img src="images/'.$row["ProductImage"].'" alt="Image Placeholder" style="width:100%">';
		}
		?>
      <h3><?php echo $row["ProductName"]; ?></h3>
      <p>
      	<?php
			echo '<p>'.$row["ProductDescription"]."</p>";
			echo "<p>".$row["Size"]."</p>";
			echo "<p style='margin-bottom: 11em;'>$".$row["UnitPrice"];
		
		echo "</p>";
		?>
      </p>
	<div class="w3-display-bottommiddle">
		<form method="POST" action="<?php echo 'details.php/'.$row['ProductID']?>">
			<input type="submit" value="<?php echo $row["ProductName"]; ?> Details" name="productdetails" class="w3-button w3-theme-action w3-hover-theme">
		</form>
	   
	   <?php
			if(in_array($row['ProductID'], $inCart)){
				?>
				
				<form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>'>
			   <input type="hidden" name="productID" value="<?php echo $row['ProductID']?>">
			   
			   <input type="submit" value="-" name="changeQuantity" class="w3-button w3-margin w3-theme-action w3-hover-theme">
				<input type="submit" value="+" name="changeQuantity" class="w3-button w3-margin w3-theme-action w3-hover-theme">
				<!-- <input type="text" value="" name="amount" style='text-align:center;' class="w3-hover-theme"> -->
				</form>
			
		<?php
			}
		else
		{
		
			if($row["UnitsInStock"]<1)
		   {
				echo "<br><span class='w3-theme'>Currently Unavailable</span>";
		   }
		   else
		   {
			   ?>
			   <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>'>
			   <input type="hidden" name="productID" value="<?php echo $row['ProductID']?>">
			   <input type="submit" value="Add to Cart" name="order" class="w3-button w3-margin w3-theme-action w3-hover-theme">
		   <?php } ?>
	   
		
		</form>
		<?php } ?>
	  </div>
    </div>
       <?php
        
		if($rows%4 == 3){
			echo '</div>';
		}
		$rows++;
    }
} else {
    echo "0 results";
}
	  ?>
   
  </div>
  

	
  <hr id="about">

  <!-- About Section -->
  <div class="w3-container w3-padding-32 w3-center">  
    <div class="">
		<img src="images/logo_transparent.png" alt="SSS Logo" class="w3-gray w3-round w3-image" style="min-width: 250px; margin: 0 auto;">
      <h4><b>Think It, Drink It</b></h4>
      <p class="w3-xxlarge">We specilize in the obscure drinks you want. Delicious, artificial, imaginary beverages.</p>
    </div>
  </div>
  <hr>
</main>  
  <!-- Footer -->
  <footer class="w3-row-padding w3-theme-l2" style="">
    <div class="">
      <p class="w3-xlarge">A fictitious company by Tyler Moon, Wyatt Thomas, and Rachel Gooding.<br>
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