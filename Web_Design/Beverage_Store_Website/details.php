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
//echo "Connected successfully<br>";



$url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$parsedurl = parse_url($url, PHP_URL_PATH);
$segments = explode("/", $parsedurl);
$productID = $segments[sizeof($segments)-1];

//get all products
$sql = "SELECT * FROM products WHERE ProductID = '".$productID."'";
$products = $conn->query($sql);
$productInfo = $products->fetch_assoc();

$conn->close();
//product image
//product name
//product description


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
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Login.php">Login</a></div>    
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Register.php">Register</a></div>
    <div class="w3-padding-16 w3-bar-item"><a href="../index.php">Sovereign Soda Supply</a></div>
  </div>
</header>
<!-- !PAGE CONTENT! -->
<main class="w3-main w3-content w3-padding w3-white " style="max-width:1200px">
<h1><?php echo $productInfo["ProductName"];?></h1>
<?php
		if(!is_null($productInfo["ProductImage"])){
			echo '<img src="../images/'.$productInfo["ProductImage"].'" alt="Image Placeholder" class="w3-left w3-quarter w3-margin ">';
		}
	else{
		echo '<img src="../images/placeholder.png" alt="Image Placeholder" class="w3-left w3-quarter w3-margin ">';
	}
	echo "<div class='w3-margin w3-padding '>";
		echo "<p>".$productInfo["ProductDescription"]."</p>";
			echo "<p>$".$productInfo["UnitPrice"]."</p>";
			echo "<p>Stock: ".$productInfo["UnitsInStock"]."</p>";
			if($productInfo["UnitsInStock"]<1){
				echo "<p>Currently Unavailable</p>";
			}
			?>
	<form method="POST" action="../index.php" class="">
		<button class="w3-button w3-theme-action w3-hover-theme">Back</button>
	</form>
	<?php
	echo "</div>";
	?>
	<div style="clear:both"></div>
</main>
  <footer class="w3-row-padding w3-theme-l2 " style="">
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








