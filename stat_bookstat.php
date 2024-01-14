<?php  require_once('auth.php');
 require_once('Connections/conn.php'); 

$x = $_GET['x'];
$statustempahan = $_GET['id'];

if ($x == 1) {
  
	  $updateSQL ="Update app_status  set flag_as = 1 WHERE appointmentstatusID = '$statustempahan'";			 
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Appointment status successfully inactivated!");
window.location="list_bookstat.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php 
} else {
       
	  $updateSQL ="Update app_status set flag_as = 0 WHERE appointmentstatusID = '$statustempahan'";			 
	  mysqli_select_db($conn, $database_conn);
	  $ResultUpdt = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
 ?>
<script type="text/javascript">

function show_alert()
{
alert("Appointment status successfully activated!!");
window.location="list_bookstat.php";
}

</script>

<script type="text/javascript">
	show_alert();
</script>

<?php } ?>


