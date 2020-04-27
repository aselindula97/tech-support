<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}

$msg = "";

if(isset($_POST["submit"])) {
	
	/*Connect to MySQL database*/
	require_once("../dbcon/dbcon.php");

	$old_pass = md5($_POST["old_pass"]);
	$new_pass = md5($_POST["new_pass"]);
	$user_name = $_SESSION["username"];

	$query_1 = "SELECT password from user_info WHERE user_name='$user_name' AND password='$old_pass'";
	$result_1 = mysqli_query($con,$query_1);

	if (mysqli_num_rows($result_1)==0){
		$msg = "<div id='error' style='display:block'>Your old password is incorrect</div>";
	}else{

		$query_2 = "UPDATE user_info SET password='$new_pass' WHERE user_name = '$user_name'";
		$result_2 = mysqli_query($con,$query_2);

		if(!$result_2) {
			$err=mysqli_error($con);
			print $err;
			exit();
		} 

		$msg = "<div class='msg' style='display:block'>Your password has been successfully updated</div>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password | TechSupport</title>
	<link rel="stylesheet" href="../styles/user.css" />
	<link rel="shortcut icon" href="../img/logo.png" />
	<script>
		function validate() {
			if(document.change_pass_form.old_pass.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter your Old Password";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.change_pass_form.new_pass.value.trim()=='') {
				document.getElementById('error').innerHTML="Please enter your New Password";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.change_pass_form.conf_new_pass.value.trim()=='') {
				document.getElementById('error').innerHTML="Please confirm your New Password";
				document.getElementById('error').style.display="block";
				return false;
			}
			if(document.change_pass_form.new_pass.value!=document.change_pass_form.conf_new_pass.value) {
				document.getElementById('error').innerHTML="Passwords did not match";
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
			<a href="user-question.php"><li>Ask a Question</li></a>
			<a href="user-inbox.php"><li>Inbox</li></a>
			<a href="user-profile.php"><li>Profile</li></a>
			<a href="user-change-password.php"><li class="active">Change Password</li></a>
		</ul>
	</aside><!--end of the header & navigation side bar-->

	<div class="content">
		<h1>Change Password</h1><hr>
		
		<?php 
			//Display message
			echo $msg;
		?>
		<div id="error"></div><!--Validation error msg-->

		<center>
		<form name="change_pass_form" method="post" action="user-change-password.php" onSubmit="return validate()">
		<table class="change_pass">
			<tbody>
			<tr>
				<th>Old Password</th>
				<td><input type="password" name="old_pass" size="40" maxlength="50" /></td>
			</tr>
			<tr>
				<th>New Password</th>
				<td><input type="password" name="new_pass" size="40" maxlength="50" /></td>
			</tr>
			<tr>
				<th>Confirm New Password</th>
				<td><input type="password" name="conf_new_pass" size="40" maxlength="50" /></td>
			</tr>
			</tbody>

			<tfoot>
				<tr>
					<td colspan="2"><center><input type="submit" name="submit" value=" Save " /></center></td>
				</tr>
			</tfoot>
		</table>
		</form>
		</center>
		

	</div>	
	

</body>
</html>