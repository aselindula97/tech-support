<?php
	/*variable needed for the user to connect to the database*/		
	$host="localhost";
	$dbuser="root";
	$dbpassword="";
	$dbase="techsupport";

	/*connect to mysql database */	
	$con=mysqli_connect($host,$dbuser,$dbpassword) or die("Can't connect to server :".mysqli_connect.error());
	mysqli_select_db($con,$dbase) or die("Can't connect to database");	
	
?>