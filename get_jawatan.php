<?php  require_once('auth.php');
 require_once('Connections/conn.php');

$cat=$_GET["q"];
$key =$_GET["s"];

$ROW = 0;

mysqli_select_db($conn, $database_conn);


if ($cat == 1 )
{
$query_recjwtn = "Select A.*, B.* from pos_tbl as A left join gred_tbl as B on A.pos_id=B.pos_id where A.pos_name like '%$key%' ";
}
else if ($cat == 2 )
{
$query_recjwtn = "Select A.*, B.* from pos_tbl as A left join gred_tbl as B on A.pos_id=B.pos_id where B.gred_no like '%$key%' ";
}
else
{
$query_recjwtn = "Select A.*, B.* from pos_tbl as A left join gred_tbl as B on A.pos_id=B.pos_id ";
}

$recjwtn = mysqli_query($conn, $query_recjwtn) or die(mysqli_error($conn));
$row_recjwtn = mysqli_fetch_assoc($recjwtn);
$totalRows_recjwtn = mysqli_num_rows($recjwtn);

?>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<p><center><strong><font color="#FF0000"> <?php echo $totalRows_recjwtn; ?> </font> records found.</strong></center></p>
	<table class="table table-bordered table-hover" align="center">
      <tr align="center" bgcolor="#1690A7">
        <td><div align="center" class="style1">No</div></td>
        <td><div align="center" class="style1">Position </div></td>
        <td><div align="center" class="style1">Gred</div></td>
      </tr><?php
if($totalRows_recjwtn != 0){
         do {
	 $ROW++;

	 ?>
          <tr>
            <td height="27" align="center"><?php echo $ROW; ?></td>
            <td><?php echo $row_recjwtn['pos_name'];?></td>
              <td align="center">

				<?php if ($row_recjwtn['gred_id'] != 0 && $row_recjwtn['gred_id'] != '') {?>
				<table><tr><td><?php echo $row_recjwtn['gred_no']; ?></td>

					<td width="150" align="center"><?php if ($row_recjwtn['gred_flag']==0) { ?><a href="stat_gred.php?x=1&id=<?php echo $row_recjwtn['gred_id']; ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span>  Activated</a><?php } else { ?><a href="stat_gred.php?x=2&id=<?php echo $row_recjwtn['gred_id']; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Inactivated</a><?php } ?>  </td></tr></table>
				<?php
			} ?>

			  </td>
			</tr>
            <?php } while ($row_recjwtn = mysqli_fetch_assoc($recjwtn));

			} else { ?>
		  <tr align="center">
               <td height="27" colspan="15">-- No Records--</td>
          </tr>

		<?php	} ?></table>
