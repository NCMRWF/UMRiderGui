<?php
$_SESSION['login_user']=array();
include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
header("location: form_initiator.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form in PHP with Session</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main", align="center">
<h1>UMRiderGui - NCMRWF</h1> 
<p><h3> A quick way of conversion from NCUM pp/ff fileformat to grib1/grib2/nc fileformat </h3></p>
<div id="login", align="center">
<h2>Login to Bhaskara</h2>
<form action="" method="post">
<p><label>UserName :</label>
<input id="name" name="username" placeholder="username" type="text"></p> 
<p><label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password"></p>
<p><input name="submit" type="submit" value=" Login "></p>
<span><?php echo $error; ?></span>
</form>
</div>
<div id="umriderinfo", align="left", style="position:absolute; top:300pt; left:220pt;" >
<p> <font  size='3pt'><b> UMRider </b></font>
<font color='blue' size='3pt'><b><a href="https://github.com/NCMRWF/UMRider", target="_blank">https://github.com/NCMRWF/UMRider</a> </b></font>
<font  size='3pt'> Powered by Python, IRIS, Parallel-Python, bash, LSF  </font>  </p>

<p> <font  size='3pt'><b> UMRiderGui </b></font>
<font color='blue' size='3pt'><b><a href="https://github.com/NCMRWF/UMRiderGui", target="_blank">https://github.com/NCMRWF/UMRiderGui</a> </b></font>  
<font  size='3pt'> Powered by Php, Html, Css, JS, Xml  </font>  </p>
</div>
</div>
</body>
</html>

