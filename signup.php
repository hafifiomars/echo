<?php
require_once('Connections/conn.php');
mysqli_select_db($conn, $database_conn);
$query_recjab = "SELECT * FROM dept_tbl WHERE department_flag=0 ORDER BY department_name ASC";
$recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
$row_recjab = mysqli_fetch_assoc($recjab);
$totalRows_recjab = mysqli_num_rows($recjab);

mysqli_select_db($conn, $database_conn);
$query_recjaw = "SELECT * FROM pos_tbl WHERE pos_flag=0 ORDER BY pos_name ASC";
$recjaw = mysqli_query($conn, $query_recjaw) or die(mysqli_error($conn));
$row_recjaw = mysqli_fetch_assoc($recjaw);
$totalRows_recjaw = mysqli_num_rows($recjaw);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title> i-Echo System SignUp </title>
<link rel="stylesheet" href="style2.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">

  function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp=false;
    try{
      xmlhttp=new XMLHttpRequest();
    }
    catch(e)  {
      try{
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e){
        try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e1){
          xmlhttp=false;
        }
      }
    }

    return xmlhttp;
  }
  function getData(strURL,divid) {

    var req = getXMLHTTP();

    if (req) {

      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          // only if "OK"
          if (req.status == 200) {
            document.getElementById(divid).innerHTML=req.responseText;
          } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }

  }
function validate(f) {

    var tbLen = f.txtnama.value.trim().length;
    if (tbLen == 0) {
      alert("Please enter your Fullname ");
      f.txtnama.focus();
      return(false);
      }

    if (f.ddldept.value == "0") {
      alert("Please enter Department");
      f.ddldept.focus();
      return(false);
    }


    if (f.ddlpos.value == "0") {
      alert("Please enter Position ");
      f.ddlpos.focus();
      return(false);
    }

    if (f.ddlpos.value != "0" && f.ddlgred.value == "") {
      alert("Please enter Grade");
      f.ddlgred.focus();
      return(false);
    }


   //  var tbLen2 = f.txtemail.value.trim().length;
   //  if (tbLen2 == 0) {
   //    alert("Please Enter Email ");
   //    f.txtemail.focus();
   //    return(false);
   // }

     var tbLen3 = f.txtusername.value.trim().length;
     if (tbLen3 == 0) {
       alert("Please Enter Username ");
       f.txtusername.focus();
       return(false);
    }

    
    var tbLen4 = f.txtnotel.value.trim().length;
    if (tbLen4 == 0) {
      alert("Please enter Phone Number / Ext ");
      f.txtnotel.focus();
      return(false);
    }
    var tbLen4 = f.txtps.value.trim().length;
    if (tbLen4 == 0) {
      alert("Please enter password ");
      f.txtps.focus();
      return(false);
    }

  }

  function functoupcs(f)
{
  var x=document.getElementById(f);
  x.value=x.value.toUpperCase();
}
</script>

</head>
<body>

  <div class="container">
    <div class="title">i-Echo Account Registration</div>
    <div class="content">
      <form id="signupForm" name="signupForm" method="post" onsubmit="return validate(this)" action="signup-check.php">

        <div class="user-details">

          <div class="input-box">
            <span class="details">Full Name</span>
            <input name="txtnama" type="text" id="txtnama" placeholder="Please enter full name" >
          </div>

         <div class="input-box">
            <span class="details">Department</span>
            <select class="input-box4" name="ddldept" id="ddldept" >
             <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
            <?php
        do {
        ?>
          <option value="<?php echo $row_recjab['department_id']?>"<?php if (!(strcmp($row_recjab['department_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recjab['department_name']?></option>
          <?php
        } while ($row_recjab = mysqli_fetch_assoc($recjab));
          $rows = mysqli_num_rows($recjab);
          if($rows > 0) {
            mysqli_data_seek($recjab, 0);
            $$row_recjab = mysqli_fetch_assoc($recjab);
          }
        ?>
            </select>
          </div>

          <div class="input-box2">
            <span class="details">Position</span>
            <select class="input-box3" name="ddlpos" id="ddlpos" onchange="getData('get_search_pos.php?posid='+this.value,'pos')" >
                <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
                <?php
            do {
            ?>
                <option value="<?php echo $row_recjaw['pos_id']?>"<?php if (!(strcmp($row_recjaw['pos_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recjaw['pos_name']?></option>
                <?php
            } while ($row_recjaw = mysqli_fetch_assoc($recjaw));
              $rows = mysqli_num_rows($recjaw);
              if($rows > 0) {
                mysqli_data_seek($recjaw, 0);
                $row_recjaw = mysqli_fetch_assoc($recjaw);
              }
            ?>
              </select>
          </div>

          <div class="input-box2">
            <span class="details">Grade</span>
            <div id="pos"><select class="input-box3" name="ddlgred" id="ddlgred">
              <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
            </select></div>
          </div>

          <div class="input-box">
             <span class="details">Email</span>
            <input name="txtemail" type="text" id="txtemail" placeholder="Please enter Email" >
          </div>

          <div class="input-box2">
           <span class="details">Username</span>
            <input name="txtusername" type="text" id="txtusername" placeholder="Please enter username" >
          </div>

          <div class="input-box2">
            <span class="details">Phone Number / Ext</span>
            <input name="txtnotel" type="text" id="txtnotel" placeholder="Please enter phone number / ext" >
          </div>

          <div class="input-box">
            <span class="details">Password</span>
            <input name="txtps" type="password" id="txtps" placeholder="Please enter password" >
          </div>
        </div>

        <div class="button">
          <input type="submit" value="Sign up" id="submitform">
        </div>
        <p>
      <a href="index.php">Login</a>
      </p>



      </form>
    </div>
  </div>

</body>
</html>
