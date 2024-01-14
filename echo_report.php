<?php require_once('auth.php');
require_once('Connections/conn.php');

$type = $_SESSION['SESS_TYPE'];
$er = $_GET['er'];
$lg_id = $_SESSION['SESS_MEMBER_ID'];
$brid = $_GET['brid'];


    mysqli_select_db($conn, $database_conn);
    $query_recAccSet = "SELECT * FROM login A LEFT JOIN gred_tbl B ON A.jawatan = B.gred_id WHERE A.login_id = '$lg_id'";
    $recAccSet = mysqli_query($conn, $query_recAccSet) or die(mysqli_error($conn));
    $row_recAccSet = mysqli_fetch_assoc($recAccSet);
    $totalRows_recAccSet = mysqli_num_rows($recAccSet);
    $posid = $row_recAccSet['pos_id'];

      
    mysqli_select_db($conn, $database_conn);
    $query_recpat = "SELECT * FROM app_form A LEFT JOIN login B ON A.loginID=B.login_id WHERE A.borang_id='$brid'";
    $recpat = mysqli_query($conn, $query_recpat) or die(mysqli_error($conn));
    $row_recpat = mysqli_fetch_assoc($recpat);
    $totalRows_recpat = mysqli_num_rows($recpat);

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

    $H = $row_rececho['Height']; 
    $W = $row_rececho['Weight'];
    $bsa = round(0.007184 * (pow($W,0.425)) * (pow($H,0.725)),1);


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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<title>Echocardiogram Report</title>
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>

<script>
  function validate(f) {
    ErrorText= "";
  var tbLen = f.echo_date.value.trim().length;
      if (tbLen == 0) {
      alert("Set The Date (Section 1)");
      f.echo_date.focus();
      return(false);
      }

    var tbLen1 = f.echo_time.value.trim().length;
      if (tbLen1 == 0) {
      alert("Set The Time (Section 1)");
      f.echo_time.focus();
      return(false);
      }

    var tbLen2 = f.lv_diastole.value.trim().length;
    if (tbLen2 == 0) {
      alert(" Please enter LV internal Dimension (diastole) (Section 2)");
      f.lv_diastole.focus();
      return(false);
      }

    var tbLen3 = f.lv_systole.value.trim().length;
    if (tbLen3 == 0) {
      alert(" Please enter LV internal Dimension (systole) (Section 2)");
      f.lv_systole.focus();
      return(false);
      }

    var tbLen4 = f.inter_systole.value.trim().length;
    if (tbLen4 == 0) {
      alert(" Please enter Interventricular Septum (systole) (Section 2) ");
      f.inter_systole.focus();
      return(false);
      }    


    var tbLen5 = f.lv_post_diastole.value.trim().length;
    if (tbLen5 == 0) {
      alert(" Please enter LV Posterior Wall (diastole) (Section 2) ");
      f.lv_post_diastole.focus();
      return(false);
      }   

    var tbLen6 = f.lv_post_systole.value.trim().length;
    if (tbLen6 == 0) {
      alert(" Please enter LV Posterior Wall (systole) (Section 2) ");
      f.lv_post_systole.focus();
      return(false);
      } 

    var tbLen7 = f.la_volume.value.trim().length;
    if (tbLen7 == 0) {
      alert(" Please enter LA volume (biplane) (Section 3) ");
      f.la_volume.focus();
      return(false);
      } 

    var tbLen8 = f.la_bsa.value.trim().length;
    if (tbLen8 == 0 ) {
      alert(" Please enter LA volume (biplane) properly e.g: 1.7 (Section 3) ");
      f.la_bsa.focus();
      return(false);
      }

    var la_type = document.getElementsByName('la_type');
    var genValue = false;

        for(var i=0; i<la_type.length;i++){
            if(la_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Normal Or Abnormal (Section 3) ");
            return false;
        }
    

    var tbLen9 = f.rv_diameter.value.trim().length;
    if (tbLen9 == 0 ) {
      alert(" Please enter RV basal diameter (Section 4) ");
      f.rv_diameter.focus();
      return(false);
      }

    var tbLen10 = f.mid_rv_diameter.value.trim().length;
    if (tbLen10 == 0 ) {
      alert(" Please enter Mid-RV diameter (Section 4) ");
      f.mid_rv_diameter.focus();
      return(false);
      }

    var tbLen11 = f.rv_length.value.trim().length;
    if (tbLen11 == 0 ) {
      alert(" Please enter RV Length (Section 4) ");
      f.rv_length.focus();
      return(false);
      }

    var rv_type = document.getElementsByName('rv_type');
    var genValue = false;

        for(var i=0; i<rv_type.length;i++){
            if(rv_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Normal Or Abnormal (Section 4) ");
            return false;
        }


    var tbLen12 = f.ra_vol.value.trim().length;
    if (tbLen12 == 0 ) {
      alert(" Please enter RA Volume (Section 5) ");
      f.ra_vol.focus();
      return(false);
      }

    var tbLen13 = f.ra_bsa.value.trim().length;
    if (tbLen13 == 0 ) {
      alert(" Please enter RA volume indexed (Section 5) ");
      f.ra_bsa.focus();
      return(false);
      }

    var ra_type = document.getElementsByName('ra_type');
    var genValue = false;

        for(var i=0; i<ra_type.length;i++){
            if(ra_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Normal Or Abnormal (Section 5) ");
            return false;
        }


    var aortic_type = document.getElementsByName('aortic_type');
    var genValue = false;

        for(var i=0; i<aortic_type.length;i++){
            if(aortic_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Normal Or Abnormal (Section 6) ");
            return false;
        }

    var mv_type = document.getElementsByName('mv_type');
    var genValue = false;

        for(var i=0; i<mv_type.length;i++){
            if(mv_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Native or Prosthetic Valve (Section 7) ");
            return false;
        }

    var mv_result = document.getElementsByName('mv_result');
    var genValue = false;

        for(var i=0; i<mv_result .length;i++){
            if(mv_result [i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Normal or Abnormal (Section 7) ");
            return false;
        }


    var tbLen13 = f.mv_assess.value.trim().length;
    if (tbLen13 == 0 ) {
      alert(" Please enter Mitral Valve Assessment (Section 7) ");
      f.mv_assess.focus();
      return(false);
      }

    var aorv_type = document.getElementsByName('aorv_type');
    var genValue = false;

        for(var i=0; i<aorv_type.length;i++){
            if(aorv_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Native or Prosthetic Valve (Section 8) ");
            return false;
        }


    var aorv_result = document.getElementsByName('aorv_result');
    var genValue = false;

        for(var i=0; i<aorv_result .length;i++){
            if(aorv_result [i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Normal or Abnormal (Section 8) ");
            return false;
        }



    var tbLen14 = f.av_assess.value.trim().length;
    if (tbLen14 == 0 ) {
      alert(" Please enter Aortic Valve Assessment (Section 8) ");
      f.av_assess.focus();
      return(false);
      }

    var tv_type = document.getElementsByName('tv_type');
    var genValue = false;

        for(var i=0; i<tv_type.length;i++){
            if(tv_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Native or Prosthetic Valve (Section 9) ");
            return false;
        }

    var tv_result = document.getElementsByName('tv_result');
    var genValue = false;

        for(var i=0; i<tv_result .length;i++){
            if(tv_result[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Normal or Abnormal (Section 9) ");
            return false;
        }



    var tbLen15 = f.tv_assess.value.trim().length;
    if (tbLen15 == 0 ) {
      alert(" Please enter Aortic Valve Assessment (Section 9) ");
      f.tv_assess.focus();
      return(false);
      }

    var pv_type = document.getElementsByName('pv_type');
    var genValue = false;

        for(var i=0; i<pv_type.length;i++){
            if(pv_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Native or Prosthetic Valve (Section 10) ");
            return false;
        }

    var pv_result = document.getElementsByName('pv_result');
    var genValue = false;

        for(var i=0; i<pv_result .length;i++){
            if(pv_result [i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Normal or Abnormal (Section 10) ");
            return false;
        }

    var tbLen16 = f.pv_assess.value.trim().length;
    if (tbLen16 == 0 ) {
      alert(" Please enter Pulmonary Valve Assessment (Section 10) ");
      f.pv_assess.focus();
      return(false);
      }

    var tbLen17 = f.simpson.value.trim().length;
    if (tbLen17 == 0 ) {
      alert(" Please enter simpson percentage (Section 11) ");
      f.simpson.focus();
      return(false);
      }

    var simpson_type = document.getElementsByName('simpson_type');
    var genValue = false;

        for(var i=0; i<simpson_type.length;i++){
            if(simpson_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose biplane or monoplane (Section 11) ");
            return false;
        }

    var rmwa = document.getElementsByName('rmwa');
    var genValue = false;

        for(var i=0; i<rmwa.length;i++){
            if(rmwa[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose option Yes Or No (Section 11) ");
            return false;
        }

    var tbLen18 = f.rwma_comment.value.trim().length;
    if (tbLen18 == 0 ) {
      alert(" Please enter Regional Wall Motion Abnormalities assessment (Section 11) ");
      f.rwma_comment.focus();
      return(false);
      }

    var tbLen19 = f.lv_e_velocity.value.trim().length;
    if (tbLen19 == 0 ) {
      alert(" Please enter E velocity (Section 12) ");
      f.lv_e_velocity.focus();
      return(false);
      }

    var tbLen20 = f.lv_ea_velocity.value.trim().length;
    if (tbLen20 == 0 ) {
      alert(" Please enter E/A ratio  (Section 12) ");
      f.lv_ea_velocity.focus();
      return(false);
      }

    var tbLen20 = f.lv_ea_velocity.value.trim().length;
    if (tbLen20 == 0 ) {
      alert(" Please enter E/A ratio  (Section 12) ");
      f.lv_ea_velocity.focus();
      return(false);
      }

    var tbLen21 = f.lv_dt.value.trim().length;
    if (tbLen21 == 0 ) {
      alert(" Please enter Deceleration Time (DT) (Section 12) ");
      f.lv_dt.focus();
      return(false);
      }

    var tbLen22 = f.systolic_velocity.value.trim().length;
    if (tbLen22 == 0 ) {
      alert(" Please enter systolic flow velocity (S) (Section 12) ");
      f.systolic_velocity.focus();
      return(false);
      }

    var tbLen23 = f.diastolic_velocity.value.trim().length;
    if (tbLen23 == 0 ) {
      alert(" Please enter diastolic flow velocity (D) (Section 12) ");
      f.diastolic_velocity.focus();
      return(false);
      }

    var tbLen24 = f.pv_ratio.value.trim().length;
    if (tbLen24 == 0 ) {
      alert(" Please enter PV S/D ratio (Section 12) ");
      f.pv_ratio.focus();
      return(false);
      }

    var tbLen25 = f.atrial_vel.value.trim().length;
    if (tbLen25 == 0 ) {
      alert(" Please enter atrial reversal flow velocity (Ar) (Section 12) ");
      f.atrial_vel.focus();
      return(false);
      }   

    var tbLen26 = f.atrial_dur.value.trim().length;
    if (tbLen26 == 0 ) {
      alert(" Please enter atrial reversal flow duration (Section 12) ");
      f.atrial_dur.focus();
      return(false);
      }   

    var tbLen27 = f.s_septal_velocity.value.trim().length;
    if (tbLen27 == 0 ) {
      alert(" Please enter S' Velocity (Section 12 (A) ) ");
      f.s_septal_velocity.focus();
      return(false);
      }  

    var tbLen27 = f.e_septal_velocity.value.trim().length;
    if (tbLen27 == 0 ) {
      alert(" Please enter E' Velocity (Section 12 (A) ) ");
      f.e_septal_velocity.focus();
      return(false);
      } 

    var tbLen28 = f.a_septal_velocity.value.trim().length;
    if (tbLen28 == 0 ) {
      alert(" Please enter A' Velocity (Section 12 (A) ) ");
      f.a_septal_velocity.focus();
      return(false);
      } 

    var tbLen29 = f.s_lateral_velocity.value.trim().length;
    if (tbLen29 == 0 ) {
      alert(" Please enter S' Velocity (Section 12 (B) ) ");
      f.s_lateral_velocity.focus();
      return(false);
      }  

    var tbLen27 = f.e_lateral_velocity.value.trim().length;
    if (tbLen27 == 0 ) {
      alert(" Please enter E' Velocity (Section 12 (B) ) ");
      f.e_lateral_velocity.focus();
      return(false);
      } 

    var tbLen28 = f.a_lateral_velocity.value.trim().length;
    if (tbLen28 == 0 ) {
      alert(" Please enter A' Velocity (Section 12 (B) ) ");
      f.a_lateral_velocity.focus();
      return(false);
      } 

    var tbLen29 = f.septal_e.value.trim().length;
    if (tbLen29 == 0 ) {
      alert(" Please enter Septal E/e' (Section 12 ) ");
      f.septal_e.focus();
      return(false);
      } 

    var tbLen30 = f.lateral_e.value.trim().length;
    if (tbLen30 == 0 ) {
      alert(" Please enter Lateral E/e' (Section 12 ) ");
      f.lateral_e.focus();
      return(false);
      } 

    var tbLen31 = f.lateral_e.value.trim().length;
    if (tbLen31 == 0 ) {
      alert(" Please enter Lateral E/e' (Section 12 ) ");
      f.lateral_e.focus();
      return(false);
      } 

    var grad_lv = document.getElementsByName('grad_lv');
    var genValue = false;

        for(var i=0; i<grad_lv.length;i++){
            if(grad_lv[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose grading of LV Diastolic Function ");
            return false;
        }

    var tbLen32 = f.tapse.value.trim().length;
    if (tbLen32 == 0 ) {
      alert(" Please enter TAPSE (Section 12) ");
      f.tapse.focus();
      return(false);
      } 

    var tbLen33 = f.tapse.value.trim().length;
    if (tbLen33 == 0 ) {
      alert(" Please enter Trucuspid Annulus Plane Systolic Excursion (Section 13) ");
      f.tapse.focus();
      return(false);
      } 

    var asd = document.getElementsByName('asd');
    var genValue = false;

        for(var i=0; i<asd.length;i++){
            if(asd[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Atrial Septal Defect (ASD) (Section 14) ");
            return false;
        }
    var vsd = document.getElementsByName('vsd');
    var genValue = false;

        for(var i=0; i<vsd.length;i++){
            if(vsd[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Ventricular Septal Defect (VSD) (Section 14) ");
            return false;
        }
    var pda = document.getElementsByName('pda');
    var genValue = false;

        for(var i=0; i<pda.length;i++){
            if(pda[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Patent Ductus Arteriosus (PDA) (Section 14) ");
            return false;
        }

    var shunt = document.getElementsByName('shunt');
    var genValue = false;

        for(var i=0; i<shunt.length;i++){
            if(shunt[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert("  Choose shunt (Section 14) ");
            return false;
        }

    var tbLen34 = f.shunt_defect.value.trim().length;
    if (tbLen34 == 0 ) {
      alert(" Please enter Shunt defect size  (Section 14) ");
      f.shunt_defect.focus();
      return(false);
      } 

    var tbLen35 = f.associate_find.value.trim().length;
    if (tbLen35 == 0 ) {
      alert(" Please enter other associated findings  (Section 14) ");
      f.associate_find.focus();
      return(false);
      } 

    var normal_peri = document.getElementsByName('normal_peri');
    var genValue = false;

        for(var i=0; i<normal_peri.length;i++){
            if(normal_peri[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert("  Choose normal pericardium (Section 15) ");
            return false;
        }

    var peri_effu = document.getElementsByName('peri_effu');
    var genValue = false;

        for(var i=0; i<peri_effu.length;i++){
            if(peri_effu[i].checked == true ){
                genValue = true;    
            }
        }
        if(!genValue){
            alert("  Choose pericardial effusion (Section 15) ");
            return false;
        }

    var tbLen36 = f.size_effu.value.trim().length;
    if (tbLen36 == 0 ) {
      alert(" Please enter Size of Effusion (Section 15) ");
      f.size_effu.focus();
      return(false);
      } 

    var effu_type = document.getElementsByName('effu_type');
    var genValue = false;

        for(var i=0; i<effu_type.length;i++){
            if(effu_type[i].checked == true){
                genValue = true;    

            }
        }
        if(!genValue){
            alert("  Choose size of Effusion (Section 15) ");
            return false;
        }

    var tamphy = document.getElementsByName('tamphy');
    var genValue = false;

        for(var i=0; i<tamphy.length;i++){
            if(tamphy[i].checked == true ){
                genValue = true;    
            }
        }
        if(!genValue){
            alert("  Choose tamponade physiology (Section 15) ");
            return false;
        }

    var tbLen37 = f.echo_diag.value.trim().length;
    if (tbLen37 == 0 ) {
      alert(" Please enter Echo Diagnosis (Section 17) ");
      f.echo_diag.focus();
      return(false);
      } 
 
    var echo_type = document.getElementsByName('echo_type');
    var genValue = false;

        for(var i=0; i<echo_type.length;i++){
            if(echo_type[i].checked == true){
                genValue = true;    
            }
        }
        if(!genValue){
            alert(" Choose Conclusion Of Echo Assessment (Section 18) ");
            return false;
        }

}


function myFunctionla() 
  {

  var LaVolume =document.getElementById("la_volume").value / document.getElementById("bsa").value;

  document.getElementById("la_bsa").value = LaVolume.toFixed(1);
}
function myFunctionra() 
{

  var RaVolume =document.getElementById("ra_vol").value / document.getElementById("bsa").value;

  document.getElementById("ra_bsa").value = RaVolume.toFixed(1);

}

function myFunctionPV_ratio() 
{

  var PVratio = document.getElementById("systolic_velocity").value / document.getElementById("diastolic_velocity").value;

  document.getElementById("pv_ratio").value = PVratio.toFixed(1);

}

function funshunt(){
	if ( document.getElementById('shunt4').checked == true ){ 
		document.getElementById('shunt_defect').disabled = true;
		document.getElementById('shunt_defect').value = '0';

	} else {
		document.getElementById('shunt_defect').disabled = false;
		document.getElementById('shunt_defect').value = null;
	} 
}


function funceffu(){
	if ( document.getElementById('peri_effu2').checked == true ){
		document.getElementById('size_effu').disabled = true;
		document.getElementById('effu_type').disabled = true;
		document.getElementById('effu_type1').disabled = true;
		document.getElementById('effu_type2').disabled = true;
		document.getElementById('size_effu').value = '0';
              document.getElementById('effu_type3').disabled = false;
		document.getElementById('effu_type3').checked = true;

	} else {
		document.getElementById('size_effu').disabled = false;
		document.getElementById('effu_type').disabled = false;
		document.getElementById('effu_type1').disabled = false;
		document.getElementById('effu_type2').disabled = false;
		document.getElementById('size_effu').value = null;
              document.getElementById('effu_type3').checked = false;
              document.getElementById('effu_type3').disabled = true;
	} 
}


function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
            }

</script>
<style type="text/css">
 
 .textarea {
  resize: none;
  overflow: hidden;
  min-height: 50px;
  max-height: 100px;
}
   

.style1 {
  color: #FFFFFF;
  font-weight: bold;

  box-sizing: border-box;
}

.column {
  float: left;
  width: 50%;
  padding: 20px;
  height: 300px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

</style>
</head>
<body>

  <?php

    if($er == 1 AND $type == 1) { //add for admin


  ?>


  <div class="container" align="center">
    <tr>
      <td>
  <p>&nbsp;</p>
    <div id="txtHint">
    
    <tr>
    <td><a href="booking.php?x=0">Back</a></td>
  </tr>
  </div> 
</td>
</tr>
</div>


  <form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="echo_report_exec.php?er=1" >

  <div>
    <h3 align="center"> ECHOCARDIOGRAM REPORT</h3>
  </div>

 <div class="row">
  <div class="column" style="background-color:white;">

<div class="container p-3 my-3 bg-dark text-white">
<h6>1) Patient & Vital Signs Information</h6>
Name : <?php echo $row_rececho['Pat_Name']; ?><br>
IC/Passport : <?php echo $row_rececho['Pat_Ic']; ?><br>

Age : <?php echo $row_rececho['Pat_Age']; ?> &nbsp;&nbsp;&nbsp;&nbsp; Gender : <?php $gender = $row_rececho['Pat_Gender']; 
      mysqli_select_db($conn, $database_conn);
      $query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
      $recgender = mysqli_query($conn,$query_recgender) or die(mysqli_error($conn));
      $row_recgender = mysqli_fetch_assoc($recgender);
      echo $row_recgender['gender_name']?>&nbsp;&nbsp;&nbsp;&nbsp;

Ward/Unit : <?php echo $row_rececho['Pat_Wad']; ?><br>
Height : <?php echo $row_rececho['Height']; ?> cm &nbsp;&nbsp;&nbsp;&nbsp; Weight : <?php echo $row_rececho['Weight']; ?> kg<br>

BSA : <input type="text" name="bsa" id="bsa" size = "1" readonly value="<?php echo $bsa?> "/> m2 </input> <br><br>


Date : <input type="date" class="form-control" id="echo_date" name="echo_date"size = "10"/>  Time: <input type="time" class="form-control" id="echo_time" name="echo_time"size = "10"> <br>

  </div>

  <div class="container p-3 my-3 bg-dark text-white">
    <label> 2) Left Ventricular (LV) dimensions (2D/M-mode) </label><br>

    LV internal Dimension (diastole) = <input type="text" id="lv_diastole" name="lv_diastole" size = "1"/> cm  <br>

    LV internal Dimension (systole) = <input type="text" id="lv_systole" name="lv_systole" size = "1"/> cm <br>

    Interventricular Septum (diastole) = <input type="text" id="inter_diastole" name="inter_diastole" size = "1"/> cm <br>

    Interventricular Septum (systole) = <input type="text" id="inter_systole" name="inter_systole" size = "1"/> cm<br>

    LV Posterior Wall (diastole) = <input type="text" id="lv_post_diastole" name="lv_post_diastole" size = "1"/> cm <br>

    LV Posterior Wall (systole) = <input type="text" id="lv_post_systole" name="lv_post_systole" size = "1"/> cm<br><br>

        <label> 3) Left Artial (LA) dimensions (End-systole) </label><br>

        LA volume (biplane) = <input type="text" id="la_volume" name="la_volume" size = "1" onkeyup="myFunctionla()"/> ml<br>
        LA volume indexed  = <input type="text" id="la_bsa" name="la_bsa" size = "1" readonly />  ml/m2<br>

        <input type="radio" id="la_type" name="la_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="la_type" name="la_type" value="Abnormal"/><label>Abnormal</label><br><br>
  

        <label> 4) Right Ventricular (RV) dimensions (2D) </label><br>

        RV basal diameter = <input type="text" id="rv_diameter" name="rv_diameter" size = "1"/> cm  <br>
        Mid-RV diameter = <input type="text" id="mid_rv_diameter" name="mid_rv_diameter" size = "1"/> cm  <br>
        RV Length = <input type="text" id="rv_length" name="rv_length" size = "1"/> cm <br>
        <input type="radio" id="rv_type" name="rv_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="rv_type" name="rv_type" value="Abnormal"/><label>Abnormal</label><br><br>

        <label> 5) Right Artial (RA) dimensions (2D)</label><br>

        RA Volume = <input type="text" id="ra_vol" name="ra_vol" size = "1" onkeyup="myFunctionra()"/> ml <br>
        RA volume indexed = <input type="text" id="ra_bsa" name="ra_bsa" size = "1" readonly /> </span> ml/m2 <br>
        <input type="radio" id="ra_type" name="ra_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="ra_type" name="ra_type" value="Abnormal"/><label>Abnormal</label><br><br>

        <label> 6) Aortic Root Dimensions (2D)</label><br>
        <input type="radio" id="aortic_type" name="aortic_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="aortic_type" name="aortic_type" value="Abnormal"/><label>Abnormal</label><br><br>
        </div>

      <div class="container p-3 my-3 bg-dark text-white">
      <label> 7) Mitral Valve</label><br>
      <input type="radio" id="mv_type" name="mv_type" value="Native_valve"/><label for="mv_type">Native Valve</label>
      <input type="radio" id="mv_type" name="mv_type" value="Prosthetic_Valve"><label for="mv_type"/>Prosthetic Valve</label><br>

	
      <input type="radio" id="mv_result" name="mv_result" value="Normal"><label for="mv_result"/>Normal</label>
      <input type="radio" id="mv_result" name="mv_result" value="Abnormal"><label for="mv_result"/>Abnormal</label><br>
  

      <label for="mv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="mv_assess" name="mv_assess"/><br>

 
      <label>8) Aortic Valve</label><br>
      <input type="radio" id="aorv_type" name="aorv_type" value="Native_valve"><label for="aorv_type"/>Native Valve</label>
      <input type="radio" id="aorv_type" name="aorv_type" value="Prosthetic_Valve"><label for="aorv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="aorv_result" name="aorv_result" value="Normal"><label for="aorv_result"/>Normal</label>
      <input type="radio" id="aorv_result" name="aorv_result" value="Abnormal"><label for="aorv_result"/>Abnormal</label><br>


      <label for="av_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="av_assess" name="av_assess"/><br>

      <label> 9) Tricuspid Valve</label><br>
      <input type="radio" id="tv_type" name="tv_type" value="Native_valve"><label for="tv_type"/>Native Valve</label>
      <input type="radio" id="tv_type" name="tv_type" value="Prosthetic_Valve"><label for="tv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="tv_result" name="tv_result" value="Normal"><label for="tv_result"/>Normal</label>
      <input type="radio" id="tv_result" name="tv_result" value="Abnormal"><label for="tv_result"/>Abnormal</label><br>

      <label for="tv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="tv_assess" name="tv_assess"/><br>

      <label> 10) Pulmonary Valve</label><br>
      <input type="radio" id="pv_type" name="pv_type" value="Native_valve"><label for="pv_type"/>Native Valve</label>
      <input type="radio" id="pv_type" name="pv_type" value="Prosthetic_Valve"><label for="pv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="pv_result" name="pv_result" value="Normal"><label for="pv_result"/>Normal</label>
      <input type="radio" id="pv_result" name="pv_result" value="Abnormal"><label for="pv_result"/>Abnormal</label><br>

      <label for="pv_assess"> Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="pv_assess" name="pv_assess"/><br>

      <label> 11) Left Ventricular (LV) Systolic Function </label><br>
      Simpson = <input type="text" id="simpson" name="simpson" size = "1"> % ( 
      <input type="radio" id="simpson_type" name="simpson_type" value="Biplane"/><label>Biplane</label> /
      <input type="radio" id="simpson_type" name="simpson_type" value="Monoplane"/><label>Monoplane )</label> <br>
      Regional Wall Motion Abnormalities (RWMA):<br>
      <input type="radio" id="rmwa" name="rmwa" value="YES"/><label>YES</label>
      <input type="radio" id="rmwa" name="rmwa" value="NO"/><label>NO</label><br>
      <input type="text" class="form-control" id="rwma_comment" name="rwma_comment"><br>
      </div>
</div>

<div class="column" style="background-color:white;">
      <div class="container p-3 my-3 bg-dark text-white">


      <label> 12) Mitral Valve Inflow Profile: </label><br>
  
      E velocity = <input type="text" id="lv_e_velocity" name="lv_e_velocity" size = "1"/> cm/s<br>
      E/A ratio = <input type="text" id="lv_ea_velocity" name="lv_ea_velocity" size = "1"/><br>
      Deceleration Time (DT) = <input type="text" id="lv_dt" name="lv_dt" size = "1"/> msec<br><br>

      Pulmonary Venous Flow Profile :<br>
      Systolic flow velocity (S) = <input type="text" id="systolic_velocity" name="systolic_velocity" size = "1" onkeyup="myFunctionPV_ratio()"/>cm/s<br>
      Diastolic flow velocity (D)  = <input type="text" id="diastolic_velocity" name="diastolic_velocity" size = "1" onkeyup="myFunctionPV_ratio()"/> cm/s<br>
      PV S/D ratio  = <input type="text" id="pv_ratio" name="pv_ratio" size = "1" readonly /> cm/s<br>
      Atrial reversal flow velocity (Ar) = <input type="text" id="atrial_vel" name="atrial_vel" size = "1"/> cm/s<br>
      Atrial reversal flow duration = <input type="text" id="atrial_dur" name="atrial_dur" size = "1"/> msec<br><br>

      Tissue Doppler Imaging (TDI):<br>
      A) Septal Mitral Annulus: <br>
      S' Velocity = <input type="text" id="s_septal_velocity" name="s_septal_velocity" size = "1"/> cm/s<br>
      E' Velocity = <input type="text" id="e_septal_velocity" name="e_septal_velocity" size = "1"/> cm/s<br>
      A' velocity = <input type="text" id="a_septal_velocity" name="a_septal_velocity" size = "1"/> cm/s<br>

      B) Lateral Mitral Annulus: :<br>
      S' Velocity = <input type="text" id="s_lateral_velocity" name="s_lateral_velocity" size = "1"/> cm/s<br>
      E' Velocity = <input type="text" id="e_lateral_velocity" name="e_lateral_velocity" size = "1"/> cm/s<br>
      A' velocity = <input type="text" id="a_lateral_velocity" name="a_lateral_velocity" size = "1"/> cm/s<br><br>

      Septal E/e' = <input type="text" id="septal_e" name="septal_e" size = "1"/><br>
      Lateral E/e' = <input type="text" id="lateral_e" name="lateral_e" size = "1"/><br>
      Average E/e' = <input type="text" id="average_e" name="average_e" size = "1" /><br><br>

      Grading of LV Diastolic Function:<br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_0"/><label> Grad 0(Normal diastolic function)</label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_1"/><label> Grad 1(Impaired Relaxation) </label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_2"/><label> Grad 2(Pseudonormal Pattern) </label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_3"/><label> Grad 3(Restrictive Pattern) </label><br><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Indeterminate" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_Indeterminate') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      
      13) Right Ventricular (RV) Systolic Fuction<br>
      Trucuspid Annulus Plane Systolic Excursion
      (TAPSE) = <input type="text" id="tapse" name="tapse" size = "1"/> cm <br>
     </div>

    <div class="container p-3 my-3 bg-dark text-white">
        <label> 14) Congenital hearth Diseases </label><br>

        A) Atrial Septal Defect (ASD):
        <input type="radio" id="asd" name="asd" value="Yes"/><label> Yes </label>
        <input type="radio" id="asd" name="asd" value="No"/><label> No</label><br>
        B) Ventricular Septal Defect (VSD):
        <input type="radio" id="vsd" name="vsd" value="Yes"/><label> Yes </label>
        <input type="radio" id="vsd" name="vsd" value="No"/><label> No</label><br>

        C) Patent Ductus Arteriosus (PDA):
        <input type="radio" id="pda" name="pda" value="Yes"/><label for="pda"> Yes </label>
        <input type="radio" id="pda" name="pda" value="No"/><label for="pda"> No</label><br>
        Shunt:<br>
        <input type="radio" id="shunt" name="shunt" value="plr" onclick="funshunt()"/><label> Predominant left-to-right </label> <br>
        <input type="radio" id="shunt" name="shunt" value="prl" onclick="funshunt()"/><label> Predominant right-to-left</label><br>
        <input type="radio" id="shunt" name="shunt" value="bidi" onclick="funshunt()"/><label> Bidirectional</label><br>
	 <input type="radio" id="shunt4" name="shunt" value="noshunt" onclick="funshunt()"/><label> No Shunt</label><br>
        Shunt defect size approx <input type="text" id="shunt_defect" name="shunt_defect" size = "1"/> mm<br>
        Other associated findings: <br>
        <input type="text" class="form-control" id="associate_find" name="associate_find"/><br>

        <label> 15) Pericardial Diseases </label><br>

        Normal Pericardium
        <input type="radio" id="normal_peri" name="normal_peri" value="Yes" ><label> Yes </label>
        <input type="radio" id="normal_peri" name="normal_peri" value="No" /><label> No</label><br>

        Pericardial Effusion
        <input type="radio" id="peri_effu1" name="peri_effu" value="Yes" onclick="funceffu()"/><label> Yes </label>
        <input type="radio" id="peri_effu2" name="peri_effu" value="No" onclick="funceffu()"/><label> No</label><br>

        Size of Effusion <input type="text" id="size_effu" name="size_effu" size = "1"/>cm<br>
        <input type="radio" id="effu_type" name="effu_type" value="Small"/><label> Small </label>
        <input type="radio" id="effu_type1" name="effu_type" value="Moderate"/><label> Moderate </label>  
        <input type="radio" id="effu_type2" name="effu_type" value="Large"/><label> Large </label> 
		    <input type="radio" id="effu_type3" name="effu_type" value="No_Effusion" style="display:none;" /> <br>

        Tamponade physiology:
        <input type="radio" id="tamphy" name="tamphy" value="Yes"/><label> Yes </label>
        <input type="radio" id="tamphy" name="tamphy" value="No"/><label> No</label><br><br>
        <label for="tamphy_desc"> Tamponade Details </label><br>
        <input type="text" class="form-control" id="tamphy_desc" name="tamphy_desc"/><br><br>

        16)Vegetation
        <input type="radio" id="vegetation" name="vegetation" value="Yes"/><label> Yes </label>
        <input type="radio" id="vegetation" name="vegetation" value="No"/><label> No</label><br>
        <label for="vegetation_details">Vegetation details</label><br>
        <input type="text" class="form-control" id="vegetation_details" name="vegetation_details"/><br>

        17) Thrombus or other mass
        <input type="radio" id="thrombus_mass" name="thrombus_mass" value="Yes"/><label> Yes </label>
        <input type="radio" id="thrombus_mass" name="thrombus_mass" value="No"/><label> No</label><br>
        <label for="thrombus_details">Thrombus mass findings</label><br>
        <input type="text" class="form-control" id="thrombus_details" name="thrombus_details"/><br>

        <label for="other_find">18) Other Echo Findings </label>
        <input type="text" class="form-control" id="other_find" name="other_find"/>

        <label for="echo_diag">19) Echo Diagnosis </label>
        <input type="text" class="form-control" id="echo_diag" name="echo_diag"/>

        20) Conclusion Of Echo Assessment<br>
        <input type="radio" id="echo_type" name="echo_type" value="Normal_Echo"/><label> Normal Echo </label>
        <input type="radio" id="echo_type" name="echo_type" value="Abnormal_Echo"/><label> Abnormal Echo </label>
    </div>
      <div class="container p-3 my-3 border">

      <label for="txtappliedby">Reported By: </label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_recAccSet['name']; ?>" readonly /><br>
      <label for="comment">Comment</label>
      <textarea  class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason']; ?> </textarea>

      <input type="hidden" name="txtborangid" id="txtborangid" value="<?php echo $row_rececho['borang_id']; ?>"/>

      <input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recpat["borang_id"]; ?>" /><br>
      <button type="submit" name="submit" id="submit">Submit</button>
    </div>
</div>


  </form>
  </div>
  </div>
  </div>

    <?php
    
  } 


      elseif($er == 1 AND $type == 3) { //add for verify


  ?>


  <div class="container" align="center">
    <tr>
      <td>
  <p>&nbsp;</p>
    <div id="txtHint">
    
    <tr>
    <td><a href="booking.php?x=0">Back</a></td>
  </tr>
  </div> 
</td>
</tr>
</div>


  <form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="echo_report_exec.php?er=2" >
  <div>
    <h3 align="center"> ECHOCARDIOGRAM REPORT</h3>
  </div>

 <div class="row">
  <div class="column" style="background-color:white;">

<div class="container p-3 my-3 bg-dark text-white">
<h6>1) Patient & Vital Signs Information</h6>
Name : <?php echo $row_rececho['Pat_Name']; ?><br>
IC/Passport : <?php echo $row_rececho['Pat_Ic']; ?><br>

Age : <?php echo $row_rececho['Pat_Age']; ?> &nbsp;&nbsp;&nbsp;&nbsp; Gender : <?php $gender = $row_rececho['Pat_Gender']; 
      mysqli_select_db($conn, $database_conn);
      $query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
      $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
      $row_recgender = mysqli_fetch_assoc($recgender);
      echo $row_recgender['gender_name']?>&nbsp;&nbsp;&nbsp;&nbsp;

Ward/Unit : <?php echo $row_rececho['Pat_Wad']; ?><br>
Height : <?php echo $row_rececho['Height']; ?> cm &nbsp;&nbsp;&nbsp;&nbsp; Weight : <?php echo $row_rececho['Weight']; ?> kg<br>

BSA : <input type="text" name="bsa" id="bsa" size = "1" readonly value="<?php echo $bsa?> "/> m2 </input> <br><br>

Date : <input type="date" class="form-control" id="echo_date" name="echo_date"size = "10">  Time: <input type="time" class="form-control" id="echo_time" name="echo_time"size = "10"> <br>

  </div>

  <div class="container p-3 my-3 bg-dark text-white">
    <label> 2) Left Ventricular (LV) dimensions (2D/M-mode) </label><br>

    LV internal Dimension (diastole) = <input type="text" id="lv_diastole" name="lv_diastole" size = "1"/> cm  <br>

    LV internal Dimension (systole) = <input type="text" id="lv_systole" name="lv_systole" size = "1"/> cm <br>

    Interventricular Septum (diastole) = <input type="text" id="inter_diastole" name="inter_diastole" size = "1"/> cm <br>

    Interventricular Septum (systole) = <input type="text" id="inter_systole" name="inter_systole" size = "1"/> cm<br>

    LV Posterior Wall (diastole) = <input type="text" id="lv_post_diastole" name="lv_post_diastole" size = "1"/> cm <br>

    LV Posterior Wall (systole) = <input type="text" id="lv_post_systole" name="lv_post_systole" size = "1"/> cm<br><br>

        <label> 3) Left Artial (LA) dimensions (End-systole) </label><br>

        LA volume (biplane) = <input type="text" id="la_volume" name="la_volume" size = "1" onkeyup="myFunctionla()"/> ml<br>
        LA volume indexed  = <input type="text" id="la_bsa" name="la_bsa" size = "1" readonly />  ml/m2<br>
        <input type="radio" id="la_type" name="la_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="la_type" name="la_type" value="Abnormal"/><label>Abnormal</label><br><br>
  

        <label> 4) Right Ventricular (RV) dimensions (2D) </label><br>

        RV basal diameter = <input type="text" id="rv_diameter" name="rv_diameter" size = "1"/> cm  <br>
        Mid-RV diameter = <input type="text" id="mid_rv_diameter" name="mid_rv_diameter" size = "1"/> cm  <br>
        RV Length = <input type="text" id="rv_length" name="rv_length" size = "1"/> <br>
        <input type="radio" id="rv_type" name="rv_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="rv_type" name="rv_type" value="Abnormal"/><label>Abnormal</label><br><br>

        <label> 5) Right Artial (RA) dimensions (2D)</label><br>

        RA Volume = <input type="text" id="ra_vol" name="ra_vol" size = "1" onkeyup="myFunctionra()"/> ml <br>
        RA volume indexed = <input type="text" id="ra_bsa" name="ra_bsa" size = "1" readonly /> </span> ml/m2 <br>
        <input type="radio" id="ra_type" name="ra_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="ra_type" name="ra_type" value="Abnormal"/><label>Abnormal</label><br><br>

        <label> 6) Aortic Root Dimensions (2D)</label><br>
        <input type="radio" id="aortic_type" name="aortic_type" value="Normal"/><label>Normal</label>
        <input type="radio" id="aortic_type" name="aortic_type" value="Abnormal"/><label>Abnormal</label><br><br>
      </div>

    <div class="container p-3 my-3 bg-dark text-white">
      <label> 7) Mitral Valve</label><br>
      <input type="radio" id="mv_type" name="mv_type" value="Native_valve"/><label for="mv_type">Native Valve</label>
      <input type="radio" id="mv_type" name="mv_type" value="Prosthetic_Valve"><label for="mv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="mv_result" name="mv_result" value="Normal"><label for="mv_result"/>Normal</label>
      <input type="radio" id="mv_result" name="mv_result" value="Abnormal"><label for="mv_result"/>Abnormal</label><br>
  

      <label for="mv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="mv_assess" name="mv_assess"/><br>

 
      <label>8) Aortic Valve</label><br>
      <input type="radio" id="aorv_type" name="aorv_type" value="Native_valve"><label for="aorv_type"/>Native Valve</label>
      <input type="radio" id="aorv_type" name="aorv_type" value="Prosthetic_Valve"><label for="aorv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="aorv_result" name="aorv_result" value="Normal"><label for="aorv_result"/>Normal</label>
      <input type="radio" id="aorv_result" name="aorv_result" value="Abnormal"><label for="aorv_result"/>Abnormal</label><br>


      <label for="av_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="av_assess" name="av_assess"/><br>

      <label> 9) Tricuspid Valve</label><br>
      <input type="radio" id="tv_type" name="tv_type" value="Native_valve"><label for="tv_type"/>Native Valve</label>
      <input type="radio" id="tv_type" name="tv_type" value="Prosthetic_Valve"><label for="tv_type"/>Prosthetic Valve</label> <br>


      <input type="radio" id="tv_result" name="tv_result" value="Normal"><label for="tv_result"/>Normal</label>
      <input type="radio" id="tv_result" name="tv_result" value="Abnormal"><label for="tv_result"/>Abnormal</label><br>

      <label for="tv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="tv_assess" name="tv_assess"/><br>

      <label> 10) Pulmonary Valve</label><br>
      <input type="radio" id="pv_type" name="pv_type" value="Native_valve"><label for="pv_type"/>Native Valve</label>
      <input type="radio" id="pv_type" name="pv_type" value="Prosthetic_Valve"><label for="pv_type"/>Prosthetic Valve</label> <br>

      <input type="radio" id="pv_result" name="pv_result" value="Normal"><label for="pv_result"/>Normal</label>
      <input type="radio" id="pv_result" name="pv_result" value="Abnormal"><label for="pv_result"/>Abnormal</label><br>

      <label for="pv_assess"> Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="pv_assess" name="pv_assess"/><br>

      <label> 11) Left Ventricular (LV) Systolic Function </label><br>
      Simpson = <input type="text" id="simpson" name="simpson" size = "1"> % ( 
      <input type="radio" id="simpson_type" name="simpson_type" value="Biplane"/><label>Biplane</label> /
      <input type="radio" id="simpson_type" name="simpson_type" value="Monoplane"/><label>Monoplane )</label> <br>
      Regional Wall Motion Abnormalities (RWMA):<br>
      <input type="radio" id="rmwa" name="rmwa" value="YES"/><label>YES</label>
      <input type="radio" id="rmwa" name="rmwa" value="NO"/><label>NO</label><br>
      <input type="text" class="form-control" id="rwma_comment" name="rwma_comment"><br>
      </div>
</div>

<div class="column" style="background-color:white;">
      <div class="container p-3 my-3 bg-dark text-white">


      <label> 12) Mitral Valve Inflow Profile: </label><br>
  
      E velocity = <input type="text" id="lv_e_velocity" name="lv_e_velocity" size = "1"/> cm/s<br>
      E/A ratio = <input type="text" id="lv_ea_velocity" name="lv_ea_velocity" size = "1"/><br>
      Deceleration Time (DT) = <input type="text" id="lv_dt" name="lv_dt" size = "1"/> msec<br><br>

      Pulmonary Venous Flow Profile :<br>
      Systolic flow velocity (S) = <input type="text" id="systolic_velocity" name="systolic_velocity" size = "1" onkeyup="myFunctionPV_ratio()"/>cm/s<br>
      Diastolic flow velocity (D)  = <input type="text" id="diastolic_velocity" name="diastolic_velocity" size = "1" onkeyup="myFunctionPV_ratio()"/> cm/s<br>
      PV S/D ratio  = <input type="text" id="pv_ratio" name="pv_ratio" size = "1" readonly /> cm/s<br>
      Atrial reversal flow velocity (Ar) = <input type="text" id="atrial_vel" name="atrial_vel" size = "1"/> cm/s<br>
      Atrial reversal flow duration = <input type="text" id="atrial_dur" name="atrial_dur" size = "1"/> msec<br><br>

      Tissue Doppler Imaging (TDI):<br>
      A) Septal Mitral Annulus: <br>
      S' Velocity = <input type="text" id="s_septal_velocity" name="s_septal_velocity" size = "1"/> cm/s<br>
      E' Velocity = <input type="text" id="e_septal_velocity" name="e_septal_velocity" size = "1"/> cm/s<br>
      A' velocity = <input type="text" id="a_septal_velocity" name="a_septal_velocity" size = "1"/> cm/s<br>

      B) Lateral Mitral Annulus: :<br>
      S' Velocity = <input type="text" id="s_lateral_velocity" name="s_lateral_velocity" size = "1"/> cm/s<br>
      E' Velocity = <input type="text" id="e_lateral_velocity" name="e_lateral_velocity" size = "1"/> cm/s<br>
      A' velocity = <input type="text" id="a_lateral_velocity" name="a_lateral_velocity" size = "1"/> cm/s<br><br>

      Septal E/e' = <input type="text" id="septal_e" name="septal_e" size = "1"/><br>
      Lateral E/e' = <input type="text" id="lateral_e" name="lateral_e" size = "1"/><br>
      Average E/e' = <input type="text" id="average_e" name="average_e" size = "1"/><br><br>

      Grading of LV Diastolic Function:<br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_0"/><label> Grad 0(Normal diastolic function)</label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_1"/><label> Grad 1(Impaired Relaxation) </label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_2"/><label> Grad 2(Pseudonormal Pattern) </label><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_3"/><label> Grad 3(Restrictive Pattern) </label><br><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Indeterminate" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_Indeterminate') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      
      13) Right Ventricular (RV) Systolic Fuction<br>
      Trucuspid Annulus Plane Systolic Excursion
      (TAPSE) = <input type="text" id="tapse" name="tapse" size = "1"/> cm <br>
     </div>

    <div class="container p-3 my-3 bg-dark text-white">
        <label> 14) Congenital hearth Diseases </label><br>

        A) Atrial Septal Defect (ASD):
        <input type="radio" id="asd" name="asd" value="Yes"/><label> Yes </label>
        <input type="radio" id="asd" name="asd" value="No"/><label> No</label><br>
        B) Ventricular Septal Defect (VSD):
        <input type="radio" id="vsd" name="vsd" value="Yes"/><label> Yes </label>
        <input type="radio" id="vsd" name="vsd" value="No"/><label> No</label><br>
        C) Patent Ductus Arteriosus (PDA):
        <input type="radio" id="pda" name="pda" value="Yes"/><label for="pda"> Yes </label>
        <input type="radio" id="pda" name="pda" value="No"/><label for="pda"> No</label><br>
        Shunt:<br>
        <input type="radio" id="shunt" name="shunt" value="plr"  onclick="funshunt()"/><label> Predominant left-to-right </label> <br>
        <input type="radio" id="shunt" name="shunt" value="prl"  onclick="funshunt()"/><label> Predominant right-to-left</label><br>
        <input type="radio" id="shunt" name="shunt" value="bidi"  onclick="funshunt()"/><label> Bidirectional</label><br>
	 <input type="radio" id="shunt4" name="shunt" value="noshunt" onclick="funshunt()"/><label> No Shunt</label><br>
        Shunt defect size approx <input type="text" id="shunt_defect" name="shunt_defect" size = "1"/> mm<br>
        Other associated findings: <br>
        <input type="text" class="form-control" id="associate_find" name="associate_find"/><br>

        <label> 15) Pericardial Diseases </label><br>

        Normal Pericardium
        <input type="radio" id="normal_peri" name="normal_peri" value="Yes" ><label> Yes </label>
        <input type="radio" id="normal_peri" name="normal_peri" value="No" /><label> No</label><br>
        
        Pericardial Effusion
        <input type="radio" id="peri_effu1" name="peri_effu" value="Yes" onclick="funceffu()"/><label> Yes </label>
        <input type="radio" id="peri_effu2" name="peri_effu" value="No" onclick="funceffu()"/><label> No</label><br>

        <label for="peri_location"> Location </label><br>
        <input type="text" class="form-control" id="peri_location" name="peri_location"/><br><br>

        Size of Effusion <input type="text" id="size_effu" name="size_effu" size = "1"/>cm<br>
        <input type="radio" id="effu_type" name="effu_type" value="Small"/><label> Small </label>
        <input type="radio" id="effu_type1" name="effu_type" value="Moderate"/><label> Moderate </label>  
        <input type="radio" id="effu_type2" name="effu_type" value="Large"/><label> Large </label> 
        <input type="radio" id="effu_type3" name="effu_type" value="No_Effusion" style="display:none;" /> <br>


        Tamponade physiology:
        <input type="radio" id="tamphy" name="tamphy" value="Yes"/><label> Yes </label>
        <input type="radio" id="tamphy" name="tamphy" value="No"/><label> No</label><br><br>

        <label for="other_find">16) Other Echo Findings </label>
        <input type="text" class="form-control" id="other_find" name="other_find"/>

        <label for="echo_diag">17) Echo Diagnosis </label>
        <input type="text" class="form-control" id="echo_diag" name="echo_diag"/>

        18) Conclusion Of Echo Assessment<br>
        <input type="radio" id="echo_type" name="echo_type" value="Normal_Echo"/><label> Normal Echo </label>
        <input type="radio" id="echo_type" name="echo_type" value="Abnormal_Echo"/><label> Abnormal Echo </label>
</div>
      <div class="container p-3 my-3 border">

      <label for="txtappliedby">Reported By: </label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_recAccSet['name']; ?>" readonly /><br>

      <label for="txtverifyby">Verify By: </label>
      <input type="text" class="form-control" name="txtverifyby" id="txtverifyby" value="<?php echo $row_recAccSet['name']; ?>" readonly /><br>
      <input type="checkbox" name="chbverify" > <label><b> Verification </b> (Please Click If To Verify, Then Submit ) </label>
     </div>

     <label for="comment">Comment</label>
     <textarea  class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason']; ?> </textarea>


      <input type="hidden" name="txtborangid" id="txtborangid" value="<?php echo $row_rececho['borang_id']; ?>"/>

      <input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recpat["borang_id"]; ?>" /><br>
      <button type="submit" name="submit" id="submit">Submit</button>
    </div>
</div>


  </form>
  </div>
  </div>
  </div>

    <?php
  }

      else if ($er == 3) { //edit by verify

  ?>


  <div class="container" align="center">
    <tr>
      <td>
  <p>&nbsp;</p>
    <div id="txtHint">
    
    <tr>
    <td><a href="booking.php?x=0">Back</a></td>
  </tr>
  </div> 
</td>
</tr>
</div>


  <form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="echo_report_exec.php?er=3" >
  <div>
    <h3 align="center"> ECHOCARDIOGRAM REPORT</h3>
  </div>

 <div class="row">
  <div class="column" style="background-color:white;">

<div class="container p-3 my-3 bg-dark text-white">
<h6>1) Patient & Vital Signs Information</h6><br>
Name : <?php echo $row_rececho['Pat_Name']; ?><br>
IC/Passport : <?php echo $row_rececho['Pat_Ic']; ?><br>
Age : <?php echo $row_rececho['Pat_Age']; ?> &nbsp;&nbsp;&nbsp;&nbsp; Gender : <?php $gender = $row_rececho['Pat_Gender']; 
      mysqli_select_db($conn, $database_conn);
      $query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
      $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
      $row_recgender = mysqli_fetch_assoc($recgender);
      echo $row_recgender['gender_name']?>&nbsp;&nbsp;&nbsp;&nbsp;

Ward/Unit : <?php echo $row_rececho['Pat_Wad']; ?><br>
Height : <?php echo $row_rececho['Height']; ?> cm &nbsp;&nbsp;&nbsp;&nbsp; Weight : <?php echo $row_rececho['Weight']; ?> kg<br>

BSA : <input type="text" id="bsa" name="bsa" size = "1" value = "<?php echo $row_rececho1['Bsa']; ?>" readonly/> m2<br>

Date : <input type="date" class="form-control" id="echo_date" name="echo_date"size = "10" value = "<?php echo $row_rececho1['Echo_Date']; ?>" />  Time: <input type="time" class="form-control" id="echo_time" name="echo_time"size = "10" value = "<?php echo $row_rececho1['Echo_Time']; ?>" />  <br>

  </div>

  <div class="container p-3 my-3 bg-dark text-white">
    <label> 2) Left Ventricular (LV) dimensions (2D/M-mode) </label><br>

    LV internal Dimension (diastole) = <input type="text" id="lv_diastole" name="lv_diastole" size = "1" value = "<?php echo $row_rececho1['LV_diastole']; ?>" />  cm <br>

    LV internal Dimension (systole) = <input type="text" id="lv_systole" name="lv_systole" size = "1" value = "<?php echo $row_rececho1['LV_systole']; ?>" />  cm<br>

    Interventricular Septum (diastole) = <input type="text" id="inter_diastole" name="inter_diastole" size = "1" value = "<?php echo $row_rececho1['Inter_diastole']; ?> "/> cm<br>

    Interventricular Septum (systole) = <input type="text" id="inter_systole" name="inter_systole" size = "1" value = "<?php echo $row_rececho1['Inter_systole']; ?> "/> cm<br>

    LV Posterior Wall (diastole) = <input type="text" id="lv_post_diastole" name="lv_post_diastole" size = "1" value = "<?php echo $row_rececho1['Post_diastole']; ?> "/>  cm <br>

    LV Posterior Wall (systole) = <input type="text" id="lv_post_systole" name="lv_post_systole" size = "1" value = "<?php echo $row_rececho1['Post_systole']; ?> "/> cm<br><br>

        <label> 3) Left Artial (LA) dimensions (End-systole) </label><br>

        LA volume (biplane) = <input type="text" id="la_volume" name="la_volume" size = "1" onkeyup="myFunctionla()" value = "<?php echo $row_rececho1['LA_Volume']; ?>"/> cm3<br>
        LA volume indexed  = <input type="text" id="la_bsa" name="la_bsa" size = "1" value = "<?php echo $row_rececho1['LA_BSA']; ?> "readonly/> ml/m2<br>
        <input type="radio" id="la_type" name="la_type" value="Normal"  <?php echo ( $row_rececho1['LA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
        <input type="radio" id="la_type" name="la_type" value="Abnormal" <?php echo ( $row_rececho1['LA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>
  

        <label> 4) Right Ventricular (RV) dimensions (2D) </label><br>

        RV basal diameter = <input type="text" id="rv_diameter" name="rv_diameter" size = "1" value = "<?php echo $row_rececho1['RV_Dia']; ?> "/> cm <br>
        Mid-RV diameter = <input type="text" id="mid_rv_diameter" name="mid_rv_diameter" size = "1" value = "<?php echo $row_rececho1['Mid_RV']; ?> "/> cm <br>
        RV Length = <input type="text" id="rv_length" name="rv_length" size = "1" value = "<?php echo $row_rececho1['RV_Length']; ?> "/> cm <br>
          <input type="radio" id="rv_type" name="rv_type" value="Normal"  <?php echo ( $row_rececho1['RV_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio" id="rv_type" name="rv_type" value="Abnormal" <?php echo ( $row_rececho1['RV_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>

        <label> 5) Right Artial (RA) dimensions (2D)</label><br>

        RA Volume = <input type="text" id="ra_vol" name="ra_vol" size = "1"onkeyup="myFunctionra()" value = "<?php echo $row_rececho1['RA_Volume']; ?> "/> <br>
        RA volume indexed = <input type="text" id="ra_bsa" name="ra_bsa" size = "1" value = "<?php echo $row_rececho1['RA_BSA']; ?>"readonly/> cml/m2 <br>
          <input type="radio" id="ra_type" name="ra_type" value="Normal"  <?php echo ( $row_rececho1['RA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio" id="ra_type" name="ra_type" value="Abnormal" <?php echo ( $row_rececho1['RA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>

        <label> 6) Aortic Root Dimensions (2D)</label><br>
        <input type="radio" id="aortic_type" name="aortic_type" value="Normal"  <?php echo ( $row_rececho1['AR_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
        <input type="radio" id="aortic_type" name="aortic_type" value="Abnormal" <?php echo ( $row_rececho1['AR_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>
      </div>

    <div class="container p-3 my-3 bg-dark text-white">
      <label> 7) Mitral Valve</label><br>
      <input type="radio" id="mv_type" name="mv_type" value="Native_valve" <?php echo ( $row_rececho2['MV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="mv_type" name="mv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['MV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>


      <input type="radio" id="mv_result" name="mv_result" value="Normal"<?php echo ( $row_rececho2['MV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="mv_result" name="mv_result" value="Abnormal"<?php echo ( $row_rececho2['MV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>
  

      <label for="mv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="mv_assess" name="mv_assess" value = "<?php echo $row_rececho2['MV_assess']; ?>" /><br>

 
      <label>8) Aortic Valve</label><br>
      <input type="radio" id="aorv_type" name="aorv_type" value="Native_valve" <?php echo ( $row_rececho2['AV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="aorv_type" name="aorv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['AV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>


      <input type="radio" id="aorv_result" name="aorv_result" value="Normal"<?php echo ( $row_rececho2['AV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="aorv_result" name="aorv_result" value="Abnormal"<?php echo ( $row_rececho2['AV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>


      <label for="av_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="av_assess" name="av_assess" value = "<?php echo $row_rececho2['AV_assess']; ?>" /><br>

      <label> 9) Tricuspid Valve</label><br>
      <input type="radio" id="tv_type" name="tv_type" value="Native_valve" <?php echo ( $row_rececho2['TV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="tv_type" name="tv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['TV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>


      <input type="radio" id="tv_result" name="tv_result" value="Normal"<?php echo ( $row_rececho2['TV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="tv_result" name="tv_result" value="Abnormal"<?php echo ( $row_rececho2['TV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>

      <label for="tv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="tv_assess" name="tv_assess" value = "<?php echo $row_rececho2['TV_assess']; ?>" /><br>

      <label> 10) Pulmonary Valve</label><br>
      <input type="radio" id="pv_type" name="pv_type" value="Native_valve" <?php echo ( $row_rececho2['PV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="pv_type" name="pv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['PV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>


      <input type="radio" id="pv_result" name="pv_result" value="Normal"<?php echo ( $row_rececho2['PV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="pv_result" name="pv_result" value="Abnormal"<?php echo ( $row_rececho2['PV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>

      <label for="pv_assess"> Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="pv_assess" name="pv_assess" value = "<?php echo $row_rececho2['PV_assess']; ?>" /><br>

      <label> 11) Left Ventricular (LV) Systolic Function </label><br>
      Simpson = <input type="text" id="simpson" name="simpson" size = "1" value = "<?php echo $row_rececho3['LV_Simspson']; ?>" /> % ( 
      <input type="radio" id="simpson_type" name="simpson_type" value="Biplane" <?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Biplane') ? 'checked' : ''; ?> /> Biplane /
      <input type="radio" id="simpson_type" name="simpson_type" value="Monoplane"<?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Monoplane') ? 'checked' : ''; ?> /> Monoplane ) <br><br>
      Regional Wall Motion Abnormalities (RWMA):<br>
      <input type="radio" id="rmwa" name="rmwa" value="YES" <?php echo ( $row_rececho3['LV_RWMA'] == 'YES') ? 'checked' : ''; ?> /> YES
      <input type="radio" id="rmwa" name="rmwa" value="NO"  <?php echo ( $row_rececho3['LV_RWMA'] == 'NO') ? 'checked' : ''; ?> /> NO <br>
      <input type="text" class="form-control" id="rwma_comment" name="rwma_comment"  value = "<?php echo $row_rececho3['LV_RWMA_Com']; ?>"> <br>
      </div>
</div>

<div class="column" style="background-color:white;">
      <div class="container p-3 my-3 bg-dark text-white">


      <label> 12) Mitral Valve Inflow Profile: </label><br>

      E velocity = <input type="text" id="lv_e_velocity" name="lv_e_velocity" size = "1" value = "<?php echo $row_rececho3['LV_E_Vel']; ?> "/> cm/s<br>
      E/A ratio = <input type="text" id="lv_ea_velocity" name="lv_ea_velocity" size = "1" value = "<?php echo $row_rececho3['LV_EA_Velocity']; ?> "/> <br>
      Deceleration Time (DT) = <input type="text" id="lv_dt" name="lv_dt" size = "1" value = "<?php echo $row_rececho3['LV_DT']; ?> "/> msec<br><br>

      Pulmonary Venous Flow Profile :<br>
      Systolic flow velocity (S) = <input type="text" id="systolic_velocity" name="systolic_velocity" size = "1" value = "<?php echo $row_rececho3['Sys_Vel']; ?>" onkeyup="myFunctionPV_ratio()"/>cm/s<br>
      Diastolic flow velocity (D)  = <input type="text" id="diastolic_velocity" name="diastolic_velocity" size = "1" value = "<?php echo $row_rececho3['Dias_Vel']; ?> "onkeyup="myFunctionPV_ratio()"/> cm/s<br>
      PV S/D ratio  = <input type="text" id="pv_ratio" name="pv_ratio" size = "1" value = "<?php echo $row_rececho3['PV_Ratio']; ?> "readonly/> cm/s<br>
      Atrial reversal flow velocity (Ar) = <input type="text" id="atrial_vel" name="atrial_vel" size = "1" value = "<?php echo $row_rececho3['Atrial_Vel']; ?> "/> cm/s<br>
      Atrial reversal flow duration = <input type="text" id="atrial_dur" name="atrial_dur" size = "1" value = "<?php echo $row_rececho3['Atrial_Dur']; ?> "/> msec<br><br>

      Tissue Doppler Imaging (TDI):<br>
      A) Septal Mitral Annulus: <br>
      S' Velocity = <input type="text" id="s_septal_velocity" name="s_septal_velocity" size = "1" value = "<?php echo $row_rececho3['S_Septal_Velocity']; ?> "/> cm/s<br>
      E' Velocity = <input type="text" id="e_septal_velocity" name="e_septal_velocity" size = "1" value = "<?php echo $row_rececho3['E_septal_velocity']; ?> "/> cm/s<br>
      A' velocity = <input type="text" id="a_septal_velocity" name="a_septal_velocity" size = "1" value = "<?php echo $row_rececho3['A_septal_velocity']; ?> "/> cm/s<br>

      B) Lateral Mitral Annulus: :<br>
      S' Velocity = <input type="text" id="s_lateral_velocity" name="s_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['S_lateral_velocity']; ?> "/> cm/s<br>
      E' Velocity = <input type="text" id="e_lateral_velocity" name="e_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['E_lateral_velocity']; ?> "/> cm/s<br>
      A' velocity = <input type="text" id="a_lateral_velocity" name="a_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['A_lateral_velocity']; ?> "/> cm/s<br> <br>

      Septal E/e' = <input type="text" id="septal_e" name="septal_e" size = "1" value = "<?php echo $row_rececho3['Septal_E']; ?> " /><br>
      Lateral E/e' = <input type="text" id="lateral_e" name="lateral_e" size = "1" value = "<?php echo $row_rececho3['Lateral_E']; ?> " /><br>
      Average E/e' = <input type="text" id="average_e" name="average_e" size = "1" value = "<?php echo $row_rececho3['Average_E']; ?> "  /><br><br>

      Grading of LV Diastolic Function:<br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_0" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_0') ? 'checked' : ''; ?> /> Grad 0(Normal diastolic function) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_1" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_1') ? 'checked' : ''; ?> /> Grad 1(Impaired Relaxation) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_2" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_2') ? 'checked' : ''; ?> /> Grad 2(Pseudonormal Pattern) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_3" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_3') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Indeterminate" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_Indeterminate') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      
      13) Right Ventricular (RV) Systolic Fuction<br>
      Trucuspid Annulus Plane Systolic Excursion
      (TAPSE) = <input type="text" id="tapse" name="tapse" size = "1" value = "<?php echo $row_rececho3['TAPSE']; ?> "/><br>
     </div>

    <div class="container p-3 my-3 bg-dark text-white">
        <label> 14) Congenital hearth Diseases </label><br>

        A) Atrial Septal Defect (ASD):
        <input type="radio" id="asd" name="asd" value="Yes"<?php echo ( $row_rececho4['Asd'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="asd" name="asd" value="No"<?php echo ( $row_rececho4['Asd'] == 'No') ? 'checked' : ''; ?> /> No<br>
        B) Ventricular Septal Defect (VSD):
        <input type="radio" id="vsd" name="vsd" value="Yes" <?php echo ( $row_rececho4['VSD'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="vsd" name="vsd" value="No" <?php echo ( $row_rececho4['VSD'] == 'No') ? 'checked' : ''; ?> /> No<br>
        C) Patent Ductus Arteriosus (PDA):
        <input type="radio" id="pda" name="pda" value="Yes" <?php echo ( $row_rececho4['Pda'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="pda" name="pda" value="No" <?php echo ( $row_rececho4['Pda'] == 'No') ? 'checked' : ''; ?> /> No<br>
        Shunt:<br>
        <input type="radio" id="shunt" name="shunt" value="plr"<?php echo ( $row_rececho4['Shunt'] == 'plr') ? 'checked' : ''; ?>  onclick="funshunt()"/> Predominant left-to-right </label> <br>
        <input type="radio" id="shunt" name="shunt" value="prl"<?php echo ( $row_rececho4['Shunt'] == 'prl') ? 'checked' : ''; ?>  onclick="funshunt()"/> Predominant right-to-left</label><br>
        <input type="radio" id="shunt" name="shunt" value="bidi"<?php echo ( $row_rececho4['Shunt'] == 'bidi') ? 'checked' : ''; ?>  onclick="funshunt()"/> Bidirectional</label><br>
	 <input type="radio" id="shunt4" name="shunt" value="noshunt"<?php echo ( $row_rececho4['Shunt'] == 'noshunt') ? 'checked' : ''; ?>  onclick="funshunt()"/> No Shunt</label><br>
        Shunt defect size approx <input type="text" id="shunt_defect" name="shunt_defect" size = "1" value= "<?php echo $row_rececho4['Shunt_Defect']; ?>" /> mm<br>
        Other associated findings: <br>
        <input type="text" class="form-control" id="associate_find" name="associate_find" value = "<?php echo $row_rececho4['A_Find']; ?> "/><br>

        <label> 15) Pericardial Diseases </label><br>

        Normal Pericardium
        <input type="radio" id="normal_peri" name="normal_peri" value="Yes" <?php echo ( $row_rececho4['N_Peri'] == 'Yes') ? 'checked' : ''; ?> /> Yes 
        <input type="radio" id="normal_peri" name="normal_peri" value="No" <?php echo ( $row_rececho4['N_Peri'] == 'No') ? 'checked' : ''; ?> /> No <br>
        
        Pericardial Effusion
        <input type="radio" id="peri_effu1" name="peri_effu" value="Yes" <?php echo ( $row_rececho4['P_Effu'] == 'Yes') ? 'checked' : ''; ?> onclick="funceffu()"/> Yes
        <input type="radio" id="peri_effu2" name="peri_effu" value="No" <?php echo ( $row_rececho4['P_Effu'] == 'No') ? 'checked' : ''; ?> onclick="funceffu()" /> No <br>
       
        Size of Effusion <input type="text" id="size_effu" name="size_effu" size = "1" value = "<?php echo $row_rececho4['Size_Effu']; ?> "/> cm<br>
        <input type="radio" id="effu_type" name="effu_type" value="Small" <?php echo ( $row_rececho4['Effu_Type'] == 'Small') ? 'checked' : ''; ?> /> <label> Small </label>
        <input type="radio" id="effu_type1" name="effu_type" value="Moderate" <?php echo ( $row_rececho4['Effu_Type'] == 'Moderate') ? 'checked' : ''; ?> /> <label>Moderate </label>
        <input type="radio" id="effu_type2" name="effu_type" value="Large" <?php echo ( $row_rececho4['Effu_Type'] == 'Large') ? 'checked' : ''; ?> /><label> Large </label>
        <input type="radio" id="effu_type3" name="effu_type" value="No_Effusion" style="display:none;"  <?php echo ( $row_rececho4['Effu_Type'] == 'No_Effusion') ? 'checked' : ''; ?> /> <br>


        Tamponade physiology:
        <input type="radio" id="tamphy" name="tamphy" value="Yes" <?php echo ( $row_rececho4['Tamphy'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="tamphy" name="tamphy" value="No" <?php echo ( $row_rececho4['Tamphy'] == 'No') ? 'checked' : ''; ?> /> No<br><br>

        <label for="other_find">16) Other Echo Findings </label>
        <input type="text" class="form-control" id="other_find" name="other_find" value = "<?php echo $row_rececho4['Other_Find']; ?> "/>

        <label for="echo_diag">17) Echo Diagnosis </label>
        <input type="text" class="form-control" id="echo_diag" name="echo_diag" value = "<?php echo $row_rececho4['Echo_Diag']; ?> "/> <br>

        18) Conclusion Of Echo Assessment<br>
        <input type="radio" id="echo_type" name="echo_type" value="Normal_Echo" <?php echo ( $row_rececho4['Echo_Type'] == 'Normal_Echo') ? 'checked' : ''; ?> />  Normal Echo </label>
        <input type="radio" id="echo_type" name="echo_type" value="Abnormal_Echo" <?php echo ( $row_rececho4['Echo_Type'] == 'Abnormal_Echo') ? 'checked' : ''; ?> />  Abnormal Echo </label>
    </div>
      <div class="container p-3 my-3 border">

      <label for="txtappliedby">Reported By: </label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_rececho4['report_by']; ?>" readonly /><br>

      <label for="txtverifyby">Verify By: </label>
      <input type="text" class="form-control" name="txtverifyby" id="txtverifyby" value="<?php echo $row_recAccSet['name']; ?>" readonly /><br>
      <label for="comment">Comment</label>
      <textarea  class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason']; ?> </textarea>


      <input type="hidden" name="txtcolumn1" id="txtcolumn1" value="<?php echo $row_rececho1['column1_id']; ?>"/>
      <input type="hidden" name="txtcolumn2" id="txtcolumn2" value="<?php echo $row_rececho2['column2_id']; ?>"/>
      <input type="hidden" name="txtcolumn3" id="txtcolumn3" value="<?php echo $row_rececho3['column3_id']; ?>"/>
      <input type="hidden" name="txtcolumn4" id="txtcolumn4" value="<?php echo $row_rececho4['column4_id']; ?>"/>
      <input type="hidden" name="txtidedit" id="txtidedit" value="<?php echo $row_recpat["borang_id"]; ?>" />
      <input type="checkbox" name="chbverify" > <label> <b> Verification </b> (Please Click If To Verify, Then Submit ) </label> <br>
      <button type="submit" name="submit" id="submit">SUBMIT</button>
    </div></div>


  </form>
  </div>
  </div>
  </div>

    <?php
  
  } 


     else if ($er == 4) { //edit by admin

  ?>


  <div class="container" align="center">
    <tr>
      <td>
  <p>&nbsp;</p>
    <div id="txtHint">
    
    <tr>
    <td><a href="booking.php?x=0">Back</a></td>
  </tr>
  </div> 
</td>
</tr>
</div>


  <form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="echo_report_exec.php?er=4" >
  <div>
    <h3 align="center"> ECHOCARDIOGRAM REPORT</h3>
  </div>

 <div class="row">
  <div class="column" style="background-color:white;">

<div class="container p-3 my-3 bg-dark text-white">
<h6>1) Patient & Vital Signs Information</h6><br>
Name : <?php echo $row_rececho['Pat_Name']; ?><br>
IC/Passport : <?php echo $row_rececho['Pat_Ic']; ?><br>
Age : <?php echo $row_rececho['Pat_Age']; ?> &nbsp;&nbsp;&nbsp;&nbsp; Gender : <?php $gender = $row_rececho['Pat_Gender']; 
      mysqli_select_db($conn, $database_conn);
      $query_recgender = "SELECT * FROM gender_tbl WHERE gender_id = '$gender'";
      $recgender = mysqli_query($conn, $query_recgender) or die(mysqli_error($conn));
      $row_recgender = mysqli_fetch_assoc($recgender);
      echo $row_recgender['gender_name']?>&nbsp;&nbsp;&nbsp;&nbsp;

Ward/Unit : <?php echo $row_rececho['Pat_Wad']; ?><br>
Height : <?php echo $row_rececho['Height']; ?> cm &nbsp;&nbsp;&nbsp;&nbsp; Weight : <?php echo $row_rececho['Weight']; ?> kg<br>

BSA : <input type="text" id="bsa" name="bsa" size = "1" value = "<?php echo $row_rececho1['Bsa']; ?>" readonly/> m2<br>

Date : <input type="date" class="form-control" id="echo_date" name="echo_date"size = "10" value = "<?php echo $row_rececho1['Echo_Date']; ?>" />  Time: <input type="time" class="form-control" id="echo_time" name="echo_time"size = "10" value = "<?php echo $row_rececho1['Echo_Time']; ?>" />  <br>

  </div>

  <div class="container p-3 my-3 bg-dark text-white">
    <label> 2) Left Ventricular (LV) dimensions (2D/M-mode) </label><br>

    LV internal Dimension (diastole) = <input type="text" id="lv_diastole" name="lv_diastole" size = "1" value = "<?php echo $row_rececho1['LV_diastole']; ?>" />  cm <br>

    LV internal Dimension (systole) = <input type="text" id="lv_systole" name="lv_systole" size = "1" value = "<?php echo $row_rececho1['LV_systole']; ?>" />  cm<br>

    Interventricular Septum (diastole) = <input type="text" id="inter_diastole" name="inter_diastole" size = "1" value = "<?php echo $row_rececho1['Inter_diastole']; ?> "/> cm<br>

    Interventricular Septum (systole) = <input type="text" id="inter_systole" name="inter_systole" size = "1" value = "<?php echo $row_rececho1['Inter_systole']; ?> "/> cm<br>

    LV Posterior Wall (diastole) = <input type="text" id="lv_post_diastole" name="lv_post_diastole" size = "1" value = "<?php echo $row_rececho1['Post_diastole']; ?> "/>  cm <br>

    LV Posterior Wall (systole) = <input type="text" id="lv_post_systole" name="lv_post_systole" size = "1" value = "<?php echo $row_rececho1['Post_systole']; ?> "/> cm<br><br>

        <label> 3) Left Artial (LA) dimensions (End-systole) </label><br>

        LA volume (biplane) = <input type="text" id="la_volume" name="la_volume" size = "1" onkeyup="myFunctionla()" value = "<?php echo $row_rececho1['LA_Volume']; ?>"/> cm3<br>
        LA volume indexed  = <input type="text" id="la_bsa" name="la_bsa" size = "1" value = "<?php echo $row_rececho1['LA_BSA']; ?> "readonly/> ml/m2<br>
        <input type="radio" id="la_type" name="la_type" value="Normal"  <?php echo ( $row_rececho1['LA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
        <input type="radio" id="la_type" name="la_type" value="Abnormal" <?php echo ( $row_rececho1['LA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>
  

        <label> 4) Right Ventricular (RV) dimensions (2D) </label><br>

        RV basal diameter = <input type="text" id="rv_diameter" name="rv_diameter" size = "1" value = "<?php echo $row_rececho1['RV_Dia']; ?> "/> cm <br>
        Mid-RV diameter = <input type="text" id="mid_rv_diameter" name="mid_rv_diameter" size = "1" value = "<?php echo $row_rececho1['Mid_RV']; ?> "/> cm <br>
        RV Length = <input type="text" id="rv_length" name="rv_length" size = "1" value = "<?php echo $row_rececho1['RV_Length']; ?> "/> cm <br>
          <input type="radio" id="rv_type" name="rv_type" value="Normal"  <?php echo ( $row_rececho1['RV_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio" id="rv_type" name="rv_type" value="Abnormal" <?php echo ( $row_rececho1['RV_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>

        <label> 5) Right Artial (RA) dimensions (2D)</label><br>

        RA Volume = <input type="text" id="ra_vol" name="ra_vol" size = "1"onkeyup="myFunctionra()" value = "<?php echo $row_rececho1['RA_Volume']; ?> "/> <br>
        RA volume indexed = <input type="text" id="ra_bsa" name="ra_bsa" size = "1" value = "<?php echo $row_rececho1['RA_BSA']; ?>"readonly/> cml/m2 <br>
          <input type="radio" id="ra_type" name="ra_type" value="Normal"  <?php echo ( $row_rececho1['RA_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
          <input type="radio" id="ra_type" name="ra_type" value="Abnormal" <?php echo ( $row_rececho1['RA_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>

        <label> 6) Aortic Root Dimensions (2D)</label><br>
        <input type="radio" id="aortic_type" name="aortic_type" value="Normal"  <?php echo ( $row_rececho1['AR_Type'] == 'Normal') ? 'checked' : ''; ?> /> Normal
        <input type="radio" id="aortic_type" name="aortic_type" value="Abnormal" <?php echo ( $row_rececho1['AR_Type'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br><br>
      </div>

    <div class="container p-3 my-3 bg-dark text-white">
      <label> 7) Mitral Valve</label><br>
      <input type="radio" id="mv_type" name="mv_type" value="Native_valve" <?php echo ( $row_rececho2['MV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="mv_type" name="mv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['MV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>

      <input type="radio" id="mv_result" name="mv_result" value="Normal"<?php echo ( $row_rececho2['MV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="mv_result" name="mv_result" value="Abnormal"<?php echo ( $row_rececho2['MV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>
  

      <label for="mv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="mv_assess" name="mv_assess" value = "<?php echo $row_rececho2['MV_assess']; ?>" /><br>

 
      <label>8) Aortic Valve</label><br>
      <input type="radio" id="aorv_type" name="aorv_type" value="Native_valve" <?php echo ( $row_rececho2['AV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="aorv_type" name="aorv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['AV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>

      <input type="radio" id="aorv_result" name="aorv_result" value="Normal"<?php echo ( $row_rececho2['AV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="aorv_result" name="aorv_result" value="Abnormal"<?php echo ( $row_rececho2['AV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>


      <label for="av_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="av_assess" name="av_assess" value = "<?php echo $row_rececho2['AV_assess']; ?>" /><br>

      <label> 9) Tricuspid Valve</label><br>
      <input type="radio" id="tv_type" name="tv_type" value="Native_valve" <?php echo ( $row_rececho2['TV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="tv_type" name="tv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['TV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>

      <input type="radio" id="tv_result" name="tv_result" value="Normal"<?php echo ( $row_rececho2['TV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="tv_result" name="tv_result" value="Abnormal"<?php echo ( $row_rececho2['TV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>

      <label for="tv_assess">Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="tv_assess" name="tv_assess" value = "<?php echo $row_rececho2['TV_assess']; ?>" /><br>

      <label> 10) Pulmonary Valve</label><br>
      <input type="radio" id="pv_type" name="pv_type" value="Native_valve" <?php echo ( $row_rececho2['PV_type'] == 'Native_valve') ? 'checked' : ''; ?> /> Native Valve
      <input type="radio" id="pv_type" name="pv_type" value="Prosthetic_Valve"<?php echo ( $row_rececho2['PV_type'] == 'Prosthetic_Valve') ? 'checked' : ''; ?> /> Prosthetic Valve <br>

      <input type="radio" id="pv_result" name="pv_result" value="Normal"<?php echo ( $row_rececho2['PV_result'] == 'Normal') ? 'checked' : ''; ?> /> Normal
      <input type="radio" id="pv_result" name="pv_result" value="Abnormal"<?php echo ( $row_rececho2['PV_result'] == 'Abnormal') ? 'checked' : ''; ?> /> Abnormal<br>

      <label for="pv_assess"> Assessment (2D/Color Doppler/Spectra Doppler) </label>
      <input type="text" class="form-control" id="pv_assess" name="pv_assess" value = "<?php echo $row_rececho2['PV_assess']; ?>" /><br>

      <label> 11) Left Ventricular (LV) Systolic Function </label><br>
      Simpson = <input type="text" id="simpson" name="simpson" size = "1" value = "<?php echo $row_rececho3['LV_Simspson']; ?>" /> % ( 
      <input type="radio" id="simpson_type" name="simpson_type" value="Biplane" <?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Biplane') ? 'checked' : ''; ?> /> Biplane /
      <input type="radio" id="simpson_type" name="simpson_type" value="Monoplane"<?php echo ( $row_rececho3['LV_Simspson_Type'] == 'Monoplane') ? 'checked' : ''; ?> /> Monoplane ) <br><br>
      Regional Wall Motion Abnormalities (RWMA):<br>
      <input type="radio" id="rmwa" name="rmwa" value="YES" <?php echo ( $row_rececho3['LV_RWMA'] == 'YES') ? 'checked' : ''; ?> /> YES
      <input type="radio" id="rmwa" name="rmwa" value="NO"  <?php echo ( $row_rececho3['LV_RWMA'] == 'NO') ? 'checked' : ''; ?> /> NO <br>
      <input type="text" class="form-control" id="rwma_comment" name="rwma_comment"  value = "<?php echo $row_rececho3['LV_RWMA_Com']; ?>"> <br>
      </div>
</div>

<div class="column" style="background-color:white;">
      <div class="container p-3 my-3 bg-dark text-white">


      <label> 12) Mitral Valve Inflow Profile: </label><br>

      E velocity = <input type="text" id="lv_e_velocity" name="lv_e_velocity" size = "1" value = "<?php echo $row_rececho3['LV_E_Vel']; ?> "/> cm/s<br>
      E/A ratio = <input type="text" id="lv_ea_velocity" name="lv_ea_velocity" size = "1" value = "<?php echo $row_rececho3['LV_EA_Velocity']; ?> "/> <br>
      Deceleration Time (DT) = <input type="text" id="lv_dt" name="lv_dt" size = "1" value = "<?php echo $row_rececho3['LV_DT']; ?> "/> msec<br><br>

      Pulmonary Venous Flow Profile :<br>
      Systolic flow velocity (S) = <input type="text" id="systolic_velocity" name="systolic_velocity" size = "1" value = "<?php echo $row_rececho3['Sys_Vel']; ?>" onkeyup="myFunctionPV_ratio()"/>cm/s<br>
      Diastolic flow velocity (D)  = <input type="text" id="diastolic_velocity" name="diastolic_velocity" size = "1" value = "<?php echo $row_rececho3['Dias_Vel']; ?> "onkeyup="myFunctionPV_ratio()"/> cm/s<br>
      PV S/D ratio  = <input type="text" id="pv_ratio" name="pv_ratio" size = "1" value = "<?php echo $row_rececho3['PV_Ratio']; ?> "readonly/> cm/s<br>
      Atrial reversal flow velocity (Ar) = <input type="text" id="atrial_vel" name="atrial_vel" size = "1" value = "<?php echo $row_rececho3['Atrial_Vel']; ?> "/> cm/s<br>
      Atrial reversal flow duration = <input type="text" id="atrial_dur" name="atrial_dur" size = "1" value = "<?php echo $row_rececho3['Atrial_Dur']; ?> "/> msec<br><br>

      Tissue Doppler Imaging (TDI):<br>
      A) Septal Mitral Annulus: <br>
      s' Velocity = <input type="text" id="s_septal_velocity" name="s_septal_velocity" size = "1" value = "<?php echo $row_rececho3['S_Septal_Velocity']; ?> "/> cm/s<br>
      e' Velocity = <input type="text" id="e_septal_velocity" name="e_septal_velocity" size = "1" value = "<?php echo $row_rececho3['E_septal_velocity']; ?> "/> cm/s<br>
      a' velocity = <input type="text" id="a_septal_velocity" name="a_septal_velocity" size = "1" value = "<?php echo $row_rececho3['A_septal_velocity']; ?> "/> cm/s<br>

      B) Lateral Mitral Annulus: :<br>
      s' Velocity = <input type="text" id="s_lateral_velocity" name="s_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['S_lateral_velocity']; ?> "/> cm/s<br>
      e' Velocity = <input type="text" id="e_lateral_velocity" name="e_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['E_lateral_velocity']; ?> "/> cm/s<br>
      a' velocity = <input type="text" id="a_lateral_velocity" name="a_lateral_velocity" size = "1" value = "<?php echo $row_rececho3['A_lateral_velocity']; ?> "/> cm/s<br> <br>

      Septal E/e' = <input type="text" id="septal_e" name="septal_e" size = "1" value = "<?php echo $row_rececho3['Septal_E']; ?>" /><br>
      Lateral E/e' = <input type="text" id="lateral_e" name="lateral_e" size = "1" value = "<?php echo $row_rececho3['Lateral_E']; ?>"/><br>
      Average E/e' = <input type="text" id="average_e" name="average_e" size = "1" value = "<?php echo $row_rececho3['Average_E']; ?>" /><br><br>

      Grading of LV Diastolic Function:<br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_0" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_0') ? 'checked' : ''; ?> /> Grad 0(Normal diastolic function) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_1" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_1') ? 'checked' : ''; ?> /> Grad 1(Impaired Relaxation) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_2" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_2') ? 'checked' : ''; ?> /> Grad 2(Pseudonormal Pattern) <br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Grad_3" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_3') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      <input type="radio" id="grad_lv" name="grad_lv" value="Indeterminate" <?php echo ( $row_rececho3['Grad_lv'] == 'Grad_Indeterminate') ? 'checked' : ''; ?> /> Grad 3(Restrictive Pattern) <br><br>
      
      13) Right Ventricular (RV) Systolic Fuction<br>
      Trucuspid Annulus Plane Systolic Excursion
      (TAPSE) = <input type="text" id="tapse" name="tapse" size = "1" value = "<?php echo $row_rececho3['TAPSE']; ?> "/><br>
     </div>

    <div class="container p-3 my-3 bg-dark text-white">
        <label> 14) Congenital hearth Diseases </label><br>

        A) Atrial Septal Defect (ASD):
        <input type="radio" id="asd" name="asd" value="Yes"<?php echo ( $row_rececho4['Asd'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="asd" name="asd" value="No"<?php echo ( $row_rececho4['Asd'] == 'No') ? 'checked' : ''; ?> /> No<br>

        B) Ventricular Septal Defect (VSD):
        <input type="radio" id="vsd" name="vsd" value="Yes" <?php echo ( $row_rececho4['VSD'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="vsd" name="vsd" value="No" <?php echo ( $row_rececho4['VSD'] == 'No') ? 'checked' : ''; ?> /> No<br>

        C) Patent Ductus Arteriosus (PDA):
        <input type="radio" id="pda" name="pda" value="Yes" <?php echo ( $row_rececho4['Pda'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="pda" name="pda" value="No" <?php echo ( $row_rececho4['Pda'] == 'No') ? 'checked' : ''; ?> /> No<br>
        Shunt:<br>
        <input type="radio" id="shunt" name="shunt" value="plr"<?php echo ( $row_rececho4['Shunt'] == 'plr') ? 'checked' : ''; ?>  onclick="funshunt()"/> Predominant left-to-right </label> <br>
        <input type="radio" id="shunt" name="shunt" value="prl"<?php echo ( $row_rececho4['Shunt'] == 'prl') ? 'checked' : ''; ?>  onclick="funshunt()"/> Predominant right-to-left</label><br>
        <input type="radio" id="shunt" name="shunt" value="bidi"<?php echo ( $row_rececho4['Shunt'] == 'bidi') ? 'checked' : ''; ?>  onclick="funshunt()" /> Bidirectional</label><br>
	 <input type="radio" id="shunt4" name="shunt" value="noshunt"<?php echo ( $row_rececho4['Shunt'] == 'noshunt') ? 'checked' : ''; ?> onclick="funshunt()"/>No Shunt</label><br>
        Shunt defect size approx <input type="text" id="shunt_defect" name="shunt_defect" size = "1" value= "<?php echo $row_rececho4['Shunt_Defect']; ?>" /> mm<br>
        Other associated findings: <br>
        <input type="text" class="form-control" id="associate_find" name="associate_find" value = "<?php echo $row_rececho4['A_Find']; ?> "/><br>

        <label> 15) Pericardial Diseases </label><br>

        Normal Pericardium
        <input type="radio" id="normal_peri" name="normal_peri" value="Yes" <?php echo ( $row_rececho4['N_Peri'] == 'Yes') ? 'checked' : ''; ?> /> Yes 
        <input type="radio" id="normal_peri" name="normal_peri" value="No" <?php echo ( $row_rececho4['N_Peri'] == 'No') ? 'checked' : ''; ?> /> No <br>
        
        Pericardial Effusion
        <input type="radio" id="peri_effu1" name="peri_effu" value="Yes" <?php echo ( $row_rececho4['P_Effu'] == 'Yes') ? 'checked' : ''; ?> onclick="funceffu()"/> Yes
        <input type="radio" id="peri_effu2" name="peri_effu" value="No" <?php echo ( $row_rececho4['P_Effu'] == 'No') ? 'checked' : ''; ?> onclick="funceffu()" /> No <br>
       
        Size of Effusion <input type="text" id="size_effu" name="size_effu" size = "1" value = "<?php echo $row_rececho4['Size_Effu']; ?> "/> cm<br>
        <input type="radio" id="effu_type" name="effu_type" value="Small" <?php echo ( $row_rececho4['Effu_Type'] == 'Small') ? 'checked' : ''; ?> /> <label> Small </label>
        <input type="radio" id="effu_type1" name="effu_type" value="Moderate" <?php echo ( $row_rececho4['Effu_Type'] == 'Moderate') ? 'checked' : ''; ?> /> <label>Moderate </label>
        <input type="radio" id="effu_type2" name="effu_type" value="Large" <?php echo ( $row_rececho4['Effu_Type'] == 'Large') ? 'checked' : ''; ?> /><label> Large </label>
        <input type="radio" id="effu_type3" name="effu_type" value="No_Effusion" style="display:none;"  <?php echo ( $row_rececho4['Effu_Type'] == 'No_Effusion') ? 'checked' : ''; ?> /> <br>


        Tamponade physiology:
        <input type="radio" id="tamphy" name="tamphy" value="Yes" <?php echo ( $row_rececho4['Tamphy'] == 'Yes') ? 'checked' : ''; ?> /> Yes
        <input type="radio" id="tamphy" name="tamphy" value="No" <?php echo ( $row_rececho4['Tamphy'] == 'No') ? 'checked' : ''; ?> /> No<br><br>

        <label for="other_find">16) Other Echo Findings </label>
        <input type="text" class="form-control" id="other_find" name="other_find" value = "<?php echo $row_rececho4['Other_Find']; ?> "/>

        <label for="echo_diag">17) Echo Diagnosis </label>
        <input type="text" class="form-control" id="echo_diag" name="echo_diag" value = "<?php echo $row_rececho4['Echo_Diag']; ?> "/> <br>

        18) Conclusion Of Echo Assessment<br>
        <input type="radio" id="echo_type" name="echo_type" value="Normal_Echo" <?php echo ( $row_rececho4['Echo_Type'] == 'Normal_Echo') ? 'checked' : ''; ?> />  Normal Echo </label>
        <input type="radio" id="echo_type" name="echo_type" value="Abnormal_Echo" <?php echo ( $row_rececho4['Echo_Type'] == 'Abnormal_Echo') ? 'checked' : ''; ?> />  Abnormal Echo </label>
    </div>
      <div class="container p-3 my-3 border">

      <label for="txtappliedby">Reported By: </label>
      <input type="text" class="form-control" name="txtappliedby" id="txtappliedby" value="<?php echo $row_rececho4['report_by']; ?>" readonly /><br>
      <label for="comment">Comment</label>
      <textarea oninput="auto_grow(this)" class="form-control" name="comment" id="comment" > <?php echo $row_recpat['reason']; ?> </textarea>
      <input type="hidden" name="txtcolumn1" id="txtcolumn1" value="<?php echo $row_rececho1['column1_id']; ?>"/>
      <input type="hidden" name="txtcolumn2" id="txtcolumn2" value="<?php echo $row_rececho2['column2_id']; ?>"/>
      <input type="hidden" name="txtcolumn3" id="txtcolumn3" value="<?php echo $row_rececho3['column3_id']; ?>"/>
      <input type="hidden" name="txtcolumn4" id="txtcolumn4" value="<?php echo $row_rececho4['column4_id']; ?>"/>
      <input type="hidden" name="txtidedit" id="txtidedit" value="<?php echo $row_recpat["borang_id"]; ?>" /><br>
      <button type="submit" name="submit" id="submit">Submit</button>
    </div>
</div>


  </form>
  </div>
  </div>
  </div>


    <?php
  
  } 
  
  ?>  


