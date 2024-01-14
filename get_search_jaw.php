
<?php  //signup.php
 require_once('Connections/conn.php'); 

$jawid = $_REQUEST['jawid'];
mysqli_select_db($conn, $database_conn);
$query_recgred = "SELECT * FROM gred_tbl WHERE jawatanID = '$jawid' and flag_gred=0 ORDER BY jenisGred ASC"; 
$recgred = mysqli_query($conn, $query_recgred) or die(mysqli_error($conn));
$row_recgred = mysqli_fetch_assoc($recgred);
$totalRows_recgred = mysqli_num_rows($recgred);
 
?>
<link rel="stylesheet" href="style2.css">
<input name="ddljaw" id="ddljaw" type="hidden" value="<?php echo $jawid; ?>" />
<select  class="input-box3" name="ddlgred" id="ddlgred">
  <option value="" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
  <?php
if($totalRows_recgred !=0){
do {  
?>
  <option value="<?php echo $row_recgred['gredID']?>"<?php if (!(strcmp($row_recgred['gredID'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recgred['jenisGred']; ?></option>
  <?php
} while ($row_recgred = mysqli_fetch_assoc($recgred));
  $rows = mysqli_num_rows($recgred);
  if($rows > 0) {
      mysqli_data_seek($recgred, 0);
	  $row_recgred = mysqli_fetch_assoc($recgred);
  }
}
?>
</select>


<?php
mysqli_free_result($recgred);
?>




