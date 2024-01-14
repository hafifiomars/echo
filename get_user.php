<?php  require_once('auth.php');
require_once('Connections/conn.php');
$id =$_SESSION['SESS_MEMBER_ID'];
$cat=$_GET["q"];
$key =$_GET["s"];
$type = $_SESSION['SESS_TYPE'];

$ROW = 0;

mysqli_select_db($conn, $database_conn);

 if ($cat == 1){

  $query_recUser ="SELECT * FROM login WHERE EMAIL like '%$key%' ORDER BY login_id ASC ";

 } else if ($cat == 2) {

  $query_recUser = "SELECT * FROM login WHERE name like '%$key%' ORDER BY login_id ASC";

 } else if ($cat == 3){

  mysqli_select_db($conn, $database_conn);
  $query_recjab = "SELECT * FROM dept_tbl WHERE department_name LIKE '%$key%'";
  $recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
  $row_recjab = mysqli_fetch_assoc($recjab);
  $totalRows_recjab = mysqli_num_rows($recjab);

  $jabatan= $row_recjab['department_id'];

  $query_recUser = "SELECT * FROM login WHERE jabatan = '$jabatan' ORDER BY login_id ASC";
  mysqli_free_result($recjab);

 } else if ($cat == 4) {

  mysqli_select_db($conn, $database_conn);
  $query_reclevel = "SELECT * FROM userlevel_tbl WHERE level_type LIKE '%$key%'";
  $reclevel = mysqli_query($conn, $query_reclevel) or die(mysqli_error($conn));
  $row_reclevel = mysqli_fetch_assoc($reclevel);
  $totalRows_reclevel = mysqli_num_rows($reclevel);

  $jenis= $row_reclevel['level_id'];

  $query_recUser = "SELECT * FROM login WHERE levelUser = '$jenis' ORDER BY login_id ASC";
  mysqli_free_result($reclevel);

} else {
  $query_recUser="SELECT * FROM login ORDER BY login_id ASC ";
}

  $recUser = mysqli_query($conn, $query_recUser) or die(mysqli_error($conn));
  $row_recUser = mysqli_fetch_assoc($recUser);
  $totalRows_recUser = mysqli_num_rows($recUser);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>Untitled Document</title>
<script type="text/javascript">
function show_confirm_delete()
{
 var r=confirm("Do you want to delete this VC?");
 if (r==true)
   {
     return(true);
   }
 else
   {
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
<p><center><strong> <font color="##FF0000"><?php echo $totalRows_recUser; ?></font> records found.&nbsp;&nbsp;&nbsp;</strong></center></p>

      <table class="table table-bordered" align="center">
      <thead>
      <tr align="center" bgcolor="#1690A7">
        <td width="38"><div align="center" class="style1">No</div></td>
  <td width="100"><div align="center" class="style1">Date Register</div></td>
        <td width="180"> <div align="center" class="style1">Full Name</div></td>
        <td width="170"><div align="center" class="style1">Department</div></td>
        <td width="180"><div align="center" class="style1">Email </div></td>
        <td width="70"><div align="center" class="style1">Level </div></td>
        <td width="70"><div align="center" class="style1">Registration Status</div></td>
        <td colspan="3" ><div align="center" class="style1">Action</div></td>
       </tr>
      </thead>

  <?php $row =0;?>

      <?php
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


       <!-- <?php
      if ($row_recUser['flag_log']==0) {
        echo "<td align=center>Active</td>";
      } else {
        echo "<td align=center>Inactive</td>";
      } ?> -->

      <td width="75"><a href="add_user.php?x=2&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>

        <td width="75" align="center"><?php if ($row_recUser['flag_log']==0) { ?><a href="stat_user.php?x=1&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Actived</a>

      <?php } else { ?><a href="stat_user.php?x=2&id=<?php echo $row_recUser['login_id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Deactivated</a>
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
</body>



</html>
