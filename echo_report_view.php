<?php require_once('auth.php');
require_once('Connections/conn.php');

$er = $_GET['er'];
$lg_id = $_SESSION['SESS_MEMBER_ID'];

mysqli_select_db($conn, $database_conn);
$query_recAccSet = "SELECT * FROM login A LEFT JOIN gred_tbl B ON A.jawatan = B.gred_id WHERE A.login_id = '$lg_id'";
$recAccSet = mysqli_query($conn, $query_recAccSet) or die(mysqli_error($conn));
$row_recAccSet = mysqli_fetch_assoc($recAccSet);
$totalRows_recAccSet = mysqli_num_rows($recAccSet);
$posid = $row_recAccSet['pos_id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta  name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<title>Echocardiogram Report</title>
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>
</script>

<style>
{
  box-sizing: border-box;
}

.column {
  float: left;
  width: 50%;
  padding: 20px;
  
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

h5 {text-align: center;}

textarea {
  padding: 12px 20px;
  box-sizing: border-box;
  border: 3px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  resize: none;
}

</style>
</head>
<body>

  <?php



    if($er == 2) {

      $brid = $_GET['brid'];

      mysqli_select_db($conn, $database_conn);
      $query_rececho = "SELECT * FROM app_form as A 
      left join login as B on(A.loginID = B.login_id) 
      left join patient_tbl as C on(A.pat_id=C.pat_id)
      WHERE A.borang_id='$brid'";
      $rececho = mysqli_query($conn, $query_rececho) or die(mysqli_error($conn));
      $row_rececho = mysqli_fetch_assoc($rececho);
      $totalRows_rececho = mysqli_num_rows($rececho);


     mysqli_select_db($conn, $database_conn);
     $query_recgender = "SELECT * from gender_tbl WHERE gender_flag=0 ORDER BY gender_name ASC";
     $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
     $row_recgender = mysqli_fetch_assoc($recgender);
     $totalRows_recgender = mysqli_num_rows($recgender);

    mysqli_select_db($conn, $database_conn);
    $query_recpatuser = "SELECT * FROM app_form A LEFT JOIN login B ON A.loginID=B.login_id WHERE A.borang_id='$brid'";
    $recpatuser = mysqli_query($conn, $query_recpatuser) or die(mysqli_error($conn));
    $row_recpatuser = mysqli_fetch_assoc($recpatuser);
    $totalRows_recpatuser = mysqli_num_rows($recpatuser);

    mysqli_select_db($conn, $database_conn);
    $query_rececho1 = "SELECT * FROM result1_echo A LEFT JOIN app_form B ON A.column1_id=B.borang_id WHERE A.borang_id='$brid'";
    $rececho1 = mysqli_query($conn, $query_rececho1) or die(mysqli_error($conn));
    $row_rececho1 = mysqli_fetch_assoc($rececho1);
    $totalRows_rececho1 = mysqli_num_rows($rececho1);

    mysqli_select_db($conn, $database_conn);
    $query_rececho2 = "SELECT * FROM result2_echo A LEFT JOIN app_form B ON A.column2_id=B.borang_id WHERE A.borang_id='$brid'";
    $rececho2 = mysqli_query($conn, $query_rececho2) or die(mysqli_error($conn));
    $row_rececho2 = mysqli_fetch_assoc($rececho2);
    $totalRows_rececho2 = mysqli_num_rows($rececho2);

    mysqli_select_db($conn, $database_conn);
    $query_rececho3 = "SELECT * FROM result3_echo A LEFT JOIN app_form B ON A.column3_id=B.borang_id WHERE A.borang_id='$brid'";
    $rececho3 = mysqli_query($conn, $query_rececho3) or die(mysqli_error($conn));
    $row_rececho3 = mysqli_fetch_assoc($rececho3);
    $totalRows_rececho3 = mysqli_num_rows($rececho3);

    mysqli_select_db($conn, $database_conn);
    $query_rececho4 = "SELECT * FROM result4_echo A LEFT JOIN app_form B ON A.column4_id=B.borang_id WHERE A.borang_id='$brid'";
    $rececho4 = mysqli_query($conn, $query_rececho4) or die(mysqli_error($conn));
    $row_rececho4 = mysqli_fetch_assoc($rececho4);
    $totalRows_rececho4 = mysqli_num_rows($rececho4);

  ?>

<img src="img\htar.png" width="120" height="100"><br><br>
<h5> Echocardiogram Report </h5>
<h5> Department Of Medicine </h5><br><br>

 <div class="row">
  <div class="column" style="background-color:white;">

      <h6>1) Patient & Vital Signs Information</h6>

      <th> Name : </th>
      <td> <?php echo $row_rececho['Pat_Name']; ?></td><br>

      <th> IC/Passport : </th>
      <td> <?php echo $row_rececho['Pat_Ic']; ?></td><br>

      <th> Age : </th>
      <td> <?php echo $row_rececho['Pat_Age']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
      <th> Gender : </th>
      <td> <?php $gender = $row_rececho['Pat_Gender'];
      mysqli_select_db($conn, $database_conn);
      $query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
      $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
      $row_recgender = mysqli_fetch_assoc($recgender);
      echo $row_recgender['gender_name']?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <th> Wad/Unit : </th>
      <td> <?php echo $row_rececho['Pat_Wad']; ?></td><br>
      <th> Height :</th>
      <td>  <?php echo $row_rececho['Height']; ?></td> cm &nbsp;&nbsp;&nbsp;&nbsp;
      <th> Weight : </th>
      <td> <?php echo $row_rececho['Weight']; ?> </td> kg
      <br>
      <th> BSA :</th>
      <td> <?php echo $row_rececho1['Bsa']; ?> </td> m2
      <br>
      <th> Date :</th>
      <td>  <?php echo $row_rececho1['Echo_Date']; ?> </td>&nbsp;&nbsp;&nbsp;&nbsp;
      <th> Time :</th>
      <td> <?php echo $row_rececho1['Echo_Time']; ?> </td>
      <br><br>

      <h6>2) Left Ventricular (LV) dimensions (2D/M-mode)</h6>
       <th> LV internal Dimension (diastole) = </th>
          <td> <?php echo $row_rececho1['LV_diastole']; ?></td>cm<br>
       <th> LV internal Dimension (systole) = </th>
          <td> <?php echo $row_rececho1['LV_systole']; ?></td>cm<br>
       <th> Interventricular Septum (diastole) =  </th>
          <td> <?php echo $row_rececho1['Inter_diastole']; ?></td>cm<br> 
       <th> Interventricular Septum (systole) =  </th>
          <td> <?php echo $row_rececho1['Inter_systole']; ?></td>cm<br>
       <th> LV Posterior Wall (diastole) = </th>
          <td> <?php echo $row_rececho1['Post_diastole']; ?></td>cm<br>
       <th> LV Posterior Wall (systole) = </th>
          <td> <?php echo $row_rececho1['Post_systole']; ?></td>cm<br><br>



      <h6>3) Left Artial (LA) dimensions (End-systole)</h6>
       <th> LA volume (biplane) = </th>
          <td> <?php echo $row_rececho1['LA_Volume']; ?></td>cm3<br>
       <th> LA volume indexed = </th>
          <td> <?php echo $row_rececho1['LA_BSA']; ?></td>ml/m2<br>
          <td><input type="radio"  <?php echo ( $row_rececho1['LA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho1['LA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br><br>

      <h6>4)  Right Ventricular (RV) dimensions (2D)</h6>
        <th> RV basal diameter =  </th>
          <td> <?php echo $row_rececho1['RV_Dia']; ?></td>cm<br>
       <th> Mid-RV diameter = </th>
          <td> <?php echo $row_rececho1['Mid_RV']; ?></td>cm<br>
       <th> RV Length = </th>
          <td> <?php echo $row_rececho1['RV_Length']; ?></td>cm<br>
        <td><input type="radio"  <?php echo ( $row_rececho1['RV_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho1['RV_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br><br>

      <h6>5) Right Artial (RA) dimensions (2D)</h6>
       <th> RA volume = </th>
          <td> <?php echo $row_rececho1['RA_Volume']; ?></td> cm3<br>
       <th> RA volume indexed = </th>
          <td> <?php echo $row_rececho1['RA_BSA']; ?></td>ml/m2<br>
          <td><input type="radio"  <?php echo ( $row_rececho1['RA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho1['RA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br><br>

      <h6>6) Aortic Root Dimensions (2D)</h6>
          <td><input type="radio"  <?php echo ( $row_rececho1['AR_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho1['AR_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br><br>
</div>

  <div class="column" style="background-color:white;">
      <h6>7) Mitral Valve</h6>
          <td><input type="radio"  <?php echo ( $row_rececho2['MV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
          <input type="radio"  <?php echo ( $row_rececho2['MV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve</td> <br>

         <td><input type="radio"  <?php echo ( $row_rececho2['MV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho2['MV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br>
          <th>Assessment (2D/Color Doppler/Spectra Doppler)</th><br>
          <textarea rows="6" cols="60"><?php echo $row_rececho2['MV_assess']; ?></textarea><br><br>

         <h6>8) Aortic Valve</h6>
          <td><input type="radio"  <?php echo ( $row_rececho2['AV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
          <input type="radio"  <?php echo ( $row_rececho2['AV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve</td> <br>

         <td><input type="radio"  <?php echo ( $row_rececho2['AV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho2['AV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br>
          <th>Assessment (2D/Color Doppler/Spectra Doppler)</th><br>
          <textarea rows="6" cols="60"><?php echo $row_rececho2['AV_assess']; ?></textarea><br><br>

        <h6>9) Tricuspid Valve</h6>
          <td><input type="radio"  <?php echo ( $row_rececho2['TV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
          <input type="radio"  <?php echo ( $row_rececho2['TV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve</td> <br>

         <td><input type="radio"  <?php echo ( $row_rececho2['TV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho2['TV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br>
          <th>Assessment (2D/Color Doppler/Spectra Doppler)</th><br>
          <textarea rows="6" cols="60"><?php echo $row_rececho2['TV_assess']; ?></textarea><br><br>

        <h6>10) Pulmonary Valve</h6>
          <td><input type="radio"  <?php echo ( $row_rececho2['PV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
          <input type="radio"  <?php echo ( $row_rececho2['PV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve</td> <br>

         <td><input type="radio"  <?php echo ( $row_rececho2['PV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio"  <?php echo ( $row_rececho2['PV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal</td> <br>
          <th>Assessment (2D/Color Doppler/Spectra Doppler)</th><br>
          <textarea rows="6" cols="60"><?php echo $row_rececho2['PV_assess']; ?></textarea><br><br>
    </div>
</div>

<br><br><br><br><br><br><br>

 <div class="row">
  <div class="column" style="background-color:white;">
          <h6>11) Left Ventricular (LV) Systolic Function</h6>
    <td>Simpson = </td>
    <th><?php echo $row_rececho3['LV_Simspson']; ?></th>% &nbsp;&nbsp;&nbsp;&nbsp; 
    <input type="radio"  <?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Biplane') ? 'checked' : ''; ?> /> Biplane
    <input type="radio"  <?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Monoplane') ? 'checked' : ''; ?> /> Monoplane</td> <br>
     Regional Wall Motion Abnormalities (RWMA):<br>
     <td><input type="radio"  <?php echo ( $row_rececho3['LV_RWMA'] == 'YES') ? 'checked' : ''; ?> /> YES
          <input type="radio"  <?php echo ( $row_rececho3['LV_RWMA'] == 'NO') ? 'checked' : ''; ?> /> NO</td> <br>
    <textarea rows="6" cols="60"><?php echo $row_rececho3['LV_RWMA_Com']; ?></textarea><br><br>


    <h6>12) Mitral Valve Inflow Profile:</h6>

    E velocity = <?php echo $row_rececho3['LV_E_Vel']; ?> cm/s<br>
    E/A ratio = <?php echo $row_rececho3['LV_EA_Velocity']; ?> <br>
    Deceleration Time (DT) =<?php echo $row_rececho3['LV_DT']; ?> msec<br><br>

    Pulmonary Venous Flow Profile :<br>
    Systolic flow velocity (S) = <?php echo $row_rececho3['Sys_Vel']; ?> cm/s<br> 
    Diastolic flow velocity (D)  = <?php echo $row_rececho3['Dias_Vel']; ?> cm/s<br>
    PV S/D ratio = <?php echo $row_rececho3['PV_Ratio']; ?> cm/s<br>
    Atrial reversal flow velocity (Ar) = <?php echo $row_rececho3['Atrial_Vel']; ?> cm/s<br>
    Atrial reversal flow duration = <?php echo $row_rececho3['Atrial_Dur']; ?> msec<br><br>

    Tissue Doppler Imaging (TDI):<br>
    A) Septal Mitral Annulus: <br>
    s' Velocity = <?php echo $row_rececho3['S_Septal_Velocity']; ?> cm/s <br>
    e' Velocity = <?php echo $row_rececho3['E_septal_velocity']; ?> cm/s <br>
    a' velocity = <?php echo $row_rececho3['A_septal_velocity']; ?> cm/s <br>

    B) Lateral Mitral Annulus: :<br>
    s' Velocity = <?php echo $row_rececho3['S_lateral_velocity']; ?> cm/s <br>
    e' Velocity = <?php echo $row_rececho3['E_lateral_velocity']; ?> cm/s <br>
    a' velocity = <?php echo $row_rececho3['A_lateral_velocity']; ?> cm/s <br><br>

    Septal E/e' = <?php echo $row_rececho3['Septal_E']; ?> cm/s <br>
    Lateral E/e' =  <?php echo $row_rececho3['Lateral_E']; ?> cm/s <br>
    Average E/e' = <?php echo $row_rececho3['Average_E']; ?> cm/s <br><br>

    Grading of LV Diastolic Function:<br>
    <input type="radio"  <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_0') ? 'checked' : ''; ?> /> Grad 0(Normal diastolic function)<br>
    <input type="radio"  <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_1') ? 'checked' : ''; ?> /> Grad 1(Impaired Relaxation)<br>
    <input type="radio"  <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_2') ? 'checked' : ''; ?> /> Grad 2(Pseudonormal Pattern)<br>
    <input type="radio"  <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_3') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>


 <h6>13) Right Ventricular (RV) Systolic Fuction</h6>
 Trucuspid Annulus Plane Systolic Excursion<br>
 (TAPSE) = <?php echo $row_rececho3['TAPSE']; ?> cm ( Normal > 1.7cm ) <br><br>

</div>


<div class="column" style="background-color:white;">
 <h6>14) Congenital heart Diseases</h6>
  A) Atrial Septal Defect (ASD):  
    <input type="radio"  <?php echo ( $row_rececho4['Asd'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio"  <?php echo ( $row_rececho4['Asd'] == 'No') ? 'checked' : ''; ?> /> No <br>
  B) Ventricular Septal Defect (VSD):
    <input type="radio"  <?php echo ( $row_rececho4['VSD'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio"  <?php echo ( $row_rececho4['VSD'] == 'No') ? 'checked' : ''; ?> /> No <br>
  C) Patent Ductus Arteriosus (PDA):
    <input type="radio"  <?php echo ( $row_rececho4['Pda'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio"  <?php echo ( $row_rececho4['Pda'] == 'No') ? 'checked' : ''; ?> /> No <br>
  Shunt: <br>
    <input type="radio"  <?php echo ( $row_rececho4['Shunt'] == 'plr') ? 'checked' : ''; ?> /> Predominant left-to-right <br>
    <input type="radio"  <?php echo ( $row_rececho4['Shunt'] == 'prl') ? 'checked' : ''; ?> /> Predominant right-to-left <br>
    <input type="radio"  <?php echo ( $row_rececho4['Shunt'] == 'bidi') ? 'checked' : ''; ?> /> Bidirectional <br>
    <input type="radio"  <?php echo ( $row_rececho4['Shunt'] == 'noshunt') ? 'checked' : ''; ?> /> No Shunt <br>

    Shunt defect size approx <?php echo $row_rececho4['Shunt_Defect']; ?> mm<br><br>
    
    Other associated findings <br> 
    <textarea rows="6" cols="60"><?php echo $row_rececho4['A_Find']; ?></textarea><br><br>

    <h6>15) Pericardial Diseases</h6>
    Normal Pericardium 
    <input type="radio" <?php echo ( $row_rececho4['N_Peri'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio" <?php echo ( $row_rececho4['Pda'] == 'No') ? 'checked' : ''; ?> /> No <br>
    Pericardial Effusion
    <input type="radio" <?php echo ( $row_rececho4['P_Effu'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio" <?php echo ( $row_rececho4['P_Effu'] == 'No') ? 'checked' : ''; ?> /> No<br>
    Size of Effusion: <?php echo $row_rececho4['Size_Effu']; ?> cm<br>
    <input type="radio" <?php echo ( $row_rececho4['Effu_Type'] == 'Small') ? 'checked' : ''; ?> /> Small
    <input type="radio" <?php echo ( $row_rececho4['Effu_Type'] == 'Moderate') ? 'checked' : ''; ?> /> Moderate
    <input type="radio" <?php echo ( $row_rececho4['Effu_Type'] == 'Large') ? 'checked' : ''; ?> /> Large <br>
    Tamponade physiology:
    <input type="radio"  <?php echo ( $row_rececho4['Tamphy'] == 'Yes') ? 'checked' : ''; ?> /> Yes
    <input type="radio"  <?php echo ( $row_rececho4['Tamphy'] == 'No') ? 'checked' : ''; ?> /> No <br><br>

    16) Other Echo Findings<br>
    <textarea rows="6" cols="60"><?php echo $row_rececho4['Other_Find']; ?></textarea><br><br>
    17) Echo Diagnosis<br>
    <textarea rows="6" cols="60"><?php echo $row_rececho4['Echo_Diag']; ?></textarea><br><br>
    18) Conclusion Of Echo Assessment<br>
    <input type="radio"  <?php echo ( $row_rececho4['Echo_Type'] == 'Normal_Echo') ? 'checked' : ''; ?> /> Normal Echo
    <input type="radio"  <?php echo ( $row_rececho4['Echo_Type'] == 'Abnormal_Echo') ? 'checked' : ''; ?> /> Abnormal Echo <br><br>

    Reported By:
    <?php echo $row_rececho4['report_by']; ?><br>

    Verify by:
    <?php echo $row_rececho4['verify_by']; ?><br>
  </div>
</div>

<script>window.print();
</script>

    <?php

   //elseje     
  } //else if user
  ?>  