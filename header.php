<?php
require_once('auth.php');
require_once('Connections/conn.php');
$type = $_SESSION['SESS_TYPE'];
$lg_id = $_SESSION['SESS_MEMBER_ID'];

mysqli_select_db($conn, $database_conn);
$query_recloginname = "SELECT * FROM login  WHERE login_id = '$lg_id'";
$recloginname = mysqli_query($conn, $query_recloginname) or die(mysqli_error($conn));
$row_recloginname = mysqli_fetch_assoc($recloginname);
$totalRows_recloginname = mysqli_num_rows($recloginname);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>i-Echo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

  <link href="bootstrap-3.4.1/css/bootstrap-theme.css" rel="stylesheet" media="screen">
  <link href="bootstrap-3.4.1/css/bootstrap.css" rel="stylesheet" media="screen">

</head>
<body style="height:1500px" >

<nav class="navbar navbar-expand-lg navbar navbar-light" style="background-color: #e3f2fd;">
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">

    <ul class="nav navbar-nav" >
      <li><img src="img/echo-icon.png" width="40" height="40"/></li>
      <li><img src="img/htar.png" width="40" height="40"/></li>
      <li><a href="booking.php" target="mainFrame">Patient</a></li>
	    <li><a href="add_rec_patient.php" target="mainFrame">Appointment</a></li>
      <li><a href="block_date.php?a=0" target="mainFrame">Reservation</a>


      <?php if ($type == 1) { // admin ?>

      <li><a href="list_jabatan.php" target="mainFrame">Department</a></li>
      <li><a href="list_jawatan.php" target="mainFrame">Position</a></li>
      <li><a href="user.php" target="mainFrame">User</a></li>
      <li><a href="stat_echo.php?a=0" target="mainFrame">Echo Statistics</a>
      <li><a href="stat_pat.php?a=0" target="mainFrame">Patient Statistics</a>
      <li><a href="stat_hf.php?a=0" target="mainFrame">Heart Failure Statistics</a>
      <li><a href="export_exl.php?a=0" target="mainFrame">Export Excel</a>

      <?php } ?>

      <?php if ($type == 2) { // user ?>
	<li><a href="search_patient.php" target="mainFrame">Search Patient</a></li>
  <li><a href="export_exl.php?a=0" target="mainFrame">Export Excel</a>
      
  <?php } ?>

      <?php if ($type == 3) { // Verify ?>
      <li><a href="stat_echo.php?a=0" target="mainFrame">Echo Statistics</a>
      <li><a href="stat_pat.php?a=0" target="mainFrame">Patient Statistics</a>
      <li><a href="stat_hf.php?a=0" target="mainFrame">Heart Failure Statistics</a>
      <li><a href="export_exl.php?a=0" target="mainFrame">Export Excel</a>
      <?php } ?>

      <?php if ($type == 0) { // reviewer ?>
	<li><a href="search_patient.php" target="mainFrame">Search Patient</a></li>
      <?php } ?>

    </ul>
<ul class="nav navbar-nav navbar-right">

	<li><a href="Manual.pdf" target="_blank">User Manual</a></li>
      <li><a href="acc_set.php" target="mainFrame"><span class="glyphicon glyphicon-user"></span> <?php echo $row_recloginname['username']; ?></a></li>
      <li><a href="logout.php" target="_parent"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>

  </div>
</nav>


</body>
</html>