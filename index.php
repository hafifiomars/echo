<!DOCTYPE html>
<html>
<head>

<!-- <title>Login Form</title> -->
<title>i-Echo</title>
<link rel="icon" href="img/echo-icon.png">
<link rel="stylesheet" type="text/css" href="style2.css">

</head>
<style type="text/css">
body {
  background-image: url(img/banner.png), linear-gradient(120deg, #fbe5d6, #fbe5d6);
  background-size: 65% 15%;
  background-position:top;
  background-repeat:no-repeat, repeat;

}


</style><p>
<body>

<form class="container" id="loginForm" name="loginForm" method="post" action="login-exec.php">
  <div class="title">Login</div>
    <div class="content">
        <div class="user-details">

    <div class="input-box">
       <span class="details">Username</span>
      <input name="username" type="text" class="textfield" id="username" />
    </div>

    <div class="input-box">
      <span class="details">Password</span>
      <input name="password" type="password" class="textfield" id="password" />
    </div>

  </div>

    <div class="button">
      <input type="submit" value="Login">
    </div>

    <p>
      <a href="signup.php">Register</a>
      <td>&nbsp;</td>
      <a href="Manual.pdf" target="_blank">User Manual</a>

    </p>
	<div class="title">Please contact echo admin for any enquiries EXT : 6245</div>


</div>
</div>
</form>
</body>
</html>
