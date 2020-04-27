<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}

$msg = "";

if(isset($_GET["uname_d"])) {

		/*Connect to MySQL database*/
		require_once("../dbcon/dbcon.php");
			
		$uname=$_GET["uname_d"];

		$query2 = "DELETE FROM user_info WHERE user_name = '$uname'";
		$result2 = mysqli_query($con,$query2);

		if(!$result2) {
			$err=mysqli_error($con);
			print $err;
			exit();
		}
	
		$msg = "<div class='msg' style='display:block'>User Information has been deleted.</div>";
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Users | TechSupport</title>
	<link rel="stylesheet" href="../styles/admin.css" />
	<link rel="shortcut icon" href="../img/logo.png" />
	<script type="text/javascript">
		function delete_conf() {
			return confirm("Do you want to delete this user?");
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
		<?php 
			//display message
			echo $msg;
		?>
		<h1>Users</h1><hr>
		<a href="admin-add-user.php" class="add_btn_a">
			<div class="add_btn">
				<img src="../img/add-user-icon.png" alt="Add User" class="add_icon">
				<p>Add User</p>
			</div>
		</a>
		<?php

		/*Connect to MySQL database*/
		require_once("../dbcon/dbcon.php");

		$user_name=$_SESSION["username"];

		/*Execute SQL command*/
		$query = "SELECT user_name, first_name, last_name, gender, email FROM user_info WHERE user_name!='$user_name'";
		$result=mysqli_query($con,$query);	
	
	
		/* Output results as HTML table */
		echo "<center><table width=75% class='usertable'>\n";

		/* Output field names as table header */
		echo "<tr>
			<th width='15%'>USERNAME</th>
			<th width='20%'>FIRST NAME</th>
			<th width='20%'>LAST NAME</th>
			<th width='5%' >GENDER</th>
			<th width='20%'>E-MAIL</th>
			<th width='10%'>EDIT</th>
			<th width='15%'>DELETE</th>
			</tr>";
	
	
		/* Output all records */
		while($myrow=mysqli_fetch_row($result))  {
		echo "<tr>";
		for($f=0;$f<mysqli_num_fields($result);$f++)  {
			echo "<td>&nbsp;".htmlspecialchars($myrow[$f]);
		}
		echo "<td width='5%' align='center'><a class='edit_btn' href='./admin-edit-user.php?uname=".urlencode($myrow[0])."'>edit</a>";
		echo "<td width='5%' align='center'><a class='del_btn' onClick='return delete_conf()' href='?uname_d=".urlencode($myrow[0])."'>delete</a>";
		}
		echo "</table>\n
			  </center>\n";

		
		?>
	</div>

</body>
</html>