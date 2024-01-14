<?php  require_once('auth.php');
 require_once('Connections/conn.php'); 
$id =$_SESSION['SESS_MEMBER_ID'];
$cat=$_GET["l"];
$key =$_GET["m"];
$type = $_SESSION['SESS_TYPE'];

$ROW = 0;

mysqli_select_db($conn, $database_conn);

?>
<?php


 if ($cat == 1){ 

   $query_recpatuser = "SELECT * FROM app_form as A 
  left join login as B on(A.loginID = B.login_id) 
  left join patient_tbl as C on(A.pat_id=C.pat_id) WHERE Pat_Name like '%$key%' ORDER BY FIELD(appointment_status, 1, 2, 3, 4, 6, 5 ), Reg_Date DESC ";

 } else if ($cat == 2) { 

  $query_recpatuser ="SELECT * FROM app_form as A 
  left join login as B on(A.loginID = B.login_id) 
  left join patient_tbl as C on(A.pat_id=C.pat_id) WHERE  Pat_Ic like '%$key%' ORDER BY FIELD(appointment_status, 1, 2, 3, 4, 6, 5 ), Reg_Date DESC ";


 } else { 
  $query_recpatuser = "SELECT * from app_form as A 
  left join login as B on(A.loginID = B.login_id) 
  left join patient_tbl as C on(A.pat_id=C.pat_id)
  ORDER BY FIELD(appointment_status, 1, 2, 3, 4, 6, 5), Reg_Date DESC";
}

  $recpatuser = mysqli_query($conn, $query_recpatuser) or die(mysqli_error($conn));
  $row_recpatuser = mysqli_fetch_assoc($recpatuser);
  $totalRows_recpatuser = mysqli_num_rows($recpatuser);

  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<style type="text/css">

.style1 {
	color: #FFFFFF;
	font-weight: bold;
}

</style>
</head>

<body>
	<p><center><strong> <font color="#FF0000"><?php echo $totalRows_recpatuser; ?></font> Found record &nbsp;&nbsp;&nbsp; </strong></center></p>
   
   <img src="img/legend.png"  width="1000" height="30">

      <table class="table table-bordered" align="center" >
       <thead>
        <tr align="center" bgcolor="#db420f"  >

          <td width="120"><div align="center" class="style1">Reg Date </div></td>
          <td width="250"><div align="center" class="style1">Name </div></td> 
          <td width="110"><div align="center" class="style1">IC/Passport </div></td>
          <td width="30"><div align="center" class="style1">Covid</div></td>
          <td width="120"><div align="center" class="style1">App Date </div></td> 
          <td width="120"><div align="center" class="style1">App Time </div></td>
          <td width="300"><div align="center" class="style1">Indication</div></td>
          <td width="70"><div align="center" class="style1">Urgency</div></td>
          <td width="150"><div align="center" class="style1">Status </div></td> 
          <td width="70" colspan="2"><div align="center" class="style1">Action</div></td>      
          <td width="150"><div align="center" class="style1">Reason</div></td>
          <td width="150"><div align="center" class="style1">Applied By</div></td> 
        </thead>

     <?php $row =0;?>
    
      <?php 
  if ($totalRows_recpatuser != 0) {
    do {
      $row++;
      /*colour code for row*/
      $statclr =$row_recpatuser['appointment_status'];
      $color1 = "#FFA7FF"; //pending appoinment
      $color2 = "#FF968A"; // Pending For Echo Procedure 
      $color3 = "#DEDAD0"; // Patient Rejected
      $color4 = "#FFFFB5"; // Report Ready (Validated)
      $color5 = "#77DD77"; //Report Ready (Not Validated)


      ?>
      <tbody>
        <tr bgcolor="<?php
        if ($statclr == 1) { // status tempahan baru 
          echo $color1;
        } else if ($statclr == 2) {
          echo "$color2";
        }
        else if ($statclr == 3) {
          echo "$color3";
        }
        else if ($statclr == 6) {
          echo "$color4";
        }
        else {
          echo "$color5";
        }
      ?>"> 
      <td><?php if ($row_recpatuser['Reg_Date']!= '0000-00-00') {
      echo date('d/m/Y',strtotime($row_recpatuser['Reg_Date'])); } ?> &nbsp;
      </td>      
      <td><?php echo $row_recpatuser['Pat_Name']; ?>&nbsp;</td>
      <td><?php echo $row_recpatuser['Pat_Ic']; ?>&nbsp;</td>
      <td><?php  $covidstat = $row_recpatuser['Pat_Covid_Status'];
      mysqli_select_db($conn, $database_conn);
      $query_reccovstat = "SELECT * from patient_covid_status WHERE covidstat_id= '$covidstat' ";
      $reccovstat = mysqli_query($conn, $query_reccovstat) or die(mysqli_error($conn));
      $row_reccovstat = mysqli_fetch_assoc($reccovstat);
      echo $row_reccovstat ['covidstat'];
      ?>&nbsp;</td>

          <td><?php if ($row_recpatuser['App_Date']!= '0000-00-00') {
          echo date('d/m/Y',strtotime($row_recpatuser['App_Date'])); } ?> &nbsp;
          </td>

          <td><?php if ($row_recpatuser['App_Time']!= '00:00:00') {
          echo date('h:i:a',strtotime($row_recpatuser['App_Time'])); } ?> &nbsp;
          </td>

          <td><span class="style4">
            <?php
               $id = $row_recpatuser['borang_id']; 
            mysqli_select_db($conn, $database_conn);
            $query_recindi = "SELECT * FROM pat_indication WHERE borang_id = '$id'";
            $recindi = mysqli_query($conn, $query_recindi) or die(mysqli_error($conn));
            $row_recindi = mysqli_fetch_assoc($recindi);
            do {

              $id_type = $row_recindi['indication_type'];
              mysqli_select_db($conn, $database_conn);
              $query_recinditype = "SELECT * FROM ref_indication_tbl WHERE indication_id = '$id_type'";
              $recinditype = mysqli_query($conn, $query_recinditype) or die(mysqli_error($conn));
              $row_recinditype = mysqli_fetch_assoc($recinditype);
              echo "&#8226" . $row_recinditype ['indication_name']."<br>";

            } while ($row_recindi = mysqli_fetch_assoc($recindi)); 


            ?></td>

          <td><?php echo $row_recpatuser['Urgency']; ?>&nbsp;</td>
           <td><?php  $statapp = $row_recpatuser['appointment_status'];
            mysqli_select_db($conn, $database_conn);
            $query_recappstatus = "SELECT * FROM app_status WHERE appointmentstatusID = '$statapp'";
            $recappstatus = mysqli_query($conn, $query_recappstatus) or die(mysqli_error($conn));
            $row_recappstatus = mysqli_fetch_assoc($recappstatus);
            echo $row_recappstatus['appointment_status'];
            ?>&nbsp;</td> 


            <td withd="75" align="center"><a href="edit_view_record.php?x=3&id=<?php echo $row_recpatuser['borang_id']; ?>" class="btn btn-success btn-sm" ><span class="glyphicon glyphicon-new-window"></span> <img class="btn" src="img/details.png" width="80" height="35" /></a></td> 


            <?php if ($statapp == 1){ 
            ?><td> </td></button></a>
            <?php
            } 

            elseif ($statapp == 2){ 
            ?><td> </td>
            <?php
            }

            elseif ($statapp == 3){ 
            ?><td> </td>
            <?php
            }

            elseif ($statapp == 5){ 
            ?><td align="center"><button class="btn"><a href="echo_report_view.php?er=2&brid=<?php echo $row_recpatuser['borang_id']; ?>"> <img src="img/echo-icon.png" width="40" height="40"/></td></button></a>
            <?php
            }

            else {
            ?><td> </td>
          <?php } 



          ?>
            <td><?php echo $row_recpatuser['reason']; ?>&nbsp;</td>
            <td><?php echo $row_recpatuser['Applied_By']; ?>&nbsp;</td>
 
        <?php } while ($row_recpatuser = mysqli_fetch_assoc($recpatuser)); 
} else { ?>
    <tr align="center"> 
          <td height="27" colspan="15">-- No Record --</td>
        </tr>
 

 <?php } ?>
		</tbody>
    </table>
</body>
  
</html>

