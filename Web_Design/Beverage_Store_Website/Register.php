<!DOCTYPE html>
<html>

<?php
$firstnameErr = $lastnameErr = $emailErr = $usernameErr = $passwordErr = $confirmPassErr = $address = $citySt = "";
$firstname = $lastname = $email = $username = $password = $confirmPass  = $addressErr = $cityStErr= "";
$firstnameOK = $lastnameOK = $emailOK = $usernameOK = $passwordOK = $confirmPassOK = $invalid  = $addressOK = $cityStOK = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["firstname"])) 
  {
    $firstnameErr = " is required";
  } 
  else 
  {
    $firstname = test_input($_POST["firstname"]);
	
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname))
	{
      $firstnameErr = "  Only letters and white space allowed"; 
    }
	else
	{
		$firstnameOK = true;
	}
  }
  
  if (empty($_POST["lastname"])) 
  {
    $lastnameErr = " is required";
  } else 
  {
    $lastname = test_input($_POST["lastname"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname))
	{
      $lastnameErr = "  Only letters and white space allowed"; 
    }
	else
		$lastnameOK = true;
  }
  
  if (empty($_POST["email"])) 
  {
    $emailErr = " is required";
  } else 
  {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
      $emailErr = "Invalid email format"; 
    }
	else
		$emailOK = true;
  }
  
  
  if (empty($_POST["address"])) 
  {
    $addressErr = " is required";
  } else 
  {
    $address = test_input($_POST["address"]);
    if (!preg_match('/\d+ [0-9a-zA-Z ]+/',$address))
	{
      $addressErr = " Only letters, numbers and white space allowed"; 
    }
	else
		$addressOK = true;
  }
  
  if (empty($_POST["citySt"])) 
  {
    $cityStErr = " is required";
  } else 
  {
    $citySt = test_input($_POST["citySt"]);
    if (!preg_match("/^[a-zA-Z0-9, ]*$/",$citySt))
	{
      $cityStErr = " Only letters, numbers, commas, and white space allowed"; 
    }
	else
		$cityStOK = true;
  }
  
  
	if (empty($_POST["username"])) 
  {
    $usernameErr = " is required";
  } 
  else 
  {
    $username = test_input($_POST["username"]);
	
	if (!preg_match("/^[a-zA-Z0-9]*$/",$username))
	{
      $usernameErr = "Must contain only letters and numbers"; 
    }
	else
	{
		$servername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "drinkstore";

		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		
		$sql = "select username from customers";
		
		$result = $conn->query($sql);

		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				if(strcmp($row["username"],$username) === 0)
				{
					$usernameErr = "This username is already in use";
					$invalid = true;
					break;
				}
			}
				
		}
		
		if($invalid === false)
		{
			$usernameOK = true;
		}
		
	}
	
  }
	
  if (empty($_POST["pass"])) 
  {
    $passwordErr = " is required";
  } else 
  {
    $password = test_input($_POST["pass"]);
    if (!preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[\W])(?=\S*[A-Z])(?=\S*[\d])\S*$^",$password))
	{
		$passwordErr = "Invalid. The Password should be at least 8 characters long
		Password should contain at least one lowercase letter. 
		Password should contain at least one uppercase letter. 
		Password should contain at least one digit.
		Password should have at least special character.";
	}
	else
		$passwordOK = true;
  }
  
  
  if (empty($_POST["confirmPass"])) 
  {
    $confirmPassErr = " is required";
  } else 
  {
    $confirmPass = test_input($_POST["confirmPass"]);
    if (strcmp($password,$confirmPass) !== 0)
	{
      $confirmPassErr = "The passwords must match.";
    }
	else
		$confirmPassOK = true;
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
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a href="Login.php">Login</a></div>    
    <div class="w3-right w3-large w3-padding-16 w3-button w3-bar-item"><a class ="active" href="Register.php">Register</a></div>
    <div class="w3-padding-16 w3-bar-item"><a href="index.php">Sovereign Soda Supply</a></div>
  </div>
</header>
<!-- !PAGE CONTENT! -->
<main class="w3-main w3-content w3-padding w3-white" style="max-width:1500px">
   
    <h1 style="text-align: center;">Register an Account</h1>
    
    <p><span class="error">* required field</span></p>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <div class="container">

	<div class="input-field col">
	  <span class="error">*</span>                                  
	  <input id="firstname" name="firstname" type="text" class="validate" value="<?php echo $firstname;?>">
	  <label for="firstname">First Name	<span class="error"><?php echo $firstnameErr;?> </span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span> 
	  <input id="lastname" name="lastname" type="text" class="validate" value="<?php echo $lastname;?>">
	  <label for="lastname">Last Name	<span class="error"><?php echo $lastnameErr;?> </span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="email" name="email" type="text" class="validate" value="<?php echo $email;?>">
	  <label for="email">E-mail	<span class="error"><?php echo $emailErr;?> </span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="address" name="address" type="text" class="validate" value="<?php echo $address;?>">
	  <label for="address">Address<span class="error"><?php echo $addressErr;?> </span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="citySt" name="citySt" type="text" class="validate" value="<?php echo $citySt;?>">
	  <label for="citySt">City, State, ZIP	<span class="error"><?php echo $cityStErr;?> </span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="username" name="username" type="text" class="validate" value="<?php echo $username;?>">
	  <label for="username">Username  <span class="error"><?php echo $usernameErr;?></span> </label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="pass" name="pass" type="password" class="validate" value="<?php echo $password;?>">
	  <label for="pass">Password	<span class="error"><?php echo $passwordErr;?></span></label>
	</div>
	
	<div class="input-field col">
	  <span class="error">*</span>
	  <input id="confirmPass" name="confirmPass" type="password" class="validate" value="<?php echo $confirmPass;?>">
	  <label for="confirmPass">Confirm Password	<span class="error"><?php echo $confirmPassErr;?></span></label>
	</div>

    <input type="submit" name="submit" class="w3-button w3-theme">
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

	if (!empty($_POST["submit"]) && $firstnameOK === true && $lastnameOK === true && $emailOK === true && $usernameOK === true && $passwordOK === true && $confirmPassOK === true && $cityStOK === true && $addressOK === true) 
  {
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "drinkstore";

	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

	if($conn->connect_error)
	{
		die("Connection Failed. " . $conn->connect_error);
	}

	$stmt = $conn->prepare("INSERT INTO customers(firstname, lastname, email, password, address, CityStateZIP, username) VALUES(?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssss", $firstname, $lastname, $email, $password, $address, $citySt, $username);
	
	$firstname = $firstname;
	$lastname = $lastname;
	$email = $email; 
	$username = $username;
	$password = $password;
	$address = $address;
	$citySt = $citySt;

	
	if($stmt->execute() === true)
	{
		echo "<script type='text/javascript'>";
			echo "window.location = 'Login.php'";
		echo "</script>";
	}
	else
		echo "Error, Try Again Later.";
	
	$conn->close();
	
  }
?>

</body>
</html>