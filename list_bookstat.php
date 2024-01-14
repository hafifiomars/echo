<?php  require_once('auth.php');
 require_once('Connections/conn.php'); 

mysqli_select_db($conn, $database_conn);
$query_recappstatus = "SELECT * from app_status ORDER BY appointment_status ASC";
$recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
$row_recappstatus = mysqli_fetch_assoc($recappstatus);
$totalRows_recappstatus = mysqli_num_rows($recappstatus);

$ROW = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>Untitled Document</title>
<script type="text/javascript">
function showUser(str,str1)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

var namevalue=encodeURIComponent(document.getElementById("txtSearch").value);

xmlhttp.open("GET","get_bookstat.php?s="+namevalue+"&q="+str,true);
//xmlHttp.send(params); 
xmlhttp.send();
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
<div class="container" align="center">

  <tr>
    <h2><center>Appointment Status</center></h2>
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
              <option value="1">Appointment Status</option>
            </select>
          </label></td>
        </tr>
      </table>
        </form>    </td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><a href="add_bookstat.php?x=1"class="btn btn-warning btn-sm">  <span class="glyphicon glyphicon-plus"></span> Appointment Status </a> </td>
  </tr>
  <tr>
    <td>
  <p>&nbsp;</p>
    <div id="txtHint">
  
  <table class="table table-bordered table-hover" align="center">
    <thead>
      <tr align="center" bgcolor="#1690A7">
        <td><div align="center" class="style1">No </div></td>
        <td><div align="center" class="style1">Appointment Status </div></td>
        <td colspan="3" ><div align="center" class="style1">Action</div></td>
      </tr>
    </thead>

        <?php do {  
   $ROW++;
   
   ?>
    <tbody> 
          <tr>
            <td width="75" align="center"><?php echo $ROW; ?></td>
            <td  align="center"><a href="add_bookstat.php?x=2&id=<?php echo $row_recappstatus['appointmentstatusID']; ?>"><?php echo $row_recappstatus['appointment_status']; ?></a>
           
            <?php if ($row_recappstatus['flag_as']==0) { ?><td width="150" align="center"><a href="stat_bookstat.php?x=1&id=<?php echo $row_recappstatus['appointmentstatusID']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" ></span> Activated </a></td>

            <?php } else { ?><td width="150" align="center"><a href="stat_bookstat.php?x=2&id=<?php echo $row_recappstatus['appointmentstatusID']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Inactived </a></td>
            <?php } ?> </td>
          </tr>
        <?php } while ($row_recappstatus = mysqli_fetch_assoc($recappstatus)); ?></table>
  </div>  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</div>
</body>
</html>
<?php
mysqli_free_result($recappstatus);
?>


