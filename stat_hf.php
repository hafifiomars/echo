<?php require_once('auth.php'); 
require_once('Connections/conn.php');


if(isset($_POST['SubmitButton'])){ //check if form was submitted

  $tarikhM= mysqli_real_escape_string($conn,$_POST['txtSearchdt1']);
  $tarikhA= mysqli_real_escape_string($conn,$_POST['txtSearchdt2']);
  $tarikh1 = date("d/m/Y" , strtotime($tarikhM));
  $tarikh2 = date("d/m/Y" , strtotime($tarikhA));
} 

mysqli_select_db($conn, $database_conn);

        $query_recpat = "SELECT  c.Pat_Name, a.Reg_Date, d.LV_Simspson,

        sum(CASE WHEN (d.LV_Simspson <= '40') THEN 1 else 0 END)  as 'Reduced EF',
        sum(CASE WHEN (d.LV_Simspson > '40' AND d.LV_Simspson <= '49') THEN 1 else 0 END)  as 'Mid Range EF',
        sum(CASE WHEN (d.LV_Simspson > '49') THEN 1 else 0 END)  as 'Preserved EF',

        COUNT(a.borang_id)     as bil
        FROM    app_form a
        LEFT JOIN patient_tbl c on a.pat_id = c.pat_id
        LEFT JOIN result3_echo d on a.borang_id = d.borang_id
        WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA' AND  d.LV_Simspson != 'NULL' )  
        GROUP BY a.borang_id  
        ORDER BY a.borang_id";

        $recpat = mysqli_query($conn, $query_recpat) or die(mysqli_error($conn));
        $row_recpat = mysqli_fetch_assoc($recpat);
        $totalRows_recpat = mysqli_num_rows($recpat);

//data for pie chart

        $query_rechf = "SELECT  c.Pat_Name, a.Reg_Date, d.LV_Simspson,

        sum(CASE WHEN (d.LV_Simspson <= '40') THEN 1 else 0 END)  as 'Reduced EF',
        sum(CASE WHEN (d.LV_Simspson > '40' AND d.LV_Simspson <= '49') THEN 1 else 0 END)  as 'Mid Range EF',
        sum(CASE WHEN (d.LV_Simspson > '49') THEN 1 else 0 END)  as 'Preserved EF',

        COUNT(a.borang_id)     as bil
        FROM    app_form a
        LEFT JOIN patient_tbl c on a.pat_id = c.pat_id
        LEFT JOIN result3_echo d on a.borang_id = d.borang_id
        WHERE (a.Reg_Date >= '$tarikhM' AND a.Reg_Date <= '$tarikhA' AND  d.LV_Simspson != 'NULL' )  
        GROUP BY a.borang_id  
        ORDER BY a.borang_id";

        $rechf = mysqli_query($conn, $query_rechf) or die(mysqli_error($conn));
        $row_rechf = mysqli_fetch_assoc($rechf);
        $totalRows_rechf = mysqli_num_rows($rechf);

         $t='';$bil=0;$totalr=0;$totalmr=0;$totalp=0;$totalall=0;
        do{              
             $totalr = $totalr + $row_rechf['Reduced EF'];
             $totalmr = $totalmr + $row_rechf['Mid Range EF'];
             $totalp = $totalp + $row_rechf['Preserved EF'];
             $totalall = $totalall + $row_rechf['bil'];

        } while ($row_rechf = mysqli_fetch_assoc($rechf));       


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

        </table>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Type', 'Value'],
          ['Reduced EF',     <?php echo $totalr; ?>],
          ['Mid Range EF',  <?php echo $totalmr; ?>],
          ['Preserved EF',  <?php echo $totalp; ?>],

        ]);
                var options = {  
                      title: 'Percentage of Heart Failure Statistics',  
                      width:900,
                       height:300
                     };  

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
          <p>
    <table class="columns" align="center">
      <tr>
        <td><div id="piechart" style="border: 1px solid #ccc"></div></td>
      </tr>

          <td>
        <table border="1" width="1000" align="center">
          <tr bgcolor="#FF9AA2" align="center" height="50">
          <th width="80">Register Date </th>
          <th width="350">Patient Name </th>
          <th width="100" bgcolor="#FF9AA2">Reduced EF <br><=40%</th>
          <th width="100" bgcolor="#FF9AA2">Mid Range EF<br>41%-49%</th>
          <th width="100" bgcolor="#FF9AA2">Preserved EF<br>>=50% </th>
          <th width="100" bgcolor="#FF9AA2">Total</th>
                              
          </tr>

            <?php $hftotal='';$bil=0;$total1=0;$total2=0;$total3=0;$totalall=0;
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


              echo "<td align=\"center\">".$row_recpat['Reduced EF']."</td>";
              $total1 = $total1 + $row_recpat['Reduced EF'];


              echo "<td align=\"center\">".$row_recpat['Mid Range EF']."</td>";
              $total2 = $total2 + $row_recpat['Mid Range EF'];

              echo "<td align=\"center\">".$row_recpat['Preserved EF']."</td>";
              $total3 = $total3 + $row_recpat['Preserved EF'];


              echo "<td align=\"center\"><a ".$row_recpat['Pat_Name']."&t1=".$tarikhM."&t2=".$tarikhA."\">".$row_recpat['bil']."</a></td>";
              $totalall = $totalall + $row_recpat['bil'];

            } while ($row_recpat = mysqli_fetch_assoc($recpat));

        ?> <tr>
            <td colspan="2" bgcolor="#999999">Total</td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total1; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total2; ?></td>
            <td align="center" bgcolor="#FFB7B2"><?php echo $total3; ?></td>
            <td align="center" bgcolor="#FFB7B2"><b><font size="+2"><?php echo $totalall; ?></a></font></b></td>
            
            
          </tr>

    </table>
      </body>  
      <p>&nbsp;</p>
</table>
</body>
</html>
<?php
mysqli_free_result($recpat);
?>