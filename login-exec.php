<?php
	//Start session
	session_start();

	//Include database connection details
	include('Connections/conn.php');

	//Array to store validation errors
	$errmsg_arr = array();

	//Validation error flag
	$errflag = false;

	//Connect to mysql server
	$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysqli_error($conn),E_USER_ERROR);

	$link = mysqli_connect($hostname_conn, $username_conn, $password_conn);
	if(!$link) {
		die('Failed to connect to server: ' . mysqli_error($conn));
	}
	
	//Select database
	$db = mysqli_select_db($conn,$database_conn);
	if(!$db) {
		die("Unable to select database");
	}

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean ($conn,$str) {
		// $str = @trim($str);
		// if(get_magic_quotes_gpc()) {
		// 	$str = stripslashes($str);
		// }
		return mysqli_real_escape_string($conn, $str);
	}

	//Sanitize the POST values
	$username = clean($conn,$_POST['username']);
	$password = clean($conn,$_POST['password']);

	//Input Validations
	if($username == '') {
		$errflag = true;


	}
	if($password == '') {
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		//header("location: index.php");
		header("location: login-failed.php");
		exit();
	}

	//Create query
	$qry="SELECT * FROM login WHERE username='$username' AND password='$password' AND flag_log='0'";
	$result=mysqli_query($conn, $qry);

	//Check whether the query was successful or not
	if($result) {
		if(mysqli_num_rows($result) == 1) {
			//Login SuccessfulTTT
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['login_id'];
			$_SESSION['SESS_USERNAME'] = $member['username'];
			$_SESSION['SESS_TYPE'] = $member['levelUser'];
			$_SESSION['SESS_NAMA'] = $member['name'];
			session_write_close();
			header("location: echo.php");

			exit();
		}else {
			//Login failed
			header("location: login-failed.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>
