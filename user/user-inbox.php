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
			<a href="user-question.php"><li>Ask a Question</li></a>
			<a href="user-inbox.php"><li class="active">Inbox</li></a>
			<a href="user-profile.php"><li>Profile</li></a>
			<a href="user-change-password.php"><li>Change Password</li></a>
		</ul>
	</aside><!--end of the header & navigation side bar-->

	<div class="content">
		<h1>Inbox</h1><hr>
		<?php  
		
			require_once("../dbcon/dbcon.php");

			$user_name=$_SESSION["username"];

			//select unanswered questions
			$query_1 = "SELECT * FROM questions_n_answers WHERE user_name='$user_name' AND answer IS NULL ORDER BY question_ID DESC";
			$result_1=mysqli_query($con,$query_1);

			echo "<h3 class='subtopic'>Unanswered Questions</h3>";
			while($row=mysqli_fetch_assoc($result_1)){
			echo "<div class='qn_row'>
					<h3>".$row['title']."</h3>
					<span><img src='../img/user-icon.png' alt='user icon' class='small_icon' />Asked By: You</span>
					<span><img src='../img/folder-icon.png' alt='folder icon' class='small_icon' />Category: ".$row['category']."</span>
					<span><a href='./user-answer.php?qid=".urlencode($row['question_ID'])."'>View more details...</a></span>
				</div>";
			}

			echo "<hr>";
			echo "<h3 class='subtopic'>Answered Questions</h3>";

			//select answered questions
			$query_2 = "SELECT * FROM questions_n_answers WHERE user_name='$user_name' AND answer IS NOT NULL ORDER BY question_ID DESC";
			$result_2=mysqli_query($con,$query_2);

			while($row=mysqli_fetch_assoc($result_2)){
			echo "<div class='qn_row'>
					<h3>".$row['title']."</h3>
					<span><img src='../img/user-icon.png' alt='user icon' class='small_icon' />Asked By: You</span>
					<span><img src='../img/folder-icon.png' alt='folder icon' class='small_icon' />Category: ".$row['category']."</span>
					<span><a href='./user-answer.php?qid=".urlencode($row['question_ID'])."'>View more details...</a></span>
				</div>";
			}	
		?>
	</div>

</body>
</html>