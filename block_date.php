<?php
require_once('auth.php');
require_once('Connections/conn.php');

$id = $_SESSION['SESS_MEMBER_ID'];

mysqli_select_db($conn, $database_conn);
$query_reclogindetail = "SELECT * FROM  login a LEFT JOIN block_date b ON a.login_id=b.blockedby_id WHERE a.login_id = '$id'";
$reclogindetail = mysqli_query($conn, $query_reclogindetail) or die(mysqli_error($conn));
$row_reclogindetail = mysqli_fetch_assoc($reclogindetail);
$totalRows_reclogindetail = mysqli_num_rows($reclogindetail);

mysqli_select_db($conn, $database_conn);
$query_recblockdate = "SELECT * FROM  block_date ";
$recblockdate = mysqli_query($conn, $query_recblockdate) or die(mysqli_error($conn));
$row_recblockdate = mysqli_fetch_assoc($recblockdate);
$totalRows_recblockdate = mysqli_num_rows($recblockdate);

$ROW = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><title>Block To Reserve Date</title></head>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>Untitled Document</title>

<script type="text/javascript">

function validate(f) {

var tbLen7 = f.txtblockdate.value.trim().length;
if (tbLen7 == 0) {
alert("Please enter date to reserve!");
// f.txtdateecho.focus();
return(false); 
}

}

</script>

</head>

<body>
<div class="container" align="center">
<form id="form1" name="form1" method="post" action = "block_date_exec.php" onSubmit="return validate(this)">
<table align="center" width="900" >
<tr>
<h3><center>Please enter date to reserve</center></h3>
</tr>
<div class="panel-body" align="center">

<div class="form-group" align="center">

<div class="form-group">
<label for="txtblockdate"> Date </label>
<input type="date" class="form-control" id="txtblockdate" name="txtblockdate" placeholder="Input date to block"/>
</div>



<input type="hidden" name="txtid" id="txtid" value="<?php echo $row_reclogindetail["login_id"]; ?>" />
<input type="hidden" name="txtblockername" id="txtblockername" value="<?php echo $row_reclogindetail["name"]; ?>" />
<button type="submit" name="Submit" id="Submit" class="btn btn-o btn-primary">Submit</button>

<div id="txtHint">

<table class="table table-bordered table-hover" align="center">
<thead>
  <tr align="center" bgcolor="#1690A7">
    <td><strong><div align="center" class="style1">No</div></td>
    <td><strong><div align="center" class="style1">Date </div></td>
    <td><strong><div align="center" class="style1">Blocked by  </div></td>
    <td><strong><div align="center" class="style1">Time of entry </div></td>

  </tr>
</thead>

    <?php do {
 $ROW++;
 ?>
<tbody>
      <tr>
       <td width="75" align="center"><?php echo $ROW; ?></td>
       <td align="center"><?php echo date('Y-m-d', strtotime($row_recblockdate['datetoblock'])); ?></td>
       <td align="center"><?php echo $row_recblockdate['blocker_name']; ?></td>
       <td align="center"><?php echo $row_recblockdate['dateofblock']; ?></td>
         </tr>
    <?php } while ($row_recblockdate = mysqli_fetch_assoc($recblockdate)); ?></table>
</div>	</td>

</tr>
<tr>
<td>&nbsp;</td>
</tr>
</tbody>
</div>
</body>
</html>
<?php
mysqli_free_result($recblockdate);
?>
