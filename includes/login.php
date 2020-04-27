<?php
	session_start();

$error="";


//check for form submission
if(isset($_POST["submit"])) {	
	
	//conncet to the database
	require_once("../dbcon/dbcon.php");

	//assign username and password into variables
	$username=$_POST["username"];
	$password=md5($_POST["password"]);
	
	
	//retriving data from db
	$query = "SELECT user_name FROM user_info WHERE user_name = '$username' AND password = '$password'";
	$result=mysqli_query($con,$query);
	
	//if something wrong with the query
	if(!$result) {
		$error = mysqli_error($con);
		print $error;
		exit;
	}


	while($row=mysqli_fetch_assoc($result)) {
		$uname=$row['user_name'];
	}
	
	if(mysqli_affected_rows($con)==0) {
		$error = "<div id='error' style='display:block'>Invalid Username or Password</div>";
	} elseif ($uname=="admin") {
		$_SESSION["username"]=$uname;
		header("Location: ../admin/admin-users.php");//redirect to admin page
		exit;
	}else{
		$_SESSION["username"]=$uname;
		header("Location: ../user/user-question.php");//redirect to user page
		exit;
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Log in | Tech Support</title>
	<link rel="stylesheet" type="text/css" href="../styles/login.css" />
	<link rel="shortcut icon" href="../img/logo.png" />

	<script>
		function validate() {
			if(document.loginform.username.value=='') {
				document.getElementById('error').innerHTML="Please enter your username";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.loginform.password.value=='') {
				document.getElementById('error').innerHTML="Please enter your password";
				document.getElementById('error').style.display="block";
				return false;
			}
		}
	</script>

</head>

<body>
	<div class="loginbox">
	<img src="../img/avatar.png" class="avatar" />
		<h1>Login</h1>
		
		<?php
		//error message
		 	echo $error;
		?>
		<?php 
		if (isset($_GET['logout'])) {
			echo "<div id='success'>You have logged out successfully</div>";
		}
		?>
		<div id="error"></div>

		<form name="loginform" action="login.php" method="post" onSubmit="return validate()">
			<p>Username</p>
			<input type="text" name="username" placeholder="Enter Username" />

			<p>Password</p>
			<input type="password" name="password" placeholder="Enter Password" />

			<input type="submit" name="submit" value="Login" />

			<div class="acc">Don't have an account? <a href="signup.php">SignUp</a></div>
			<a href="../index.php">Back</a>
		</form>

	</div>

</body>
</head>
</html>