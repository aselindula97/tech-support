<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}

$msg = "";

if(isset($_POST["submit"])) {

	require_once("../dbcon/dbcon.php");
	
	$fname = $_POST["first_name"];
	$lname = $_POST["last_name"];
	$email = $_POST["email"];
	$user_name = $_GET["uname"];
	
	if(isset($_POST["gender"])) {
		$gender = $_POST["gender"];
		$query_2 = "UPDATE user_info SET first_name='$fname',last_name='$lname', gender='$gender', email='$email' WHERE user_name = '$user_name'";
	}else{
		$query_2 = "UPDATE user_info SET first_name='$fname',last_name='$lname', gender= NULL, email='$email' WHERE user_name = '$user_name'";
	}

	$result_2 = mysqli_query($con,$query_2);
	
	if(!$result_2) {
		$err=mysqli_error($con);
		print $err;
		exit();
	} 

	$msg = "<div class='msg' style='display:block'>Information has been entered</div>";
			
	

} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>TechSupport | Users</title>
	<link rel="stylesheet" href="../styles/admin.css">
	<link rel="shortcut icon" href="../img/logo.png" />
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
			<a href="admin-dashboard.php"><li>Dashboard</li></a>
			<a href="admin-users.php"><li class="active">Users</li></a>
			<a href="admin-inbox.php"><li>Inbox</li></a>
			<a href="admin-profile.php"><li>Profile</li></a>
			<a href="admin-change-password"><li>Change Password</li></a>
		</ul>
	</aside>

	<div class="content">
		
		<h1>Edit User Information</h1><hr>
		<?php 
			//Display message
			echo $msg;
		?>
		<br />
		<a class="back_btn" href='./admin-users.php' style='margin:10px'>back</a>

		<?php 
		if(isset($_GET["uname"])) {
			require_once("../dbcon/dbcon.php");

			$uname = $_GET["uname"];

			$query_1 = "SELECT first_name, last_name, gender, email FROM user_info WHERE user_name = '$uname'";
			$result_1 = mysqli_query($con,$query_1);

			if(!$result_1) {	
				print mysqli_error($con);
				exit();  
			}

			while($row=mysqli_fetch_assoc($result_1)) {
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$gender = $row['gender'];
				$email = $row['email'];
			}
		}	
		?>
	
	<center>

	<form name="admin_edit" method="post" action="">
	
		
		<table width="50%" class="edit_user">
		<tbody>
		<tr>
			<th><p>Username</p></th>
			<td><input type="text" name="user_name" size="50" value="<?php echo $uname; ?>" disabled /></td>
		</tr>
		<tr>						
			<th><p>E-mail</p></th>
			<td><input type="text" name="email" size="50" maxlength="50" value="<?php echo $email; ?>" /></td>
		</tr>		
		<tr>
			<th><p>First Name</p></th>
			<td><input type="text" name="first_name" size="50" maxlength="50" value="<?php echo $first_name; ?>" /></td>
		</tr>
		<tr>		
			<th><p>Last Name</p></th>
			<td><input type="text" name="last_name" size="50" maxlength="50" value="<?php echo $last_name; ?>" /></td>
		</tr>
		<tr>												
			<th><p>Gender</p></th>
			<td><input type="radio" name="gender" value="Male" <?php if($gender == "male") echo "CHECKED"; ?> /> &nbsp; Male
			<input type="radio" name="gender" value="Female" <?php if($gender == "female") echo "CHECKED"; ?> /> &nbsp; Female
			</td>
		</tr></tbody>
		<tfoot>
		<tr>
			<td colspan="2"><center><input type="submit" name="submit" value=" Submit " /></center></td>
		</tr></tfoot>
		</table>


	</form>

	</center>
			

		
		
	</div>

</body>
</html>