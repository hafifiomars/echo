<?php
require_once('auth.php');
require_once('Connections/conn.php');

$id = $_POST['txtid'];
$dateentered = $_POST['txtblockdate'];
$blockername = $_POST['txtblockername'];
$date_now = date('Y-m-d H:i:s');

mysqli_select_db($conn, $database_conn);
$query_reclogindetail = "SELECT * FROM  login a LEFT JOIN block_date b ON a.login_id=b.blockedby_id WHERE a.login_id = '$id'";
$reclogindetail = mysqli_query($conn, $query_reclogindetail) or die(mysqli_error($conn));
$row_reclogindetail = mysqli_fetch_assoc($reclogindetail);
$totalRows_reclogindetail = mysqli_num_rows($reclogindetail);

mysqli_select_db($conn, $database_conn);
$query_recblockdate = "SELECT * FROM block_date WHERE datetoblock = '$dateentered'";
$recblockdate = mysqli_query($conn, $query_recblockdate) or die(mysqli_error($conn));
$row_recblockdate = mysqli_fetch_assoc($recblockdate);
$totalRows_recblockdate = mysqli_num_rows($recblockdate);


if ( $totalRows_recblockdate == 0 && $row_reclogindetail['fl_blockdate']== 0){

         $insertSQL = "INSERT INTO block_date (datetoblock, blockedby_id, dateofblock, blocker_name) VALUES ('$dateentered', '$id', '$date_now' , '$blockername')";
		mysqli_select_db($conn, $database_conn);
		$Result1 = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
        ?>
        
        <script type="text/javascript">
 		function show_alert_date_unavailable(){

	 		alert("Successfully booked!");
	 		window.location="block_date.php";
 		}
 		show_alert_date_unavailable();
 		</script>

<?php		
}

elseif ( $totalRows_recblockdate == 0 && $row_reclogindetail['fl_blockdate']== 1){ ?>

    <center>
    <h2>YOU ARE NOT AUTHORISED TO BLOCK ECHO APPOINTMENT DATE!</h2><br>
    <h3>Please contact MOPD for any enquiries.</h3><br>
    </center>
    
<?php } else {?>

<center>
<h2>The date has been blocked by <?php echo $row_recblockdate ['blocker_name']; ?></h2>

</center>


<?php }
?>


