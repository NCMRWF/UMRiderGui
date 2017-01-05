<?php session_start(); ?>
<?php
// project: xml2web
// author : SOMJEET DASGUPTA .  3/6/2016

//=========================================================================//
$FORM_CSS     = '../styling/styler.css';

$dom = new DOMDocument("2.0");
//=========================================================================//
//styling constants
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



$css_text = file_get_contents($FORM_CSS);

$style = $dom->createElement('style', $css_text);
$dom->appendChild($style);
$usr = $_SESSION['login_user'];
  $OUTPUT_FILE  = "../outfiles/$usr/umr_setup.cfg";
  $FORMAT_XML   = 'description.xml';
  $FORM_HANDLER = 'form_processor.php';
  $FORM_HEADER  = 'ALL FIELDS NECCESSARY';
  $VALIDATOR_JS = 'validator_scripts/validator.js';
  $xml = simplexml_load_file($FORMAT_XML) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");
  $FORM_HEADER = "setup.cfg generated, please select variables for vars.cfg file";
  $filewrite = "";                              //the string to be written to the file
  
  $mtypename = strtoupper($_SESSION['model_type']);
  $sdate = date('d-M-Y');
  $filewrite = "##############################################################################
## setup configure file: Used to setup indata path, outdata path, temporary ##
## path to run the UMRider python parallel scripts which will create        ##
## analysis and forecast files.                                             ##
##                                                                          ##
##  NCUM $mtypename MODEL POST PROCESSING SETUP CONFIGURE FILE    ##
##                                                                          ##
## Setup Created By UMRider's User : $usr <$usr@ncmrwf.gov.in>     ##
## using UMRiderGui                                                         ##
## Created on : $sdate                                                ##
##############################################################################".PHP_EOL;

  $filewrite .= PHP_EOL;
  $cfgfile = fopen($OUTPUT_FILE, "w");
  $Jscript = file_get_contents($VALIDATOR_JS);


  $div = $dom->createElement('div');
  $attr = $dom->createAttribute('class');
  $attr->value = 'header';
  $div->appendChild($attr);
  $header = $dom->createElement('h1', $FORM_HEADER);
  $div->appendChild($header);
  $dom->appendChild($div);
  $dom->appendChild($dom->createElement('hr')); //dom horizontal ruler
  $dom->appendChild($dom->createElement('br'));

  $filewrite .= PHP_EOL."###################### User Defined Arguments Begin ##########################".PHP_EOL;

  $model_type = file_get_contents("../outfiles/$usr/umtype.txt");
  $umtype = trim($model_type);
  $filewrite .= 'UMtype = '.$model_type.PHP_EOL;




  $a = file_get_contents("../outfiles/$usr/startdate.txt");
  if($a!="" && $a!=NULL && $a != "YYYYMMDD")
    $start_date =  date('Ymd', strtotime(trim($a)));
  else $start_date = "YYYYMMDD";
  $a = file_get_contents("../outfiles/$usr/enddate.txt");
  if($a!="" && $a!=NULL && $a != 'None')
    $end_date = date('Ymd', strtotime(trim($a)));
  else $end_date = "None";
  $filewrite .= 'startdate = '.$start_date.PHP_EOL;
  $filewrite .= 'enddate = '.$end_date.PHP_EOL;



  foreach($xml->children() as $thing){
    if($model_type == $thing->getName()){
      $model = $thing;
      break;
    }
  }

  foreach($model->objects->children() as $object){
    $ob_label = trim($object->label);             //object label
    $ob_type = trim($object->inputType);          //object type
    $ob_descript = $object->description;
    $ob_descript_array = explode("\n", $ob_descript);
    foreach($ob_descript_array as $obsd){
	    $filewrite .= "# $obsd".PHP_EOL;}

    $filewrite .= PHP_EOL."$ob_label = ";

    switch($ob_type){

      case 'checkbox' :
          $val = '[';
          if(isset($_POST[$ob_label]) && is_array($_POST[$ob_label]))
          foreach($_POST[$ob_label] as $var){
            $val .= "'$var'".',';
          }
          $val = rtrim($val, ',');
          $val .= ']';
          if($val == '[]') $val = '[]';
          $filewrite .= $val;

      break;

      case 'radio' :
      case 'select' :
      case 'boolean':
        if(isset($_POST[$ob_label]) && $_POST[$ob_label] != NULL && $_POST[$ob_label] != ''){
          $filewrite .= $_POST[$ob_label];
        }
        else $filewrite .= "None";
      break;

      case 'date' :
        if(isset($_POST[$ob_label]) && $_POST[$ob_label] != NULL && $_POST[$ob_label] != ''){
          $date = date('Ymd', strtotime($_POST[$ob_label]));
          $filewrite .= $date;
        }
        else $filewrite .= "None";
      break;

      case 'pinteger' :
      case 'float' :
      case 'integer' :
        if(isset($_POST[$ob_label]) && $_POST[$ob_label] != NULL && $_POST[$ob_label] != ''){
          $filewrite .= $_POST[$ob_label];
        }
        else $filewrite .= "None";
      break;

      case 'text' :
      case 'password' :
        if(isset($_POST[$ob_label]) && $_POST[$ob_label] != NULL && $_POST[$ob_label] != ''){
          $filewrite .= $_POST[$ob_label];
        }
        else $filewrite .= "None";
      break;

    }// end of switch case------------------------------------------------------

    $filewrite .= PHP_EOL;
    
    fwrite($cfgfile, $filewrite);
    $filewrite = "";

  }//end of foreach object------------------------------------------------------
$filewrite .= PHP_EOL;
    $filewrite .= PHP_EOL."###################### User Defined Arguments End ############################".PHP_EOL;
fwrite($cfgfile, $filewrite);
    $filewrite = "";
  //"<h3>SUCCESS: File has been created</h3>";
  fclose($cfgfile);
  ///

  ///
  $FORM_HANDLER = "vars_processor.php";
  //echo $model->varsfile;
  $varsxml = trim($model->varsfile);
  $xml = simplexml_load_file($varsxml) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");


  //$header = $dom->createElement('h4', 'setup.cfg generated, please select variables for vars.cfg file');
  //$dom->appendChild($header);
  $form = $dom->createElement('form');
  $attr = $dom->createAttribute('method');
  $attr->value = 'post';
  $form->appendChild($attr);
  $attr = $dom->createAttribute('action');
  $attr->value = $FORM_HANDLER;
  $form->appendChild($attr);
  $dom->appendChild($form);
  $form->appendChild($dom->createElement('br')); // line breaker


  $button = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'button';
  $button->appendChild($attr);
  $attr = $dom->createAttribute('onclick');
  $attr->value = 'check_all()';
  $button->appendChild($attr);
  $attr = $dom->createAttribute('value');
  $attr->value = 'Select ALL';
  $button->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 150%;";
  $button->appendChild($attr);
  $form->appendChild($button);
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'reset';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('value');
  $attr->value = 'Reset ALL';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 38.17%; font-size: 150%;";
  $input->appendChild($attr);
  $form->appendChild($input);
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker

  foreach($xml->children() as $var){
    $name = trim($var->name);
    $stash = trim($var->stash);
    $descript = trim($var->description);
    $hidden_descript = $dom->createElement('input');
    $attr = $dom->createAttribute('value');
    $attr->value = $descript;
    $hidden_descript->appendChild($attr);
    $attr = $dom->createAttribute('type');
    $attr->value = 'hidden';
    $hidden_descript->appendChild($attr);
    $attr = $dom->createAttribute('id');
    $attr->value = $name.'  :  '.$stash;
    $hidden_descript->appendChild($attr);
    $dom->appendChild($hidden_descript);


    $input = $dom->createElement('input');
    $attr = $dom->createAttribute('name');
    $attr->value = 'checklist[]';
    $input->appendChild($attr);
    $attr = $dom->createAttribute('type');
    $attr->value = 'checkbox';
    $input->appendChild($attr);
    $attr = $dom->createAttribute('value');
    $attr->value = "('$name', '$stash')";
    $input->appendChild($attr);

    $form->appendChild($input);
    $label = $dom->createElement('label', $name.'  :  '.$stash);
    $attr = $dom->createAttribute('onmouseover');
    $attr->value = 'descriptor(this)';    // and this.value is the ob_label which inturn is the ID of it's descript
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
?>`
