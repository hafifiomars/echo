<script type="text/javascript">
function show_alert_add() {

	alert("Department has been recorded");
	window.location='list_jabatan.php';
}
</script>

<script type="text/javascript">
function show_alert_up() {

	alert("Department has been updated");
	window.location='list_jabatan.php';
}
</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];
$jbtn = mysqli_real_escape_string($conn, $_POST['txtjab']);

if ($x == 1) {
	//insert new type
	$insertSQL = "INSERT INTO dept_tbl (department_name) VALUES ('$jbtn')";
	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
?>
	<script type="text/javascript">
		show_alert_add();
	</script>

<?php } else { // edit type

	$jabatanID = mysqli_real_escape_string($conn, $_POST['txtid']);

	$updateSQL = "UPDATE dept_tbl SET department_name='$jbtn' WHERE department_id='$jabatanID'";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));

?>
	<script type="text/javascript">
		show_alert_up();
	</script>
<?php }
?>
