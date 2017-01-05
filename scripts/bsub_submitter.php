<?php session_start(); ?>
<?php
// project: xml2web
// author : SOMJEET DASGUPTA .  3/6/2016

//=========================================================================//
$usr = $_SESSION['login_user'];
$SAVE_DIRECTORY = "../outfiles/$usr/";
// will store the edited bsub files in the bashfile_box folder in the home

$TEMP_STRAY_STRING = ""; // for saving  in a temporary file instead of original
$FORM_HANDLER = "bsub_runner.php";
foreach ($_POST as $key => $value) {
//$textToStore = nl2br(htmlentities($value, ENT_QUOTES, 'UTF-8'));
//echo $textToStore;
  //echo $key." "."<pre>".nl2br($value)."</pre>"."<br>";
//$value = str_replace('<br />', "\n", $value);
//$value = preg_replace("/\r\n|\r/", "???????????", $value);
//$value = preg_split('/\r\n|[\r\n]/', $value);
//$value = preg_replace('/\r\n|\r/', "\n", $value);  
//$value = explode(PHP_EOL,$value);
//$textToStore = nl2br(htmlentities($value, ENT_QUOTES, 'UTF-8'));

$value = nl2br(htmlentities($value));

$lines = explode("\n", $value);
foreach( $lines as $index => $line )
{
    $lines[$index] = $line . '<br/>';
}


//echo stripcslashes($value);
//$text = $newList = ereg_replace( "\n",'|',str_replace("\r", "\n", $value);
//echo $newList ;

//$vowels = array("\r\n", "\r", "\n");
//$onlyconsonants = str_replace($vowels, "\n", $value);

//echo "Woal".$onlyconsonants;

//parse domains entered by user into dom textarea and put in doms array:
//$doms = preg_split("/[\r\n]+/", $value, -1, PREG_SPLIT_NO_EMPTY);//array of domains

  //  foreach($doms as $dname){
   // echo $dname."<br>";
   // }//end foreach domain.

  $file_name_arr = explode("_sh", $key);
  $file_name = $file_name_arr[0].".sh";

  $outfile = $SAVE_DIRECTORY.$file_name;
  //echo "<br><br>".$file_name."<br><br>";
//  file_put_contents($file_name, $value);   // Arulalan commented - need to enable to write the edited contents.
 $cmd = "cp ./$file_name $outfile";

$ret_val = "";
$result = system($cmd, $ret_val);
//echo $cmd."<br/>";
//echo $ret_val;

}

// copy umrider_bashrc
$cmd = "cp ./umrider_bashrc $SAVE_DIRECTORY";
  system($cmd);

//this script is to be called by bsub_submitter

$connection = ssh2_connect('192.168.0.222', 22);
ssh2_auth_password($connection, $usr, $_SESSION['login_pass']);


$cdate = date('YmdHi');
$_SESSION['cdate'] = $cdate;

$remote = "/gpfs2/home/$usr/UMRider_Scripts/$cdate/";

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

echo "<p></p><br/>";
$stream = @ssh2_exec($connection, "mkdir -p $remote");
echo "<p> <font size='3pt' ><b>The following directory and files are being created in your home folder</b></font></p> <br/>";
echo "<p> <font size='3pt' color='blue'>".$remote."</font></p><br/>";
                                         
$indir = "../outfiles/$usr/";
$scanned_files = array_diff(scandir($indir), array('..', '.'));
foreach ($scanned_files as $fname) {
if(!endsWith($fname, ".txt")) // omitting txt temp files
{
ssh2_scp_send($connection, $indir.$fname, $remote.$fname, 0644);
echo "<p> <font size='3pt' color='blue'>".$remote.$fname."</font></p>";
}
}
ssh2_exec($connection, 'exit');
unset($connection);

$rmcmd = "rm -rf ../outfiles/$usr";
system($rmcmd);


$dom = new DOMDocument("5.0");

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
$attr->value = 'SUBMIT BJOBs';
$input->appendChild($attr);

$attr = $dom->createAttribute('title');
$attr->value = 'You have to wait for 10 sec after clicked me';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; font-size: 150%; position: absolute; top: 200px; left: 900px;";
$input->appendChild($attr);
$form->appendChild($input);
// logout form

$form = $dom->createElement('form');
$attr = $dom->createAttribute('method');
$attr->value = 'post';
$form->appendChild($attr);
$attr = $dom->createAttribute('action');
$attr->value = "logout.php";
$form->appendChild($attr);
$dom->appendChild($form);
$form->appendChild($dom->createElement('br')); // line breaker

$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'submit';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'LOGOUT';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; font-size: 150%; position: absolute; top: 400px; left: 900px;";
$input->appendChild($attr);
$form->appendChild($input);


echo $dom->saveHTML();
?>
