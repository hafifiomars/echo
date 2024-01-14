<?php require_once('auth.php');
require_once('Connections/conn.php');

$ROW = 0;
$id = $_SESSION['SESS_MEMBER_ID'];
$type = $_SESSION['SESS_TYPE'];

mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * from patient_type_tbl WHERE patient_type_flag=0 ORDER BY patient_type ASC"; //for search based on patient type
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
$totalRows_recpattype = mysqli_num_rows($recpattype);

mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * from app_status WHERE flag_as=0 ORDER BY appointment_status ASC"; //for search based on status tempahan 
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
$totalRows_recappstatus = mysqli_num_rows($recappstatus);

if ($type == 1) { //admin

// pagination start
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recpat = 20;
$pageNum_recpat = 0;
if (isset($_GET['pageNum_recpat'])) {
    $pageNum_recpat = $_GET['pageNum_recpat'];
}
$startRow_recpat = $pageNum_recpat * $maxRows_recpat;

// pagination end

mysqli_select_db($conn, $database_conn);
$query_recpat = "SELECT * from app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id) WHERE app_flag=0
ORDER BY FIELD(A.appointment_status, 1, 2, 3, 4, 6, 5) , A.Reg_Date DESC ";
$query_limit_recpat = sprintf("%s LIMIT %d, %d", $query_recpat, $startRow_recpat, $maxRows_recpat);
$recpat = mysqli_query($conn, $query_limit_recpat) or die(mysqli_error($conn));
$row_recpat = mysqli_fetch_assoc($recpat);

// pagination start
if (isset($_GET['totalRows_recpat'])) {
    $totalRows_recpat = $_GET['totalRows_recpat'];
} else { //user
    $all_recpat = mysqli_query($conn, $query_recpat);
    $totalRows_recpat = mysqli_num_rows($all_recpat);
}
$totalPages_recpat = ceil($totalRows_recpat / $maxRows_recpat) - 1;

$queryString_recpat = "";
if (!empty($_SERVER['QUERY_STRING'])) {
$params = explode("&", $_SERVER['QUERY_STRING']);
$newParams = array();
foreach ($params as $param) {
    if (
        stristr($param, "pageNum_recpat") == false &&
        stristr($param, "totalRows_recpat") == false
    ) {
        array_push($newParams, $param);
    }
}
if (count($newParams) != 0) {
    $queryString_recpat = "&" . htmlentities(implode("&", $newParams));
}
}
$queryString_recpat = sprintf("&totalRows_recpat=%d%s", $totalRows_recpat, $queryString_recpat);

// pagination end 

} elseif ($type == 2) { //user
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recpatuser = 20;
$pageNum_recpatuser = 0;
if (isset($_GET['pageNum_recpatuser'])) {
    $pageNum_recpatuser = $_GET['pageNum_recpatuser'];
}
$startRow_recpatuser = $pageNum_recpatuser * $maxRows_recpatuser;

// pagination end

mysqli_select_db($conn, $database_conn);
$query_recpatuser = "SELECT * from app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id) 
WHERE login_id = '$id' && app_flag=0 ORDER BY FIELD(A.appointment_status, 1, 2, 3, 4, 6, 5) , A.Reg_Date DESC ";

$query_limit_recpatuser = sprintf("%s LIMIT %d, %d", $query_recpatuser, $startRow_recpatuser, $maxRows_recpatuser);
$recpatuser = mysqli_query($conn, $query_limit_recpatuser) or die(mysqli_error($conn));
$row_recpatuser = mysqli_fetch_assoc($recpatuser);

// pagination start
if (isset($_GET['totalRows_recpatuser'])) {
    $totalRows_recpatuser = $_GET['totalRows_recpatuser'];
} else {
    $all_recpatuser = mysqli_query($conn, $query_recpatuser);
    $totalRows_recpatuser = mysqli_num_rows($all_recpatuser);
}
$totalPages_recpatuser = ceil($totalRows_recpatuser / $maxRows_recpatuser) - 1;

$queryString_recpatuser = "";
if (!empty($_SERVER['QUERY_STRING'])) {
$params = explode("&", $_SERVER['QUERY_STRING']);
$newParams = array();
foreach ($params as $param) {
    if (
        stristr($param, "pageNum_recpatuser") == false &&
        stristr($param, "totalRows_recpatuser") == false
    ) {
        array_push($newParams, $param);
    }
}
if (count($newParams) != 0) {
    $queryString_recpatuser = "&" . htmlentities(implode("&", $newParams));
}
}
$queryString_recpatuser = sprintf("&totalRows_recpatuser=%d%s", $totalRows_recpatuser, $queryString_recpatuser);


} elseif ($type == 0) { //reviewer
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recpatreviewer = 20;
$pageNum_recpatreviewer = 0;
if (isset($_GET['pageNum_recpatreviewer'])) {
    $pageNum_recpatreviewer = $_GET['pageNum_recpatreviewer'];
}
$startRow_recpatreviewer = $pageNum_recpatreviewer * $maxRows_recpatreviewer;

// pagination end

mysqli_select_db($conn, $database_conn);
$query_recpatreviewer = "SELECT * from app_form as A  
left join patient_tbl as B on(A.pat_id=B.pat_id) 
WHERE app_flag=0 && appointment_status=5 ORDER BY Reg_Date DESC ";

$query_limit_recpatreviewer = sprintf("%s LIMIT %d, %d", $query_recpatreviewer, $startRow_recpatreviewer, $maxRows_recpatreviewer);
$recpatreviewer = mysqli_query($conn, $query_limit_recpatreviewer) or die(mysqli_error($conn));
$row_recpatreviewer = mysqli_fetch_assoc($recpatreviewer);

// pagination start
if (isset($_GET['totalRows_recpatreviewer'])) {
    $totalRows_recpatreviewer = $_GET['totalRows_recpatreviewer'];
} else {
    $all_recpatreviewer = mysqli_query($conn, $query_recpatreviewer);
    $totalRows_recpatreviewer = mysqli_num_rows($all_recpatreviewer);
}
$totalPages_recpatreviewer = ceil($totalRows_recpatreviewer / $maxRows_recpatreviewer) - 1;

$queryString_recpatreviewer = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (
            stristr($param, "pageNum_recpatreviewer") == false &&
            stristr($param, "totalRows_recpatreviewer") == false
        ) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_recpatreviewer = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_recpatreviewer = sprintf("&totalRows_recpatreviewer=%d%s", $totalRows_recpatreviewer, $queryString_recpatreviewer);
    
}else { //verify

// pagination start
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recver = 20;
$pageNum_recver = 0;
if (isset($_GET['pageNum_recver'])) {
    $pageNum_recver = $_GET['pageNum_recver'];
}
$startRow_recver = $pageNum_recver * $maxRows_recver;

// pagination end

mysqli_select_db($conn, $database_conn);
$query_recver = "SELECT * from app_form as A 
left join login as B on(A.loginID = B.login_id) 
left join patient_tbl as C on(A.pat_id=C.pat_id) WHERE app_flag=0
ORDER BY FIELD(A.appointment_status, 1, 2, 3, 4, 6, 5) , A.Reg_Date DESC ";

$query_limit_recver = sprintf("%s LIMIT %d, %d", $query_recver, $startRow_recver, $maxRows_recver);
$recver = mysqli_query($conn, $query_limit_recver) or die(mysqli_error($conn));
$row_recver = mysqli_fetch_assoc($recver);

// pagination start
if (isset($_GET['totalRows_recver'])) {
    $totalRows_recver = $_GET['totalRows_recver'];
} else { //user
    $all_recver = mysqli_query($conn, $query_recver);
    $totalRows_recver = mysqli_num_rows($all_recver);
}
$totalPages_recver = ceil($totalRows_recver / $maxRows_recver) - 1;

$queryString_recver = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (
            stristr($param, "pageNum_recver") == false &&
            stristr($param, "totalRows_recver") == false
        ) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_recver = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_recver = sprintf("&totalRows_recver=%d%s", $totalRows_recver, $queryString_recver);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Content-Type" content="text/html; charset=iso-8859-1" >
<title>Echo Patient List</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script language="javascript" type="text/javascript" src="function/datetimepicker.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="jspdf/tableExport.js"></script>
<script type="text/javascript" src="jspdf/jquery.base64.js"></script>

<script type="text/javascript">

function auto_grow(element) {
element.style.height = "5px";
element.style.height = (element.scrollHeight) + "px";
                        }
                        
function showUser(str) //search box
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

var namevalue = encodeURIComponent(document.getElementById("txtSearch").value);

xmlhttp.open("GET", "get_booking.php?m=" + namevalue + "&l=" + str, true);
//xmlHttp.send(params); 
xmlhttp.send();
}

function showUser2(str2, str3) //search based on Status Tempahan
{
if (str2 == "") {
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

xmlhttp.open("GET", "get_search_appstat.php?t=" + str2, true);
//xmlHttp.send(params); 
xmlhttp.send();
}

function showUser3(str2, str3) //search based on patient type
{
if (str2 == "") {
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

xmlhttp.open("GET", "get_search_pattype.php?t=" + str2, true);
//xmlHttp.send(params); 
xmlhttp.send();
}
</script>


<style type="text/css">
.style1 {
color: #FFFFFF;
font-weight: bold;}
</style>
</head>

<body>
<div class="container" align="center">

  <tr>
    <h2><center>Patient Echocardiogram List</center></h2>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr> 

<tr>
<td><form id="form1" name="form1" method="post" action="">

<table width="695" border="0" align="center">
    <tr>
  <td width="393"><label>
  <input class="form-control" name="txtSearch" type="text" id="txtSearch" size="60" />   
  </label></td>
  <td width="292"><label>
    <select class="form-control" name="ddlsearch" id="ddlsearch" onclick="showUser(this.value)">
      <option value="0">Please Choose</option>
      <option value="1">Name</option>
      <option value="2">IC</option>
      <option value="3">Appoinment Date (yyyy-mm-dd)</option>
      
    </select>
  </label></td>
</tr>
</table>

<p>&nbsp;</p>

<table width="550" border="0" align="center">
<tr>
<td width="200" align="right">Appointment Status &nbsp;&nbsp;&nbsp;</td>
<td width="400" align="left">
<select class="form-control" name="users" onchange="showUser2(this.value)">
  <option value="0">Echo Status</option>
  <?php
    do {
    ?>
    <option value="<?php echo $row_recappstatus['appointmentstatusID'] ?>"><?php echo $row_recappstatus['appointment_status'] ?></option>
    <?php
    } while ($row_recappstatus = mysqli_fetch_assoc($recappstatus));
    $rows = mysqli_num_rows($recappstatus);
    if ($rows > 0) {
        mysqli_data_seek($recappstatus, 0);
        $row_recappstatus = mysqli_fetch_assoc($recappstatus);
    }
    ?>

</select>
</td>
</tr>

<tr>
  <td width="200" align="right">Patient Type &nbsp;&nbsp;&nbsp;</td>
  
  <td width="400" align="left">
  <select class="form-control" name="users" onchange="showUser3(this.value)">
    <option value="0">Please Choose</option>
    <?php
    do {
    ?>
    <option value="<?php echo $row_recpattype['patient_type_id'] ?>"><?php echo $row_recpattype['patient_type'] ?></option>
    <?php
    } while ($row_recpattype = mysqli_fetch_assoc($recpattype));
    $rows = mysqli_num_rows($recpattype);
    if ($rows > 0) {
        mysqli_data_seek($recpattype, 0);
        $recpattype = mysqli_fetch_assoc($recpattype);
    }
    ?>  

  </select>
  </td>
 	 </tr>
</table>
</form>  </td>
</tr>
  
<tr align="center">
<td>&nbsp;</td>
</tr>



<!-- -------------------------------------------------------------------------------------------------------------------------------->


<?php if ($type == 1) { //rekod admin sides 
  ?>

<tr>
<td>
<div id="txtHint">

<p><center><strong><font color="#FF4A4A"><?php echo $totalRows_recpat; ?></font> record found &nbsp;&nbsp;&nbsp; </strong></center></p>
<img src="img/legend.png"  width="1000" height="30" ><br>

<table border="0" width="50%" align="center">
<tr>

<td width="23%" align="center"><?php if ($pageNum_recpat > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, 0, $queryString_recpat); ?>">First</a>
 <?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpat > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, max(0, $pageNum_recpat - 1), $queryString_recpat); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpat < $totalPages_recpat) { // Show if not last page  ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, min($totalPages_recpat, $pageNum_recpat + 1), $queryString_recpat); ?>">Next</a>
<?php } // Show if not last page  ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpat < $totalPages_recpat) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, $totalPages_recpat, $queryString_recpat); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
</table>

<table class="table table-bordered" align="center" >

<thead>
<tr align="center" bgcolor="#db420f"  >
    <td width="120"><div align="center" class="style1">Reg Date </div></td>
    <td width="250"><div align="center" class="style1">Name / IC</div></td> 
    <td width="1"><div align="center" class="style1">Ward</div></td>
    <td width="80"><div align="center" class="style1">Height / Weight</div></td>
    <td width="120"><div align="center" class="style1">App Date-Time </div></td> 
    <td width="300"><div align="center" class="style1">Indication</div></td>      
    <td width="80"><div align="center" class="style1">Patient Type</div></td>
    <td width="150"><div align="center" class="style1">Status </div></td> 
    <td width="70" colspan="2"><div align="center" class="style1">Action</div></td>      
    <td width="150"><div align="center" class="style1">Comment</div></td> 
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
<td><?php echo $row_recpat['Height'];?>cm <br> <?php echo $row_recpat['Weight']; ?>kg&nbsp;</td>
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
?>&nbsp;<br>
</td> 


<td><?php $statapp = $row_recpat['appointment_status'];
mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
echo $row_recappstatus['appointment_status'];
?>&nbsp;<br> 
</td>          


<?php if ($statapp == 5) {?>
<td width="170" align="center">
    <a href="del_booking_exec.php?id=<?php echo $row_recpat['borang_id']; ?>" onclick="return show_confirm()" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/delete-icon.png" width="40" height="40"/></a><br>
    <a href="edit_view_record.php?x=3&id=<?php echo $row_recpat['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35" /></a>
 </td>
 
<?php } else {?>

<td width="170" align="center"><a href="edit_view_record.php?x=1&id=<?php echo $row_recpat['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span><img class="btn" src="img/app_icon.png" width="40" height="40" /> </a>
<a href="edit_view_record.php?x=2 &id=<?php echo $row_recpat['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/edits.png" width="40" height="40"/></a> 
<a href="del_booking_exec.php?id=<?php echo $row_recpat['borang_id']; ?>" onclick="return show_confirm()" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/delete-icon.png" width="40" height="40"/></a><br>      
<a href="edit_view_record.php?x=3&id=<?php echo $row_recpat['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35"/></a></td>
<?php }?>

<?php if ($statapp == 1) {?>
<td> </td>
<?php } elseif ($statapp == 2) {?>
<td width="75" align="center"><button class="btn"><a href="echo_report.php?er=1&brid=<?php echo $row_recpat['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></td>
<?php } elseif ($statapp == 3) {?> 
<td> </td>
<?php } elseif ($statapp == 4) { ?>
<td> </td>
<?php } elseif ($statapp == 5) {?>
<td width="75" align="center">
<button class="btn"><a href="echo_report_view.php?er=2&brid=<?php echo $row_recpat['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></br>
<a href="edit_echo_report.php?er=3&brid=<?php echo $row_recpat['borang_id']; ?>"> <img src="img/edit-report.png" width="40" height="40"/></a>
</td>
<?php } elseif ($statapp == 6) {?>
<td width="75" align="center"><button class="btn"><a href="echo_report.php?er=4&brid=<?php echo $row_recpat['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></td>
<?php } else {?>
<td>system error</td>
<?php }?>

<td><br><textarea readonly style="height: 200px ; background-color: #00FFCC" oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason'];  ?>  </textarea>
<br>
<a style="background-color:yellow;" >LAST UPDATE :</a> <br>
<?php

$id = $row_recpat['borang_id'];
mysqli_select_db($conn, $database_conn);
$query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$id'";
$rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
$row_rececho4 = mysqli_fetch_assoc($rececho4);
$totalRows_rececho4 = mysqli_num_rows($rececho4);

mysqli_select_db($conn, $database_conn);
$query_recstatusapp = "SELECT * FROM app_form WHERE borang_id='$id'";
$recstatusapp = mysqli_query($conn, $query_recstatusapp) or die(mysqli_error($conn));
$row_recstatusapp = mysqli_fetch_assoc($recstatusapp);
$totalRows_recstatusapp = mysqli_num_rows($recstatusapp);
$status_application = $row_recstatusapp ['appointment_status'];

if ($status_application == 5 || $status_application == 6) {

  echo $row_rececho4['updatedttm'];

} else {

  echo $row_recstatusapp['edit_dttm']; 

}?>
&nbsp;
</td>
</tr>

<?php } while ($row_recpat = mysqli_fetch_assoc($recpat));
} else { ?>
<tr align="center"> 
<td height="27" colspan="15">-- No Record --</td>
</tr>
<?php } ?>
</table>

</table>

<table border="0" width="50%" align="center">
<tr>
<td width="23%" align="center"><?php if ($pageNum_recpat > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, 0, $queryString_recpat); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpat > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, max(0, $pageNum_recpat - 1), $queryString_recpat); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpat < $totalPages_recpat) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, min($totalPages_recpat, $pageNum_recpat + 1), $queryString_recpat); ?>">Next</a>
<?php } // Show if not last page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpat < $totalPages_recpat) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpat=%d%s", $currentPage, $totalPages_recpat, $queryString_recpat); ?>">Last</a>
<?php } // Show if not last page ?>
</td>

</tr>
</table>
</tbody>

</div>
</div>

<p>&nbsp;</p>
</tbody>
</div>
</table>



<?php mysqli_free_result($recpat);?>


<!-- -------------------------------------------------------------------------------------------------------------------------------->


<?php } elseif ($type == 2) { //  user sides ?>

<tr>
<td>
<div id="txtHint">
<p><center><strong><font color="#FF4A4A"><?php echo $totalRows_recpatuser; ?></font> record found &nbsp;&nbsp;&nbsp; </strong></center></p>
<img src="img/legend.png"  width="1000" height="30">

<table border="0" width="50%" align="center">
<tr>
<td width="23%" align="center"><?php if ($pageNum_recpatuser > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, 0, $queryString_recrecpatuser); ?>">First</a>
<?php } // Show if not first page  ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpatuser > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, max(0, $pageNum_recrecpatuser - 1), $queryString_recrecpatuser); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatuser < $totalPages_recpatuser) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, min($totalPages_recrecpatuser, $pageNum_recrecpatuser + 1), $queryString_recrecpatuser); ?>">Next</a>
<?php } // Show if not last page?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatuser < $totalPages_recpatuser) { ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, $totalPages_recrecpatuser, $queryString_recrecpatuser); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
<tr>
</table>

<table class="table table-bordered" align="center" >
<thead>
<tr align="center" bgcolor="#2C3E50"  >
          
  <td width="120"><div align="center" class="style1">Reg Date </div></td>
  <td width="250"><div align="center" class="style1">Name / IC</div></td> 
  <td width="80"><div align="center" class="style1">Ward</div></td> 
  <td width="80"><div align="center" class="style1">Height / Weight </div></td> 
  <td width="120"><div align="center" class="style1">App Date-Time </div></td> 
  <td width="300"><div align="center" class="style1">Indication</div></td>      
	<td width="80"><div align="center" class="style1">Patient Type</div></td>
  <td width="150"><div align="center" class="style1">Status </div></td> 
  <td width="70" colspan="2"><div align="center" class="style1">Action</div></td>      
  <td width="150"><div align="center" class="style1">Comment</div></td> 

</thead>

<?php $row = 0; ?>

<?php
if ($totalRows_recpatuser != 0) {
   do {
       $row++;
       /*colour code for row*/
       $statclr = $row_recpatuser['appointment_status'];
       $color1 = "#FFA7FF"; //pending appoinment
       $color2 = "#FF968A"; // Pending For Echo Procedure 
       $color3 = "#DEDAD0"; // Patient Rejected
       $color4 = "#FFFFB5"; // Report Ready (Not Validated)
       $color5 = "#77DD77"; //Report Ready (Validated)
?>


  <tbody>
   <tr bgcolor="<?php
     if ($statclr == 1 or $statclr == 0) { // status tempahan baru 
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


<td><?php if ($row_recpatuser['Reg_Date'] != '0000-00-00') {
echo date('d/m/Y', strtotime($row_recpatuser['Reg_Date']));} ?>
&nbsp;
</td> 

<td><?php echo $row_recpatuser['Pat_Name']; ?> <br> 
<?php echo $row_recpatuser['Pat_Ic']; ?>&nbsp;
</td>

<td><?php echo $row_recpatuser['Pat_Wad']; ?>&nbsp;</td>

<td><?php echo $row_recpatuser['Height'];?>cm <br> <?php echo $row_recpatuser['Weight']; ?>kg&nbsp;</td>
          
<td><?php if ($row_recpatuser['App_Date'] != '00-00-0000') {
      echo date('d/m/Y', strtotime($row_recpatuser['App_Date']));
      } ?> <br> 
      <?php if ($row_recpatuser['App_Time'] != '00:00:00') {
      echo date('h:i:a', strtotime($row_recpatuser['App_Time']));
      } ?> &nbsp;
</td>

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
   echo "&#8226" . $row_recinditype['indication_name'] . "<br>";
   } while ($row_recindi = mysqli_fetch_assoc($recindi));
?>
</td>


<td>
<?php 
$pattype = $row_recpatuser['Pat_Type'];
mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
echo $row_recpattype['patient_type'];
?>&nbsp;
<br> 
</td> 

<td><?php
$statapp = $row_recpatuser['appointment_status'];
mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
echo $row_recappstatus['appointment_status'];
?>&nbsp;</td> 

<?php if ($statapp == 1) { //able to edit if pending appoinment
?>
<td width="75" align="center"><a href="edit_view_record.php?x=2 &id=<?php echo $row_recpatuser['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/edits.png" width="40" height="40"/></a> <br></td>
<?php
} else {
?>
<td withd="75" align="center"> <a href="edit_view_record.php?x=3&id=<?php echo $row_recpatuser['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35"/></a></td> 
<?php } ?>

<?php if ($statapp == 1) {
?><td> </td>
<?php
} elseif ($statapp == 2) {
?><td> </td>
<?php
} elseif ($statapp == 3) {
?><td> </td>
<?php
} elseif ($statapp == 4) {
?><td> </td>
<?php
} elseif ($statapp == 5) {
?><td width="75" align="center"><button class="btn"><a href="echo_report_view.php?er=2&brid=<?php echo $row_recpatuser['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button>
</td>
<?php
} else {
?><td> </td>
<?php }



?>
<td><br><textarea readonly style="height: 200px ; background-color: #00FFCC" oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recpatuser['reason'];  ?>  </textarea>
<br>


<br>
<br>

<a style="background-color:yellow;" >LAST UPDATE :</a>
<?php
$id = $row_recpatuser['borang_id'];
mysqli_select_db($conn, $database_conn);
$query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$id'";
$rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
$row_rececho4 = mysqli_fetch_assoc($rececho4);
$totalRows_rececho4 = mysqli_num_rows($rececho4);
echo $row_rececho4['updatedttm']; ?> &nbsp;</td>



<?php } while ($row_recpatuser = mysqli_fetch_assoc($recpatuser));
} else { ?>
<tr align="center"> 
<td height="27" colspan="15">-- No Record --</td>
</tr>
<?php } ?>
</table>
<table border="0" width="50%" align="center">
<tr>

<td width="23%" align="center"><?php if ($pageNum_recpatuser > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, 0, $queryString_recrecpatuser); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpatuser > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, max(0, $pageNum_recrecpatuser - 1), $queryString_recrecpatuser); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatuser < $totalPages_recpatuser) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, min($totalPages_recrecpatuser, $pageNum_recrecpatuser + 1), $queryString_recrecpatuser); ?>">Next</a>
<?php } // Show if not last page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatuser < $totalPages_recpatuser) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recrecpatuser=%d%s", $currentPage, $totalPages_recrecpatuser, $queryString_recrecpatuser); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
<tr>

</table>
</tbody>
</div>
</div>
</table>
</body>
</html>

<?php mysqli_free_result($recpatuser);?>

<!-- -------------------------------------------------------------------------------------------------------------------------------->


<?php } elseif ($type == 0) { //  reviewer sides ?>
<tr>
<td>
<div id="txtHint">
<p><center><strong><font color="#FF4A4A"><?php echo $totalRows_recpatreviewer; ?></font> record found &nbsp;&nbsp;&nbsp; </strong></center></p>

<img src="img/legend.png"  width="1000" height="30"><br>
<table border="0" width="50%" align="center">
<tr>
<td width="23%" align="center"><?php if ($pageNum_recpatreviewer > 0) { // Show if not first page 
                      ?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, 0, $queryString_recpatreviewer); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpatreviewer > 0) { // Show if not first page?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, max(0, $pageNum_recpatreviewer - 1), $queryString_recpatreviewer); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatreviewer < $totalPages_recpatreviewer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, min($totalPages_recpatreviewer, $pageNum_recpatreviewer + 1), $queryString_recpatreviewer); ?>">Next</a>
<?php } // Show if not last page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatreviewer < $totalPages_recpatreviewer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, $totalPages_recpatreviewer, $queryString_recpatreviewer); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
<tr>
</table>

<table class="table table-bordered" align="center" >
<thead>
<tr align="center" bgcolor="#2C3E50"  > 
<td width="120"><div align="center" class="style1">Reg Date </div></td>
<td width="250"><div align="center" class="style1">Name / IC</div></td> 
<td width="80"><div align="center" class="style1">Ward</div></td> 
<td width="80"><div align="center" class="style1">Height / Weight</div></td> 
<td width="120"><div align="center" class="style1">App Date-Time </div></td> 
<td width="300"><div align="center" class="style1">Indication</div></td>      
<td width="80"><div align="center" class="style1">Patient Type</div></td>
<td width="150"><div align="center" class="style1">Status </div></td> 
<td width="70" colspan="2"><div align="center" class="style1">Action</div></td>      
<td width="150"><div align="center" class="style1">Comment</div></td> 
</thead>

<?php $row = 0; ?>


<?php
if ($totalRows_recpatreviewer != 0) {
do {
$row++;
/*colour code for row*/
$statclr = $row_recpatreviewer['appointment_status'];
$color1 = "#FFA7FF"; //pending appoinment
$color2 = "#FF968A"; // Pending For Echo Procedure 
$color3 = "#DEDAD0"; // Patient Rejected
$color4 = "#FFFFB5"; // Report Ready (Not Validated)
$color5 = "#77DD77"; //Report Ready (Validated)
?>

<tbody>
<tr bgcolor="<?php
    if ($statclr == 1 or $statclr == 0) { // status tempahan baru 
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
    ?>"> &nbsp;
</td> 
<td><?php if ($row_recpatreviewer['Reg_Date'] != '0000-00-00') {
    echo date('d/m/Y', strtotime($row_recpatreviewer['Reg_Date']));
} ?> &nbsp;
</td> 

<td><?php echo $row_recpatreviewer['Pat_Name']; ?> <br> 
<?php echo $row_recpatreviewer['Pat_Ic']; ?>&nbsp;</td>

<td><?php echo $row_recpatreviewer['Pat_Wad']; ?>&nbsp;</td>

<td><?php echo $row_recpatreviewer['Height'];?>cm <br> <?php echo $row_recpatreviewer['Weight']; ?>kg&nbsp;</td>

<td><?php if ($row_recpatreviewer['App_Date'] != '00-00-0000') {
    echo date('d/m/Y', strtotime($row_recpatreviewer['App_Date']));
} ?> <br> 
<?php if ($row_recpatreviewer['App_Time'] != '00:00:00') {
    echo date('h:i:a', strtotime($row_recpatreviewer['App_Time']));
} ?> &nbsp;
</td>

<td><span class="style4">
<?php
$id = $row_recpatreviewer['borang_id'];
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
} while ($row_recindi = mysqli_fetch_assoc($recindi));?>
</td>


<td><?php $pattype = $row_recpatreviewer['Pat_Type'];
mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
echo $row_recpattype['patient_type'];
?>&nbsp;<br> 
</td> 

<td><?php $statapp = $row_recpatreviewer['appointment_status'];
mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
echo $row_recappstatus['appointment_status'];
?>&nbsp;
</td> 

<?php if ($statapp == 6) { //able to edit if pending appoinment
?>
<td width="75" align="center"><a href="edit_view_record.php?x=2 &id=<?php echo $row_recpatreviewer['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/edits.png" width="40" height="40"/></a> <br></td>
<?php
} else {
?>
<td withd="75" align="center"> <a href="edit_view_record.php?x=3&id=<?php echo $row_recpatreviewer['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35"/></a></td> 
<?php } ?>

<?php if ($statapp == 1) {
?><td> </td>
<?php } elseif ($statapp == 2) {
?><td> </td>
<?php } elseif ($statapp == 3) {
?><td> </td>
<?php } elseif ($statapp == 4) {
?><td> </td>
<?php } elseif ($statapp == 5) {
?>

<td width="75" align="center"><button class="btn"><a href="echo_report_view.php?er=2&brid=<?php echo $row_recpatreviewer['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button>
</td>

<?php } else { ?>

<td></td>

<?php } ?>
<td><br><textarea readonly style="height: 200px ; background-color: #00FFCC" oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recpatreviewer['reason'];  ?>  </textarea>
<br>


<br>
<br>

<a style="background-color:yellow;" >LAST UPDATE :</a>
  <?php
      $id = $row_recpatreviewer['borang_id'];
      mysqli_select_db($conn, $database_conn);
      $query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$id'";
      $rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
      $row_rececho4 = mysqli_fetch_assoc($rececho4);
      $totalRows_rececho4 = mysqli_num_rows($rececho4);
      echo $row_rececho4['updatedttm']; ?> &nbsp;</td>

<?php } while ($row_recpatreviewer = mysqli_fetch_assoc($recpatreviewer));
} else { ?>

<tr align="center"> 
<td height="27" colspan="15">-- No Record --</td>
</tr>

<?php } ?>

</table>
<table border="0" width="50%" align="center">
<tr>
<td width="23%" align="center"><?php if ($pageNum_recpatreviewer > 0) { // Show if not first page?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, 0, $queryString_recpatreviewer); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recpatreviewer > 0) { // Show if not first page?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, max(0, $pageNum_recpatreviewer - 1), $queryString_recpatreviewer); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatreviewer < $totalPages_recpatreviewer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, min($totalPages_recpatreviewer, $pageNum_recpatreviewer + 1), $queryString_recpatreviewer); ?>">Next</a>
<?php } // Show if not last page 
?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recpatreviewer < $totalPages_recpatreviewer) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recpatreviewer=%d%s", $currentPage, $totalPages_recpatreviewer, $queryString_recpatreviewer); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>
<tr>
</table>
</tbody>
</div>
</div>
</table>
</body>
</html>
<?php mysqli_free_result($recpatreviewer);?>


<!-- -------------------------------------------------------------------------------------------------------------------------------->


<?php }else { //verify side ?>

<tr>
<td>
<div id="txtHint">

<p><center><strong>Found <font color="#FF4A4A"><?php echo $totalRows_recver; ?></font> record &nbsp;&nbsp;&nbsp; </strong></center></p>

<img src="img/legend.png"  width="1000" height="30"><br>

<table border="0" width="50%" align="center">
<tr>

<td width="23%" align="center"><?php if ($pageNum_recver > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, 0, $queryString_recver); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recver > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, max(0, $pageNum_recver - 1), $queryString_recver); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recver < $totalPages_recver) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, min($totalPages_recver, $pageNum_recver + 1), $queryString_recver); ?>">Next</a>
<?php } // Show if not last page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recver < $totalPages_recver) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, $totalPages_recver, $queryString_recver); ?>">Last</a>
<?php } // Show if not last page ?>
</td>

</tr>
</table>

<table class="table table-bordered" align="center" id="tableID" >
<thead>
<tr align="center" bgcolor="#2C3E50"  >
<td width="120"><div align="center" class="style1">Reg Date </div></td>
<td width="250"><div align="center" class="style1">Name / IC</div></td> 
<td width="80"><div align="center" class="style1">Ward</div></td> 
<td width="80"><div align="center" class="style1">Height / Weight</div></td> 
<td width="120"><div align="center" class="style1">App Date-Time </div></td> 
<td width="300"><div align="center" class="style1">Indication</div></td>
<td width="70"><div align="center" class="style1">Patient Type</div></td>
<td width="150"><div align="center" class="style1">Status </div></td> 
<td width="70" colspan="2"><div align="center" class="style1">Action</div></td>      
<td width="150"><div align="center" class="style1">Comment</div></td> 
</thead>

<?php $row = 0; ?>

<?php
if ($totalRows_recver != 0) {
  do {
      $row++;
      /*colour code for row*/
      $statclr = $row_recver['appointment_status'];
      $color1 = "#FFA7FF"; //pending appoinment
      $color2 = "#FF968A"; // Pending For Echo Procedure 
      $color3 = "#DEDAD0"; // Patient Rejected
      $color4 = "#FFFFB5"; // Report Ready (Validated)
      $color5 = "#77DD77"; //Report Ready (Not Validated)
?>

<tbody>
<tr bgcolor="<?php
    if ($statclr == 1 or $statclr == 0) { // status tempahan baru 
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

<td><?php if ($row_recver['Reg_Date'] != '0000-00-00') {
            echo date('d/m/Y', strtotime($row_recver['Reg_Date']));
        } ?> &nbsp;
</td> 

<td><?php echo $row_recver['Pat_Name']; ?><br> 
<?php echo $row_recver['Pat_Ic']; ?>&nbsp;
</td>

<td><?php echo $row_recver['Pat_Wad']; ?>&nbsp;</td>

<td><?php echo $row_recver['Height'];?>cm <br> <?php echo $row_recver['Weight']; ?>kg&nbsp;</td>

<td><?php if ($row_recver['App_Date'] != '0000-00-00') {
      echo date('d/m/Y', strtotime($row_recver['App_Date']));
      } ?> <br> 
      <?php if ($row_recver['App_Time'] != '00:00:00') {
      echo date('h:i:a', strtotime($row_recver['App_Time']));
      } ?> &nbsp;
</td>

<td><span class="style4">
<?php
  $id = $row_recver['borang_id'];
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

<td><?php $pattype = $row_recver['Pat_Type'];
    mysqli_select_db($conn, $database_conn);
    $query_recpattype = "SELECT * FROM patient_type_tbl WHERE patient_type_id = '$pattype'";
    $recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
    $row_recpattype = mysqli_fetch_assoc($recpattype);
    echo $row_recpattype['patient_type'];
    ?>
    &nbsp;<br>   
</td> 

<td><?php $statapp = $row_recver['appointment_status'];
        mysqli_select_db($conn, $database_conn);
        $query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
        $recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
        $row_recappstatus = mysqli_fetch_assoc($recappstatus);
        echo $row_recappstatus['appointment_status'];
    ?>
    &nbsp;</td>

<?php if ($statapp == 1) { ?>

<td width="170" align="center"><a href="edit_view_record.php?x=1&id=<?php echo $row_recver['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span><img class="btn" src="img/app_icon.png" width="40" height="40" /> </a>

<a href="edit_view_record.php?x=2 &id=<?php echo $row_recver['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/edits.png" width="40" height="40"/></a> <br></td>
<?php
} else {?>
<td withd="75" align="center"> <a href="edit_view_record.php?x=3&id=<?php echo $row_recver['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35"/></a></td> 
<?php } ?>


<?php if ($statapp == 1) {
?><td> </td>
<?php
        } elseif ($statapp == 2) {
?><td width="75" align="center"><button class="btn"><a href="echo_report.php?er=1&brid=<?php echo $row_recver['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></td>
<?php
        } elseif ($statapp == 3) {
?><td> </td>
<?php
        } elseif ($statapp == 4) {
?><td> </td>
<?php
        } elseif ($statapp == 5) {
?><td width="75" align="center"><button class="btn"><a href="echo_report_view.php?er=2&brid=<?php echo $row_recver['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></br>
<a href="edit_echo_report.php?er=3&brid=<?php echo $row_recver['borang_id']; ?>"> <img src="img/edit-report.png" width="45" height="45"/></a>

</td>
<?php
        } elseif ($statapp == 6) {
?><td width="75" align="center"><button class="btn"><a href="echo_report.php?er=3&brid=<?php echo $row_recver['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></a></button></td>
<?php
        } else { ?> 

<td> </td>

<?php } ?>

<td><br><textarea readonly style="height: 200px ; background-color: #00FFCC" oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recver['reason'];  ?>  </textarea>
<br>
<br>
<br>
<a style="background-color:yellow;" >LAST UPDATE :</a>
  <?php
    $id = $row_recver['borang_id'];
    mysqli_select_db($conn, $database_conn);
    $query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$id'";
    $rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
    $row_rececho4 = mysqli_fetch_assoc($rececho4);
    $totalRows_rececho4 = mysqli_num_rows($rececho4);
    echo $row_rececho4['updatedttm']; 
    ?> 

&nbsp;
</td>
</tr>
<?php } while ($row_recver = mysqli_fetch_assoc($recver));
} else { ?>

<tr align="center"> 
<td height="27" colspan="15">-- No Record--</td>
</tr>

<?php } ?>
</table>

<table border="0" width="50%" align="center">
<tr>
<td width="23%" align="center"><?php if ($pageNum_recver > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, 0, $queryString_recver); ?>">First</a>
<?php } // Show if not first page ?>
</td>

<td width="31%" align="center"><?php if ($pageNum_recver > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, max(0, $pageNum_recver - 1), $queryString_recver); ?>">Previous</a>
<?php } // Show if not first page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recver < $totalPages_recver) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, min($totalPages_recver, $pageNum_recver + 1), $queryString_recver); ?>">Next</a>
<?php } // Show if not last page ?>
</td>

<td width="23%" align="center"><?php if ($pageNum_recver < $totalPages_recver) { // Show if not last page ?>
<a href="<?php printf("%s?pageNum_recver=%d%s", $currentPage, $totalPages_recver, $queryString_recver); ?>">Last</a>
<?php } // Show if not last page ?>
</td>
</tr>

</table>
</tbody>
</div>

</div>

<p>&nbsp;</p>
</tbody>
</div>
</table>

</body>
</html>

<?php mysqli_free_result($recver); ?>

<?php } ?>
</body>
</html>