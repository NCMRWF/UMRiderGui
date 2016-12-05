<?php
// project: xml2web
// author : SOMJEET DASGUPTA .  3/6/2016

//=========================================================================//
if(!file_exists("bashfile_box")){
  mkdir("bashfile_box");
}
$SAVE_DIRECTORY = "./bashfile_box/";
// will store the edited bsub files in the bashfile_box folder in the home

$TEMP_STRAY_STRING = ""; // for saving  in a temporary file instead of original
$FORM_HANDLER = "command_runner.php";
foreach ($_POST as $key => $value) {
  echo $key." ".$value."<br>";
  $file_name_arr = explode("_", $key);
  $file_name = $SAVE_DIRECTORY.$file_name_arr[0]."_".$file_name_arr[1].".txt";
  //echo "<br><br>".$file_name."<br><br>";
  file_put_contents($file_name, $value);
}

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
$attr->value = 'SUBMIT JOB';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; font-size: 250%; position: absolute; top: 320px; left: 900px;";
$input->appendChild($attr);
$form->appendChild($input);

echo $dom->saveHTML();
?>
