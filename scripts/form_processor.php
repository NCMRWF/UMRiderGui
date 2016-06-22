<?php
/*
$i = 0;
$filewrite = "";
$cfgfile = fopen("setup.cfg", "w");
while(list($name, $value) = each($_POST)){

  //echo "$i<br>"; $i++;
  $filewrite .= $name.' = ';
  //fwrite($cfgfile, $filewrite);
  if(is_array($value)){
    $val = '[';
    foreach($value as $var){
      $val .= "'$var'".',';
    }
    $val = rtrim($val, ',');
    $val .= ']';

    $filewrite .= $val;
    //fwrite($cfgfile, $filewrite);
  }
  else{
    $filewrite .= $value;
    //fwrite($cfgfile, $filewrite);
  }

  $filewrite .= PHP_EOL;
  fwrite($cfgfile, $filewrite);
  $filewrite = "";
}

echo "SUCCESS: File has been created";
fclose($cfgfile);
*/

$FORM_CSS     = 'styler.css';

$dom = new DOMDocument("2.0");
//=========================================================================//
//styling constants
$HEADER_FONT_LINK =  'https://fonts.googleapis.com/css?family=Titillium+Web:300';
$OB_LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald';
$LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300';
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

  $OUTPUT_FILE  = 'setup.cfg';
  $FORMAT_XML   = 'description.xml';
  $FORM_HANDLER = 'form_processor.php';
  $FORM_HEADER  = 'ALL FIELDS NECCESSARY';
  $VALIDATOR_JS = 'validator.js';
  $xml = simplexml_load_file($FORMAT_XML) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");
  $FORM_HEADER = trim($xml->title);
  $filewrite = "";                              //the string to be written to the file
  $cfgfile = fopen($OUTPUT_FILE, "w");
  $Jscript = file_get_contents($VALIDATOR_JS);

  $model_type = file_get_contents('umtype.txt');
  $umtype = trim($model_type);
  $filewrite .= 'UMType = '.$model_type.PHP_EOL;




  $a = file_get_contents('startdate.txt');
  if($a!="" && $a!=NULL && $a != "YYYYMMDD")
    $start_date =  date('Ymd', strtotime(trim($a)));
  else $start_date = "YYYYMMDD";
  $a = file_get_contents('enddate.txt');
  if($a!="" && $a!=NULL && $a != 'None')
    $end_date = date('Ymd', strtotime(trim($a)));
  else $end_date = "None";
  $filewrite .= 'startdate = '.$start_date.PHP_EOL;
  $filewrite .= 'enddate = '.$end_date.PHP_EOL;
  //if($model_type == 'global') $model = $xml->global->objects;
  //if($model_type == 'ensemble') $model = $xml->ensemble->objects;
  //if($model_type == 'regional') $model = $xml->regional->objects;





  foreach($xml->children() as $thing){
    if($model_type == $thing->getName()){
      $model = $thing;
      break;
    }
  }

  foreach($model->objects->children() as $object){
    $ob_label = trim($object->label);             //object label
    $ob_type = trim($object->inputType);          //object type
    $ob_descript = trim($object->description);

    $filewrite .= "# $ob_descript".PHP_EOL;
    $filewrite .= "$ob_label = ";

    switch($ob_type){

      case 'checkbox' :
          $val = '[';
          if(isset($_POST[$ob_label]) && is_array($_POST[$ob_label]))
          foreach($_POST[$ob_label] as $var){
            $val .= "'$var'".',';
          }
          $val = rtrim($val, ',');
          $val .= ']';
          if($val == '[]') $val = 'None';
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
    $filewrite .= PHP_EOL;
    fwrite($cfgfile, $filewrite);
    $filewrite = "";

  }//end of foreach object------------------------------------------------------
  echo "<h3>SUCCESS: File has been created</h3>";
  fclose($cfgfile);
  ///
  ///
  ///

  ///
  $FORM_HANDLER = "vars_processor.php";
  //echo $model->varsfile;
  $varsxml = trim($model->varsfile);
  $xml = simplexml_load_file($varsxml) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");


  $header = $dom->createElement('h4', 'setup.cfg generated, please select variables for vars.cfg file');
  $dom->appendChild($header);
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
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 100%;";
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
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 38.17%; font-size: 100%;";
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
    $attr->value = '('.$name.', '.$stash.')';
    $input->appendChild($attr);
    /*
    $input->appendChild($attr);
    $attr = $dom->createAttribute('checked');
    $input->appendChild($attr);
    */
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
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 100%;";
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
    $content = $dom->createElement('p', '');
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
