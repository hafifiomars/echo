<script type="text/javascript">
function show_alert_add()
{
alert("Record Deleted Successfully");
history.go(-1);
}

</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$brid= $_GET['id']
// $confirmDel = $_GET['r']
?>

<?php

	//delete echo record for admin

	$deleteSQL = "UPDATE app_form SET app_flag = '1' WHERE borang_id='$brid' ";

	mysqli_select_db($conn, $database_conn);
	$ResultDelete = mysqli_query($conn, $deleteSQL) or die(mysqli_error($conn));


?>

<script type="text/javascript">
show_alert_add();
</script>
