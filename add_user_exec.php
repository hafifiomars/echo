<script type="text/javascript">

function show_alert_add()
{
alert("Record Entered Successfully");
history.go(-2);
}

function show_alert_edit()
{
alert("Record Updated Successfully");
history.go(-2);
}

</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];

//$type = $_SESSION['SESS_TYPE'];

$fullname = mysqli_real_escape_string($conn, $_POST['txtname']);
$position = mysqli_real_escape_string($conn, $_POST['ddlpos']);
$gred = mysqli_real_escape_string($conn, $_POST['ddlgred']);
$department = mysqli_real_escape_string($conn, $_POST['ddldept']);
$email = mysqli_real_escape_string($conn, $_POST['txtemail']);
$notel = mysqli_real_escape_string($conn, $_POST['txtnotel']);
$username = mysqli_real_escape_string($conn, $_POST['txtusername']);
$password = mysqli_real_escape_string($conn, $_POST['txtps']);
$jenis = mysqli_real_escape_string($conn, $_POST['ddllevel']);



if ($x == 1) { // add

	$email = mysqli_real_escape_string($conn, $_POST['txtemail']);

	mysqli_select_db($conn, $database_conn);
	$query_recUser = "SELECT * FROM login WHERE email = '$email'";
	$recUser = mysqli_query($conn, $query_recUser) or die(mysqli_error($conn));
	$row_recUser = mysqli_fetch_assoc($recUser);
	$totalRows_recUser = mysqli_num_rows($recUser);

	if ($totalRows_recUser==0) {
		$insertSQL = "INSERT INTO login (name, jabatan, jawatan, email,phonenum,username, password, levelUser) VALUES ('$fullname', '$department', '$gred','$email', '$notel' ,'$username' , '$password', '$jenis')";
		mysqli_select_db($conn, $database_conn);
		$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
		?>

		<script type="text/javascript">
		show_alert_add();
		</script>

		<?php
	} else {
		?>

		<script type="text/javascript">
		function show_exist()
		{
		var jsvar = <?php echo json_encode($username); ?>;

		alert("The record was unsuccessful,  \"" +jsvar+ "\" username is already in the system. Enter another username.");
		history.go(-2);
		}
		show_exist();
		</script>

		<?php
	}
} else if ($x == 2) { // edit

	$id = mysqli_real_escape_string($conn, $_POST['txtid']);
//	$regstat = mysqli_real_escape_string($conn, $_POST['ddlreg']);


	$updateSQL = "UPDATE login SET name='$fullname', jabatan='$department', jawatan='$gred', email ='$email', phonenum = '$notel' , username = '$username', levelUser='$jenis', EMAIL='$email'  WHERE login_id='$id'";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
	?>


	<script type="text/javascript">
	show_alert_edit();
	</script>

	<?php
	}
	?>
