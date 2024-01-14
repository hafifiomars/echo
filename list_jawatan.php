<?php  require_once('auth.php');
 require_once('Connections/conn.php');

mysqli_select_db($conn, $database_conn);
$query_recjwtn = "SELECT * from pos_tbl ORDER BY pos_name ASC";
$recjwtn = mysqli_query($conn, $query_recjwtn) or die(mysqli_error($conn));
$row_recjwtn = mysqli_fetch_assoc($recjwtn);
$totalRows_recjwtn = mysqli_num_rows($recjwtn);

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

xmlhttp.open("GET","get_jawatan.php?s="+namevalue+"&q="+str,true);
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
    <h2><center>Position List</center></h2>
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
            <select  class="form-control" name="ddlsearch" id="ddlsearch" onclick="showUser(this.value)">
              <option value="0">Please Choose</option>
              <option value="1">Position</option>
			        <option value="2">Grade</option>
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
    <td><a href="add_jawatan.php?x=1"class="btn btn-warning btn-sm">  <span class="glyphicon glyphicon-plus"></span> Position </a>&nbsp;&nbsp;&nbsp;<a href="add_gred.php?x=1"class="btn btn-warning btn-sm">  <span class="glyphicon glyphicon-plus"></span> Grade </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
  <p>&nbsp;</p>
	<div id="txtHint">

	<table class="table table-bordered table-hover" align="center">
    <thead>
      <tr align="center" bgcolor="#1690A7">
        <td><div align="center" class="style1">No</div></td>
        <td><div align="center" class="style1">Position </div></td>
        <td><div align="center" class="style1">Grade</div></td>
      </tr>
    </thead>

        <?php do {
	 $ROW++;

	 ?>
    <tbody>
        <tr>
          <td width="75" align="center"><?php echo $ROW; ?></td>
          <td align="center"><?php $posid =  $row_recjwtn['pos_id']; ?>
          <a href="add_jawatan.php?x=2&posid=<?php echo $posid; ?>"><?php echo $row_recjwtn['pos_name']; ?></a></td>


          <?php
          mysqli_select_db($conn, $database_conn);
          $query_recjawGred = "SELECT * FROM gred_tbl where pos_id = '$posid' order by gred_no ASC";
          $recjawGred = mysqli_query($conn, $query_recjawGred) or die(mysqli_error($conn));
          $row_recjawGred = mysqli_fetch_assoc($recjawGred);
          $totalRows_recjawGred = mysqli_num_rows($recjawGred);
          ?></td>
          <td align="center">
        <table >
          <?php if ($totalRows_recjawGred != 0){
          do {  $gid = $row_recjawGred['gred_id']; ?>
          <td align="center"><p><a href="add_gred.php?x=2&gid=<?php echo $gid; ?>"><?php echo $row_recjawGred['gred_no']; ?></a></td>

          <?php if ($row_recjawGred['gred_flag']==0) { ?><td width="150" align="center"><p><a href="stat_gred.php?x=1&id=<?php  echo $row_recjawGred['gred_id']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span>Activated</a></td>

          <?php } else { ?><td width="150" align="center"><p><a href="stat_gred.php?x=2&id=<?php echo $row_recjawGred['gred_id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span>Inactivated</a></td><?php } ?> </td></tr>


          <?php
          }while ($row_recjawGred = mysqli_fetch_assoc($recjawGred));

          mysqli_free_result($recjawGred);
          }
          ?></table>
        </td>
      </tr>
            <?php } while ($row_recjwtn = mysqli_fetch_assoc($recjwtn)); ?></table>
  </div>  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</tbody>
</div>
</body>
</html>
<?php
mysqli_free_result($recjwtn);
?>
