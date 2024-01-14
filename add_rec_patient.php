<?php require_once('auth.php');
require_once('Connections/conn.php');

$ROW = 0;
$id = $_SESSION['SESS_MEMBER_ID'];
$type = $_SESSION['SESS_TYPE'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet">
<title>Search Existing Patient</title>
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>

<script type="text/javascript">

function validate(f) {
		
	var tbLen = f.txtic.value.trim().length;
	if (tbLen == 0) {

		alert("Please insert Identity Card / Passport No ");
		f.txtic.focus();
		return(false);
	}
}	

function onlyAlphanumeric(str){
  str.value=str.value.replace(/\s/g, "");//No Space
  str.value=str.value.replace(/[^a-zA-Z0-9 ]/g, "");
}

</script>

 
<!-- <form id="form1" name="form1" method="post" action="add_rec.php?us=1&x=1" onsubmit="return validate(this)"> -->
<form id="form1" name="form1" method="post" action="view_appointment.php?" onsubmit="return validate(this)">
  <tr>
    <td><table width="500" border="0" bgcolor="#FF968A" bordercolor="#000066" align="center">
      <tr>
        <td colspan="4" bgcolor="#db420f"><div align="center"><strong><span class="style1">Echocardiogram Request</span></strong></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="150"><strong>I/C or Passport No :</strong></td>
        <td width="200"><input name="txtic" type="text" id="txtic" size="17" placeholder="Only number and letter"  onKeyUp="onlyAlphanumeric(this);" /></td>
      </tr>

      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr align="center">
        <td colspan="3"><input type="submit" name="Submit" value="Check History" /></td>
      </tr>
    </table></td>
    </tr>
</form>
  </head>
  </html>


