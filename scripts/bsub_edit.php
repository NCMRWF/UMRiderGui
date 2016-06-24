<?php

$FORM_HANDLER = "bsub_submitter.php";
$VALIDATOR_JS = 'validator.js';
$FORM_CSS     = 'styler.css';
$FORM_HEADER  = 'Edit bsub files . . .';
$dom = new DOMDocument("4.0");


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

$css_text = file_get_contents($FORM_CSS);
$style = $dom->createElement('style', $css_text);
$dom->appendChild($style);

$div = $dom->createElement('div');
$attr = $dom->createAttribute('class');
$attr->value = 'header';
$div->appendChild($attr);
$header = $dom->createElement('h1', $FORM_HEADER);
$div->appendChild($header);
$dom->appendChild($div);
$dom->appendChild($dom->createElement('hr')); //dom horizontal ruler

$form = $dom->createElement('form');
$attr = $dom->createAttribute('method');
$attr->value = 'post';
$form->appendChild($attr);
$attr = $dom->createAttribute('action');
$attr->value = $FORM_HANDLER;
$form->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "width: 1%; margin: 0; border: 0px solid black; border-radius: 0px; background: white";
$form->appendChild($attr);



if(isset($_POST['checklist'])){
  $label = $dom->createElement('label', "TOGGLE  EDITOR >> ");
  $attr = $dom->createAttribute('style');
  $attr->value = "font-size: 115%; margin-left: 5px;";
  $label->appendChild($attr);
  $dom->appendChild($label);


  foreach($_POST['checklist'] as $filepath){
    $filedata = (string)file_get_contents($filepath.".txt");// replace txt with sh when working with linux
    //echo $filedata."<br>";
    $filename = end(explode("/", $filepath));
    //echo $filename;

    $input = $dom->createElement('input');
    $attr = $dom->createAttribute('type');
    $attr->value = 'text';
    $input->appendChild($attr);
    $attr = $dom->createAttribute('name');
    $attr->value = $filepath;
    $input->appendChild($attr);
    $attr = $dom->createAttribute('value');
    $attr->value = $filedata;
    $input->appendChild($attr);
    $attr = $dom->createAttribute('hidden');
    $input->appendChild($attr);
    $form->appendChild($input);


    $input = $dom->createElement('input');
    $attr = $dom->createAttribute('type');
    $attr->value = 'button';
    $input->appendChild($attr);
    $attr = $dom->createAttribute('value');
    $attr->value = "$filename";
    $input->appendChild($attr);
    $attr = $dom->createAttribute('id');
    $attr->value = $filepath;
    $input->appendChild($attr);
    $attr = $dom->createAttribute('onclick');
    $attr->value = "editorpop(this)";
    $input->appendChild($attr);
    $attr = $dom->createAttribute('style');
    $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 3%; font-size: 85%;";
    $input->appendChild($attr);
    $dom->appendChild($input);
  }
  //============================================//
  //$dom->appendChild($dom->createElement('br')); //form horizontal ruler
  $dom->appendChild($dom->createElement('hr')); //form horizontal ruler
  //============================================//

  foreach($_POST['checklist'] as $filepath){
    $filedata = (string)file_get_contents($filepath.".txt");// replace txt with sh when working with linux
    //echo $filedata."<br>";
    $filename = end(explode("/", $filepath));
    //echo $filename;
    $div = $dom->createElement('div');
    $attr = $dom->createAttribute('class');
    $attr->value = "$filepath editor";
    $div->appendChild($attr);
    $attr = $dom->createAttribute('style');
    $attr->value = 'display: none;';
    $div->appendChild($attr);
    $attr = $dom->createAttribute('onchange');
    $attr->value = 'editorsave(this)';
    $div->appendChild($attr);
    //$attr = $dom->createAttribute('hidden');
    //$div->appendChild($attr);
    $dom->appendChild($div);


    $inputbox = $dom->createElement('textarea', $filedata);
    //$attr = $dom->createAttribute('class');
    //$attr->value = $filename;
    //$inputbox->appendChild($attr);
    $attr = $dom->createAttribute('rows');
    $attr->value = 34;
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('cols');
    $attr->value = 100;
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('wrap');
    $attr->value = 'off';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('style');
    $attr->value = 'resize: none;';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('autocorrect');
    $attr->value = 'off';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('autocomplete');
    $attr->value = 'off';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('autocapitalize');
    $attr->value = 'off';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('spellcheck');
    $attr->value = 'off';
    $inputbox->appendChild($attr);
    $attr = $dom->createAttribute('style');
    $attr->value = 'resize: none;';
    $inputbox->appendChild($attr);
    $div->appendChild($inputbox);
  }
}
$dom->appendChild($dom->createElement('br'));
$dom->appendChild($dom->createElement('br'));
$Jscript = file_get_contents($VALIDATOR_JS);
$script = $dom->createElement('script', $Jscript);
$dom->appendChild($script);

$input = $dom->createElement('input');
$attr = $dom->createAttribute('type');
$attr->value = 'submit';
$input->appendChild($attr);
$attr = $dom->createAttribute('value');
$attr->value = 'SAVE and SUBMIT';
$input->appendChild($attr);
$attr = $dom->createAttribute('style');
$attr->value = "font-family: 'Oswald', sans-serif; font-size: 250%; position: absolute; top: 320px; left: 900px;";
$input->appendChild($attr);
$form->appendChild($input);
$dom->appendChild($form); // form for hidden data is done
echo $dom->saveHTML();

?>
