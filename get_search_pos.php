
<?php  //signup.php
 require_once('Connections/conn.php');

$posid = $_REQUEST['posid'];
mysqli_select_db($conn, $database_conn);
$query_recgred = "SELECT * FROM gred_tbl WHERE pos_id = '$posid' and gred_flag=0 ";
$recgred = mysqli_query($conn, $query_recgred) or die(mysqli_error($conn));
$row_recgred = mysqli_fetch_assoc($recgred);
$totalRows_recgred = mysqli_num_rows($recgred);

?>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
<input name="ddlpos" id="ddlpos" type="hidden" value="<?php echo $posid; ?>" />
<select  class="form-control" name="ddlgred" id="ddlgred">
  <option value="" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>

  <?php
if($totalRows_recgred !=0){
do {
?>
  <option value="<?php echo $row_recgred['gred_id']?>"<?php if (!(strcmp($row_recgred['gred_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recgred['gred_no']; ?></option>
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
