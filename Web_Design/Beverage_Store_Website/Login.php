
<?php
session_start();
$firstnameErr = $lastnameErr = $emailErr = $usernameErr = $passwordErr = $confirmPassErr = "";
$firstname = $lastname = $email = $username = $password = $confirmPass = "";
$invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

	if (empty($_POST["username"])) 
	{
		$usernameErr = "Username is required";
	} else 
	{
		$username = test_input($_POST["username"]);
	}

	if (empty($_POST["pass"])) 
	{
		$passwordErr = "Password is required";
	} else 
	{
		$password = test_input($_POST["pass"]);
	}  
}

function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- 


CSCI3000
Doctor Cueva Parra
The PHP / HTML that gives that the customer will use to login to the beverage website
-->

<!DOCTYPE html>
<html>

<head>
<title>Final Project</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-indigo.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<style>
	body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
	.w3-bar-block .w3-bar-item {padding:20px}
	a.active {color:yellow;)
	.error {color:crimson;}
</style>
</head>




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
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a class="active" href="Login.php">Login</a></div>    
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Register.php">Register</a></div>
    <div class="w3-padding-16 w3-bar-item"><a href="index.php">Sovereign Soda Supply</a></div>
  </div>
</header>
<!-- !PAGE CONTENT! -->
<main class="w3-main w3-content w3-padding w3-white" style="max-width:1500px">
   
    <h1 style="text-align: center;">Login</h1>
    
    <p><span class="error">* required field</span></p>
    
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
<div style="width: 50%; margin: 0 auto;">


	<div class="input-field col">
	  <span class="error">* <?php echo $usernameErr;?> </span>
	  <input id="username" name="username" type="text" class="validate" value="<?php echo $username;?>">
	  <label for="username">Username</label>
	</div>
	
	
	
	<div class="input-field col">
	  <span class="error">* <?php echo $passwordErr;?></span>
	  <input id="pass" name="pass" type="password" class="validate" value="<?php echo $password;?>">
	  <label for="pass">Password</label>
	</div>
	
	<div>
		<input type="submit" id="submit" name="submit" value="Login" class="w3-button w3-theme">
	</div>
	
	<br></br>
	
	<button class="w3-button w3-theme" type="submit" formaction="Register.php">Register Account</button>
	
	
	
	
</div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</main>
  <footer class="w3-row-padding w3-theme-l2" style="">
    <div class="">
      <p>A fictitious company by Tyler Moon, Wyatt Thomas, and Rachel Gooding.<br>
		&copy; 2018</p>
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  

  </footer>
<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>


<?php

  if (!empty($_POST["submit"])) 
  {

	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "drinkstore";

	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

	$sql = "select customerid, username, password from customers";

	$result = $conn->query($sql);

	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if(strcmp($row["username"],$username) === 0 AND strcmp($row["password"],$password) === 0)
			{
				$_SESSION["loggedIn"] = true;
				$_SESSION["username"] = $row["username"];
				$_SESSION['customer_id'] = $row["customerid"];
				
				
				if(isset($_SESSION["redirectLogin"]))
				{
					unset($_SESSION["redirectLogin"]);
					
					echo "<script type='text/javascript'>";
						echo "window.location = 'Checkout.php'";
					echo "</script>";
				}
				else{
					echo "<script type='text/javascript'>";
						echo "window.location = 'index.php'";
					echo "</script>";
				}
				
				
				break;
			}
			else
				$invalid = true;
		}	
		
		if($invalid === true);
			echo "Invalid username or password.";
	}
	else
	{
		echo "Invalid username or password.";
	}
	
	$conn->close();
  }
  
?>

</body>
</html>