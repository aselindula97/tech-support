<?php
	session_start();
	if(!isset($_SESSION["username"]))  {
		header("Location: ../error.html");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inbox | TechSupport</title>
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

			require_once("../dbcon/dbcon.php");

			$query_1 = "SELECT * FROM questions_n_answers WHERE answer IS NULL ORDER BY question_ID DESC";
			$result_1=mysqli_query($con,$query_1);

			if(!$result_1) {	
				print mysqli_error($con);
				exit();
			}

			echo "<h3 class='subtopic'>Unanswered Questions</h3>";
			
			while($row=mysqli_fetch_assoc($result_1)){
			echo "<div class='qn_row'>
					<h3>".$row['title']."</h3>
					<span><img src='../img/user-icon.png' alt='user icon' class='small_icon' />Asked By: ".$row['user_name']."</span>
					<span><img src='../img/folder-icon.png' alt='folder icon' class='small_icon' />Category: ".$row['category']."</span>
					<span><a href='./admin-answer.php?qid=".urlencode($row['question_ID'])."'>View more details...</a></span>
				</div>";
			}




			echo "<hr>";
			echo "<h3 class='subtopic'>Answered Questions</h3>";

			$query_2 = "SELECT * FROM questions_n_answers WHERE answer IS NOT NULL ORDER BY question_ID DESC";
			$result_2=mysqli_query($con,$query_2);

			if(!$result_2) {	
				print mysqli_error($con);
				exit();
			}

			while($row=mysqli_fetch_assoc($result_2)){
			echo "<div class='qn_row'>
					<h3>".$row['title']."</h3>
					<span><img src='../img/user-icon.png' alt='user icon' class='small_icon' />Asked By: ".$row['user_name']."</span>
					<span><img src='../img/folder-icon.png' alt='folder icon' class='small_icon' />Category: ".$row['category']."</span>
					<span><a href='./admin-answer.php?qid=".urlencode($row['question_ID'])."'>View more details...</a></span>
				</div>";
			}	
		?>
	</div>

</body>
</html>