<script type="text/javascript">
function show_alert_add() {

	alert("Information added successfully");
	window.location='list_jawatan.php';
}
</script>

<script type="text/javascript">
function show_alert_up() {

	alert("Information updated successfully");
	window.location='list_jawatan.php';
}
</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];
$gred = mysqli_real_escape_string($conn, $_POST['txtgred']);

if ($x == 1) { //insert new
	$jawatan = mysqli_real_escape_string($conn, $_POST['ddljaw']);
	$insertSQL = "INSERT INTO gred_tbl (gred_no, pos_id) VALUES ('$gred', '$jawatan')";
	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));

?>
	<script type="text/javascript">
		show_alert_add();
	</script>

<?php } else { // edit
	$gid = mysqli_real_escape_string($conn, $_POST['txtid']);

	$updateSQL = "UPDATE gred_tbl SET gred_no='$gred' WHERE gred_id='$gid'";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));

?>
	<script type="text/javascript">
		show_alert_up();
	</script>
<?php }
?>
