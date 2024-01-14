<?php
require_once('auth.php');
require_once('Connections/conn.php');


$id = $_POST['txtid'];
$fullname = $_POST['txtname'];
$department = $_POST['ddldept'];
$position = $_POST['ddlpos'];
$gred = $_POST['ddlgred'];
$txtpwdbaru = $_POST['txtpwdbaru'];
$phonenum = $_POST['txtnotel'];
$email = $_POST['txtemail'];
$username = $_POST['txtusername'];

mysqli_select_db($conn, $database_conn);
$query_recAccSet = "SELECT * FROM login WHERE login_id = '$id'";
$recAccSet = mysqli_query($conn, $query_recAccSet) or die(mysqli_error($conn));
$row_recAccSet = mysqli_fetch_assoc($recAccSet);
$totalRows_recAccSet = mysqli_num_rows($recAccSet);

if ($txtpwdbaru==''){
	$sql1 = "UPDATE login set name = '$fullname', jabatan='$department', jawatan='$gred', phonenum='$phonenum' , EMAIL ='$email', username = '$username'  WHERE login_id = '$id' ";
	$result1 = mysqli_query($conn, $sql1);
?>
<center>
<h2>Update Info</h2>
<p>Info has been updated.</p>
<p>Password remain unchanged.</p>
</center>

<?php
} else {
	$sql1 = "UPDATE login set name = '$fullname', jabatan='$department', jawatan='$gred', phonenum='$phonenum' , EMAIL ='$email', username = '$username', password = '$txtpwdbaru' WHERE login_id = '$id' ";
	$result1 = mysqli_query($conn, $sql1);

?>
<center>
<h2> Change password successfullyy</h2>
<p> Your new password: <strong><?php echo $txtpwdbaru; ?></strong></p>
</center>

<?php
}
?>
