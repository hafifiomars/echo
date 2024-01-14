<?php require_once('auth.php');
require_once('Connections/conn.php');

$type = $_SESSION['SESS_TYPE'];
$lg_id = $_SESSION['SESS_MEMBER_ID'];
$regdate = date("Y-m-d H:i:s");
$x = $_GET['x'];
$us = $_GET['us'];
if ($us==1) { // add new appoinment for existing patient
	$ic=mysqli_real_escape_string($conn,$_POST['txtic']);
} else {
	$ic=$_GET['ic'];
}


mysqli_select_db($conn, $database_conn);
$query_recgender = "SELECT * from gender_tbl WHERE gender_flag=0 ORDER BY gender_name ASC";
$recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
$row_recgender = mysqli_fetch_assoc($recgender);
$totalRows_recgender = mysqli_num_rows($recgender);

mysqli_select_db($conn, $database_conn);
$query_reccovstat = "SELECT * from patient_covid_status WHERE covidstat_flag=0 ORDER BY covidstat ASC";
$reccovstat = mysqli_query($conn, $query_reccovstat) or die(mysqli_error($conn));
$row_reccovstat = mysqli_fetch_assoc($reccovstat);
$totalRows_reccovstat = mysqli_num_rows($reccovstat);

mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * from patient_type_tbl ORDER BY patient_type ASC";
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
$totalRows_recpattype = mysqli_num_rows($recpattype);

mysqli_select_db($conn, $database_conn);
$query_recindication = "SELECT * from ref_indication_tbl WHERE indication_flag=0 ORDER BY indication_name ASC";
$recindication = mysqli_query($conn, $query_recindication) or die(mysqli_error($conn));
$row_recindication = mysqli_fetch_assoc($recindication);
$totalRows_recindication = mysqli_num_rows($recindication);

mysqli_select_db($conn, $database_conn);
$query_recAccSet = "SELECT * FROM login a LEFT JOIN gred_tbl b ON a.jawatan = b.gred_id WHERE a.login_id = '$lg_id'";
$recAccSet = mysqli_query($conn, $query_recAccSet) or die(mysqli_error($conn));
$row_recAccSet = mysqli_fetch_assoc($recAccSet);
$totalRows_recAccSet = mysqli_num_rows($recAccSet);
$posid = $row_recAccSet['pos_id'];

mysqli_select_db($conn, $database_conn);
$query_patsearch = "SELECT * FROM patient_tbl WHERE Pat_Ic= '$ic'";
$patsearch = mysqli_query($conn, $query_patsearch) or die(mysqli_error($conn));
$row_patsearch = mysqli_fetch_assoc($patsearch);
$totalRows_patsearch = mysqli_num_rows($patsearch);
if ($row_patsearch['Pat_Ic']!='') {
	$identity = $row_patsearch['Pat_Ic'];
} else {
	$identity = '';
}

mysqli_select_db($conn, $database_conn);
$query_recjab = "SELECT * FROM dept_tbl WHERE department_flag=0 ORDER BY department_name ASC";
$recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
$row_recjab = mysqli_fetch_assoc($recjab);
$totalRows_recjab = mysqli_num_rows($recjab);

mysqli_select_db($conn, $database_conn);
$query_recJawatan = "SELECT * FROM pos_tbl WHERE pos_flag=0 ORDER BY pos_name ASC";
$recJawatan = mysqli_query($conn, $query_recJawatan) or die(mysqli_error($conn));
$row_recJawatan = mysqli_fetch_assoc($recJawatan);
$totalRows_recJawatan = mysqli_num_rows($recJawatan);

mysqli_select_db($conn, $database_conn);
$query_recstatapp = "SELECT * from app_status WHERE flag_as=0 ORDER BY appointment_status ASC"; //view only active bookstatus
$recstatapp = mysqli_query($conn, $query_recstatapp) or die(mysqli_error($conn));
$row_recstatapp = mysqli_fetch_assoc($recstatapp);
$totalRows_recstatapp = mysqli_num_rows($recstatapp);

$optoxy = "disabled=\"disabled\"";
$optfirsttime = "disabled=\"disabled\"";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<title>Appoinment Record</title>
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>

<script>
	function validate(f) {

 var tbLen = f.txtic.value.trim().length;
    if (tbLen == 0) {
      alert("Please enter patient IC/Passport ");
      f.txtic.focus();
     return(false);
      }

   var tbLen1 = f.txtname.value.trim().length;
    if (tbLen1 == 0) {
      alert("Please enter patient name ");
      f.txtname.focus();
     return(false);
      }


    if (f.ddlgender.value == "0") {
      alert("Please enter patient gender ");
      f.ddlgender.focus();
      return(false);
    }

 var tbLen100 = f.pat_pnum.value.trim().length;
    if (tbLen100 == 0) {
      alert("Please enter patient phone number");
      f.pat_pnum.focus();
     return(false);
      }


   var tbLen2 = f.txtage.value.trim().length;
    if (tbLen2 == 0) {
      alert("Please enter patient age ");
      f.txtage.focus();
      return(false);
      }

   var tbLen3 = f.pat_height.value.trim().length;
    if (tbLen3 == 0) {
      alert("Please enter patient height ");
      f.pat_height.focus();
      return(false);
      }

   var tbLen4 = f.pat_weight.value.trim().length;
    if (tbLen4 == 0) {
      alert("Please enter patient weight ");
      f.pat_weight.focus();
      return(false);
      }

    if (f.txtnat.value == "0") {
      alert("Please enter patient nationality ");
      f.txtnat.focus();
      return(false);
    }

 	 if (f.ddlpatienttype.value == "0") {
       alert("Please enter Inpatient/Outpatient ");
      f.ddlpatienttype.focus();
      return(false);
    }

var tbLen5 = f.txtward.value.trim().length;
		if (tbLen5 == 0 && f.ddlpatienttype.value == 1) {
			alert("Please enter patient ward ");
			f.txtward.focus();
			return(false);
			}

  	if (f.ddlcovstat.value == "0") {
      alert("Please enter covid status");
      f.ddlcovstat.focus();
      return(false);
    }

   var tbLen6 = f.txtclinicalhistory.value.trim().length;
    if (tbLen6 == 0) {
      alert("Please enter patient clinical history ");
      f.txtclinicalhistory.focus();
      return(false);
      }

  	if (f.ddlfirsttime.value == "0") {
      alert("Please enter is patient's first time referral for an echocardiogram.");
      f.ddlfirsttime.focus();
      return(false);
    }

    var tbLen7 = f.txtdateecho.value.trim().length;
		if (tbLen7 == 0 && f.ddlfirsttime.value == "NO") {
			alert("Please enter previous date echocardiogram");
			f.txtdateecho.focus();
			return(false);
			}

    var tbLen8 = f.txtplaceecho.value.trim().length;
		if (tbLen8 == 0 && f.ddlfirsttime.value == "NO") {
			alert("Please enter previous place echocardiogram");
			f.txtplaceecho.focus();
			return(false);
			}

    if (f.ddloxy.value == "0") {
      alert("Please enter is patient dependent on oxygen");
      f.ddloxy.focus();
      return(false);
    }

    var tbLen8 = f.txtoxy.value.trim().length;
		if (tbLen8 == 0 && f.ddloxy.value == "YES") {
			alert("Please enter oxygen type");
			f.txtoxy.focus();
			return(false);
			}

    if (f.ddlurgent.value == "0") {
      alert("Please enter urgency");
      f.ddlurgent.focus();
      return(false);
    }

   if(!validateForm()){
       alert("Please choose indication echocardiogram");
       return false;
   }
			function validateForm()
		{
    var c=document.getElementsByTagName('input');
    for (var i = 0; i<c.length; i++){
        if (c[i].type=='checkbox')
        {
            if (c[i].checked){return true}
        }
    }
    return false;
}

/*     var tbLen11 = f.uptxtdate.value.trim().length;
    if (tbLen7 == 0) {
      alert("Upcoming MOPD / Other Clinics Appoinment Date");
      f.uptxtdate.focus();
      return(false);
      }
*/

    var tbLen10 = f.inchargepatient.value.trim().length;
    if (tbLen10 == 0) {
      alert("Please enter Specialist In Charge Of Patient");
      f.inchargepatient.focus();
      return(false);
      }
   }

 function adminvalidate(f) {

    var tbLen1 = f.txtrejected.value.trim().length;
		if (tbLen1 == 0 && f.ddlstatapp.value == "3") {
			alert("Please enter reason rejected");
			f.txtrejected.focus();
			return(false);
			}

		var tbLen2 = f.txtdate.value.trim().length;
		if (tbLen2 == 0 && f.ddlstatapp.value == "2") {
			alert("Set Appointment Date");
			f.txtdate.focus();
			return(false);
			}

		var tbLen2 = f.time.value.trim().length;
		if (tbLen2 == 0 && f.ddlstatapp.value == "2") {
			alert("Set Appointment Time ");
			f.time.focus();
			return(false);
			} 

}

function changeStatus() // FOR DISABLE & ENABLE INPUT BOX/ DROPDOW
{
var status = document.getElementById("ddloxy");
if(status.value == "NO" || 0)
{
document.getElementById("txtoxy").disabled = true;
document.getElementById("txtoxy").value = ' ' ;
}
else
{
document.getElementById("txtoxy").disabled = false;
}

var status1 = document.getElementById("ddlfirsttime");
if(status1.value == "YES" || 0)
{
document.getElementById("txtdateecho").disabled = true;
document.getElementById("txtdateecho").value = ' ' ;
document.getElementById("txtplaceecho").disabled = true;
document.getElementById("txtplaceecho").value = ' ' ;
}
else
{
	document.getElementById("txtdateecho").disabled = false;
	document.getElementById("txtplaceecho").disabled = false;
}

var status2 = document.getElementById("ddlpatienttype");
if(status2.value == "2" || 0)
{
document.getElementById("txtward").disabled = true;
document.getElementById("txtward").value = ' ' ;
}
else if(status2.value == "3" || 0)
{
document.getElementById("txtward").disabled = true;
document.getElementById("txtward").value = ' ' ;
}
else
{
document.getElementById("txtward").disabled = false;
}

var status3 = document.getElementById("changeindi");
if(status3.value == "checked")
{
document.getElementById("inditype[]").disabled = false;
}
else
{
document.getElementById("inditype[]").disabled = true;
}

}

</script>

<script>
 function changeStatusApp()  // FOR DISABLE & ENABLE INPUT BOX AT EDIT ADMIN
{
var status3 = document.getElementById("ddlstatapp");
if(status3.value == "3" )
{
document.getElementById("txtrejected").disabled = false;
}
else if(status3.value == "4" )
{
document.getElementById("txtrejected").disabled = false;
}
else
{
document.getElementById("txtrejected").disabled = true ;
document.getElementById("txtrejected").value = ' ' ;
}

}
</script>

<style type="text/css">
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}

q {
  font-size: 12px;
  color:red;
}

</style>
</head>
<body>

	<?php
	if ($x == 1 && $totalRows_patsearch!=0) {//create new appoinment existing patient

	 ?>
	


	<div class="container-fluid">
	<div class="col-lg-9.5 col-md-8">
		<tr>
			<td  align="center"><a href="booking.php">Back</a></td>
		</tr>
	<div class="panel panel-default" >

	<form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_rec_exec.php?x=1" >


	<tr>
		<td>&nbsp;</td>
	</tr>
	<div class="panel-heading">
		<h3 class="panel-title"></h3>
	</div>
		<tr>
		    <h3><center>Echocardiogram Patient Appointment Booking</center></h3>
		</tr>
	<div class="panel-body">

		<div class="form-group">
				<label for="txtic">Ic/Passport</label>
				<input type="text" class="form-control" id="txtic" name="txtic" value="<?php echo $identity; ?>"readonly>
		</div>

	<div class="form-group">
     	  <label for="txtname">Name</label>
      	<input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $row_patsearch['Pat_Name']; ?>" readonly/>
    	</div>	

	<div class="form-group">
    	  <?php
 				$gender = $row_patsearch['Pat_Gender'];
 				mysqli_select_db($conn, $database_conn);
	   		$query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
	  	  $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
        $row_recgender = mysqli_fetch_assoc($recgender);?>
			<label for="ddlgender">Gender</label>
      <input readonly class="form-control" name="ddlgender" id="ddlgender"value=" <?php echo $row_recgender['gender_name']?> "readonly/>
    </div>

	<div class="form-group">
     	  <label for="pat_pnum">Patient Phone Number</label>
      	<input type="text" class="form-control" id="pat_pnum" name="pat_pnum">
    	</div>

	<div class="form-group">
		<label for="txtage">Age</label>
		<input type="text" class="form-control" id="txtage" name="txtage">
	</div>

	<div class="form-group">
		<label for="pat_height">Height</label>
		<input type="text" class="form-control" id="pat_height" name="pat_height">
	</div>

	<div class="form-group">
		<label for="pat_height">Weight</label>
		<input type="text" class="form-control" id="pat_weight" name="pat_weight">
	</div>

	<div class="form-group">
		<label for="txtnat">Nationality</label>
   	<input type="text" class="form-control" id="txtnat" name="txtnat" value="<?php echo $row_patsearch['Pat_Nat']; ?>" readonly/>
	</div>

				<div class="form-group">
				<label for="ddlpatienttype">Inpatient/Outpatient</label>
				<select class="form-control" name="ddlpatienttype" id="ddlpatienttype" onchange="changeStatus()">
					<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
				<?php
				do {
				?>
					<option value="<?php echo $row_recpattype['patient_type_id']?>"<?php if (!(strcmp($row_recpattype['patient_type_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recpattype['patient_type']?></option>
				<?php
					} while ($row_recpattype = mysqli_fetch_assoc($recpattype));
						$rows = mysqli_num_rows($recpattype);
						if($rows > 0) {
						mysqli_data_seek($recpattype, 0);
						$row_recpattype = mysqli_fetch_assoc($recpattype);
					}

				?>
				</select>
			</div>

				<div class="form-group">
						<label for="txtward">Ward</label>
						<input type="text" class="form-control" id="txtward" name="txtward">
				</div>

						<div class="form-group">
						<label for="ddlcovstat">Covid Status</label>
						<select class="form-control" name="ddlcovstat" id="ddlcovstat">
							<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
						<?php
						do {
						?>
							<option value="<?php echo $row_reccovstat['covidstat_id']?>"<?php if (!(strcmp($row_reccovstat['covidstat_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_reccovstat['covidstat']?></option>
						<?php
					} while ($row_reccovstat = mysqli_fetch_assoc($reccovstat));
								$rows = mysqli_num_rows($reccovstat);
								if($rows > 0) {
								mysqli_data_seek($reccovstat, 0);
								$row_reccovstat = mysqli_fetch_assoc($reccovstat);
							}

						?>
						</select>
					</div>



			<div class="form-group">
					<label for="txtclinicalhistory"> Patient Clinical History </label>
					<input type="text" class="form-control" id="txtclinicalhistory" name="txtclinicalhistory" >
			</div>

			<div class="form-group">
						<label for="ddlfirsttime">First Time Patient is Referred for Echocardiogram</label>
						<select class="form-control" name="ddlfirsttime" id="ddlfirsttime" onchange="changeStatus()">
							<option value="0">Please Choose</option>
							<option value="YES">Yes</option>
							<option value="NO">No</option>
						</select>
					</div>

					<div class="form-group">
							<label for="txtdateecho"> Patient Previous Echocardiogram ( Month/Year )</label>
							<input type="text" class="form-control" id="txtdateecho" name="txtdateecho" placeholder="e.g. July/2019" <?php echo $optfirsttime;?>>
					</div>

					<div class="form-group">
							<label for="txtplaceecho"> Place</label>
							<input type="text" class="form-control" id="txtplaceecho" name="txtplaceecho" <?php echo $optfirsttime;?>>
					</div>

			<div class="form-group">
				<label for="ddloxy">Is patient dependent on oxygen?</label>
				<select class="form-control" name="ddloxy" id="ddloxy" onchange="changeStatus()">
					<option value="0">Please Choose</option>
					<option value="YES">Yes</option>
					<option value="NO">No</option>
				</select>
			</div>


	<div class="form-group">
			<label for="txtoxy">Oxygen Type</label>
			<input type="text" class="form-control" id="txtoxy" name="txtoxy" <?php echo $optoxy;?>>
	</div> 
	

			<div class="form-group">
						<label for="ddlurgent">Urgency</label>
						<select class="form-control" name="ddlurgent" id="ddlurgent" >
							<option value="0">Please Choose</option>
							<option value="YES">Yes</option>
							<option value="NO">No</option>
						</select>
					</div>


		<label for="txtappliedby">Indication Echocardiogram : </label> <small>(Can Choose More Than One)</small>
			<form class="form-group" action="" method="POST">
			<td><table width="900" border="0" align="center">
			<?php $c=0;
				do { 
					if ($c%2 == 0)
						{ ?>
							<tr><td width="800"><input type="checkbox" name="indication[]" id="indication_echo" style="background-color:#FFD5D5" value="<?php echo $c + $row_recindication['indication_id']; ?>" > <label><span class="style2"><?php echo $row_recindication['indication_name']; ?></span></label> </td>
							<?php
								} else { ?>
									<td width="800"><input type="checkbox" name="indication[]" id="indication_echo" style="background-color:#FFD5D5" value="<?php echo $c + $row_recindication['indication_id']; ?>" > <label><span class="style2"><?php echo $row_recindication['indication_name'];?></span></label></td></tr>
							<?php
							}
						$c++;
					} while ($row_recindication = mysqli_fetch_assoc($recindication));
						$rows = mysqli_num_rows($recindication);
							if($rows > 0) {
								mysqli_data_seek($recindication, 0);
								$row_recindication = mysqli_fetch_assoc($recindication);
            }
        
        ?></table></td><br>

      <div class="form-group">
          <label for="uptxtdate">Upcoming MOPD / Other Clinics Appoinment Date : <b>( If Available )</b> </label>
          <input type="date" class="form-control" id="uptxtdate" name="uptxtdate">
      </div>

    <div class="form-group">
      <label for="txtappliedby">Applied By</label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_recAccSet['name']; ?>" readonly />
    </div>

    <div class="form-group">
      <label for="doctelnum">Applicant's Phone Number</label>
      <input type="text" class="form-control" name="doctelnum" id="doctelnum" value="<?php echo $row_recAccSet['phonenum']; ?>"readonly/>
    
    </div>

    <div class="form-group">
    	<?php $department = $row_recAccSet['jabatan'];
	    mysqli_select_db($conn, $database_conn);
	    $query_recdepart = "SELECT * FROM dept_tbl WHERE department_id = '$department'";
	    $recdepart = mysqli_query($conn, $query_recdepart) or die(mysqli_error($conn));
	    $row_recdepart = mysqli_fetch_assoc($recdepart); ?>
      <label for="txtdepart">Department:</label>
      <input class="form-control" name="txtdepart" id="txtdepart" value=" <?php echo $row_recdepart['department_name']?> "readonly/>
 
    </div>
    
    <div class="form-group">
      <label for="inchargepatient">Specialist In Charge Of Patient</label>
      <input type="text" class="form-control" name="inchargepatient" id="inchargepatient">
    </div>
    <input type="hidden" name="txtpatid" id="txtpatid" value="<?php echo $row_patsearch["pat_id"]; ?>" />    
    <input type="hidden" name="txtregdate" value="<?php echo $regdate; ?>">
		<p>&nbsp;</p>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>	

		<button type="submit" name="submit" id="submit" class="btn btn-o btn-info">Submit</button>

	</form>

	</div>
	</div>
	</div>

<?php } else { // create new appoinment not existing patient?>
	<div class="container-fluid">
	<div class="col-lg-9.5 col-md-8">
		<tr>
			<td  align="center"><a href="booking.php">Back</a></td>
		</tr>
	<div class="panel panel-default" >

	<form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_rec_exec.php?x=2" >


	<tr>
		<td>&nbsp;</td>
	</tr>
	<div class="panel-heading">
		<h3 class="panel-title"></h3>
	</div>
		<tr>
		    <h3><center>Echocardiogram Patient Appointment Booking</center></h3>
		</tr>
	<div class="panel-body">

		<div class="form-group">
				<label for="txtic">Ic/Passport</label>
				<input type="text" class="form-control" id="txtic" name="txtic" value="<?php echo $ic; ?>"readonly>
		</div>
		<div class="form-group">
     	  <label for="txtname">Name</label>
      	<input type="text" class="form-control" id="txtname" name="txtname">
    	</div>

   	<div class="form-group">
				<label for="ddlgender">Gender</label>
				<select class="form-control" name="ddlgender" id="ddlgender">
					<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
				<?php
				do {
				?>
					<option value="<?php echo $row_recgender['gender_id']?>"<?php if (!(strcmp($row_recgender['gender_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recgender['gender_name']?></option>
				<?php
			} while ($row_recgender = mysqli_fetch_assoc($recgender));
						$rows = mysqli_num_rows($recgender);
						if($rows > 0) {
						mysqli_data_seek($recgender, 0);
						$row_recgender = mysqli_fetch_assoc($recgender);
					}

				?>
						</select>
				</div>

	<div class="form-group">
     	  <label for="pat_pnum">Patient Phone Number</label>
      	<input type="text" class="form-control" id="pat_pnum" name="pat_pnum">
    	</div>
	

	<div class="form-group">
		<label for="txtage">Age</label>
		<input type="text" class="form-control" id="txtage" name="txtage">
	</div>

	<div class="form-group">
		<label for="pat_height">Height</label>
		<input type="text" class="form-control" id="pat_height" name="pat_height">
	</div>

	<div class="form-group">
		<label for="pat_height">Weight</label>
		<input type="text" class="form-control" id="pat_weight" name="pat_weight">
	</div>

	<div class="form-group">
		<label for="txtnat">Nationality</label>
		<select class="form-control" id="txtnat" name="txtnat"> 							
			<option value= "0">Please Choose</option>
			<option value="Malaysian">Malaysian</option>
			<option value="Foreigner">Foreigner</option>
		</select>
	</div>

				<div class="form-group">
				<label for="ddlpatienttype">Inpatient/Outpatient</label>
				<select class="form-control" name="ddlpatienttype" id="ddlpatienttype" onchange="changeStatus()">
					<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
				<?php
				do {
				?>
					<option value="<?php echo $row_recpattype['patient_type_id']?>"<?php if (!(strcmp($row_recpattype['patient_type_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recpattype['patient_type']?></option>
				<?php
					} while ($row_recpattype = mysqli_fetch_assoc($recpattype));
						$rows = mysqli_num_rows($recpattype);
						if($rows > 0) {
						mysqli_data_seek($recpattype, 0);
						$row_recpattype = mysqli_fetch_assoc($recpattype);
					}

				?>
				</select>
			</div>

				<div class="form-group">
						<label for="txtward">Ward</label>
						<input type="text" class="form-control" id="txtward" name="txtward">
				</div>


						<div class="form-group">
						<label for="ddlcovstat">Covid Status</label>
						<select class="form-control" name="ddlcovstat" id="ddlcovstat">
							<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
						<?php
						do {
						?>
							<option value="<?php echo $row_reccovstat['covidstat_id']?>"<?php if (!(strcmp($row_reccovstat['covidstat_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_reccovstat['covidstat']?></option>
						<?php
					} while ($row_reccovstat = mysqli_fetch_assoc($reccovstat));
								$rows = mysqli_num_rows($reccovstat);
								if($rows > 0) {
								mysqli_data_seek($reccovstat, 0);
								$row_reccovstat = mysqli_fetch_assoc($reccovstat);
							}

						?>
						</select>
					</div>



			<div class="form-group">
					<label for="txtclinicalhistory"> Patient Clinical History </label>
					<input type="text" class="form-control" id="txtclinicalhistory" name="txtclinicalhistory" >

			</div>

			<div class="form-group">
						<label for="ddlfirsttime">First Time Patient is Referred for Echocardiogram</label>
						<select class="form-control" name="ddlfirsttime" id="ddlfirsttime" onchange="changeStatus()">
							<option value="0">Please Choose</option>
							<option value="YES">Yes</option>
							<option value="NO">No</option>
						</select>
					</div>

					<div class="form-group">
							<label for="txtdateecho"> Patient Previous Echocardiogram ( Month/Year )</label>
							<input type="text" class="form-control" id="txtdateecho" name="txtdateecho" placeholder="e.g. July/2019" <?php echo $optfirsttime;?>>
					</div>

					<div class="form-group">
							<label for="txtplaceecho"> Place</label>
							<input type="text" class="form-control" id="txtplaceecho" name="txtplaceecho" <?php echo $optfirsttime;?>>
					</div>

			<div class="form-group">
				<label for="ddloxy">Is patient dependent on oxygen?</label>
				<select class="form-control" name="ddloxy" id="ddloxy" onchange="changeStatus()">
					<option value="0">Please Choose</option>
					<option value="YES">Yes</option>
					<option value="NO">No</option>
				</select>
			</div>


	<div class="form-group">
			<label for="txtoxy">Oxygen Type</label>
			<input type="text" class="form-control" id="txtoxy" name="txtoxy" <?php echo $optoxy;?>>
	</div> 
	

			<div class="form-group">
						<label for="ddlurgent">Urgency</label>
						<select class="form-control" name="ddlurgent" id="ddlurgent" >
							<option value="0">Please Choose</option>
							<option value="YES">Yes</option>
							<option value="NO">No</option>
						</select>
					</div>


		<label for="txtappliedby">Indication Echocardiogram : </label> <small>(Can Choose More Than One)</small>
			<form class="form-group" action="" method="POST">
			<td><table width="900" border="0" align="center">
			<?php $c=0;
				do { 
					if ($c%2 == 0)
						{ ?>
							<tr><td width="800"><input type="checkbox" name="indication[]" id="indication_echo" style="background-color:#FFD5D5" value="<?php echo  $row_recindication['indication_id']; ?>" > <label><span class="style2"><?php echo $row_recindication['indication_name']; ?></span></label></td>
							<?php
								} else { ?>
									<td width="800"><input type="checkbox" name="indication[]" id="indication_echo" style="background-color:#FFD5D5" value="<?php echo  $row_recindication['indication_id']; ?>" > <label><span class="style2"><?php echo $row_recindication['indication_name'];?></span></label></td></tr>
							<?php
							}
						$c++;
					} while ($row_recindication = mysqli_fetch_assoc($recindication));
						$rows = mysqli_num_rows($recindication);
							if($rows > 0) {
								mysqli_data_seek($recindication, 0);
								$row_recindication = mysqli_fetch_assoc($recindication);
            }
        
        ?></table></td><br>

      <div class="form-group">
          <label for="uptxtdate">Upcoming MOPD / Other Clinics Appoinment Date : <b>( If Available )</b> </label>
          <input type="date" class="form-control" id="uptxtdate" name="uptxtdate">
      </div>

    <div class="form-group">
      <label for="txtappliedby">Applied By</label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_recAccSet['name']; ?>" readonly />
    </div>


    <div class="form-group">
      <label for="doctelnum">Applicant's Phone Number</label>
      <input type="text" class="form-control" name="doctelnum" id="doctelnum" value="<?php echo $row_recAccSet['phonenum']; ?>"readonly/>
    
    </div>

    <div class="form-group">
    	<?php $department = $row_recAccSet['jabatan'];
	    mysqli_select_db($conn, $database_conn);
	    $query_recdepart = "SELECT * FROM dept_tbl WHERE department_id = '$department'";
	    $recdepart = mysqli_query($conn, $query_recdepart) or die(mysqli_error($conn));
	    $row_recdepart = mysqli_fetch_assoc($recdepart); ?>
      <label for="txtdepart">Department:</label>
      <input class="form-control" name="txtdepart" id="txtdepart" value=" <?php echo $row_recdepart['department_name']?> "readonly/>
 
    </div>
    
    <div class="form-group">
      <label for="inchargepatient">Specialist In Charge Of Patient</label>
      <input type="text" class="form-control" name="inchargepatient" id="inchargepatient">
    </div>
    <input type="hidden" name="txtregdate" value="<?php echo $regdate; ?>">
		<p>&nbsp;</p>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>	

		<button type="submit" name="submit" id="submit" class="btn btn-o btn-info">Submit</button>

	</form>

	</div>
	</div>
  	<tr>
    	<td>&nbsp;</td>
  	</tr>
  
<?php } ?>
</body>
</html>
