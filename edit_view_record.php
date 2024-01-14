<?php require_once('auth.php');
require_once('Connections/conn.php');


$lg_id = $_SESSION['SESS_MEMBER_ID'];
$regdate = date("Y-m-d H:i:s");

$x = $_GET['x'];
$logid =$_SESSION['SESS_MEMBER_ID'];
$id =$_GET['id'];
$type = $_SESSION['SESS_TYPE'];

mysqli_select_db($conn, $database_conn);
$query_recpat = "SELECT * FROM app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id)
WHERE A.borang_id='$id'";
$recpat = mysqli_query($conn, $query_recpat) or die(mysqli_error($conn));
$row_recpat = mysqli_fetch_assoc($recpat);
$totalRows_recpat = mysqli_num_rows($recpat);

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

var tbLen10 = f.inchargepatient.value.trim().length;
if (tbLen10 == 0) {
alert("Please enter Specialist In Charge Of Patient");
f.inchargepatient.focus();
return(false);
}
}

function adminvalidate(f) {

if (f.ddlstatapp.value == "0") { //baru
alert("Please choose status appointment");
f.ddlstatapp.focus();
return(false);
}

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

function auto_grow(element) {
element.style.height = "5px";
element.style.height = (element.scrollHeight) + "px";
}
</script>

<script>
function changeStatusApp()  // FOR DISABLE & ENABLE INPUT BOX AT EDIT ADMIN
{
var status3 = document.getElementById("ddlstatapp");
if(status3.value == "3")
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
</style>
</head>
<body>


<?php
if ($x == 1) { //set date for admin

?>

<div class="container" align="center">
<div id="txtHint">

  <tr>
<td  align="center"><a href="booking.php">Back</a></td>
</tr>

<table border="1" class="table table-bordered">

<tr align="center">
<td colspan="4" style="font-size:25px;">Patient Details</td></tr>


<tr>
<th width="250">IC/Passport</th>
<td><?php echo $row_recpat['Pat_Ic']; ?></td>
<th width="250">Name</th>
<td><?php echo $row_recpat['Pat_Name']; ?></td>
</tr>

<tr>
<th width="250">Gender</th>
<td>  <?php $gender = $row_recpat['Pat_Gender'];
mysqli_select_db($conn, $database_conn);
$query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
$recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
$row_recgender = mysqli_fetch_assoc($recgender);
echo $row_recgender['gender_name']?>
</td>

<th width="250">Age</th>
<td><?php echo $row_recpat['Pat_Age']; ?></td>
</tr>

<tr>
<th width="250">Height</th>
<td><?php echo $row_recpat['Height']; ?></td>

<th width="250">Weight</th>
<td><?php echo $row_recpat['Weight']; ?></td>
</tr>

<tr>
<th width="250">Nationality</th>
<td> <?php echo $row_recpat['Pat_Nat']?></td>

<th width="250">Patient Phone Number</th>
<td> <?php echo $row_recpat['Pat_Pnum']?></td>

</tr>

<tr>
<th width="250">Inpatient/Outpatient</th>
<td><?php $pattype = $row_recpat['Pat_Type'];
mysqli_select_db($conn, $database_conn);
$query_rectype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
$rectype = mysqli_query($conn, $query_rectype) or die(mysqli_error($conn));
$row_rectype = mysqli_fetch_assoc($rectype);
echo $row_rectype['patient_type']?> </td>

<th width="250">Ward</th>
<td><?php echo $row_recpat['Pat_Wad']; ?></td>
</tr>

<tr>
<th width="250">Covid Status</th>
<td><?php $covid = $row_recpat['Pat_Covid_Status'];
mysqli_select_db($conn, $database_conn);
$query_reccovid = "SELECT * FROM patient_covid_status WHERE covidstat_id = '$covid'";
$reccovid = mysqli_query($conn, $query_reccovid) or die(mysqli_error($conn));
$row_reccovid = mysqli_fetch_assoc($reccovid);
echo $row_reccovid['covidstat']?>
</td>

<th width="250">Patient Clinical History</th>
<td><?php echo $row_recpat['Pat_Clinical_History']; ?></td>
</tr>

<tr>
<th width="250">First Time Patient Is Referrer For Echocardiogram?</th>
<td><?php echo $row_recpat['Pat_FirstTime']; ?></td>

<th width="250"> Patient Previous <br> Echocardiogram ( Month/Year ) </th>
<td><?php echo $row_recpat['Date_Echo']; ?></td>
</tr>

<tr>	

<th width="250">Place</th>
<td colspan="4"> <?php echo $row_recpat['Place_Echo']; ?></td>
</tr> 

<tr>
<th width="250">Is patient dependent on oxygen?</th>
<td><?php echo $row_recpat['Pat_Oxy']; ?></td>

<th width="250">Oxygen Type</th>
<td><?php echo $row_recpat['Oxy_Type']; ?></td>
</tr> 


<tr>
<th width="250">Urgency</th>
<td><?php echo $row_recpat['Urgency']; ?></td>

<th width="250">Indication Echocardiogram :</th>
  <td><span class="style4">
    <?php
        $id = $row_recpat['borang_id']; 
    mysqli_select_db($conn, $database_conn);
    $query_recindi = "SELECT * FROM pat_indication WHERE borang_id = '$id'";
    $recindi = mysqli_query($conn, $query_recindi) or die(mysqli_error($conn));
    $row_recindi = mysqli_fetch_assoc($recindi);
    do {

      $id_type = $row_recindi['indication_type'];
      mysqli_select_db($conn, $database_conn);
      $query_recinditype = "SELECT * FROM ref_indication_tbl WHERE indication_id = '$id_type'";
      $recinditype = mysqli_query($conn, $query_recinditype) or die(mysqli_error($conn));
      $row_recinditype = mysqli_fetch_assoc($recinditype);
      echo $row_recinditype ['indication_name']."<br>";

    } while ($row_recindi = mysqli_fetch_assoc($recindi)); 


    ?></td>
</tr> 

<tr>
<th width="250">Applied By</th>
<td><?php echo $row_recpat['Applied_By']; ?></td>

<th width="250">Applicant's Phone Number</th>
<td><?php echo $row_recpat['Doctor_Phone']; ?></td>
</tr> 

<tr>
<th width="250">Department:</th>
<td> <?php $department = $row_recpat['jabatan'];
mysqli_select_db($conn, $database_conn);
$query_recdepart = "SELECT * FROM dept_tbl WHERE department_id = '$department'";
$recdepart = mysqli_query($conn, $query_recdepart) or die(mysqli_error($conn));
$row_recdepart = mysqli_fetch_assoc($recdepart);
echo $row_recdepart['department_name']?></td>

<th width="250">Specialist In Charge Of Patient</th>
<td><?php echo $row_recpat['InCharge_Of_Patient']; ?></td>
</tr> 

</table>

</div>  </td>

</tr>
<tr>
<td>&nbsp;</td>
</tr>
</div>
</form>

<div class="container">
<div class="col-lg-14 col-md-14">
<div class="panel panel-default" >

<form id="form1" name="form1" method="post" onsubmit="return adminvalidate(this)" action="edit_record_exec.php?x=1" > 

<tr>
<td>&nbsp;</td>
</tr>
<div class="panel-heading">
<h3 class="panel-title"></h3>
</div>
<tr>
<h3><center>Booking Appointment</center></h3>
</tr>

<div class="form-group">
<label for="ddlstatapp">Status Appointment:</label>
<select class="form-control" name="ddlstatapp" id="ddlstatapp" onchange="changeStatusApp()">
<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Sila Pilih</option>
<?php
do {  
?>
<option value="<?php echo $row_recstatapp['appointmentstatusID']?>"<?php if (!(strcmp($row_recstatapp['appointmentstatusID'], $row_recpat['appointment_status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recstatapp['appointment_status']?></option>
<?php
} while ($row_recstatapp = mysqli_fetch_assoc($recstatapp));
$rows = mysqli_num_rows($recstatapp);
if($rows > 0) {
mysqli_data_seek($recstatapp, 0);
$row_recstatapp = mysqli_fetch_assoc($recstatapp);
}
?>
</select>
</div>

<div class="form-group">
<label for="txtrejected">Reason rejected application</label>
  <textarea class="form-control" name="txtrejected" id="txtrejected" ><?php echo $row_recpat['reason']; ?> </textarea>
</div>


<tr>
<th width="250"> <b>Upcoming MOPD / Other Clinics Appoinment Date ( If Available ): </b></th><br>

  <td><?php if ($row_recpat['Upcoming_App']!= '0000-00-00') {
  echo date('Y-m-d',strtotime($row_recpat['Upcoming_App'])); } ?> &nbsp;
  </td><br>
</tr> <br>

<div class="form-group">
  <label for="txtdate">Appointment Date </label>
  <input type="date" class="form-control" id="txtdate" name="txtdate"value = "<?php echo $row_recpat['App_Date']; ?>" />
</div>

<div class="form-group">
<?php  $statapp = $row_recpat['appointment_status']; ?>
  <?php if ($statapp == 1){
?><label for="time">Appointment Time</label>
  <input type="time" class="form-control" id="time" name="time"><?php
    } 
else {
?>
  <label for="time">Appointment Time</label>
  <input type="time" class="form-control" id="time" name="time" value = "<?php echo $row_recpat['App_Time']; ?>" />
  <?php } 
  ?>
</div>

<input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recpat["borang_id"]; ?>" />
<input type="hidden" name="txtpatid" id="txtpatid" value="<?php echo $row_recpat["pat_id"]; ?>" />
<button type="submit" name="Hantar" id="Hantar" class="btn btn-o btn-primary">Submit</button>

</div>
</table>
</form>
</div>
</div>
</div>

<?php

}else if ($x == 2) { //edit patient details


?>

<div class="container">
<div class="col-lg-10 col-md-8">
<tr>
<td  align="center"><a href="booking.php">Back</a></td>
</tr>
<div class="panel panel-default" >

<form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="edit_record_exec.php?x=2" >
<tr>
<td>&nbsp;</td>
</tr>
<div class="panel-heading">
<h3 class="panel-title"></h3>
</div>
<tr>
<h3><center>Patient Echo Appointment Booking</center></h3>
</tr>

<div class="panel-body">

<div class="form-group">
<label for="txtic">Ic/Passport</label>
<input type="text" class="form-control" id="txtic" name="txtic" value="<?php echo $row_recpat['Pat_Ic']; ?>" />
</div> 

<div class="form-group">
<label for="txtname">Name</label>
  <input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $row_recpat['Pat_Name']; ?>" />
</div>



<div class="form-group">
<label for="ddlgender">Gender</label>
<select class="form-control" name="ddlgender" id="ddlgender">
<?php
do {
?>
<option value="<?php echo $row_recgender['gender_id']?>"<?php if (!(strcmp($row_recgender['gender_id'], $row_recpat['Pat_Gender']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recgender['gender_name']?></option>
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
<input type="text" class="form-control" id="pat_pnum" name="pat_pnum" value="<?php echo $row_recpat['Pat_Pnum']; ?>"/>
</div>


<div class="form-group">
<label for="txtage">Age</label>
<input type="text" class="form-control" id="txtage" name="txtage" value="<?php echo $row_recpat['Pat_Age']; ?>" />
</div>

<div class="form-group">
<label for="pat_height">Height</label>
<input type="text" class="form-control" id="pat_height" name="pat_height" value="<?php echo $row_recpat['Height']; ?>" />
</div>

<div class="form-group">
<label for="pat_height">Weight</label>
<input type="text" class="form-control" id="pat_weight" name="pat_weight" value="<?php echo $row_recpat['Weight']; ?>" />
</div>


<div class="form-group">
<label for="txtnat">Nationality</label>
<select class="form-control" id="txtnat" name="txtnat" value="<?php echo $row_recpat['Pat_Nat']; ?>" />
<option value="Malaysian"<?php if ($row_recpat['Pat_Nat'] == 'Malaysian') {echo "selected=\"selected\"";} ?>>Malaysian</option>
<option value="Foreigner"<?php if ($row_recpat['Pat_Nat'] == 'Foreigner') {echo "selected=\"selected\"";} ?>>Foreigner</option>>
</select>  
</div>

<div class="form-group">
  <label for="ddlpatienttype">Inpatient/Outpatient</label>
  <select class="form-control" name="ddlpatienttype" id="ddlpatienttype" onchange="changeStatus()">
  <?php
  do {
?>
    <option value="<?php echo $row_recpattype['patient_type_id']?>"<?php if (!(strcmp($row_recpattype['patient_type_id'],$row_recpat['Pat_Type']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recpattype['patient_type']?></option>
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
<input type="text" class="form-control" id="txtward" name="txtward" value = "<?php echo $row_recpat['Pat_Wad']; ?>" />
</div>


<div class="form-group">
    <label for="ddlcovstat">Covid Status</label>
    <select class="form-control" name="ddlcovstat" id="ddlcovstat">
    <?php
    do {
    ?>
      <option value="<?php echo $row_reccovstat['covidstat_id']?>"<?php if (!(strcmp($row_reccovstat['covidstat_id'],$row_recpat['Pat_Covid_Status'] ))) {echo "selected=\"selected\"";} ?>><?php echo $row_reccovstat['covidstat']?></option>
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
  <input type="text" class="form-control" id="txtclinicalhistory" name="txtclinicalhistory" value = "<?php echo $row_recpat['Pat_Clinical_History']; ?>" />
</div>

<div class="form-group">
    <label for="ddlfirsttime"> First Time Patient Is Referrer For Echocardiogram? </label>
    <select class="form-control" name="ddlfirsttime" id="ddlfirsttime" value="<?php echo $row_recpat['Pat_FirstTime']; ?>" onchange="changeStatus()"/>
    <option value="YES"<?php if ($row_recpat['Pat_FirstTime'] == 'YES') {echo "selected=\"selected\"";} ?>>Yes</option>
    <option value="NO"<?php if ($row_recpat['Pat_FirstTime'] == 'NO') {echo "selected=\"selected\"";} ?>>No</option>>
    </select>
  </div>

    <div class="form-group">
      <label for="txtdateecho">  Patient Previous Echocardiogram ( Month/Year ) </label>
      <input type="text" class="form-control" id="txtdateecho" name="txtdateecho" value = "<?php echo $row_recpat['Date_Echo']; ?>" />
  </div>

  <div class="form-group">
      <label for="txtplaceecho"> Place</label>
      <input type="text" class="form-control" id="txtplaceecho" name="txtplaceecho" value = "<?php echo $row_recpat['Place_Echo']; ?>" />
  </div>

<div class="form-group">
    <label for="ddloxy">Is patient dependent on oxygen?</label>
    <select class="form-control" name="ddloxy" id="ddloxy" value="<?php echo $row_recpat['Pat_Oxy']; ?>" onchange="changeStatus()">
    <option value="YES"<?php if ($row_recpat['Pat_Oxy'] == 'YES') {echo "selected=\"selected\"";} ?>>Yes</option>
    <option value="NO"<?php if ($row_recpat['Pat_Oxy'] == 'NO') {echo "selected=\"selected\"";} ?>>No</option>
        </select>
</div>

<div class="form-group">
  <label for="txtoxy">Oxygen Type</label>
    <input type="text" class="form-control" id="txtoxy" name="txtoxy" value = "<?php echo $row_recpat['Oxy_Type']; ?>" />
</div>

<div class="form-group">
    <label for="ddlurgent">Urgency</label>
    <select class="form-control" name="ddlurgent" id="ddlurgent" value = "<?php echo $row_recpat['Urgency']; ?>" />
</div>
    <option value="YES"<?php if ($row_recpat['Urgency'] == 'YES') {echo "selected=\"selected\"";} ?>>Yes</option>
    <option value="NO"<?php if ($row_recpat['Urgency'] == 'NO') {echo "selected=\"selected\"";} ?>>No</option>
    </select>
  </div>


<label for="txtappliedby">Indication Echocardiogram : </label> <small>(Can Choose More Than One)</small>
<form class="form-group" action="" method="POST">

<td>
<?php 

mysqli_select_db($conn,$database_conn); 
$query_recindi = "SELECT * FROM ref_indication_tbl WHERE indication_flag=0 ORDER BY indication_id ASC";
$recindi = mysqli_query($conn,$query_recindi ) or die(mysqli_error($conn));
$row_recindi = mysqli_fetch_assoc($recindi);
$totalRows_recindi = mysqli_num_rows($recindi);
$dtamb = 0; $rowc=0;
do {  
  $inditype=$row_recindi['indication_id'];
  mysqli_select_db($conn,$database_conn);
  $query_recindication = "SELECT * FROM pat_indication WHERE borang_id = '$id' and indication_type = '$inditype' ";
  $recindication = mysqli_query($conn,$query_recindication) or die(mysqli_error($conn));
  $row_recindication = mysqli_fetch_assoc($recindication);
  $totalRows_recindication = mysqli_num_rows($recindication);

  //if ($inditype == $row_recindication['indication_type']) {
  if ($totalRows_recindication != 0) {
    $check = "checked=\"checked\"";
  } else {
    $check =''; 
  }
?>
  <br/><input type="checkbox" name="inditype[]" id="inditype" value="<?php echo $row_recindi['indication_id']; ?>"  <?php echo $check; ?>> <label> <?php echo $row_recindi['indication_name']; ?></label>
      <?php
        //}
      $dtamb=$inditype;

} while ($row_recindi = mysqli_fetch_assoc($recindi));
  $rows = mysqli_num_rows($recindi);
  if($rows > 0) {
    mysqli_data_seek($recindi, 0);
    $row_recindi = mysqli_fetch_assoc($recindi);
  }

?>

</td>
<div class="form-group"> <!-- //white space -->
  <table style="width:100%">
<tr>
    <th></th>
</tr>
</table>
</div>

<div class="form-group">
  <label for="uptxtdate">Upcoming MOPD / Other Clinics Appoinment Date : <b>( If Available )</b> </label>


  <input type="date" class="form-control" id="uptxtdate" name="uptxtdate" value = "<?php echo date('Y-m-d',strtotime($row_recpat['Upcoming_App'])); ?>" />

</div>


<div class="form-group">
<label for="inchargepatient">Specialist In Charge Of Patient</label>
<input type="text" class="form-control" name="inchargepatient" id="inchargepatient" value = "<?php echo $row_recpat['InCharge_Of_Patient']; ?>" />
</div>
  <?php if ($type == 1 OR $type == 3) { ?>
      <div class="form-group">
      <label for="comment">Comment</label>
      <textarea style="height: 200px ;" oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason'];  ?>  </textarea>
    <br>

    
    <br>
    <br>
    
    <a style="background-color:yellow;" >LAST UPDATE :</a>
        <?php
            $id = $row_recpat['borang_id'];
            mysqli_select_db($conn, $database_conn);
            $query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$id'";
            $rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
            $row_rececho4 = mysqli_fetch_assoc($rececho4);
            $totalRows_rececho4 = mysqli_num_rows($rececho4);
            echo $row_rececho4['updatedttm']; ?> 
            
    </div>
    <?php	
        }
    ?>
  




<input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recpat["borang_id"]; ?>" />
<input type="hidden" name="txtpatid" id="txtpatid" value="<?php echo $row_recpat["pat_id"]; ?>" />
<input type="hidden" name="txtpatindi" id="txtpatindi" value="<?php echo $row_recpat["pat_indication_id"]; ?>" />
<button type="submit" name="Hantar" id="Hantar" class="btn btn-o btn-primary">Submit</button>

</div>
</table>
</form>
</div>
</div>
</div>


<?php 

} else { //views

$id =$_GET['id'];
$logid =$_SESSION['SESS_MEMBER_ID'];

mysqli_select_db($conn, $database_conn);
$query_recpatuser = "SELECT * FROM app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id)
WHERE A.borang_id='$id'";
$recpatuser = mysqli_query($conn, $query_recpatuser) or die(mysqli_error($conn));
$row_recpatuser = mysqli_fetch_assoc($recpatuser);
$totalRows_recpatuser = mysqli_num_rows($recpatuser);
?> 


<div class="container" align="center">
<div id="txtHint">

  <tr>
<td  align="center"><a href="booking.php">Back</a></td>
</tr>

<table border="1" class="table table-bordered">

<tr align="center">
<td colspan="2" style="font-size:20px;">Appointment Details</td></tr>


<tr>
<th width="250">Name</th>
<td><?php echo $row_recpatuser['Pat_Name']; ?></td>
</tr>

<tr>
<th width="250">IC/Passport</th>
<td><?php echo $row_recpatuser['Pat_Ic']; ?></td>
</tr>

<tr>
<th width="250">Gender</th>
<td>  <?php $gender = $row_recpatuser['Pat_Gender'];
mysqli_select_db($conn, $database_conn);
$query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
$recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
$row_recgender = mysqli_fetch_assoc($recgender);
echo $row_recgender['gender_name']?>
</td>

</tr>

<tr>
<th width="250">Patient Phone Number</th>
<td> <?php echo $row_recpat['Pat_Pnum']?></td>
</tr>

<tr>
<th width="250">Age</th>
<td><?php echo $row_recpatuser['Pat_Age']; ?></td>
</tr>

<tr>
<th width="250">Height</th>
<td><?php echo $row_recpatuser['Height']; ?></td>
</tr>

<tr>
<th width="250">Weight</th>
<td><?php echo $row_recpatuser['Weight']; ?></td>
</tr>

<tr>
<th width="250">Nationality</th>
<td><?php echo $row_recpatuser['Pat_Nat']?></td>
</tr>

<tr>
<th width="250">Inpatient/Outpatient</th>
<td><?php $pattype = $row_recpatuser['Pat_Type'];
mysqli_select_db($conn, $database_conn);
$query_rectype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
$rectype = mysqli_query($conn, $query_rectype) or die(mysqli_error($conn));
$row_rectype = mysqli_fetch_assoc($rectype);
echo $row_rectype['patient_type']?> </td>
</tr>

<tr>
<th width="250">Ward</th>
<td><?php echo $row_recpatuser['Pat_Wad']; ?></td>
</tr>

<tr>
<th width="250">Covid Status</th>
<td><?php $covid = $row_recpatuser['Pat_Covid_Status'];
mysqli_select_db($conn, $database_conn);
$query_reccovid = "SELECT * FROM patient_covid_status WHERE covidstat_id = '$covid'";
$reccovid = mysqli_query($conn, $query_reccovid) or die(mysqli_error($conn));
$row_reccovid = mysqli_fetch_assoc($reccovid);
echo $row_reccovid['covidstat']?>
</td>
</tr>
<tr>
<th width="250">Patient Clinical History</th>
<td><?php echo $row_recpatuser['Pat_Clinical_History']; ?></td>
</tr>

<tr>
<th width="250">First Time Patient Is Referrer For Echocardiogram?</th>
<td><?php echo $row_recpatuser['Pat_FirstTime']; ?></td>
</tr>

<tr>
<th width="250"> Patient Previous Echocardiogram (Month/Year) </th>
<td><?php echo $row_recpatuser['Date_Echo']; ?></td>
</tr>

<tr>
<th width="250">Place</th>
<td><?php echo $row_recpatuser['Place_Echo']; ?></td>
</tr>

<tr>
<th width="250">Is patient dependent on oxygen?</th>
<td><?php echo $row_recpatuser['Pat_Oxy']; ?></td>
</tr>   

<tr>
<th width="250">Oxygen Type</th>
<td><?php echo $row_recpatuser['Oxy_Type']; ?></td>
</tr> 

<tr>
<th width="250">Appointment Date</th>

  <td><?php if ($row_recpatuser['App_Date']!= '0000-00-00') {
  echo date('y-m-d',strtotime($row_recpatuser['App_Date'])); } ?> &nbsp;
  </td>
</tr> 

<tr>
<th width="250">Appointment Time</th>
  <td><?php if ($row_recpatuser['App_Time']!= '00:00:00') {
  echo date('h:i:a',strtotime($row_recpatuser['App_Time'])); } ?> &nbsp;
  </td>
</tr>

<tr>
<th width="250">Urgency</th>
<td><?php echo $row_recpatuser['Urgency']; ?></td>
</tr>   

<tr>
<th width="250">Indication Echocardiogram :</th>
  <td><span class="style4">
    <?php
        $id = $row_recpatuser['borang_id']; 
    mysqli_select_db($conn, $database_conn);
    $query_recindi = "SELECT * FROM pat_indication WHERE borang_id = '$id'";
    $recindi = mysqli_query($conn, $query_recindi) or die(mysqli_error($conn));
    $row_recindi = mysqli_fetch_assoc($recindi);
    do {

      $id_type = $row_recindi['indication_type'];
      mysqli_select_db($conn, $database_conn);
      $query_recinditype = "SELECT * FROM ref_indication_tbl WHERE indication_id = '$id_type'";
      $recinditype = mysqli_query($conn, $query_recinditype) or die(mysqli_error($conn));
      $row_recinditype = mysqli_fetch_assoc($recinditype);
      echo $row_recinditype ['indication_name']."<br>";

    } while ($row_recindi = mysqli_fetch_assoc($recindi)); 

    ?></td>
</tr> 

<tr>
<th width="250">Applied By</th>
<td><?php echo $row_recpatuser['Applied_By']; ?></td>
</tr> 

<tr>
<th width="250">Applicant's Phone Number</th>
<td><?php echo $row_recpatuser['Doctor_Phone']; ?></td>
</tr> 

<tr>
<th width="250">Department:</th>
<td><?php $department = $row_recpatuser['jabatan'];
mysqli_select_db($conn, $database_conn);
$query_recdepart = "SELECT * FROM dept_tbl WHERE department_id = '$department'";
$recdepart = mysqli_query($conn, $query_recdepart) or die(mysqli_error($conn));
$row_recdepart = mysqli_fetch_assoc($recdepart);
echo $row_recdepart['department_name']?></td>
</tr> 

<tr>
<th width="250">Specialist In Charge Of Patient</th>
<td><?php echo $row_recpatuser['InCharge_Of_Patient']; ?></td>
</tr> 


</table>

</div>  </td>

</tr>
<tr>
<td>&nbsp;</td>
</tr>

<?php } ?>
</body>
</html>