<?php  require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];

mysqli_select_db($conn, $database_conn);
$query_recJGred = "SELECT * FROM pos_tbl ORDER BY pos_name ASC";
$recJGred = mysqli_query($conn, $query_recJGred) or die(mysqli_error($conn));
$row_recJGred = mysqli_fetch_assoc($recJGred);
$totalRows_recJGred = mysqli_num_rows($recJGred);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>


<script>
function validate(f) {

	if (f.ddljaw.value == "0") {
		alert("Please Enter Position");
		f.ddljaw.focus();
		return(false);
	}

	var tbLen = f.txtgred.value.trim().length;
	if (tbLen == 0) {
		alert("Please Enter New Grade");
		f.txtgred.focus();
		return(false);
	}
}

function functoupcs(a){
var x=document.getElementById(a);
x.value=x.value.toUpperCase();
}
</script>

<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<?php if ($x == 1) { // add  ?>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr>
		  <td><a href="list_jawatan.php?x=0">Back</a></td>
		</tr>
    <tr align="center" bgcolor="#1690A7">
      <td ><span class="style1">Add Grade </span></td>
    </tr>

   <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_gred_exec.php?x=1">
	<table width="600" border="0" cellspacing="0" cellpadding="2" >
      <tr>
        <td>Position</td>
        <td>:</td>
        <td><select name="ddljaw" id="ddljaw">
              <option value="0">Please Choose</option>
              <?php
        do {
        ?>
              <option value="<?php echo $row_recJGred['pos_id']?>"><?php echo $row_recJGred['pos_name']?></option>
              <?php
        } while ($row_recJGred = mysqli_fetch_assoc($recJGred));
          $rows = mysqli_num_rows($recJGred);
          if($rows > 0) {
              mysqli_data_seek($recJGred, 0);
              $row_recJGred = mysqli_fetch_assoc($recJGred);
          }
        ?>
            </select></td>
      </tr>
      <tr>
        <td>New Grade</td>
        <td>:</td>
        <td><textarea name="txtgred" id="txtgred" onkeyup="functoupcs('txtgred');" cols="50" rows="4"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="Hantar" value="Submit" /></td>
      </tr>
    </table>
	 </form>

	</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center" bgcolor="#1690A7">
    <td ><span class="style1">&nbsp; </span></td>
  </tr>


</table>
<?php } else { // edit
	$gid = $_GET['gid'];

	mysqli_select_db($conn, $database_conn);
	$query_recjgred = "SELECT * from gred_tbl a LEFT JOIN pos_tbl b ON a.pos_id = b.pos_id WHERE a.gred_id = '$gid'";
	$recjgred = mysqli_query($conn, $query_recjgred) or die(mysqli_error($conn));
	$row_recjgred = mysqli_fetch_assoc($recjgred);
	$totalRows_recjgred = mysqli_num_rows($recjgred);

?>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
  <td><a href=list_jawatan.php?x=0>Back</a></td>
  </tr>
  <tr align="center" bgcolor="#1690A7">
    <td ><span class="style1">Update Grade </span></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_gred_exec.php?x=2">
	<table width="600" border="0" cellspacing="0" cellpadding="2" >
      <tr>
        <td>Position</td>
        <td>:</td>
        <td><?php echo $row_recjgred['pos_name']?></td>
      </tr>
      <tr>
        <td>Grade </td>
        <td>:</td>
        <td><textarea name="txtgred" id="txtgred" onkeyup="functoupcs('txtgred');" cols="50" rows="4"><?php echo $row_recjgred['gred_no']?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recjgred["gred_id"]; ?>" /></td>
        <td><input type="submit" name="Hantar" value="Submit" /></td>
      </tr>
    </table>
	 </form>

	</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
 <tr align="center" bgcolor="#1690A7">
    <td ><span class="style1">&nbsp; </span></td>
  </tr>

</table>
<?php } ?>
</body>
</html>
<?php
mysqli_free_result($recJGred);
?>
