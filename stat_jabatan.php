<?php  require_once('auth.php');
 require_once('Connections/conn.php');

$x = $_GET['x'];
$jbtn= $_GET['id'];

if ($x == 1) {

	  $updateSQL ="Update dept_tbl set department_flag = 1 WHERE department_id = '$jbtn'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Department status successfully inactivated!");
window.location="list_jabatan.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php
} else {

	  $updateSQL ="Update dept_tbl set department_flag = 0 WHERE department_id = '$jbtn'";
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Department status successfully activated!");
window.location="list_jabatan.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php } ?>
