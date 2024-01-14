<?php  require_once('auth.php');
require_once('Connections/conn.php'); 

$ROW = 0;
$id = $_SESSION['SESS_MEMBER_ID'];
$type = $_SESSION['SESS_TYPE'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script language="javascript" type="text/javascript" src="function/datetimepicker.js">
</script>
<title>Echo Patient List</title>
<script type="text/javascript">

  function showUser(str) //search box
  {
  if (str=="")
    {
    document.getElementById("txtHint").innerHTML="";
    return;
    } 
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
   }
  else
    {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
  xmlhttp.onreadystatechange=function()
   {
   if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
     }
    }
  var namevalue=encodeURIComponent(document.getElementById("txtSearch").value);

  xmlhttp.open("GET","get_search_patient.php?m="+namevalue+"&l="+str,true);
  //xmlHttp.send(params); 
  xmlhttp.send();
  }

  function showUser2(str2,str3) //search based on Status Tempahan
{
if (str2=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
 
xmlhttp.open("GET","get_search_appstat.php?t="+str2,true);
//xmlHttp.send(params); 
xmlhttp.send();
}

  </script> 
  <style type="text/css">
  <!--
  .style1 {
     color: #FFFFFF;
     font-weight: bold;
   }
   
   
   </style>
   </head>

   <body>
   <div class="container" align="center">

     <tr>
       <h2><center>Search Existing Patient</center></h2>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr> 
  <tr>
   <td><form id="form1" name="form1" method="post" action="">
      <table width="695" border="0" align="center">
        <tr>
          <td width="393"><label>
          <input class="form-control" name="txtSearch" type="text" id="txtSearch" size="60" placeholder="Enter Name / IC / Passport FIRST, then select the dropdown on the right" />   
          </label></td>
          <td width="292"><label>
            <select class="form-control" name="ddlsearch" id="ddlsearch" onchange="showUser(this.value)">
              <option value="0">Please Choose</option>
              <option value="1">Name</option>
              <option value="2">IC/Passport</option>
            </select>
          </label></td>
        </tr>
      </table>
      <p>&nbsp;</p>

</form>  </td>
</tr>
  
  <tr align="center">
    <td>&nbsp;</td>
  </tr>

      <tr>
    <td>
  <div id="txtHint">


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


<?php
  
?>