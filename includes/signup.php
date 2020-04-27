<?php
		
$msg = "";

if(isset($_POST["submit"])) {

	//conncet to the database
	require_once("../dbcon/dbcon.php");
	
	//assign form inputs into variables
	$username=$_POST["username"];
	$email=$_POST["email"];
	$password=md5($_POST["password"]);
	
	//check the username or email already exists
	$query_1 = "SELECT user_name, email FROM user_info WHERE user_name='$username' OR email='$email'";
	$result_1 = mysqli_query($con,$query_1);

	if(mysqli_num_rows($result_1)!=0){
		$msg="<div id='error' style='display:block'>Username or Email already exists</div>";
		
	}else{
		//send data to the database
		$query_2 = "INSERT INTO user_info (user_name, email, password) VALUES ('$username', '$email', '$password')";
		$result_2 = mysqli_query($con,$query_2);
		
		//if something wrong with the query
		if(!$result_2) {
			$error = mysqli_error($con);
			print $error;
			exit;
		}
		
		$msg = "<div id='success' style='display:block'>You have registered successfully</div>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Sign up | Tech Support</title>
	<link rel="stylesheet" type="text/css" href="../styles/signup.css" />
	<link rel="shortcut icon" href="../img/logo.png" />
	<script>
		function validate() {
			if(document.signupform.username.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter your username";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.signupform.email.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter your email address";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.signupform.password.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter your password";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.signupform.password_conf.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter confirm password";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.signupform.password.value!=document.signupform.password_conf.value) {
				document.getElementById('error').innerHTML="Passwords did not match";
				document.getElementById('error').style.display="block";
				return false;
			}
		}
	</script>
</head>
<body>
	<div class="signupbox">
	<img src="../img/avatar.png" class="avatar" />
		<h1>Sign Up</h1>


		<?php
		//display message
		 	echo $msg;
		?>

		<div id="error"></div><!--Validation error msg-->

		<form name="signupform" action="signup.php" method="post" onSubmit="return validate()">
			<p>Username</p>
				<input type="text" name="username" placeholder="Enter Username" maxlength="50" />
			<p>Email</p>
				<input type="email" name="email" placeholder="Enter Email" maxlength="50" />
			<p>Password</p>
				<input type="password" name="password" placeholder="Enter Password" maxlength="50" />
			<p>Confirm Password</p>
				<input type="password" name="password_conf" placeholder="Confirm Password" maxlength="50" />
			<input type="submit" name="submit" value="Sign Up" />
			<div class="acc">Already a user? <a href="login.php">Login</a></div>
			<a href="../index.php">Back</a>
		</form>
	</div>

</body>
</head>
</html>