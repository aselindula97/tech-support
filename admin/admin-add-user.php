<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}

$msg = "";

if(isset($_POST["submit"])) {

	//conncet to the database
	require_once("../dbcon/dbcon.php");

	
	$username = $_POST["user_name"];
	$email = $_POST["email"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$password = md5($_POST["password"]);
	
	//check the username or email already exists
	$query_1 = "SELECT user_name, email FROM user_info WHERE user_name='$username' OR email='$email'";
	$result_1 = mysqli_query($con,$query_1);

	if(mysqli_num_rows($result_1)!=0){
		$msg="<div id='error' style='display:block'>Username or Email already exists</div>";
		
	}else{
		if(isset($_POST["gender"])) {
			$gender = $_POST["gender"];
			$query_2 = "INSERT INTO user_info (user_name, email, first_name, last_name, password, gender) VALUES ('$username', '$email', '$first_name', '$last_name', '$password', '$gender')";
		}else{
			$query_2 = "INSERT INTO user_info (user_name, email, first_name, last_name, password) VALUES ('$username', '$email', '$first_name', '$last_name', '$password')";
		}
			
		$result_2 = mysqli_query($con,$query_2);
		
		if(!$result_2) {
			$error = mysqli_error($con);
			print $error;
			exit;
		}
		
	$msg = "<div class='msg' style='display:block'>You have added user successfully</div>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User | TechSupport</title>
	<link rel="stylesheet" href="../styles/admin.css" />
	<link rel="shortcut icon" href="../img/logo.png" />
	<script type="text/javascript">
		function validate() {
			if(document.admin_edit.user_name.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter Username";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.admin_edit.email.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter Email";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.admin_edit.password.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter Password";
				document.getElementById('error').style.display="block";
				return false;
			}
		}
	</script>
</head>
<body>
	<header>
		<div class="container">
			<div id="sitename">
				<img src="../img/logo.png" alt="Site Logo" />
				<h1>Tech Support</h1>
			</div>
			<nav>
				<ul>
					<li>Welcome <?php echo $_SESSION["username"] ?> !</li>
					<a href="../includes/logoff.php"><li class="logout">Log Out</li></a>
				</ul>
			</nav>
		</div>
	</header>
	<aside>
		<ul>
			<a href="admin-users.php"><li class="active">Users</li></a>
			<a href="admin-inbox.php"><li>Inbox</li></a>
			<a href="admin-profile.php"><li>Profile</li></a>
			<a href="admin-change-password"><li>Change Password</li></a>
		</ul>
	</aside><!--end of the header & navigation side bar-->

	<div class="content">
		<h1>Add User</h1><hr>
		<?php 
			//display message
			echo $msg;
		?>
		<div id="error"></div><!--Validation error msg-->
		<br />
		<a class="back_btn" href='./admin-users.php' style='margin:10px'>back</a>

		<center>

		<form name="admin_edit" method="post" action="admin-add-user.php" onSubmit="return validate()">
	
		
		<table width="50%" class="edit_user">
		<tbody>
		<tr>
			<th><p>Username</p></th>
			<td><input type="text" name="user_name" size="50" required /></td>
		</tr>
		<tr>						
			<th><p>E-mail</p></th>
			<td><input type="email" name="email" size="50" maxlength="50" required /></td>
		</tr>		
		<tr>
			<th><p>First Name</p></th>
			<td><input type="text" name="first_name" size="50" maxlength="50" /></td>
		</tr>
		<tr>		
			<th><p>Last Name</p></th>
			<td><input type="text" name="last_name" size="50" maxlength="50" /></td>
		</tr>
		<tr>		
			<th><p>Password</p></th>
			<td><input type="password" name="password" size="50" maxlength="50" required /></td>
		</tr>
		<tr>												
			<th><p>Gender</p></th>
			<td><input type="radio" name="gender" value="Male" /> &nbsp; Male
			<input type="radio" name="gender" value="Female" /> &nbsp; Female
			</td>
		</tr></tbody>
		<tfoot>
		<tr>
			<td colspan="2"><center><input type="submit" name="submit" value=" Add " /></center></td>
		</tr></tfoot>
		</table>

		</form>

		</center>
	</div>

</body>
</html>