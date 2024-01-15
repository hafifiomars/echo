<script type="text/javascript">

function show_alert_edit(){
alert("Record Updated Successfully");
history.go(-2);
}
show_alert_edit();

function show_alert_date_unavailable(){

var jsvar = <?php echo json_encode($idapp) ; ?> ;
alert("Appointment full. Please choose other date! ");
window.location="edit_view_record.php?x=1&id="+jsvar;
}
show_alert_date_unavailable();
	
</script>

<?php 
require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];
$type = $_SESSION['SESS_TYPE'];

$idapp = mysqli_real_escape_string($conn, $_POST['txtid']);
// $pat_name = mysqli_real_escape_string($conn, $_POST['txtname']);
// $pat_ic = mysqli_real_escape_string($conn, $_POST['txtic']);
// $pat_gender = mysqli_real_escape_string($conn, $_POST['ddlgender']);
// $pat_phonenum = mysqli_real_escape_string($conn, $_POST['pat_pnum']);
// $pat_age = mysqli_real_escape_string($conn, $_POST['txtage']);
// $HEIGHT= mysqli_real_escape_string($conn, $_POST['pat_height']);
// $WEIGHT= mysqli_real_escape_string($conn, $_POST['pat_weight']);
// $pat_nationality = mysqli_real_escape_string($conn, $_POST['txtnat']);
// $pat_type = mysqli_real_escape_string($conn, $_POST['ddlpatienttype']);
// $pat_ward = mysqli_real_escape_string($conn, $_POST['txtward']);
// $pat_statuscovid = mysqli_real_escape_string($conn, $_POST['ddlcovstat']);
// $pat_clinical_history = mysqli_real_escape_string($conn, $_POST['txtclinicalhistory']);
// $pat_firsttime = mysqli_real_escape_string($conn, $_POST['ddlfirsttime']);
// $pat_oxy = mysqli_real_escape_string($conn, $_POST['ddloxy']);
// $echo_urgency = mysqli_real_escape_string($conn, $_POST['ddlurgent']);
// $echo_inchargepatient = mysqli_real_escape_string($conn, $_POST['inchargepatient']);
// $reason = mysqli_real_escape_string($conn, $_POST['reason']);
// $up_txtdate = mysqli_real_escape_string($conn, $_POST['uptxtdate']);


	if  ($x == 1) { //set date for admin

	
$app_date = mysqli_real_escape_string($conn, $_POST['txtdate']);
mysqli_select_db($conn, $database_conn);
$query_recblockdate = "SELECT * from block_date WHERE datetoblock='$app_date'";
$recblockdate = mysqli_query($conn, $query_recblockdate) OR die(mysqli_error($conn));
$row_recblockdate = mysqli_fetch_assoc($recblockdate);
$totalRows_recblockdate = mysqli_num_rows($recblockdate);  

mysqli_select_db($conn, $database_conn);
$query_recform = "SELECT * from app_form WHERE borang_id='$idapp'";
$recform = mysqli_query($conn, $query_recform) OR die(mysqli_error($conn));
$row_recform = mysqli_fetch_assoc($recform);
$totalRows_recform = mysqli_num_rows($recform);  

		if ($totalRows_recblockdate == 0 ){ //isi date yg available
			
		$reasonreject = $row_recform ['reason'];
		$patid = mysqli_real_escape_string($conn, $_POST['txtpatid']);
		$reason = mysqli_real_escape_string($conn, $_POST['txtrejected']);
		$statapp = mysqli_real_escape_string($conn, $_POST['ddlstatapp']);
		$app_time= mysqli_real_escape_string($conn, $_POST['time']);
	
		if ($statapp== 3){
		$reason = mysqli_real_escape_string($conn, $_POST['txtrejected']);	
		} else {
		$reason= $reasonreject;
		}
	
			$updateSQL = "UPDATE app_form SET  App_Date = '$app_date' ,  App_Time = '$app_time' , appointment_status='$statapp' , reason='$reason' WHERE borang_id='$idapp' ";
	
		mysqli_select_db($conn, $database_conn);
		$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
	

	?>	<script type="text/javascript">
	show_alert_edit();
	</script>
			
	<?php } else { ?> 

		<script type="text/javascript">
 		show_alert_date_unavailable();
 		</script>

	<?php } ?>
	
<?php } else { // edit patient detail(x=2)

$pat_name = mysqli_real_escape_string($conn, $_POST['txtname']);
$pat_ic = mysqli_real_escape_string($conn, $_POST['txtic']);
$pat_gender = mysqli_real_escape_string($conn, $_POST['ddlgender']);
$pat_phonenum = mysqli_real_escape_string($conn, $_POST['pat_pnum']);
$pat_age = mysqli_real_escape_string($conn, $_POST['txtage']);
$HEIGHT= mysqli_real_escape_string($conn, $_POST['pat_height']);
$WEIGHT= mysqli_real_escape_string($conn, $_POST['pat_weight']);
$pat_nationality = mysqli_real_escape_string($conn, $_POST['txtnat']);
$pat_type = mysqli_real_escape_string($conn, $_POST['ddlpatienttype']);
$pat_ward = mysqli_real_escape_string($conn, $_POST['txtward']);
$pat_statuscovid = mysqli_real_escape_string($conn, $_POST['ddlcovstat']);
$pat_clinical_history = mysqli_real_escape_string($conn, $_POST['txtclinicalhistory']);
$pat_firsttime = mysqli_real_escape_string($conn, $_POST['ddlfirsttime']);
$pat_oxy = mysqli_real_escape_string($conn, $_POST['ddloxy']);
$echo_urgency = mysqli_real_escape_string($conn, $_POST['ddlurgent']);
$echo_inchargepatient = mysqli_real_escape_string($conn, $_POST['inchargepatient']);
$comment = mysqli_real_escape_string($conn, $_POST['comment']);
$up_txtdate = mysqli_real_escape_string($conn, $_POST['uptxtdate']);
	
	
		$id =$_SESSION['SESS_MEMBER_ID'];
		$idapp = mysqli_real_escape_string($conn, $_POST['txtid']);
		$patid = mysqli_real_escape_string($conn, $_POST['txtpatid']);
		$patindi = mysqli_real_escape_string($conn, $_POST['txtpatindi']);
		date_default_timezone_set('Asia/Kuala_Lumpur');
		$date_now = date('Y-m-d H:i:s');
	
		if ($pat_firsttime == 'NO'){
		$dateecho = mysqli_real_escape_string($conn, $_POST['txtdateecho']);
		$placeecho = mysqli_real_escape_string($conn, $_POST['txtplaceecho']);
		} else {
		$dateecho=0;
		$placeecho=0;
		}
	
		if ($pat_oxy== 'YES'){
		$oxytype = mysqli_real_escape_string($conn, $_POST['txtoxy']);
		} else {
		$oxytype=0;
		}
	
		if ($pat_type== 1){
		$pat_ward = mysqli_real_escape_string($conn, $_POST['txtward']);	
		} else {
		$pat_ward=" ";
		}	
	
		
	
			$updateSQL = "UPDATE patient_tbl SET Pat_Name = '$pat_name' , Pat_Ic = '$pat_ic' , Pat_Gender = '$pat_gender', Pat_Nat = '$pat_nationality' WHERE pat_id='$patid' ";
	
		mysqli_select_db($conn, $database_conn);
		$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));
	
			$updateSQL1 = "UPDATE app_form SET Pat_Pnum = '$pat_phonenum', Pat_Age = '$pat_age', Height = '$HEIGHT' , Weight = '$WEIGHT', Pat_Type = '$pat_type', Pat_Wad = '$pat_ward', Pat_Covid_Status = '$pat_statuscovid', Pat_Clinical_History = '$pat_clinical_history' , Pat_FirstTime = '$pat_firsttime' ,Date_Echo = '$dateecho' , Place_Echo = '$placeecho' , Pat_Oxy = '$pat_oxy' ,  Oxy_Type = '$oxytype', Urgency = '$echo_urgency', Upcoming_App = '$up_txtdate',InCharge_Of_Patient = '$echo_inchargepatient', reason = '$comment', edit_dttm='$date_now' WHERE borang_id='$idapp' ";
	
		mysqli_select_db($conn, $database_conn);
		$Result1 = mysqli_query($conn, $updateSQL1) or die(mysqli_error($conn));
	
			$updateSQL2 = "UPDATE app_form SET edit_dttm = '$date_now' WHERE borang_id = $idapp";
		mysqli_select_db($conn, $database_conn);
		$Result2 = mysqli_query($conn, $updateSQL2) or die(mysqli_error($conn));

		if (isset($_POST['inditype'])) {
			$aIndi = $_POST['inditype'];
		} else {		
			$aIndi = 0;
		}
					
		if ($aIndi != 0) {
			$N = count($aIndi);	
			for($i=0; $i < $N; $i++) {
	
		$deleteSQL = "DELETE FROM pat_indication WHERE borang_id = '$idapp'";
		mysqli_select_db( $conn , $database_conn);
		$Resultd = mysqli_query($conn , $deleteSQL) or die(mysqli_error($conn));
			}
	
		}

		if (isset($_POST['inditype'])) {
			$aIndi = $_POST['inditype'];
		} else {		
			$aIndi = 0;
		}
					
		if ($aIndi != 0) {
			$N = count($aIndi);	
			for($i=0; $i < $N; $i++) {
	
		$insertSQL2 = "INSERT INTO pat_indication (borang_id,loginID,pat_id,indication_type) VALUES ('$idapp' , '$id', '$patid','$aIndi[$i]' ) ";
	
		mysqli_select_db($conn, $database_conn);
		$Result2 = mysqli_query($conn, $insertSQL2) or die(mysqli_error($conn));
		}
	}
?>
	<script type="text/javascript">
	show_alert_edit();
	</script>


	<?php } ?>


		
			
	
	
