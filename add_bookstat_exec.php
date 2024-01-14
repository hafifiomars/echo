<script type="text/javascript">
function show_alert_add() {

	alert("Appointment status added successfully");
	window.location='list_bookstat.php';
}
</script>

<script type="text/javascript">
function show_alert_up() {

	alert("Appointment status updated successfully");
	window.location='list_bookstat.php';
}
</script>

<?php require_once('auth.php');	
require_once('Connections/conn.php'); 

$x = $_GET['x'];
$app_status = mysqli_real_escape_string($conn, $_POST['txtbookstat']);

if ($x == 1) {
	//insert 
	$insertSQL = "INSERT INTO app_status (appointment_status) VALUES ('$app_status')";
	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
?>
	<script type="text/javascript">
		show_alert_add();
	</script>

<?php } else { // edit 

	$appointmentstatusID = mysqli_real_escape_string($conn, $_POST['txtid']);
	
	$updateSQL = "UPDATE app_status SET appointment_status='$app_status' WHERE appointmentstatusID='$appointmentstatusID'";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));

?>
	<script type="text/javascript">
		show_alert_up();
	</script>
<?php }
?>


  
