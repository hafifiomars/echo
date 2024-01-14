<?php require_once('auth.php'); 
require_once('Connections/conn.php');


if(isset($_POST['SubmitButton'])){ //check if form was submitted

  $tarikhM= mysqli_real_escape_string($conn,$_POST['txtSearchdt1']);
  $tarikhA= mysqli_real_escape_string($conn,$_POST['txtSearchdt2']);
  $tarikh1 = date("d/m/Y" , strtotime($tarikhM));
  $tarikh2 = date("d/m/Y" , strtotime($tarikhA));
} 

mysqli_select_db($conn, $database_conn);
$query_recJabatan = "SELECT b.jabatan, a.loginID, d.department_name,
        sum(CASE WHEN (a.appointment_status='1') THEN 1 else 0 END)  as 'Pending Appointment',
        sum(CASE WHEN (a.appointment_status='2') THEN 1 else 0 END)  as 'Pending For Echo Procedure',
        sum(CASE WHEN (a.appointment_status='3') THEN 1 else 0 END)  as 'Reject For Inpatient',
        sum(CASE WHEN (a.appointment_status='4') THEN 1 else 0 END)  as 'Reject For Outpatient',
        sum(CASE WHEN (a.appointment_status='5') THEN 1 else 0 END)  as 'Report Ready (Validated)',
        sum(CASE WHEN (a.appointment_status='6') THEN 1 else 0 END)  as 'Report Ready (Not Validated)',
      
        COUNT(a.borang_id)     as bil
        FROM    app_form a
        LEFT JOIN login b on a.loginID = b.login_id
        LEFT JOIN app_status c on a.appointment_status = c.appointmentstatusID
        LEFT JOIN dept_tbl d on b.jabatan = d.department_id
        WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA')
        GROUP BY b.jabatan
        ORDER BY b.jabatan";

$recJabatan = mysqli_query($conn, $query_recJabatan) or die(mysqli_error($conn));
$row_recJabatan = mysqli_fetch_assoc($recJabatan);
$totalRows_recJabatan = mysqli_num_rows($recJabatan);


//piechart

 $query_jab = "SELECT b.jabatan, a.loginID, c.department_name, count(a.borang_id) as number 
          FROM app_form a     
          LEFT JOIN login b on a.loginID = b.login_id 
          LEFT JOIN dept_tbl c on b.jabatan = c.department_id
          WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA')
          GROUP BY b.jabatan";

 $result_jab = mysqli_query($conn, $query_jab); 

 $query_as = "SELECT a.appointment_status, a.loginID, c.appointment_status, count(a.borang_id) as number 
          FROM app_form a     
          LEFT JOIN login b on a.loginID = b.login_id 
          LEFT JOIN app_status c on a.appointment_status = c.appointmentstatusID     
          WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA')
          GROUP BY a.appointment_status";

 $result_as = mysqli_query($conn, $query_as);

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

<!-- <script type="text/javascript">
  window.onload = function(){
    new JsDatePick({
      useMode:2,
      target:"txtSearchdt1",
      dateFormat:"%Y-%m-%d"
      
    });
  };
</script>  -->

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
           google.charts.setOnLoadCallback(drawJabChart);  
           google.charts.setOnLoadCallback(drawASChart);

           function drawJabChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Jabatan', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result_jab))  
                          {  
                               echo "['".$row["department_name"]."', ".$row["number"]."],";  
                               //echo "['".$row["bookingStatus"]."', ".$row["number"]."],";
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of Appointment by Department',  
                      width:450,
                       height:300 
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('jabChart'));  
                chart.draw(data, options);  
           }  

            // Callback that draws the pie chart for Booking Status.
      function drawASChart() {
        var data = new google.visualization.DataTable();
        // Create the data table for Booking Status.
        var data = google.visualization.arrayToDataTable([  
                          ['StatusTempahan', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result_as))  
                          {  
                               //echo "['".$row["bookingStatus"]."', ".$row["number"]."],";  
                               echo "['".$row["appointment_status"]."', ".$row["number"]."],";
                          }  
                          ?>  
                     ]); 

        // Set options for Booking Status pie chart.
        var options = {title:'Percentage of Appointment Status',
                       width:450,
                       height:300};

        // Instantiate and draw the chart for Booking Status.
        var chart = new google.visualization.PieChart(document.getElementById('AppStatChart'));
        chart.draw(data, options);
      }

      
           </script>  
           <body>

          <p>
    <table class="columns" align="center">
      <tr>
        <td><div id="jabChart" style="border: 1px solid #ccc"></div></td>
        <td><div id="AppStatChart" style="border: 1px solid #ccc"></div></td>
      </tr>

    </table>

       <td>
        <table border="1" width="1000" align="center">
          <tr bgcolor="#FF9AA2" align="center" height="50">
          <th width="20">No </th>
          <th width="350">Department </th>
          <th width="100" bgcolor="#FF9AA2">Pending Appointment</th>
          <th width="100" bgcolor="#FF9AA2">Pending For Echo Procedure</th>
          <th width="100" bgcolor="#FF9AA2">Reject For Inpatient</th>
          <th width="100" bgcolor="#FF9AA2">Reject For Outpatient</th>
          <th width="100" bgcolor="#FF9AA2">Report Ready (Validated)</th>
          <th width="100" bgcolor="#FF9AA2">Report Ready (Not Validated)</th>  
          <th width="100" bgcolor="#FF9AA2">Total</th>
                              
          </tr>
          <?php $jabtn='';$bil=0;$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;$total6=0;$total7=0;$totalall=0;
          do {  
              echo "<tr height=\"30\">";

              if ($row_recJabatan['department_name']=='') { 
                $bil++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$bil."</td>";
                echo "<td bgcolor=\"#DFF2FD\"></td>";
                //echo 1;
              } else if ($row_recJabatan['department_name']==$jabtn) { 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\"></td>";
                echo "<td bgcolor=\"#DFF2FD\"></td>";
                //echo 2;
              } else { 
                $bil++; 
                echo "<td align=\"center\" bgcolor=\"#CCCCCC\">".$bil."</td>";
                echo "<td bgcolor=\"#DFF2FD\">";
                //echo 3;
                echo $row_recJabatan['department_name']; 
              }

              echo "<td align=\"center\">".$row_recJabatan['Pending Appointment']."</td>";
              $total1 = $total1 + $row_recJabatan['Pending Appointment'];

              echo "<td align=\"center\">".$row_recJabatan['Pending For Echo Procedure']."</td>";
              $total2 = $total2 + $row_recJabatan['Pending For Echo Procedure'];

              echo "<td align=\"center\">".$row_recJabatan['Reject For Inpatient']."</td>";
              $total3 = $total3 + $row_recJabatan['Reject For Inpatient'];

              echo "<td align=\"center\">".$row_recJabatan['Reject For Outpatient']."</td>";
              $total4 = $total4 + $row_recJabatan['Reject For Outpatient'];

               echo "<td align=\"center\">".$row_recJabatan['Report Ready (Validated)']."</td>";
              $total5 = $total5 + $row_recJabatan['Report Ready (Validated)'];

                echo "<td align=\"center\">".$row_recJabatan['Report Ready (Not Validated)']."</td>";
              $total6 = $total6 + $row_recJabatan['Report Ready (Not Validated)'];
              echo "<td align=\"center\"><a ".$row_recJabatan['jabatan']."&t1=".$tarikhM."&t2=".$tarikhA."\">".$row_recJabatan['bil']."</a></td>";
              $totalall = $totalall + $row_recJabatan['bil'];

              $jabtn = $row_recJabatan['jabatan'];

            } while ($row_recJabatan = mysqli_fetch_assoc($recJabatan));

        ?> <tr>
            <td colspan="2" bgcolor="#999999">Total</td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total1; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total2; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total3; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total4; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total5; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total6; ?></td>
            <td align="center" bgcolor="#FFB7B2"><b><font size="+2"><?php echo $totalall; ?></a></font></b></td>
            
            
        </table>

        <p>&nbsp;</p>
  
  </td>
      </body>  
      <p>&nbsp;</p>
</table>
</body>
</html>
<?php
mysqli_free_result($recJabatan);

?>
