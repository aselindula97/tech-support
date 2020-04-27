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

	$ans = $_POST["answer"];
	$qid = $_GET["qid"];

	$query = "UPDATE questions_n_answers SET answer='$ans' WHERE question_ID='$qid'";
	$result = mysqli_query($con,$query);
		
	if(!$result) {
		$error = mysqli_error($con);
		print $error;
		exit;
	}

	$msg = "<div class='msg' style='display:block'>Your answer has been sent successfully</div>";

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>More Details | TechSupport</title>
	<link rel="stylesheet" href="../styles/admin.css" />
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
			<a href="admin-users.php"><li>Users</li></a>
			<a href="admin-inbox.php"><li class="active">Inbox</li></a>
			<a href="admin-profile.php"><li>Profile</li></a>
			<a href="admin-change-password"><li>Change Password</li></a>
		</ul>
	</aside><!--end of the header & navigation side bar-->

	<div class="content">
		<h1>Inbox</h1><hr>
		<?php 
			//Display message
			echo $msg;
		?>
		<br />
		<a class="back_btn" href='./admin-inbox.php' style='margin:10px'>back</a>

		<?php 
		if(isset($_GET["qid"])) {

			require_once("../dbcon/dbcon.php");

			$quesID = $_GET["qid"];

			$query_1 = "SELECT * FROM questions_n_answers WHERE question_ID = '$quesID'";
			$result_1 = mysqli_query($con,$query_1);

			if(!$result_1) {	
				print mysqli_error($con);
				exit();  
			}

			while($row = mysqli_fetch_assoc($result_1)) {
				$user_asked = $row["user_name"];
				$title = $row["title"];
				$category = $row["category"];
				$details = $row["details"];
				$answer = $row["answer"];
			}
		}	
		?>

		<div class="qn_row">
			<h2><?php echo $title; ?></h2>
			<p><?php echo $details; ?></p>
			<span><img src="../img/user-icon.png" alt="user icon" class="small_icon" /><b>Asked By:</b> <?php echo $user_asked; ?></span>
			<span><img src="../img/folder-icon.png" alt="folder icon" class="small_icon" /><b>Category:</b> <?php echo $category; ?></span><br /><br /><br />

			<?php
			if(isset($answer)){
				echo "<h2>Answer</h2>
					  <p>$answer</p></div>";
			}else{
				echo "</div>
					  <div class='answer'>
						<h2>Leave an Answer</h2>
						<form method='post' action=''>
							<textarea class='txtarea' name='answer' cols='70' rows='10' required></textarea>
							<input type='submit' name='submit' value=' Send ' />
						</form>
					  </div>";
			}
			?>
		
	</div>

</body>
</html>