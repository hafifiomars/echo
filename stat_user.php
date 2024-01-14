<?php  require_once('auth.php');
 require_once('Connections/conn.php');

$x = $_GET['x'];
$id = $_GET['id'];

if ($x == 1) { //deactivate user

	  $updateSQL ="UPDATE login SET flag_log = 1 WHERE login_id = '$id'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
	alert("Status successfully inactivated!");
	//window.location="user.php";
	history.go(-1);
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php
} else { //activate user

	  $updateSQL ="UPDATE login set flag_log = 0 WHERE login_id = '$id'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
	alert("Status successfully activated!");
	//window.location="user.php";
	history.go(-1);
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php } ?>
