<?php session_start(); 

//if (isset($_COOKIE[session_name()])) {
//    setcookie(session_name(), '', time()-42000, '/');

$_SESSION['login_user']=NULL;
$_SESSION['login_pass']=NULL;
$_SESSION = array();
// Finally, destroy the session.
session_destroy();
echo "Suucessfully logged out! Now redirecting to login page ...";
header( "refresh:5;url=index.php" );

?>
