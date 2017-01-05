<?php
session_start();
if(!isset($_SESSION['login_user'])){
header("location: index.php");
}
?>
  
<?php
//=========================================================================//
//file name constants
$FORM_HANDLER = 'form_builder.php';
$FORM_HEADER  = 'CHOOSE THE UMTYPE';
$FORM_CSS     = '../styling/styler.css';
$VALIDATOR_JS = 'validator_scripts/validator.js';


$usr = $_SESSION['login_user'];
if(file_exists("../outfiles/$usr/")){
  system("rm -rf ../outfiles/$usr/");
}
   mkdir("../outfiles/$usr/");


$Jscript = file_get_contents($VALIDATOR_JS);
//=========================================================================//
//styling constants
//$HEADER_FONT_LINK = '../styling/font1.css';
$HEADER_FONT_LINK = 'https://fonts.googleapis.com/css?family=Titillium+Web:300';
//$OB_LABEL_FONT_LINK = '../styling/font2.css';
$OB_LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald';
//$LABEL_FONT_LINK = '../styling/font3.css';
$LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300';
//$SUBMIT_FONT_LINK = '../styling/font4.css';
$SUBMIT_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald:700';

//=========================================================================//
if(file_exists("../outfiles/$usr/umr_setup.cfg")) unlink("../outfiles/$usr/umr_setup.cfg");
if(file_exists("../outfiles/$usr/umr_vars.cfg")) unlink("../outfiles/$usr/vars.cfg");
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





$form->appendChild($dom->createElement('br'));   // line breaker
$form->appendChild($dom->createElement('br'));   // line breaker
/*
$input = $dom->createElement('input');
$attr =  $dom->createAttribute('type');
$attr->value = 'button';
$input->appendChild($attr);
$attr =  $dom->createAttribute('onclick');
$attr->value = 'toggle_date()';
$input->appendChild($attr);
$attr =  $dom->createAttribute('value');
$attr->value = 'Everyday';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 7px; font-size: 100%;";
$input->appendChild($attr);
$form->appendChild($input);
$form->appendChild($dom->createElement('br'));   // line breaker
*/

$label = $dom->createElement('label', 'do not fill the dates for everyday operation');
$attr = $dom->createAttribute('style');
$attr->value = 'position: relative; left: 4px;';
$label->appendChild($attr);
$form->appendChild($label);


$dates = array('Start_date', 'End_date');
foreach($dates as $date){
  /*
  $hidden_descript = $dom->createElement('input');
  $attr = $dom->createAttribute('value');
  $attr->value = $ob_descript;
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'hidden';
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('id');
  $attr->value = $date;
  $hidden_descript->appendChild($attr);
  $dom->appendChild($hidden_descript);
  */

 $description = $date;
  $hidden_descript = $dom->createElement('input');
  $attr = $dom->createAttribute('value');
  $attr->value = $description;
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'hidden';
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('id');
  $attr->value = $date.' : ';
  $hidden_descript->appendChild($attr);
  $dom->appendChild($hidden_descript);


  $label =  $dom->createElement('h4', ($date.' : '));  //option text as label
  $form->appendChild($label);

  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('name');
  $attr->value = $date;
  $input->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'date';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('onchange');
  $attr->value = 'datechecker(this)';
  $input->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px; font-weight: bold;";
  $input->appendChild($attr);
  /*
  $attr = $dom->createAttribute('required');
  $input->appendChild($attr);
  */
  $form->appendChild($input);               //append  input
  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br'));   // line breaker
}



$form->appendChild($dom->createElement('hr')); //form horizontal ruler
$label =  $dom->createElement('h4', 'Choose UM Type :');  //option text as label
$form->appendChild($label);
$values = array('global', 'regional', 'ensemble', 'custom');
foreach($values as $val){
  //echo $val." ";

  $description = $val;
  $hidden_descript = $dom->createElement('input');
  $attr = $dom->createAttribute('value');
  $attr->value = $description;
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('type');
  $attr->value = 'hidden';
  $hidden_descript->appendChild($attr);
  $attr = $dom->createAttribute('id');
  $attr->value = trim($val);
  $hidden_descript->appendChild($attr);
  $dom->appendChild($hidden_descript);

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





if ($val == 'global'){
  $attr = $dom->createAttribute('checked');
  $attr->value = 'checked';
  $input->appendChild($attr);
}
  $form->appendChild($input);                      //append each and every radio input button
  $label =  $dom->createElement('label', ($val));  //option text as label
  $attr = $dom->createAttribute('onmouseover');
  $attr->value = 'descriptor(this)';    // and this.value is the ob_label which inturn is the ID of it's descript
  $label->appendChild($attr);
  $attr = $dom->createAttribute('style');
  $attr->value = "margin-left: 3px";
  $label->appendChild($attr);
  $form->appendChild($label);

  $form->appendChild($dom->createElement('br'));   // line breaker
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
$attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 42.9%; font-size: 150%;";
$input->appendChild($attr);
$form->appendChild($input);

/*
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
*/
$form->appendChild($dom->createElement('br')); // line breaker
$form->appendChild($dom->createElement('br')); // line breaker

$hidden = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'hidden';
$hidden->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = date('Y-m-d');
$hidden->appendChild($attr);
$attr = $dom->createAttribute('id');
$attr->value = 'checkdate';
$hidden->appendChild($attr);
$dom->appendChild($hidden);



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



echo $dom->saveHTML();  //run the html in the browser

?>
