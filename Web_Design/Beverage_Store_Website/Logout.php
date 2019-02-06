

<?php  
session_start();

if(isset($_SESSION["loggedIn"])) 
{
	unset($_SESSION['loggedIn']);
	unset($_SESSION['customer_id']);
	unset($_SESSION['username']);
	
	
echo "<script type='text/javascript'>";
	echo "window.location = 'index.php'";
echo "</script>";
}
?>