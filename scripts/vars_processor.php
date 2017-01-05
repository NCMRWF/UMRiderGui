<?php session_start(); ?>
<?php
$usr = $_SESSION['login_user'];
$mtypename = strtoupper($_SESSION['model_type']);
$vdate = date('d-M-Y');
$vars_cfg = fopen("../outfiles/$usr/umr_vars.cfg", 'w');
$filewrite = "##############################################################################
## vars configure file: Used for the purpose of UMRider conversion of only  ##
## needed NCUM model out variables. UMRider python parallel scripts will    ##
## create analysis and forecast files, by conveting to gri2 file only for   ##
## for the following cf_standard_name and varSTASH coded vars.              ##
##                                                                          ##
##  NCUM $mtypename MODEL POST PROCESSING VARS CONFIGURE FILE    ##
##                                                                          ##
## Setup Created By UMRider's User : $usr <$usr@ncmrwf.gov.in>     ##
## using UMRiderGui                                                         ##
## Created on : $vdate
##############################################################################".PHP_EOL;

  $filewrite .= PHP_EOL;
$filewrite .= PHP_EOL."###################### User Defined Vars Begin ##########################".PHP_EOL;
if(isset($_POST['checklist']))
foreach($_POST['checklist'] as $var){
  $filewrite .= $var.PHP_EOL;
}

$filewrite .= PHP_EOL."###################### User Defined Vars End ##########################".PHP_EOL;

fwrite($vars_cfg, $filewrite);

fclose($vars_cfg);


//echo "<h2>SUCCESS: All .cfg files generated, please select bsub files below</h2>";
//=================================================================================================//
//NEXT LEVEL

$FORMAT_XML   = 'description.xml';
$FORM_HANDLER = 'bsub_edit.php';
$VALIDATOR_JS = 'validator_scripts/validator.js';
$FORM_CSS     = '../styling/styler.css';
$FORM_HEADER  = 'All .cfg files generated, please select bsub files below';
$Jscript = file_get_contents($VALIDATOR_JS);
$umtype = trim(file_get_contents("../outfiles/$usr/umtype.txt"));

$xml = simplexml_load_file($FORMAT_XML);


$modelbsub = trim($xml->global->bsub);
foreach($xml->children() as $thing){
  if($umtype == $thing->getName()){
    $modelbsub = trim($thing->bsub);
    break;
  }
}





$xml = simplexml_load_file($modelbsub) or die("Error: FATAL ERROR. POSSIBLY CORRUPT BSUB XML FORMAT.");

$dom = new DOMDocument("3.0");

$div = $dom->createElement('div');
$attr = $dom->createAttribute('class');
$attr->value = 'header';
$div->appendChild($attr);
$header = $dom->createElement('h1', $FORM_HEADER);
$div->appendChild($header);
$dom->appendChild($div);
$dom->appendChild($dom->createElement('hr')); //dom horizontal ruler
$dom->appendChild($dom->createElement('br'));

//=========================================================================//
$HEADER_FONT_LINK = 'https://fonts.googleapis.com/css?family=Titillium+Web:300';
//$OB_LABEL_FONT_LINK = '../styling/font2.css';
$OB_LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald';
//$LABEL_FONT_LINK = '../styling/font3.css';
$LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300';
//$SUBMIT_FONT_LINK = '../styling/font4.css';
$SUBMIT_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald:700';

//load the xml file to read the object's format from.
//=========================================================================//
$link = $dom->createElement('link');
$href = $dom->createAttribute('href');
$href->value = $OB_LABEL_FONT_LINK;
$link->appendChild($href);
$rel = $dom->createAttribute('rel');
$rel->value = 'stylesheet';
$link->appendChild($rel);
$type = $dom->createAttribute('type');
$type->value = 'text/css';
$link->appendChild($type);

$dom->appendChild($link);


$link = $dom->createElement('link');
$href = $dom->createAttribute('href');
$href->value = $SUBMIT_FONT_LINK;
$link->appendChild($href);
$rel = $dom->createAttribute('rel');
$rel->value = 'stylesheet';
$link->appendChild($rel);
$type = $dom->createAttribute('type');
$type->value = 'text/css';
$link->appendChild($type);

$dom->appendChild($link);


$link = $dom->createElement('link');
$href = $dom->createAttribute('href');
$href->value = $OB_LABEL_FONT_LINK;
$link->appendChild($href);
$rel = $dom->createAttribute('rel');
$rel->value = 'stylesheet';
$link->appendChild($rel);
$type = $dom->createAttribute('type');
$type->value = 'text/css';
$link->appendChild($type);

$dom->appendChild($link);


$link = $dom->createElement('link');
$href = $dom->createAttribute('href');
$href->value = $HEADER_FONT_LINK;
$link->appendChild($href);
$rel = $dom->createAttribute('rel');
$rel->value = 'stylesheet';
$link->appendChild($rel);
$type = $dom->createAttribute('type');
$type->value = 'text/css';
$link->appendChild($type);

$dom->appendChild($link);


$link = $dom->createElement('link');
$href = $dom->createAttribute('href');
$href->value = $LABEL_FONT_LINK;
$link->appendChild($href);
$rel = $dom->createAttribute('rel');
$rel->value = 'stylesheet';
$link->appendChild($rel);
$type = $dom->createAttribute('type');
$type->value = 'text/css';
$link->appendChild($type);

$dom->appendChild($link);


/*
option texts are <label>
form header is <h1>
object labels are <h4>
*/

$css_text = file_get_contents($FORM_CSS);

$style = $dom->createElement('style', $css_text);
$dom->appendChild($style);



$form = $dom->createElement('form');
$attr = $dom->createAttribute('method');
$attr->value = 'post';
$form->appendChild($attr);
$attr = $dom->createAttribute('action');
$attr->value = $FORM_HANDLER;
$form->appendChild($attr);
$dom->appendChild($form);
$form->appendChild($dom->createElement('br')); // line breaker


$heading = $dom->createElement('h4', 'Analysis :');
$form->appendChild($heading);

foreach($xml->analysis->children() as $file){

  $name = trim($file->name);
  $path = trim($file->fullpath);
  $description = trim($file->description);


  $hidden_descript = $dom->createElement('input');
  $attr = $dom->createAttribute('value');
  $attr->value = $description;
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'hidden';
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('id');
  $attr->value = $name;
  $hidden_descript->appendChild($attr);
  $dom->appendChild($hidden_descript);


  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'checkbox';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('value');
  $attr->value = $path;
  $input->appendChild($attr);
  $attr = $dom->createAttribute('name');
  $attr->value = 'checklist[]';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "margin-left: 20px";
  $input->appendChild($attr);
  $form->appendChild($input);
  $label = $dom->createElement('label', $name);
  $attr = $dom->createAttribute('onmouseover');
  $attr->value = 'descriptor(this)';    // and this.value is the ob_label which inturn is the ID of it's descript
  $label->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "margin-left: 3px";
  $label->appendChild($attr);
  $form->appendChild($label);
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
}

//forecast part


$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker


$heading = $dom->createElement('h4', 'Forecast :');
$form->appendChild($heading);

foreach($xml->forecast->children() as $file){

  $name = trim($file->name);
  $path = trim($file->fullpath);
  $description = trim($file->description);


  $hidden_descript = $dom->createElement('input');
  $attr = $dom->createAttribute('value');
  $attr->value = $description;
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'hidden';
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('id');
  $attr->value = $name;
  $hidden_descript->appendChild($attr);
  $dom->appendChild($hidden_descript);


  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'checkbox';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('value');
  $attr->value = $path;
  $input->appendChild($attr);
  $attr = $dom->createAttribute('name');
  $attr->value = 'checklist[]';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "margin-left: 20px";
  $input->appendChild($attr);
  $form->appendChild($input);
  $label = $dom->createElement('label', $name);
  $attr = $dom->createAttribute('onmouseover');
  $attr->value = 'descriptor(this)';    // and this.value is the ob_label which inturn is the ID of it's descript
  $label->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "margin-left: 3px";
  $label->appendChild($attr);
  $form->appendChild($label);
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
}



$form->appendChild($dom->createElement('br')); // line breaker
$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'submit';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'SUBMIT';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 150%;";
$input->appendChild($attr);
$form->appendChild($input);
$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker



//=========================================================================//

  //status div for description and instructions
  $div2 = $dom->createElement('div');
  $attr = $dom->createAttribute('class');
  $attr->value = 'description';
  $div2->appendChild($attr);

  $stray_header = $dom->createElement('h4', 'HOVER MOUSE OVER FIELD NAME FOR DESCRIPTION');
  $div2->appendChild($stray_header);
  //=================DESCRIPTION CONTENT HERE ====================//
  //$div2->appendChild($dom->createElement('br')); // div2 line break
  $content = $dom->createElement('pre', '');
  $attr = $dom->createAttribute('id');
  $attr->value = "descript";
  $content->appendChild($attr);
  //$attr = $dom->createAttribute('class');
  $div2->appendChild($content);

  $dom->appendChild($div2);


  $dom->appendChild($dom->createElement('br')); // dom line breaker
  $dom->appendChild($dom->createElement('br')); // dom line breaker


  $script = $dom->createElement('script', $Jscript);
  $dom->appendChild($script);

  echo $dom->saveHTML();



?>
