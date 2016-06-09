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

  $OUTPUT_FILE  = 'setup.cfg';
  $FORMAT_XML   = 'description.xml';
  $FORM_HANDLER = 'form_processor.php';
  $FORM_HEADER  = 'ALL FIELDS NECCESSARY';
  $VALIDATOR_JS = 'validator.js';
  $xml = simplexml_load_file($FORMAT_XML) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");
  $FORM_HEADER = trim($xml->title);
  $filewrite = "";                              //the string to be written to the file
  $cfgfile = fopen($OUTPUT_FILE, "w");

  foreach($xml->objects->children() as $object){
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
  echo "SUCCESS: File has been created";
  fclose($cfgfile);

?>
