<script type="text/javascript">
function show_alert_add() {

	alert("Information added successfully");
	//window.location='list_loc.php';
	history.go(-2);
}
</script>

<script type="text/javascript">
function show_alert_up() {

	alert("Information updated successfully");

	history.go(-2);
}
</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];
$position = mysqli_real_escape_string($conn, $_POST['txtjaw']);

if ($x == 1) {

	$insertSQL = "INSERT INTO pos_tbl (pos_name) VALUES ('$position')";
	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
?>
	<script type="text/javascript">
		show_alert_add();
	</script>

<?php } else {

	$jawid = mysqli_real_escape_string($conn, $_POST['txtid']);

	$updateSQL = "UPDATE pos_tbl SET pos_name='$position' WHERE pos_id='$jawid'";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));

?>
	<script type="text/javascript">
		show_alert_up();
	</script>
<?php }
?>
