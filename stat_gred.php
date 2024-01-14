<?php  require_once('auth.php');
 require_once('Connections/conn.php');

$x = $_GET['x'];
$gred = $_GET['id'];

if ($x == 1) {


	  $updateSQL ="Update gred_tbl set gred_flag = 1 WHERE gred_id = '$gred'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Grade status successfully inactivated!");
window.location="list_jawatan.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php
} else {

	  $updateSQL ="Update gred_tbl set gred_flag = 0 WHERE gred_id = '$gred'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Grade status successfully activated!");
window.location="list_jawatan.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php } ?>
