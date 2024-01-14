<?php require_once('auth.php');
require_once('Connections/conn.php');
$type = $_SESSION['SESS_TYPE'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>i-Echo</title>
<link rel="icon" href="img/echo-icon.png">
</head>
<frameset rows="70,*" frameborder="no" border="0" framespacing="0">
  <frame src="header.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="top" />
  <frame src="booking.php" name="mainFrame" id="mainFrame" title="main" />

</frameset>
</html>
