<?php session_start(); ?>

<?php
$FORM_HANDLER = 'logout.php';

//this script is to be called by bsub_submitter
$usr = $_SESSION['login_user'];

$connection = ssh2_connect('192.168.0.222', 22);
ssh2_auth_password($connection, $usr, $_SESSION['login_pass']);
$sftp = ssh2_sftp($connection);

echo "<br/>";
echo "<p> <font size='3pt'><b>Remote login to your account and submit bjobs on behalf of you! :-)</b></font></p>";
echo "<p> <font size='3pt'>$ <font color='blue' size='3pt'><b>ssh $usr@192.168.0.222</b></font></font></p>";

$cdate = $_SESSION['cdate'];


$remote = "/gpfs2/home/$usr/UMRider_Scripts/$cdate/";


function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

$scanned_files = array_diff(scandir('ssh2.sftp://' . $sftp . $remote), array('..', '.'));

$stream = ssh2_shell($connection, 'vt102', null, 80, 24, SSH2_TERM_UNIT_CHARS);
fwrite( $stream, "cd $remote".PHP_EOL);
fwrite( $stream, "ls -lrt".PHP_EOL);


foreach ($scanned_files as $fname) {
if(endsWith($fname, ".sh")) // omitting other files
{
fwrite( $stream, "bsub < $fname".PHP_EOL);
}
}

$bjobids = array();

sleep(5);
while($line = fgets($stream)) {
flush();
if(!(startsWith($line, "cd" ) | startsWith($line, "ls" ) | startsWith($line, "bsub") | startsWith($line, "bjobs") | startsWith($line, "exit") | startsWith($line, "Currently") )){

$linedata = trim($line);
if ( is_numeric($linedata[0])) {continue;}
if(startsWith($line, "[") | startsWith($line, "ncm")){ 

$lines = explode("$", $line);
$nlines = "<p> <font size='3pt'>".$lines[0]."$<font color='blue' size='3pt'><b>".$lines[1]."</b></font></font></p>";
echo $nlines;}
else echo $line."</br>"; 
//else echo "<p> <font size='3pt'>".$line."</font></p>";

if(startsWith($line, "Job <")){
$jobid = explode("<", $line);
$jobid = explode(">", $jobid[1]);
array_push($bjobids, $jobid[0]);

}}}


foreach($bjobids as $bjid) {
fwrite( $stream, "bjobs -r ".$bjid.PHP_EOL);
}

fwrite( $stream, "exit".PHP_EOL);

sleep(5);
while($line = fgets($stream)) {
flush();
if(!( startsWith($line, "exit") | startsWith($line, "bjobs")   )){
if(startsWith($line, "[") | startsWith($line, "ncm")){
$lines = explode("$", $line);
$nlines = "<p> <font size='3pt'>".$lines[0]."$<font color='blue' size='3pt'><b>".$lines[1]."</b></font></font></p>";
echo $nlines;}
else echo "<p> <font size='3pt' color='red'>".$line."</font></p>";
}

}





ssh2_exec($connection, 'exit');
unset($connection);

echo "<p> <font size='3pt'>Successfully submitted bsub jobs and logged out! </font></p>";
echo "<p> <font size='3pt'>You can rename this folder <font color='blue' size='3pt'><b>'$remote'</b></font> and/or move into any directory path and submit bjobs as shown above!</font></p>";

$dom = new DOMDocument("6.0");
$form = $dom->createElement('form');
$attr = $dom->createAttribute('method');
$attr->value = 'post';
$form->appendChild($attr);
$attr = $dom->createAttribute('action');
$attr->value = $FORM_HANDLER;
$form->appendChild($attr);
$dom->appendChild($form);
$form->appendChild($dom->createElement('br')); // line breaker

$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'submit';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'EXIT';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 38.7%; font-size: 150%";
$input->appendChild($attr);
$form->appendChild($input);

echo $dom->saveHTML();


?>
