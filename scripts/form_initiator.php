<?php

//=========================================================================//
//file name constants
$FORM_HANDLER = 'form_builder.php';
$FORM_HEADER  = 'CHOOSE THE UMTYPE';
$FORM_CSS     = 'styler.css';
//=========================================================================//
//styling constants
$HEADER_FONT_LINK =  'https://fonts.googleapis.com/css?family=Titillium+Web:300';
$OB_LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald';
$LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300';
$SUBMIT_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald:700';
//load the xml file to read the object's format from.
//=========================================================================//




$dom = new DOMDocument('0.0');

//=========================================================================//
//style for the form page   CSS --

//linking the fonts
//<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'> h4
//<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'> label
//<link href='https://fonts.googleapis.com/css?family=Noto+Sans:700' rel='stylesheet' type='text/css'> h1
//<link href='https://fonts.googleapis.com/css?family=Titillium+Web:300' rel='stylesheet' type='text/css'> h1
//<link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'> submit button

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

//=========================================================================//


$div = $dom->createElement('div');
$attr = $dom->createAttribute('class');
$attr->value = 'header';
$div->appendChild($attr);
$header = $dom->createElement('h1', $FORM_HEADER);
$div->appendChild($header);
$dom->appendChild($div);
$dom->appendChild($dom->createElement('hr')); //dom horizontal ruler


$div = $dom->createElement('div');
$attr = $dom->createAttribute('class');
$attr->value = 'initiator_form';
$div->appendChild($attr);
$dom->appendChild($div);

$form =  $dom->createElement('form');                 //make a form tag and drop all the content in it
$attr =  $dom->createAttribute('action');             //create an attribute for the form tag
$attr->value = $FORM_HANDLER;                         //set the value to form handler
$form->appendChild($attr);                            //append the attribute to the form
$attr =  $dom->createAttribute('method');             //create another attribute and do same as abve
$attr->value = 'post';
$form->appendChild($attr);                            //done making form attributes
//end of form tag
$div->appendChild($form);                             //append the form to dom right here.


$values = array('global', 'regional', 'ensemble');
foreach($values as $val){
  //echo $val." ";
  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'radio';                          //type is specified in the xml file
  $input->appendChild($attr);
  $attr = $dom->createAttribute('name');
  $attr->value = 'model_type';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('value');          //get the value of the radio button for each $val
  $attr->value = trim($val);
  $input->appendChild($attr);

  $form->appendChild($input);                      //append each and every radio input button
  $label =  $dom->createElement('label', ($val));  //option text as label
  $form->appendChild($label);
  $form->appendChild($dom->createElement('br'));   // line breaker
}



$form->appendChild($dom->createElement('br')); // line breaker
//submit button
$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'submit';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'PROCEED';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 100%;";
$input->appendChild($attr);
$form->appendChild($input);


// form was already appended to the div which was appended to dom before.
$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker
$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'reset';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'RESET CHOICE';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 38.7%; font-size: 100%;";
$input->appendChild($attr);
$form->appendChild($input);
$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker


echo $dom->saveHTML();  //run the html in the browser

?>
