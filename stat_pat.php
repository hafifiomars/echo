<?php require_once('auth.php'); 
require_once('Connections/conn.php');


if(isset($_POST['SubmitButton'])){ //check if form was submitted

  $tarikhM= mysqli_real_escape_string($conn,$_POST['txtSearchdt1']);
  $tarikhA= mysqli_real_escape_string($conn,$_POST['txtSearchdt2']);
  $tarikh1 = date("d/m/Y" , strtotime($tarikhM));
  $tarikh2 = date("d/m/Y" , strtotime($tarikhA));
} 

mysqli_select_db($conn, $database_conn);

        $query_recpat = "SELECT  f.Pat_Name , a.Reg_Date, 
        sum(CASE WHEN (c.indication_type='1') THEN 1 else 0 END)  as 'Cardiac assessment',
        sum(CASE WHEN (c.indication_type='2') THEN 1 else 0 END)  as 'Pre-operative cardiac assessment',
        sum(CASE WHEN (c.indication_type='3') THEN 1 else 0 END)  as 'To rule out infective endocarditis',
        sum(CASE WHEN (c.indication_type='4') THEN 1 else 0 END)  as 'To rule out pericardial effusion or cardiac tamponade',
        sum(CASE WHEN (c.indication_type='5') THEN 1 else 0 END)  as 'To rule out valvular cardiomyopathy',
        sum(CASE WHEN (c.indication_type='6') THEN 1 else 0 END)  as 'To rule pulmonary hypertension',
        sum(CASE WHEN (c.indication_type='7') THEN 1 else 0 END)  as 'To rule out cardiac thrombus',
        sum(CASE WHEN (c.indication_type='8') THEN 1 else 0 END)  as 'Maternal Indication',

      
        COUNT(a.borang_id)     as bil
        FROM    app_form a
        LEFT JOIN pat_indication c on a.borang_id = c.borang_id
        LEFT JOIN patient_tbl f on a.pat_id = f.pat_id
        WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA' )
        GROUP BY a.borang_id
        ORDER BY c.borang_id ";


$recpat = mysqli_query($conn, $query_recpat) or die(mysqli_error($conn));
$row_recpat = mysqli_fetch_assoc($recpat);
$totalRows_recpat = mysqli_num_rows($recpat);

mysqli_select_db($conn, $database_conn);
$query_recpattype = "SELECT a.loginID, c.patient_type, a.Pat_Type,   
        sum(CASE WHEN (a.Pat_Type='1') THEN 1 else 0 END)   as 'Inpatient',
        sum(CASE WHEN (a.Pat_Type='2') THEN 1 else 0 END)   as 'Outpatient (HTAR)',
        sum(CASE WHEN (a.Pat_Type='2') THEN 1 else 0 END)   as 'Outpatient (Non HTAR)',
    
        COUNT(a.borang_id)     as bil2
        FROM    app_form a
        LEFT JOIN login b on a.loginID = b.login_id
        LEFT JOIN patient_type_tbl c on a.Pat_Type = c.patient_type_id
        WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA') AND patient_type_id!=0
        GROUP BY a.Pat_Type
        ORDER BY c.patient_type_id DESC";

$recpattype = mysqli_query($conn, $query_recpattype) or die(mysqli_error($conn));
$row_recpattype = mysqli_fetch_assoc($recpattype);
$totalRows_recpattype = mysqli_num_rows($recpattype);

//piechart  

 $query_indi = "SELECT  a.loginID, c.indication_type , d.indication_name, 

        count(a.borang_id) as number 
         FROM    app_form a
         LEFT JOIN pat_indication c on a.borang_id = c.borang_id
         LEFT JOIN ref_indication_tbl d on c.indication_type = d.indication_id    
         WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA')
         GROUP BY c.indication_type";

 $result_indi = mysqli_query($conn, $query_indi);

 $query_patienttype = "SELECT a.Pat_Type, a.loginID, c.patient_type, count(a.borang_id) as number 
          FROM app_form a     
          LEFT JOIN login b on a.loginID = b.login_id 
          LEFT JOIN patient_type_tbl c on a.Pat_Type = c.patient_type_id     
          WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA')
          GROUP BY a.Pat_Type";

 $result_patienttype = mysqli_query($conn, $query_patienttype);
//end piechart
              
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script type="text/javascript">

function validate(f) {
    
  var tbLen = f.txtSearchdt1.value.trim().length;
      if (tbLen == 0) {
      alert("Set Start Date");
      f.txtSearchdt1.focus();
      return(false);
  }

  var tbLen = f.txtSearchdt2.value.trim().length;
      if (tbLen == 0) {
      alert("Set End Date");
      f.txtSearchdt2.focus();
      return(false);
  }

} 
</script>

<script type="text/javascript">
  window.onload = function(){
    new JsDatePick({
      useMode:2,
      target:"txtSearchdt1",
      dateFormat:"%Y-%m-%d"
      
    });
  };
</script>

<style type="text/css">
.style4 {font-size: small}
.style5 {font-size: xx-small}
.style6 {
  color: #FFFFFF;
  font-weight: bold;
}
</style>

</head>
<body>
<form onsubmit="return validate(this)" action="" method="post" >
<table align="center" width="500" bgcolor="#DFF2FD">
<tr >
  <td >&nbsp;</td>
  <td >&nbsp;</td>
  <td >&nbsp;</td>
  <td >&nbsp;</td>
</tr>
<tr>
  <td width="150">From:</td>
  <td width="150"><input name="txtSearchdt1" type="date" id="txtSearchdt1" size="12" /></td>
  <td width="150" align="center">Until</td>
  <td width="150"><input name="txtSearchdt2" type="date" id="txtSearchdt2" size="12" /></td>
</tr>
<tr>
  <td colspan="4" align="center">&nbsp;</td>
</tr>
<tr>
   <td colspan="4" align="center"><input type="submit" name="SubmitButton"/></td>
</tr>
</table>  
</form>
<br /><br />
<table width="1000" border="0" align="center">

  <tr>
   <td align="center">From : <b><?php echo $tarikh1; ?></b> Until <b><?php echo $tarikh2; ?></b></td>
  </tr>
  <tr>
    <td align="center"><hr /> </td>
  </tr>


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  

           google.charts.load('current', {'packages':['corechart']});  

           google.charts.setOnLoadCallback(drawASChart);
           google.charts.setOnLoadCallback(drawPatientType);

      function drawASChart() {
        var data = new google.visualization.DataTable();
        // Create the data table for Booking Status.
        var data = google.visualization.arrayToDataTable([  
                          ['Indication', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result_indi))  
                          {    
                               echo "['".$row["indication_name"]."', ".$row["number"]."],";
                          }  
                          ?>  
                     ]); 

        // Set options for Booking Status pie chart.
        var options = {title:'Percentage of Patient by Echocardiagram Indication',
                       width:800,
                       height:250};

        // Instantiate and draw the chart for Booking Status.
        var chart = new google.visualization.PieChart(document.getElementById('IndicationChart'));
        chart.draw(data, options);
      }

      function drawPatientType()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['PatientType', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result_patienttype))  
                          {  
                               echo "['".$row["patient_type"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of Appointment by Patient Type',  
                      width:400,
                       height:250
                      //is3D:true,  
                      //pieHole: 0.4  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('PatientType'));  
                chart.draw(data, options);  
           }  
   
           </script>  
           <body>

          <p>
    <table class="columns" align="center">
      <tr>
        <td><div id="IndicationChart" style="border: 1px solid #ccc"></div></td>
        <td><div id="PatientType" style="border: 1px solid #ccc"></div></td>
      </tr>

    </table>

       <table border="1" width="1000" align="center">
          <tr bgcolor="#FF9AA2" align="center" height="50">
          <th width="20">No</th>
          <th width="350">Patient Type </th>
                    <th width="100" bgcolor="#FF9AA2">Total</th>
                                  
          </tr>
          <?php $pattype='';$bil2=0;$totalsall=0;
          
          do {  
              echo "<tr height=\"30\">";

              if ($row_recpattype['patient_type']=='') { 
                $bil2++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$bil2."</td>";
                echo "<td bgcolor=\"#DFF2FD\"></td>";
               } else { 
                $bil2++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$bil2."</td>";
                echo "<td bgcolor=\"#DFF2FD\">";
                echo $row_recpattype['patient_type']; 
              }
              echo "<td align=\"center\"><a ".$row_recpattype['Pat_Type']."&t1=".$tarikhM."&t2=".$tarikhA."\">".$row_recpattype['bil2']."</a></td>";
              $totalsall = $totalsall + $row_recpattype['bil2'];

              $pattype = $row_recpattype['patient_type'];

            } while ($row_recpattype = mysqli_fetch_assoc($recpattype));

        ?> <tr>
            <td colspan="2" bgcolor="#999999">Total</td>
                  
            <td align="center" bgcolor="#FFB7B2"><b><font size="+2"><?php echo $totalsall; ?></a></font></b></td>
                
          <tr>
        </table>
        <p>&nbsp;</p>
     
     <tr>
    <td>
        <table border="1" width="1000" align="center">
          <tr bgcolor="#FF9AA2" align="center" height="50">
          <th width="150">Register Date </th>
          <th width="350">Patient Name </th>
          <th width="100" bgcolor="#FF9AA2">Cardiac assessment</th>
          <th width="100" bgcolor="#FF9AA2">Pre-operative cardiac assessment</th>
          <th width="100" bgcolor="#FF9AA2">To rule out infective endocarditis</th>
          <th width="100" bgcolor="#FF9AA2">To rule out pericardial effusion or cardiac tamponade</th>
          <th width="100" bgcolor="#FF9AA2">To rule out valvular hearth disease</th>
          <th width="100" bgcolor="#FF9AA2">To rule out pulmonary hypertension</th> 
          <th width="100" bgcolor="#FF9AA2">To rule out cardiac thrombus</th>
          <th width="100" bgcolor="#FF9AA2">Maternal Indication</th>
          <th width="100" bgcolor="#FF9AA2">Total</th>
                              
          </tr>


          <?php $bil=0;$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;$total6=0;$total7=0;$total8=0;$totalall=0;

          do {  
              echo "<tr height=\"30\">";

              if ($row_recpat['Pat_Name']=='') { 
                $bil++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$row_recpat['Reg_Date']."</td>";
                echo "<td bgcolor=\"#DFF2FD\"></td>";
              } else { 
                $bil++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$row_recpat['Reg_Date']."</td>";
                echo "<td bgcolor=\"#DFF2FD\">";

                echo $row_recpat['Pat_Name']; 
              }

        

              
              echo"<td align=\"center\">".$row_recpat['Cardiac assessment']."</td>";
              $total1 = $total1 + $row_recpat['Cardiac assessment'];

              echo "<td align=\"center\">".$row_recpat['Pre-operative cardiac assessment']."</td>";
              $total2 = $total2 + $row_recpat['Pre-operative cardiac assessment'];

              echo "<td align=\"center\">".$row_recpat['To rule out infective endocarditis']."</td>";
              $total3 = $total3 + $row_recpat['To rule out infective endocarditis'];

              echo "<td align=\"center\">".$row_recpat['To rule out pericardial effusion or cardiac tamponade']."</td>";
              $total4 = $total4 + $row_recpat['To rule out pericardial effusion or cardiac tamponade'];

              echo "<td align=\"center\">".$row_recpat['To rule out valvular cardiomyopathy']."</td>";
              $total5 = $total5 + $row_recpat['To rule out valvular cardiomyopathy'];

              echo "<td align=\"center\">".$row_recpat['To rule pulmonary hypertension']."</td>";
              $total6 = $total6 + $row_recpat['To rule pulmonary hypertension'];

              echo "<td align=\"center\">".$row_recpat['To rule out cardiac thrombus']."</td>";
              $total7 = $total7 + $row_recpat['To rule out cardiac thrombus'];

              echo "<td align=\"center\">".$row_recpat['Maternal Indication']."</td>";
              $total8 = $total8 + $row_recpat['Maternal Indication'];

              echo "<td align=\"center\"><a ".$row_recpat['Pat_Name']."&t1=".$tarikhM."&t2=".$tarikhA."\">".$row_recpat['bil']."</a></td>";
              $totalall = $totalall + $row_recpat['bil'];


            } while ($row_recpat = mysqli_fetch_assoc($recpat)); 

        ?> <tr>
            <td colspan="2" bgcolor="#999999">Total</td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total1; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total2; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total3; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total4; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total5; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total6; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total7; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total8; ?></td>
            <td align="center" bgcolor="#FFB7B2"><b><font size="+2"><?php echo $totalall; ?></a></font></b></td>
            
            
          </tr>
        </table>

        <p>&nbsp;</p>
        
  </td>
  </tr>

      </body>  
      <p>&nbsp;</p>
</table>
</body>
</html>
<?php
mysqli_free_result($recpat);
mysqli_free_result($recpattype);
?>
