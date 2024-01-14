<?php  require_once('auth.php');
 require_once('Connections/conn.php');

 $x = $_GET['x'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script>
function validate(f) {


			var tbLen = f.txtjaw.value.trim().length;
			if (tbLen == 0) {
			alert("Please enter position");
			f.txtjaw.focus();
			return(false);
	   }
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
<?php if ($x == 1) { // add new  ?>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr>
		  <td><a href="list_jawatan.php?x=0">Back</a></td>
		</tr>
    <tr align="center" bgcolor="#1690A7">
      <td ><span class="style1">Add Position </span></td>
    </tr>

   <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_jawatan_exec.php?x=1">
	<table width="600" border="0" cellspacing="0" cellpadding="2" >
      <tr>
        <td>New Position</td>
        <td>:</td>
        <td><textarea name="txtjaw" id="txtjaw" cols="50" rows="4"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Submit" /></td>
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
	$posid = $_GET['posid'];

	mysqli_select_db($conn,$database_conn);
	$query_recjwtn = "SELECT * from pos_tbl WHERE pos_id = '$posid'";
	$recjwtn = mysqli_query($conn, $query_recjwtn) or die(mysqli_error($conn));
	$row_recjwtn = mysqli_fetch_assoc($recjwtn);
	$totalRows_recjwtn = mysqli_num_rows($recjwtn);

?>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td><a href=list_jawatan.php?x=0>Back</a></td>
  </tr>
  <tr align="center" bgcolor="#1690A7">
    <td ><span class="style1">Update Position </span></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_jawatan_exec.php?x=2">
	<table width="600" border="0" cellspacing="0" cellpadding="2" >
      <tr>
        <td>Position</td>
        <td>:</td>
        <td><textarea name="txtjaw" id="txtjaw" cols="50" rows="4"><?php echo $row_recjwtn['pos_name']; ?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recjwtn["pos_id"]; ?>" /></td>
        <td><input type="submit" name="Submit" value="Submit" /></td>
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
