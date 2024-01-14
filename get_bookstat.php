<?php  require_once('auth.php');
 require_once('Connections/conn.php'); 

$cat=$_GET["q"];
$key =$_GET["s"];

$ROW = 0;

mysqli_select_db($conn, $database_conn);


if ($cat == 1 )
{
$query_recbookingStat = "Select * from app_status where appointment_status like '%$key%' ";
}
else
{
$query_recbookingStat = "Select * from app_status order by appointment_status ASC ";
}

$recbookingStat = mysqli_query($conn, $query_recbookingStat) or die(mysqli_error($conn));
$row_recbookingStat = mysqli_fetch_assoc($recbookingStat);
$totalRows_recbookingStat = mysqli_num_rows($recbookingStat);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>Untitled Document</title>

<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
--> 
</style>
</head>
<body>
<p><center><strong><font color="#FF0000"> <?php echo $totalRows_recbookingStat; ?> </font> records found</strong></center></p>
	<table class="table table-bordered table-hover" align="center">
    <thead>
      <tr align="center" bgcolor="#1690A7">
        <td><div align="center" class="style1">No</div></td>
        <td ><div align="center" class="style1">Appoinment Status</div></td>
        <td colspan="3" ><div align="center" class="style1">Action </div></td>
      </tr>
    </thead>

      <?php $row =0;?>

      <?php
	if($totalRows_recbookingStat != 0){
         do {  
	 		$ROW++;
	 
	 ?>
      <tbody>
          <tr>
           <td width="75" align="center"><?php echo $ROW; ?></td>
            <td  align="center"><a href="add_bookstat.php?x=2&id=<?php echo $row_recbookingStat['appointmentstatusID']; ?>"><?php echo $row_recbookingStat['appointment_status']; ?></a>
         
            <?php if ($row_recbookingStat['flag_as']==0) { ?><td width="150" align="center"><a href="stat_bookstat.php?x=1&id=<?php echo $row_recbookingStat['appointmentstatusID']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" ></span> Activated</a></td>

            <?php } else { ?><td width="150" align="center"><a href="stat_bookstat.php?x=2&id=<?php echo $row_recbookingStat['appointmentstatusID']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Inactive</a></td>
            <?php } ?> </td>
          </tr>
          <?php } while ($row_recbookingStat = mysqli_fetch_assoc($recbookingStat)); 
	} else { ?>
		  <tr align="center"> 
               <td height="27" colspan="4">-- No Record  --</td>
          </tr>
			
	<?php	} ?>
  </tbody>
</table>
</body>
</html>
