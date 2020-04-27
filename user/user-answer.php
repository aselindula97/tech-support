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
	<title>More details | TechSupport</title>
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
		<br />
		<a class="back_btn" href='./user-inbox.php' style='margin:10px'>back</a>

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

			while($row=mysqli_fetch_assoc($result_1)) {
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
			<span><img src="../img/user-icon.png" alt="user icon" class="small_icon" /><b>Asked By:</b> You</span>
			<span><img src="../img/folder-icon.png" alt="folder icon" class="small_icon" /><b>Category:</b> <?php echo $category; ?></span><br /><br /><br />
			<?php
			if(isset($answer)){
				echo "<h2>Answer</h2>
					  <p>$answer</p>";
			}
			?>
			
		</div>
		
	</div>

</body>
</html>