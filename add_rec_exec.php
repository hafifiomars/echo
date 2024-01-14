<script type="text/javascript">


function show_alert_add()
{
alert("Record Entered Successfully");
history.go(-3);
}

</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];
$type = $_SESSION['SESS_TYPE'];

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
$up_txtdate = mysqli_real_escape_string($conn, $_POST['uptxtdate']);
$echo_apply = mysqli_real_escape_string($conn, $_POST['txtappliedby']);
$echo_doctelnum = mysqli_real_escape_string($conn, $_POST['doctelnum']);
$echo_depart = mysqli_real_escape_string($conn, $_POST['txtdepart']);
$echo_inchargepatient = mysqli_real_escape_string($conn, $_POST['inchargepatient']);


?>
<?php
if($x == 1){ //create new appoinment existing patient
$id =$_SESSION['SESS_MEMBER_ID'];
$pat_id = mysqli_real_escape_string($conn, $_POST['txtpatid']);
$regdate = mysqli_real_escape_string($conn, $_POST['txtregdate']);

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


	$insertSQL1 = "INSERT INTO app_form (loginID , pat_id , Pat_Pnum , Pat_Age, Height, Weight, Pat_Type, Pat_Wad, Pat_Covid_Status, Pat_Clinical_History , Pat_FirstTime ,Date_Echo , Place_Echo , Pat_Oxy ,  Oxy_Type , Urgency , Upcoming_App , Applied_By, Doctor_Phone, Department, InCharge_Of_Patient, Reg_Date, appointment_status) VALUES ('$id', '$pat_id', '$pat_phonenum' ,'$pat_age', '$HEIGHT' , '$WEIGHT' , '$pat_type', '$pat_ward'  , '$pat_statuscovid' , '$pat_clinical_history' , '$pat_firsttime' , '$dateecho' , '$placeecho' , '$pat_oxy' , '$oxytype' , '$echo_urgency' , '$up_txtdate' , '$echo_apply' , '$echo_doctelnum' , '$echo_depart ' , '$echo_inchargepatient','$regdate',1)";

	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL1) or die(mysqli_error($conn));

	$borid= $conn->insert_id;
	
	if (isset($_POST['indication'])) {
		$aIndi = $_POST['indication'];
	} else {		
		$aIndi = 0;
	}
				
	if ($aIndi != 0) {
		$N = count($aIndi);	
		for($i=0; $i < $N; $i++) {

	$insertSQL2 = "INSERT INTO pat_indication(borang_id,loginID,pat_id,indication_type) VALUES ('$borid' , '$id', '$pat_id','$aIndi[$i]' ) ";

	mysqli_select_db($conn, $database_conn);
	$Result2 = mysqli_query($conn, $insertSQL2) or die(mysqli_error($conn));
	}
}

?>
		<script type="text/javascript">
	show_alert_add();
	</script>

<?php
} else if($x == 2) { ////create new appoinment not existing patient

$id =$_SESSION['SESS_MEMBER_ID'];
$regdate = mysqli_real_escape_string($conn, $_POST['txtregdate']);

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

	$insertSQL	= "INSERT INTO patient_tbl (loginID , Pat_Name , Pat_Ic , Pat_Gender ,Pat_Nat) VALUES ('$id','$pat_name', '$pat_ic', '$pat_gender', '$pat_nationality') ";
	mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));

	$patientid= $conn->insert_id;

	$insertSQL1 = "INSERT INTO app_form (loginID , pat_id , Pat_Pnum , Pat_Age, Height, Weight, Pat_Type, Pat_Wad, Pat_Covid_Status, Pat_Clinical_History , Pat_FirstTime ,Date_Echo , Place_Echo , Pat_Oxy ,  Oxy_Type , Urgency , Upcoming_App , Applied_By , Doctor_Phone, Department, InCharge_Of_Patient,Reg_Date, appointment_status) VALUES ('$id', '$patientid', '$pat_phonenum' , '$pat_age' , '$HEIGHT' , '$WEIGHT' , '$pat_type', '$pat_ward'  , '$pat_statuscovid' , '$pat_clinical_history' , '$pat_firsttime' , '$dateecho' , '$placeecho' , '$pat_oxy' , '$oxytype' , '$echo_urgency' , '$up_txtdate' , '$echo_apply' , '$echo_doctelnum' , '$echo_depart ' , '$echo_inchargepatient','$regdate',1)";

	mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $insertSQL1) or die(mysqli_error($conn));

	$borid= $conn->insert_id;
	
	if (isset($_POST['indication'])) {
		$aIndi = $_POST['indication'];
	} else {		
		$aIndi = 0;
	}
				
	if ($aIndi != 0) {
		$N = count($aIndi);	
		for($i=0; $i < $N; $i++) {

	$insertSQL2 = "INSERT INTO pat_indication(borang_id,loginID,pat_id,indication_type) VALUES ('$borid' , '$id', '$patientid','$aIndi[$i]' ) ";

	mysqli_select_db($conn, $database_conn);
	$Result2 = mysqli_query($conn, $insertSQL2) or die(mysqli_error($conn));
	}
}

?>
		<script type="text/javascript">
	show_alert_add();
	</script>

		<?php	
	}

		?>

