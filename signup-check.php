<script type="text/javascript">

function show_alert_add()
{
alert("Info successfully recorded");
history.go(-2);
}

function show_alert_edit()
{
alert("Info successfully updated");
history.go(-2);
}

function show_alert_reg()
{
alert("Info successfully recorded. Registration is being processed");
history.go(-2);
}
</script>

<?php
require_once('Connections/conn.php');


//$type = $_SESSION['SESS_TYPE'];

$fullname = mysqli_real_escape_string($conn, $_POST['txtnama']);
$position = mysqli_real_escape_string($conn, $_POST['ddlpos']);
$gred = mysqli_real_escape_string($conn, $_POST['ddlgred']);
$department = mysqli_real_escape_string($conn, $_POST['ddldept']);
$username = mysqli_real_escape_string($conn, $_POST['txtusername']);
$notel = mysqli_real_escape_string($conn, $_POST['txtnotel']);
$email = mysqli_real_escape_string($conn, $_POST['txtemail']);
$password = mysqli_real_escape_string($conn, $_POST['txtps']);



	mysqli_select_db($conn, $database_conn);
	$query_reclogin = "SELECT * FROM login WHERE username = '$username'";
	$reclogin = mysqli_query($conn, $query_reclogin) or die(mysqli_error($conn));
	$row_reclogin = mysqli_fetch_assoc($reclogin);
	$totalRows_reclogin = mysqli_num_rows($reclogin);


	if ($totalRows_reclogin==0 && $username== 'admin') {
		$insertSQL = "INSERT INTO login (name, jawatan, jabatan, username, password, phonenum, EMAIL , levelUser, flag_log , ) VALUES ('$fullname', '$gred', '$department', '$username', '$password', '$notel', '$email' , 1 ,0)";
		mysqli_select_db($conn, $database_conn);
		$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
		?>

		<script type="text/javascript">
		show_alert_reg();
		</script>

		<?php
	}
	else if ($totalRows_reclogin==0) {
		$insertSQL = "INSERT INTO login (name, jawatan, jabatan, username, password, phonenum, EMAIL , levelUser, flag_log) VALUES ('$fullname', '$gred', '$department', '$username', '$password', '$notel', '$email' , 2 ,1)";
		mysqli_select_db($conn, $database_conn);
		$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
		?>

		<script type="text/javascript">
			show_alert_reg();
		</script>

		<?php
	} else {
		?>
		
		<script type="text/javascript">
		function show_exist()
		{
		var jsvar = <?php echo json_encode($username); ?>;
		
		alert("The record was NOT successfully added because the Username \"" +jsvar+ "\" already exists, Please re-check.");
		history.go(-2);
		}
		show_exist();
		</script>
		
		<?php
	}

?>	