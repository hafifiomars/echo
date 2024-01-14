<?php require_once('auth.php');
require_once('Connections/conn.php');

$x = $_GET['x'];

mysqli_select_db($conn, $database_conn);
$query_reclevel = "SELECT * from userlevel_tbl";
$reclevel = mysqli_query($conn, $query_reclevel) or die(mysqli_error($conn));
$row_reclevel = mysqli_fetch_assoc($reclevel);
$totalRows_reclevel = mysqli_num_rows($reclevel);

mysqli_select_db($conn, $database_conn);
$query_recjab = "SELECT * from dept_tbl WHERE department_flag=0 ORDER BY department_name ASC";
$recjab = mysqli_query($conn, $query_recjab) or die(mysqli_error($conn));
$row_recjab = mysqli_fetch_assoc($recjab);
$totalRows_recjab = mysqli_num_rows($recjab);

mysqli_select_db($conn, $database_conn);
$query_recJawatan = "SELECT * FROM pos_tbl ORDER BY pos_name ASC";
$recJawatan = mysqli_query($conn, $query_recJawatan) or die(mysqli_error($conn));
$row_recJawatan = mysqli_fetch_assoc($recJawatan);
$totalRows_recJawatan = mysqli_num_rows($recJawatan);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>PENAMBAHAN PENGGUNA</title>

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

  function showUser(str,str1)
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

	var namevalue=encodeURIComponent(document.getElementById("ddlpos").value);

	xmlhttp.open("GET","get_search_jwtn.php?c="+namevalue+"&sc="+str,true);

	xmlhttp.send();
	}
function validate(f) {

    var tbLen1 = f.txtname.value.trim().length;
    if (tbLen1 == 0) {
      alert("Please enter Full Name");
      f.txtname.focus();
      return(false);
    }

    if (f.ddldept.value == "0") {
      alert("Please Enter Department ");
      f.ddldept.focus();
      return(false);
    }

    if (f.ddlpos.value == "0") {
      alert("Please Enter Position ");
      f.ddlpos.focus();
      return(false);
    }

    if (f.ddlpos.value != "0" && f.ddlgred.value == "") {
      alert("Please enter Grade");
      f.ddlgred.focus();
      return(false);
    }

//    var tbLen1 = f.txtemail.value.trim().length;
//    if (tbLen1 == 0) {
//      alert("Please Enter Email ");
//      f.txtemail.focus();
//      return(false);
//    }


    var tbLen2 = f.txtnotel.value.trim().length;
    if (tbLen2 == 0) {
      alert("Please enter Phone Number / Ext");
      f.txtnotel.focus();
      return(false);
    }

    var tbLen3 = f.txtusername.value.trim().length;
    if (tbLen3 == 0) {
      alert("Please Enter Username  ");
      f.txtps.focus();
      return(false);
    }

    var tbLen4 = f.txtps.value.trim().length;
    if (tbLen4 == 0) {
      alert("Please Enter Password ");
      f.txtps.focus();
      return(false);
    }

    if (f.ddllevel.value == "0") {
      alert("Please Enter User Type ");
      f.ddllevel.focus();
      return(false);
    }

  }


</script>

<style type="text/css">
	
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
</style>
</head>

<body>
<?php

	if ($x == 1) { // add user

	?>

	<div class="container">
	<div class="col-lg-7 col-md-9">
		<tr>
			<td align="center"><a href="user.php?x=0">Back</a></td>
		</tr>
	<div class="panel panel-default" >

	<form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_user_exec.php?x=1" >

	<tr>
		<td>&nbsp;</td>
	</tr>
	<div class="panel-heading">
		<h3 class="panel-title"></h3>
	</div>
		<tr>
		    <h3><center>Add User</center></h3>
		</tr>
		<div class="panel-body">
    	<div class="form-group">
      		<label for="txtname">Full name:</label>
      		<input type="text" class="form-control" id="txtname" name="txtname">
    	</div>

    	<div class="form-group">
            <label for="ddldept">Department:</label>
            <select class="form-control" name="ddldept" id="ddldept">
             	<option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
            	<?php
        	do {
        		?>
          		<option value="<?php echo $row_recjab['department_id']?>"<?php if (!(strcmp($row_recjab['department_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recjab['department_name']?></option>
          		<?php
        		} while ($row_recjab = mysqli_fetch_assoc($recjab));
          		$rows = mysqli_num_rows ($recjab);
          		if($rows > 0) {
            	  mysqli_data_seek($recjab, 0);
                  $$row_recjab = mysqli_fetch_assoc($recjab);
          		}
        		?>
            </select>
        </div>

      <div class="form-group">
          <label for="ddlpos">Position:</label>
          <select class="form-control" name="ddlpos" id="ddlpos" onchange="getData('get_search_pos.php?posid='+this.value,'jawatan')">
              <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
              <?php
          do {
          ?>
              <option value="<?php echo $row_recJawatan['pos_id']?>"<?php if (!(strcmp($row_recJawatan['pos_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_recJawatan['pos_name']?></option>
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
          <div id="jawatan"><select class="form-control" name="ddlgred" id="ddlgred">
            <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
          </select></div>
      </div>

    	<div class="form-group">
      		<label for="txtemail">Email:</label>
      		<input type="text" class="form-control" id="txtemail" name="txtemail">
    	</div>

    	<div class="form-group">
      		<label for="txtnotel">Phone Number / Ext: </label>
      		<input type="text" class="form-control" id="txtnotel" name="txtnotel">
    	</div>


     	<div class="form-group">
      		<label for="txtusername">Username:</label>
      		<input type="text" class="form-control" id="txtusername" name="txtusername">
    	</div>

     	<div class="form-group">
      		<label for="txtps">Password:</label>
      		<input type="text" class="form-control" id="txtps" name="txtps">
    	</div>

        <div class="form-group">
            <label for="ddllevel">User Level:</label>
            <select class="form-control" name="ddllevel" id="ddllevel">
             <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
            <?php
        do {
        ?>
          <option value="<?php echo $row_reclevel['level_id']?>"<?php if (!(strcmp($row_reclevel['level_id'], 0))) {echo "selected=\"selected\"";} ?>><?php echo $row_reclevel['level_type']?></option>
          <?php
        } while ($row_reclevel = mysqli_fetch_assoc($reclevel));
          $rows = mysqli_num_rows($reclevel);
          if($rows > 0) {
            mysqli_data_seek($reclevel, 0);
            $$row_reclevel = mysqli_fetch_assoc($reclevel);
          }
        ?>
            </select>
        </div>

		<p>&nbsp;</p>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		<button type="submit" name="Hantar" id="Hantar" class="btn btn-o btn-info">Submit</button>

		<tr>
			<td>&nbsp;</td>
		</tr>
		<p>&nbsp;</p>

	</form>
	</div>
	</div>
	</div>

	  <?php

	} else if ($x == 2) { // edit user

	$id =$_GET['id'];

  mysqli_select_db($conn, $database_conn);
  $query_recUser = "SELECT * FROM login a LEFT JOIN gred_tbl b ON a.jawatan = b.gred_id WHERE a.login_id = '$id'";
  $recUser = mysqli_query($conn, $query_recUser) or die(mysqli_error($conn));
  $row_recUser = mysqli_fetch_assoc($recUser);
  $totalRows_recUser = mysqli_num_rows($recUser);
  $posid = $row_recUser['pos_id'];

  mysqli_select_db($conn, $database_conn);
  $query_recJGred = "SELECT * FROM gred_tbl WHERE pos_id = '$posid' ORDER BY gred_no ASC";
  $recJGred = mysqli_query($conn, $query_recJGred) or die(mysqli_error($conn));
  $row_recJGred = mysqli_fetch_assoc($recJGred);
  $totalRows_recJGred = mysqli_num_rows($recJGred);

	?>
	<div class="container">
	<div class="col-lg-7 col-md-9">
	<tr>
		<td><a href="user.php?x=0">Back</a></td>
	</tr>
	<div class="panel panel-default">
	<form id="form1" name="form1" method="post" onsubmit="return validate(this)" action="add_user_exec.php?x=2">
	<table align="center" width="900" >

	<tr align="center" >
		<td align="center" colspan="3"><span class="style1">Update User Info </span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<div class="panel-body">
     	<div class="form-group">
      		<label for="txtname">Full Name:</label>
      		<input type="text" class="form-control" name="txtname" id="txtname" value="<?php echo $row_recUser['name']; ?>" />
    	</div>

    	<div class="form-group">
			<label for="ddldept">Department:</label>
			<select class="form-control" name="ddldept" id="ddldept">
			<?php
			do {
			?>
				<option value="<?php echo $row_recjab['department_id']?>"<?php if (!(strcmp($row_recjab['department_id'], $row_recUser['jabatan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recjab['department_name']?></option>
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
        <option value="<?php echo $row_recJGred['gred_id']?>"<?php if (!(strcmp($row_recJGred['gred_id'], $row_recUser['jawatan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recJGred['gred_no']?></option>
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
    		<label for="txtnotel">Phone Number / Ext: </label>
     		<input type="text" class="form-control" id="txtnotel" name="txtnotel" value="<?php echo $row_recUser['phonenum']; ?>" />
  	</div>

		<div class="form-group">
      		<label for="txtemail">Email:</label>
      		<input type="text" class="form-control" name="txtemail" id="txtemail" value="<?php echo $row_recUser['EMAIL']; ?>" />
    	</div>

     <div class="form-group">
     		<label for="txtusername">Username:</label>
      		<input type="text" class="form-control" name="txtusername" id="txtusername"  value="<?php echo $row_recUser['username']; ?>" />
    	</div>



    	<div class="form-group">
			<label for="ddllevel">User Level:</label>
			<select class="form-control" name="ddllevel" id="ddllevel">
			<?php
			do {
			?>
				<option value="<?php echo $row_reclevel['level_id']?>"<?php if (!(strcmp($row_reclevel['level_id'], $row_recUser['levelUser']))) {echo "selected=\"selected\"";} ?>><?php echo $row_reclevel['level_type']?></option>
			<?php
				} while ($row_reclevel = mysqli_fetch_assoc($reclevel));
				$rows = mysqli_num_rows($reclevel);
				if($rows > 0) {
				mysqli_data_seek($reclevel, 0);
				$row_reclevel = mysqli_fetch_assoc($reclevel);
				}
			?>
			</select>
		</div>

<!--		<div class="form-group">
			<label for="ddlreg">Registration Status:</label>
			<select class="form-control" name="ddlreg" id="ddlreg">
				<option value="" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>Please Choose</option>
			<?php
			do {
			?>
				<option value="<?php echo $row_recregstat['register_id']?>"<?php if (!(strcmp($row_recregstat['register_id'], $row_recUser['reg_status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_recregstat['register_type']?></option>
			<?php
		} while ($row_recregstat = mysqli_fetch_assoc($recregstat));
				$rows = mysqli_num_rows($recregstat);
				if($rows > 0) {
				mysqli_data_seek($recregstat, 0);
				$row_recregstat = mysqli_fetch_assoc($recregstat);
				}
			?>
			</select>
		</div> -->

		<input type="hidden" name="txtid" id="txtid" value="<?php echo $row_recUser["login_id"]; ?>" />
		<button type="submit" name="Hantar" id="Hantar" class="btn btn-o btn-primary">Submit</button>

	</div>
	</table>
	</form>
	</div>
	</div>
	</div>

	  <?php
	  }
?>

</body>
</html>
