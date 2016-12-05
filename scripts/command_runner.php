<?php


//this script is to be called by bsub_submitter


//place the command in this string
$command = "whoami";

/*
  $result stores the last line of the output
  and $ret_val stores the return value of the command
*/
$result = exec($command, $ret_val);
echo $result; // test only
//add user side message below in HTML between the quotes
echo ""




?>
