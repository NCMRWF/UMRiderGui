<?php
//session_name($_POST['username']);
session_cache_limiter("nocache"); 
session_start(); // Starting Session
//session_regenerate_id(true); 
$_SESSION = array();
//$_POST = array();

$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
$error = '';
}
else
{
$connection = ssh2_connect('192.168.0.222', 22);
$lresult = @ssh2_auth_password($connection, $_POST['username'], $_POST['password']);
ssh2_exec($connection, 'exit');
unset($connection);

if ($lresult) {
$_SESSION['login_user']=$_POST['username']; // Initializing Session
$_SESSION['login_pass']=$_POST['password']; // store pass 
header("location: form_initiator.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
}
}
?>
