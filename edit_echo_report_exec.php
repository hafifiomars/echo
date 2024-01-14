<script type="text/javascript">
function show_alert_add()
{
alert("Record Entered Successfully");
history.go(-2);
}

</script>

<?php require_once('auth.php');
require_once('Connections/conn.php');

$er = $_GET['er'];;
$type = $_SESSION['SESS_TYPE'];

$BSA= mysqli_real_escape_string($conn, $_POST['bsa']);
$ECHO_Date= mysqli_real_escape_string($conn, $_POST['echo_date']);
$ECHO_Time= mysqli_real_escape_string($conn, $_POST['echo_time']);
$LV_Diastole = mysqli_real_escape_string($conn, $_POST['lv_diastole']);
$LV_Systole = mysqli_real_escape_string($conn, $_POST['lv_systole']);
$Inter_Diastole = mysqli_real_escape_string($conn, $_POST['inter_diastole']);
$Inter_Systole = mysqli_real_escape_string($conn, $_POST['inter_systole']);
$LV_post_diastole = mysqli_real_escape_string($conn, $_POST['lv_post_diastole']);
$LV_post_systole = mysqli_real_escape_string($conn, $_POST['lv_post_systole']);
$LA_volume = mysqli_real_escape_string($conn, $_POST['la_volume']);
$LA_bsa = mysqli_real_escape_string($conn, $_POST['la_bsa']);
$LA_type = mysqli_real_escape_string($conn, $_POST['la_type']);
$RV_diameter = mysqli_real_escape_string($conn, $_POST['rv_diameter']);
$Mid_RV_diameter = mysqli_real_escape_string($conn, $_POST['mid_rv_diameter']);
$RV_length = mysqli_real_escape_string($conn, $_POST['rv_length']);
$RV_type = mysqli_real_escape_string($conn, $_POST['rv_type']);
$RA_volume = mysqli_real_escape_string($conn, $_POST['ra_vol']);
$RA_bsa = mysqli_real_escape_string($conn, $_POST['ra_bsa']);
$Ra_type = mysqli_real_escape_string($conn, $_POST['ra_type']);
$Aortic_type = mysqli_real_escape_string($conn, $_POST['aortic_type']);

$mitval_type = mysqli_real_escape_string($conn, $_POST['mv_type']);
$mitval_result = mysqli_real_escape_string($conn, $_POST['mv_result']);
$mitval_assess = mysqli_real_escape_string($conn, $_POST['mv_assess']);
$aorval_type = mysqli_real_escape_string($conn, $_POST['aorv_type']);
$aorval_result = mysqli_real_escape_string($conn, $_POST['aorv_result']);
$aorval_assess = mysqli_real_escape_string($conn, $_POST['av_assess']);
$trival_type = mysqli_real_escape_string($conn, $_POST['tv_type']);
$trival_result = mysqli_real_escape_string($conn, $_POST['tv_result']);
$trival_assess = mysqli_real_escape_string($conn, $_POST['tv_assess']);
$pulval_type = mysqli_real_escape_string($conn, $_POST['pv_type']);
$pulval_result = mysqli_real_escape_string($conn, $_POST['pv_result']);
$pulval_assess = mysqli_real_escape_string($conn, $_POST['pv_assess']);

$LV_simspson = mysqli_real_escape_string($conn, $_POST['simpson']);
$LV_simspson_type = mysqli_real_escape_string($conn, $_POST['simpson_type']);
$RWMA = mysqli_real_escape_string($conn, $_POST['rmwa']);
$RWMA_comment = mysqli_real_escape_string($conn, $_POST['rwma_comment']);
$LV_e_vel = mysqli_real_escape_string($conn, $_POST['lv_e_velocity']);
$LV_ea_velocity = mysqli_real_escape_string($conn, $_POST['lv_ea_velocity']);
$LV_dt = mysqli_real_escape_string($conn, $_POST['lv_dt']);
$Sys_vel = mysqli_real_escape_string($conn, $_POST['systolic_velocity']);
$Dias_vel = mysqli_real_escape_string($conn, $_POST['diastolic_velocity']);
$PV_ratio = mysqli_real_escape_string($conn, $_POST['pv_ratio']);
$Atrial_vel = mysqli_real_escape_string($conn, $_POST['atrial_vel']);
$Atrial_dur = mysqli_real_escape_string($conn, $_POST['atrial_dur']);
$S_septal_velocity = mysqli_real_escape_string($conn, $_POST['s_septal_velocity']);
$E_septal_velocity = mysqli_real_escape_string($conn, $_POST['e_septal_velocity']);
$A_septal_velocity = mysqli_real_escape_string($conn, $_POST['a_septal_velocity']);
$S_lateral_velocity = mysqli_real_escape_string($conn, $_POST['s_lateral_velocity']);
$E_lateral_velocity = mysqli_real_escape_string($conn, $_POST['e_lateral_velocity']);
$A_lateral_velocity = mysqli_real_escape_string($conn, $_POST['a_lateral_velocity']);
$Septal_e = mysqli_real_escape_string($conn, $_POST['septal_e']);
$Lateral_e = mysqli_real_escape_string($conn, $_POST['lateral_e']);
$Average_e = mysqli_real_escape_string($conn, $_POST['average_e']);
$Grad_lv = mysqli_real_escape_string($conn, $_POST['grad_lv']);

$Tapse = mysqli_real_escape_string($conn, $_POST['tapse']);

$ASD = mysqli_real_escape_string($conn, $_POST['asd']);
$Vsd = mysqli_real_escape_string($conn, $_POST['vsd']);
$PDA = mysqli_real_escape_string($conn, $_POST['pda']);
$SHUNT = mysqli_real_escape_string($conn, $_POST['shunt']);
$SHUNT_defect = mysqli_real_escape_string($conn, $_POST['shunt_defect']);
$A_find = mysqli_real_escape_string($conn, $_POST['associate_find']);
$N_peri = mysqli_real_escape_string($conn, $_POST['normal_peri']);
$P_effu = mysqli_real_escape_string($conn, $_POST['peri_effu']);
$Size_effu = mysqli_real_escape_string($conn, $_POST['size_effu']);
$Effu_type = mysqli_real_escape_string($conn, $_POST['effu_type']);
$TAMPHY = mysqli_real_escape_string($conn, $_POST['tamphy']);
$other_Find = mysqli_real_escape_string($conn, $_POST['other_find']);
$Echo_diag = mysqli_real_escape_string($conn, $_POST['echo_diag']);
$Echo_type = mysqli_real_escape_string($conn, $_POST['echo_type']);
$Report_by = mysqli_real_escape_string($conn, $_POST['txtappliedby']);
$comment = mysqli_real_escape_string($conn, $_POST['txteditreport']);



?>
<?php
if ($er == 3){ // edit echo record for verifier

?>
 <?php

	$idappedit = mysqli_real_escape_string($conn, $_POST['txtidedit']);
	$idapp = mysqli_real_escape_string($conn, $_POST['txtidedit']);
	$Verify_by = mysqli_real_escape_string($conn, $_POST['txtverifyby']);
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$date_now = date('Y-m-d H:i:s');

	$updateSQL = "UPDATE result1_echo SET Bsa = '$BSA' , Echo_Date = '$ECHO_Date' , Echo_Time = '$ECHO_Time' , LV_diastole = '$LV_Diastole' , LV_systole = '$LV_Systole' , Inter_diastole = '$Inter_Diastole' , Inter_systole = '$Inter_Systole' , Post_diastole = '$LV_post_diastole' , Post_systole = '$LV_post_systole' , LA_Volume = '$LA_volume' , LA_BSA = '$LA_bsa' , LA_Type = '$LA_type' , RV_Dia = '$RV_diameter' , Mid_RV = '$Mid_RV_diameter'  , RV_Length = '$RV_length'  , RV_Type = '$RV_type' , RA_Volume = '$RA_volume', RA_BSA = '$RA_bsa' , RA_Type ='$Ra_type' , AR_Type = '$Aortic_type' WHERE borang_id='$idappedit' ";

   mysqli_select_db($conn, $database_conn);
	$Result = mysqli_query($conn, $updateSQL) or die(mysqli_error($conn));

	$updateSQL1 = "UPDATE result2_echo SET MV_type = '$mitval_type' , MV_result = '$mitval_result' , MV_assess = '$mitval_assess' , AV_type =  '$aorval_type' , AV_result  =  '$aorval_result' , AV_assess = '$aorval_assess' , TV_type = '$trival_type' , TV_result = '$trival_result' ,TV_assess = '$trival_assess' , PV_type = '$pulval_type' , PV_result = '$pulval_result' , PV_assess = '$pulval_assess' WHERE borang_id='$idappedit' ";

   mysqli_select_db($conn, $database_conn);
	$Result1 = mysqli_query($conn, $updateSQL1) or die(mysqli_error($conn));

	$updateSQL2 = "UPDATE result3_echo SET LV_Simspson = '$LV_simspson'  , LV_Simspson_Type = '$LV_simspson_type' , LV_RWMA = '$RWMA' , LV_RWMA_Com = '$RWMA_comment' , LV_E_Vel = '$LV_e_vel' , LV_EA_Velocity = '$LV_ea_velocity' , LV_DT = '$LV_dt' , Sys_Vel = '$Sys_vel' , Dias_Vel = '$Dias_vel' , PV_Ratio = '$PV_ratio' , Atrial_Vel = '$Atrial_vel' , Atrial_Dur = '$Atrial_dur' , S_Septal_Velocity = '$S_septal_velocity' , E_septal_velocity = '$E_septal_velocity' , A_septal_velocity = '$A_septal_velocity' , S_lateral_velocity = '$S_lateral_velocity' , E_lateral_velocity = '$E_lateral_velocity' , A_lateral_velocity = '$A_lateral_velocity'  , Septal_E = '$Septal_e' , Lateral_E = '$Lateral_e', Average_E  = '$Average_e', Grad_lv = '$Grad_lv', TAPSE = '$Tapse' WHERE borang_id='$idappedit' "; 
 	
	mysqli_select_db($conn, $database_conn);
	$Result2 = mysqli_query($conn, $updateSQL2) or die(mysqli_error($conn));

	
	$updateSQL3 = "UPDATE result4_echo SET updatedttm = '$date_now', Asd = '$ASD' , VSD = '$Vsd' , Pda = '$PDA' , Shunt = '$SHUNT' , Shunt_Defect = '$SHUNT_defect', A_Find = '$A_find' , N_Peri = '$N_peri' , P_Effu =  '$P_effu' , Size_Effu =  '$Size_effu', Effu_Type = '$Effu_type', Tamphy = '$TAMPHY' , Other_Find = '$other_Find' , Echo_Diag = '$Echo_diag' , Echo_Type = '$Echo_type' , report_by =  '$Report_by' , verify_by = '$Verify_by' WHERE borang_id='$idappedit' ";
	

  	mysqli_select_db($conn, $database_conn);
	$Result3 = mysqli_query($conn, $updateSQL3) or die(mysqli_error($conn));

	$app_status = 5;
	$updateSQL4 = "UPDATE app_form SET appointment_status = '$app_status', reason = '$comment' WHERE borang_id='$idapp' ";

	mysqli_select_db($conn, $database_conn);
	$Result4 = mysqli_query($conn, $updateSQL4) or die(mysqli_error($conn));

	?>

		<script type="text/javascript">
	show_alert_add();
	</script>


		<?php	
	}
		?>