<?php require_once('auth.php');
require_once('Connections/conn.php');

$ROW = 0;
$id = $_SESSION['SESS_MEMBER_ID'];
$type = $_SESSION['SESS_TYPE'];

mysqli_select_db($conn, $database_conn);
$query_recpat = "SELECT * from app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id) WHERE A.loginID='$id' && app_flag=0 
ORDER BY FIELD(A.appointment_status, 1, 2, 3, 4, 6, 5) , A.Reg_Date DESC ";
$recpat = mysqli_query($conn, $query_recpat) or die(mysqli_error($conn));
$row_recpat = mysqli_fetch_assoc($recpat);
$totalRows_recpat = mysqli_num_rows($recpat);

mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * from patient_type_tbl WHERE patient_type_flag=0 ORDER BY patient_type ASC"; //for search based on status tempahan 
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
$totalRows_recpattype = mysqli_num_rows($recpattype);

mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * from app_status WHERE flag_as=0 ORDER BY appointment_status ASC"; //for search based on status tempahan 
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
$totalRows_recappstatus = mysqli_num_rows($recappstatus);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="Content-Type" content="text/html; charset=iso-8859-1" >
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>
<title>Echo Patient List</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="jspdf/tableExport.js"></script>
<script type="text/javascript" src="jspdf/jquery.base64.js"></script>


<script type="text/javascript">
function validate(f) {

var tbLen = f.txtic.value.trim().length;
if (tbLen == 0) {

  alert("Please insert Identity Card / Passport No ");
  f.txtic.focus();
  return (false);
}
}

function onlyAlphanumeric(str) {
str.value = str.value.replace(/\s/g, ""); //No Space
str.value = str.value.replace(/[^a-zA-Z0-9 ]/g, "");
}
showUser(2, <?php echo $_POST['txtic']; ?>);

function showUser(str, value) //search box
{
if (str == "") {
  document.getElementById("txtHint").innerHTML = "";
  return;
}
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
} else { // code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
  }
}
var namevalue = value;

xmlhttp.open("GET", "get_appointment.php?m=" + namevalue + "&l=" + str, true);
//xmlHttp.send(params); 
xmlhttp.send();
}

</script>

<style type="text/css">
.style1 {
color: #FFFFFF;
font-weight: bold;
}
</style>

<form id="form1" name="form1" method="post" action="add_rec.php?us=1&x=1" onsubmit="return validate(this)">
<tr>
<td>
<table width="500" border="0" bgcolor="#FF968A" bordercolor="#000066" align="center">
<tr>
<td colspan="4" bgcolor="#db420f">
<div align="center"><strong><span class="style1">Echocardiogram Request</span></strong></div>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="150"><strong>I/C or Passport No :</strong></td>
<td width="200"><input name="txtic" type="text" id="txtic" size="17" value="<?php echo (isset($_POST['txtic'])) ? htmlentities($_POST['txtic']) : 'Default text' ?>" onKeyUp="onlyAlphanumeric(this);" /></td>
</tr>

<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr align="center">
<td colspan="3"><input type="submit" name="Submit" value="Add Appointment" /></td>
</tr>
</table>
</td>
</tr>
</form>
</head>

<body>
<div class="container" align="center">


<tr>
<td>
<div id="txtHint">

<p>
<center><strong>
<font color="#FF4A4A"><?php echo $totalRows_recpat; ?></font> record found &nbsp;&nbsp;&nbsp;
</strong></center>
</p>

<img src="img/legend.png" width="1000" height="30">

<table class="table table-bordered" align="center" id="tableID">
<thead>
<tr align="center" bgcolor="#db420f">

<td width="120">
<div align="center" class="style1">Reg Date</div>
</td>
<td width="250">
<div align="center" class="style1">Name / IC</div>
</td>
<td width="80">
<div align="center" class="style1">Ward</div>
</td>
<td width="120">
<div align="center" class="style1">App Date-Time </div>
</td>
<td width="300">
<div align="center" class="style1">Indication</div>
</td>
<td width="80">
<div align="center" class="style1">Patient Type</div>
</td>
<td width="150">
<div align="center" class="style1">Status </div>
</td>
<td width="70" colspan="2">
<div align="center" class="style1">Action</div>
</td>
<td width="150">
<div align="center" class="style1">Comment</div>
</td>
</thead>

<?php $row = 0; ?>

<?php
if ($totalRows_recpat != 0) {
do {
$row++;
/*colour code for row*/
$statclr = $row_recpat['appointment_status'];
$color1 = "#FFA7FF"; //pending appoinment
$color2 = "#FF968A"; // Pending For Echo Procedure 
$color3 = "#DEDAD0"; // Patient Rejected
$color4 = "#FFFFB5"; // Report Ready (Validated)
$color5 = "#77DD77"; //Report Ready (Not Validated)
?>

<tbody>
<tr bgcolor="<?php
        if ($statclr == 1 or $statclr == 0) {
          echo $color1;
        } else if ($statclr == 2) {
          echo "$color2";
        } else if ($statclr == 3) {
          echo "$color3";
        } else if ($statclr == 6) {
          echo "$color4";
        } else {
          echo "$color5";
        }
        ?>">

<td><?php if ($row_recpat['Reg_Date'] != '0000-00-00') {
  echo date('d/m/Y', strtotime($row_recpat['Reg_Date']));
} ?> &nbsp;
</td>

<td><?php echo $row_recpat['Pat_Name']; ?> <br>
<?php echo $row_recpat['Pat_Ic']; ?>&nbsp;</td>

<td><?php echo $row_recpat['Pat_Wad']; ?>&nbsp;</td>

<td><?php if ($row_recpat['App_Date'] != '0000-00-00') {
  echo date('d/m/Y', strtotime($row_recpat['App_Date']));
} ?> <br>
<?php if ($row_recpat['App_Time'] != '00:00:00') {
echo date('h:i:a', strtotime($row_recpat['App_Time']));
} ?> &nbsp;
</td>

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
  echo "&#8226" . $row_recinditype['indication_name'] . "<br>";
} while ($row_recindi = mysqli_fetch_assoc($recindi));

?>
</td>

<td><?php $pattype = $row_recpat['Pat_Type'];
mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
echo $row_recpattype['patient_type'];
?>&nbsp;<br> </td>

<td><?php $statapp = $row_recpat['appointment_status'];
mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
echo $row_recappstatus['appointment_status'];
?>&nbsp;<br> </td>

<td><?php echo $row_recpat['reason']; ?>&nbsp;</td>
</tr>

<?php } while ($row_recpat = mysqli_fetch_assoc($recpat));
} else { ?>
<tr align="center">
<td height="27" colspan="15">-- No Record --</td>
</tr>
<?php } ?>
</table>

</table>
</tbody>
</div>
</td>
</tr>
</div>
</body>
</html>