<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}

$msg="";

if(isset($_POST["submit"])) {

	require_once("../dbcon/dbcon.php");

	$user_name=$_SESSION["username"];
	$title = $_POST["title"];
	$category = $_POST["category"];
	$details = $_POST["details"];

	$query="INSERT INTO questions_n_answers (user_name, title, category, details) VALUES ('$user_name', '$title', '$category', '$details')";
	$result = mysqli_query($con,$query);
		
	if(!$result) {
		$error = mysqli_error($con);
		print $error;
		exit;
	}

	$msg="<div class='msg' style='display:block'>Your message has been sent successfully</div>";

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Question | TechSupport</title>
	<link rel="stylesheet" href="../styles/user.css" />
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
			<a href="user-question.php"><li class="active">Ask a Question</li></a>
			<a href="user-inbox.php"><li>Inbox</li></a>
			<a href="user-profile.php"><li>Profile</li></a>
			<a href="user-change-password.php"><li>Change Password</li></a>
		</ul>
	</aside><!--end of the header & navigation side bar-->

	<div class="content">
		<h1>Ask a Question</h1><hr>
		<?php 
			//Display message
			echo $msg;
		?>
		<center>

		<form method="post" action="user-question.php">
	
		
		<table width="50%" class="QnAtable">
		<tbody>
		<tr>
			<th><p>Title</p></th>
			<td><input type="text" name="title" size="55" maxlength="60" placeholder="Type an appropriate title for your question" value="" required /></td>
		</tr>
		<tr>						
			<th><p>Category</p></th>
			<td><select name="category" class="listbox" required>
					<option value="" selected>Select a Category</option>
					<option value="Operating Systems">Operating Systems</option>
					<option value="Software">Software</option>
					<option value="Hardware">Hardware</option>
					<option value="Internet & Networking">Internet & Networking</option>
					<option value="Security & Malware Removal">Security & Malware Removal</option>
					<option value="Phones & Mobile Devices">Phones & Mobile Devices</option>
					<option value="General Technology">General Technology</option>
					<option value="Other">Other</option>
				</select>
			</td>
		</tr>		
		<tr>
			<th class="detailhead"><p>Details</p></th>
			<td><textarea name="details" class="txtarea" cols="55" rows="13" placeholder="Describe your question..." required></textarea></td>
		</tr>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="2"><center><input type="submit" name="submit" value=" Send " /></center></td>
		</tr></tfoot>
		</table>

		</form>

		</center>
		
	</div>

</body>
</html>
