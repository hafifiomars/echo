<?php  require_once('auth.php');
 require_once('Connections/conn.php');
 $type = $_SESSION['SESS_TYPE'];

$ROW = 0;
mysqli_select_db($conn, $database_conn);
$query_recUser = "SELECT * FROM login a
          LEFT JOIN userlevel_tbl b ON a.levelUser = b.level_id";
$recUser = mysqli_query($conn, $query_recUser) or die(mysqli_error($conn));
$row_recUser = mysqli_fetch_assoc($recUser);
$totalRows_recUser = mysqli_num_rows($recUser);
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

xmlhttp.open("GET","get_user.php?s="+namevalue+"&q="+str,true);
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
</head>

<body>
<div class="container" align="center">

  <tr>
    <h2><center>User Registration List</center></h2>
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
            <select class="form-control" name="search" id="search" onclick="showUser(this.value)">
              <option value="0">Filter</option>
              <option value="1">Email</option>
              <option value="2">Full name</option>
              <option value="3">Department</option>
              <option value="4">Level User</option>
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
    <td><a href="add_user.php?x=1"class="btn btn-warning btn-sm">  <span class="glyphicon glyphicon-plus"></span> ADD USER </a> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <p>&nbsp;</p>
  <div id="txtHint">
    <table class="table table-bordered table-hover" align="center">
      <thead>
       <tr align="center" bgcolor="#1690A7">
         <td width="38"><div align="center" class="style1">No</div></td>
          <td width="100"><div align="center" class="style1">Date Register</div></td>
         <td width="180"> <div align="center" class="style1">Full Name</div></td>
         <td width="170"><div align="center" class="style1">Department</div></td>
         <td width="180"><div align="center" class="style1">Email </div></td>
         <td width="70"><div align="center" class="style1">Level </div></td>
         <td colspan="3" ><div align="center" class="style1">Action</div></td>
        </tr>
       </thead>

  <?php $row=0;
  if ($totalRows_recUser != 0) {
    do {
      $row++;
      ?>
     <tbody>
        <tr>
        <td><?php echo  $row; ?>&nbsp;</td>
        <td><?php echo $row_recUser['register_time']; ?>&nbsp;</td>
        <td><?php echo $row_recUser['name']; ?>&nbsp;</td>
        <td><?php  $jabatan = $row_recUser['jabatan'];
        mysqli_select_db($conn, $database_conn);
        $query_recjab = "SELECT * FROM dept_tbl WHERE department_id = '$jabatan'";
        $recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
        $row_recjab = mysqli_fetch_assoc($recjab);
        echo $row_recjab['department_name'];
        ?>&nbsp;</td>
        <td><?php echo $row_recUser['EMAIL']; ?>&nbsp;</td>
        <td><?php  $jenis = $row_recUser['levelUser'];
        mysqli_select_db($conn, $database_conn);
        $query_reclevel = "SELECT * FROM userlevel_tbl WHERE level_id = '$jenis'";
        $reclevel = mysqli_query($conn, $query_reclevel) or die(mysqli_error($conn));
        $row_reclevel = mysqli_fetch_assoc($reclevel);

        echo $row_reclevel['level_type'];
        ?>&nbsp;</td>


      <td width="75"><a href="add_user.php?x=2&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>

        <td width="75" align="center"><?php if ($row_recUser['flag_log']==0) { ?><a href="stat_user.php?x=1&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Activated
         </a>

      <?php } else { ?><a href="stat_user.php?x=2&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Deactivated </a>
      <?php } ?></td>
        </tr>
        <?php } while ($row_recUser = mysqli_fetch_assoc($recUser));
} else { ?>
    <tr align="center">
          <td height="27" colspan="15">-- No Record --</td>
        </tr>
 <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>

<?php
mysqli_free_result($recUser);


?>
