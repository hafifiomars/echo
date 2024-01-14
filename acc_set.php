<?php
require_once('auth.php');
require_once('Connections/conn.php');

$id = $_SESSION['SESS_MEMBER_ID'];

mysqli_select_db($conn, $database_conn);
$query_recAccSet = "SELECT * FROM login a LEFT JOIN gred_tbl b ON a.jawatan = b.gred_id WHERE a.login_id = '$id'";
$recAccSet = mysqli_query($conn, $query_recAccSet) or die(mysqli_error($conn));
$row_recAccSet = mysqli_fetch_assoc($recAccSet);
$totalRows_recAccSet = mysqli_num_rows($recAccSet);
$posid = $row_recAccSet['pos_id'];

mysqli_select_db($conn, $database_conn);
$query_recjab = "SELECT * FROM dept_tbl WHERE department_flag=0 ORDER BY department_name ASC";
$recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
$row_recjab = mysqli_fetch_assoc($recjab);
$totalRows_recjab = mysqli_num_rows($recjab);

mysqli_select_db($conn, $database_conn);
$query_recJawatan = "SELECT * FROM pos_tbl WHERE pos_flag=0 ORDER BY pos_name ASC";
$recJawatan = mysqli_query($conn, $query_recJawatan) or die(mysqli_error($conn));
$row_recJawatan = mysqli_fetch_assoc($recJawatan);
$totalRows_recJawatan = mysqli_num_rows($recJawatan);

mysqli_select_db($conn, $database_conn);
$query_recJGred = "SELECT * FROM gred_tbl WHERE pos_id = '$posid' AND gred_flag=0 ORDER BY gred_no ASC";
$recJGred = mysqli_query($conn, $query_recJGred) or die(mysqli_error($conn));
$row_recJGred = mysqli_fetch_assoc($recJGred);
$totalRows_recJGred = mysqli_num_rows($recJGred);

?>

<html>
<head><title>User Account</title></head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>Untitled Document</title>

<script type="text/javascript">
function getXMLHTTP() { //function to return the xml http object
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

      var tbLen = f.txtname.value.trim().length;
      if (tbLen == 0) {
        alert("Pls Enter Name ");
        f.txtnama.focus();
        return(false);
        }

      if (f.ddldept.value == "0") {
        alert("Pls Enter department ");
        f.ddljab.focus();
        return(false);
      }

      if (f.ddlpos.value == "0") {
        alert("Pls enter position ");
        f.ddljaw.focus();
        return(false);
      }

      if (f.ddlpos.value != "0" && f.ddlgred.value == "0") {
        alert("pls enter gred");
        f.ddlgred.focus();
        return(false);
      }

            var tbLen1 = f.txtnotel.value.trim().length;
      if (tbLen1 == 0) {
        alert("Pls enter phone number or ext ");
        f.txtnotel.focus();
        return(false);
      }
  
      var tbLen1 = f.txtemail.value.trim().length;
      if (tbLen1 == 0) {
        alert("Pls enter email ");
        f.txtemail.focus();
        return(false);
      }
  
      var tbLen4 = f.txtps.value.trim().length;
      if (tbLen4 == 0) {
        alert("Sila Masukkan Kata Laluan ");
        f.txtps.focus();
        return(false);
      }

      if (f.ddlevel.value == "0") {
        alert("Sila Masukkan Jenis ");
        f.ddlevel.focus();
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
  <div class="col-lg-7 col-md-9">

  <div class="panel panel-default">
  <form id="form1" name="form1" method="post" action = "acc_set_exec.php" onSubmit="return validate(this)">
  <table align="center" width="900" >

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
	   <h3><center>User Account</center></h3>
		</tr>
  <div class="panel-body">

    <div class="form-group">
      <label for="txtname">Full name:</label>
      <input type="text" class="form-control" name="txtname" id="txtname" value="<?php echo $row_recAccSet['name']; ?>" />
    </div>

    <div class="form-group">
      <label for="ddljab">Department:</label>
      <select class="form-control" name="ddldept" id="ddldept">
      <?php
      do {
      ?>
        <option value="<?php echo $row_recjab['department_id']?>"<?php if (!(strcmp($row_recjab['department_id'], $row_recAccSet['jabatan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recjab['department_name']?></option>
      <?php
        } while ($row_recjab = mysqli_fetch_assoc($recjab));
        $rows = mysqli_num_rows($recjab);
        if($rows > 0) {
        mysqli_data_seek($recjab, 0);
        $row_recjab = mysqli_fetch_assoc($recjab);
        }
      ?>
      </select>
    </div>

    <div class="form-group">
      <label for="ddlpos">Position:</label>
      <select class="form-control" name="ddlpos" id="ddlpos" onchange="getData('get_search_pos.php?posid='+this.value,'jwtn')">
      <?php
      do {
      ?>
        <option value="<?php echo $row_recJawatan['pos_id']?>"<?php if (!(strcmp($row_recJawatan['pos_id'], $posid))) {echo "selected=\"selected\"";} ?>><?php echo $row_recJawatan['pos_name']?></option>
      <?php
        } while ($row_recJawatan = mysqli_fetch_assoc($recJawatan));
        $rows = mysqli_num_rows($recJawatan);
        if($rows > 0) {
        mysqli_data_seek($recJawatan, 0);
        $row_recJawatan = mysqli_fetch_assoc($recJawatan);
        }
      ?>
      </select>
    </div>


    <div class="form-group">
      <label for="ddlgred">Grade:</label>
      <div id="jwtn"><select class="form-control" name="ddlgred" id="ddlgred">
      <?php
      do {
      ?>
        <option value="<?php echo $row_recJGred['gred_id']?>"<?php if (!(strcmp($row_recJGred['gred_id'], $row_recAccSet['jawatan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recJGred['gred_no']?></option>
        <?php
      } while ($row_recJGred = mysqli_fetch_assoc($recJGred));
        $rows = mysqli_num_rows($recJGred);
        if($rows > 0) {
          mysqli_data_seek($recJGred, 0);
          $$row_recJGred = mysqli_fetch_assoc($recJGred);
        }
    ?>
      </select></div>
    </div>

    <div class="form-group">
      <label for="txtnotel">Phone Number / Ext:</label>
      <input type="text" class="form-control" name="txtnotel" id="txtnotel" value="<?php echo $row_recAccSet['phonenum']; ?>" />
    </div>

    <div class="form-group">
      <label for="txtemail">Email:</label>
      <input type="text" class="form-control" name="txtemail" id="txtemail" value="<?php echo $row_recAccSet['EMAIL']; ?>" />
    </div>

    <div class="form-group">
      <label for="txtusername">username:</label>
      <input type="text" class="form-control" name="txtusername" id="txtusername" value="<?php echo $row_recAccSet['username']; ?>" />
    </div>

    <div class="form-group">
      <label for="txtps">Password:</label>
      <input type="text" class="form-control" name="txtps" id="txtps" readonly="readonly" value="<?php echo $row_recAccSet['password']; ?>" />
    </div>

    <div class="form-group">
      <label for="txtpwdbaru">New Password:</label>
      <input type="text" class="form-control" id="txtpwdbaru" name="txtpwdbaru">
    </div>

    <input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recAccSet["login_id"]; ?>" />
    <button type="submit" name="Submit" id="Submit" class="btn btn-o btn-primary">Submit</button>

  </div>
  </table>
  </form>
  </div>
  </div>
  </div>

</body>
</html>
