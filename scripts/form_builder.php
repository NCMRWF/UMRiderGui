<?php
  // project: xml2web
  // author : SOMJEET DASGUPTA .  3/6/2016

  //=========================================================================//
  //CONSTANTS
  //=========================================================================//
  //file name constants
  $FORMAT_XML   = 'description.xml';
  $FORM_HANDLER = 'form_processor.php';
  $FORM_HEADER  = 'ALL FIELDS NECCESSARY';
  //=========================================================================//
  //styling constants
  $HEADER_FONT_LINK =  'https://fonts.googleapis.com/css?family=Titillium+Web:300';
  $OB_LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald';
  $LABEL_FONT_LINK = 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300';
  $SUBMIT_FONT_LINK = 'https://fonts.googleapis.com/css?family=Oswald:700';
  //load the xml file to read the object's format from.
  //=========================================================================//

  //=========================================================================//
  // loading the objects descriptions file using simplexml_load_file utility
  $xml = simplexml_load_file($FORMAT_XML) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");
  //print_r($xml);
  //=========================================================================//

  //=========================================================================//
  //admin defined form header CONSTANTS
  $FORM_HEADER = $xml->title;
  $FORM_HEADER = trim($xml->title);
  //=========================================================================//


  //=========================================================================//
  //create DOM object -- (stays same for the whole php script) OPEN DOC 1.0
  $dom = new DOMDocument('1.0');
  /*supports createElement, createAttribute, appendChild*/
  //=========================================================================//


  //=========================================================================//
  //style for the form page

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

  $css_text = "h1{color:#8c8c8c; font-family: 'Titillium Web', sans-serif;}
               h4{color:#4d4d4d; font-family: 'Oswald', sans-serif; text-decoration: underline;}
               label{color:#404040; font-family: 'Open Sans Condensed', sans-serif;}
               select{color:#404040; font-family: 'Open Sans Condensed', sans-serif;}";

  $style = $dom->createElement('style', $css_text);
  $dom->appendChild($style);

  //=========================================================================//


  //=========================================================================//

  //form header in h2
  $header = $dom->createElement('h1', $FORM_HEADER);
  $dom->appendChild($header);
  $dom->appendChild($dom->createElement('hr')); //dom horizontal ruler
  $dom->appendChild($dom->createElement('hr')); //dom horizontal ruler
  $dom->appendChild($dom->createElement('br')); //dom line-breaker
  $dom->appendChild($dom->createElement('br')); //dom line-breaker


  //form tag code starts below (not form's start, just the code responsible for form tags are here)
  $form =  $dom->createElement('form');                 //make a form tag and drop all the content in it
  $attr =  $dom->createAttribute('action');             //create an attribute for the form tag
  $attr->value = $FORM_HANDLER;                         //set the value to form handler
  $form->appendChild($attr);                            //append the attribute to the form
  $attr =  $dom->createAttribute('method');             //create another attribute and do same as abve
  $attr->value = 'post';
  $form->appendChild($attr);                            //done making form attributes
  //end of form tag
  $dom->appendChild($form);                             //append the form to dom right here.




  foreach($xml->objects->children() as $object){
    $form->appendChild($dom->createElement('hr')); //form horizontal ruler
    $form->appendChild($dom->createElement('br')); // line breaker
    // write these below 2 to a file --- option1
    // make the for reading dynamic for the form_processor.php --- option2
    $ob_label = trim($object->label);             //object label
    $ob_type = trim($object->inputType);          //object type


    $label = $dom->createElement('h4', $ob_label." : ");    //object labels in h4
    $form->appendChild($label);

    //start input tag code
    //get ob_type, ob_label and values...
    //$label = $dom->createElement('h5', $ob_label." : ");
    $input = $dom->createElement('input');

    if($ob_type == 'text'){ //text type handler

      $attr = $dom->createAttribute('type');
      $attr->value = $ob_type;                  //type is specified in the xml file
      $input->appendChild($attr);
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;                 //label is specified in the xml file, becomes identity name && field description
      $input->appendChild($attr);
      $attr = $dom->createAttribute('placeholder');
      $attr->value = $ob_label;                 //label is specified in the xml file, becomes identity name && field description
      $input->appendChild($attr);
      //end input tag code
      $form->appendChild($input);
      $form->appendChild($dom->createElement('br')); // line breaker
    }


    else if($ob_type == 'radio'){                         // radio type handler
      $values = $object->validVals;
      foreach($values->children() as $val){
        //echo $val." ";
        $input = $dom->createElement('input');
        $attr = $dom->createAttribute('type');
        $attr->value = $ob_type;                          //type is specified in the xml file
        $input->appendChild($attr);
        $attr = $dom->createAttribute('name');
        $attr->value = $ob_label;
        $input->appendChild($attr);
        $attr = $dom->createAttribute('value');          //get the value of the radio button for each $val
        $attr->value = trim($val);
        $input->appendChild($attr);

        $form->appendChild($input);                      //append each and every radio input button
        $label =  $dom->createElement('label', ($val));  //option text as label
        $form->appendChild($label);
        $form->appendChild($dom->createElement('br'));   // line breaker
      }
    }

    else if($ob_type == 'select'){
      $values = $object->validVals;
      $select = $dom->createElement('select');
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $select->appendChild($attr);

      foreach($values->children() as $val){
        //echo $val." ";
        $option = $dom->createElement('option', trim($val));
        $attr = $dom->createAttribute('value');   //get the value of the select button for each $val
        $attr->value = trim($val);
        $option->appendChild($attr);
        //$label =  $dom->createElement('label', ($val));
        //$form->appendChild($label);
        $select->appendChild($option);               //append each and every select option
      }
      $form->appendChild($select);               //append select input button
      $form->appendChild($dom->createElement('br')); // line breaker
    }

    else if($ob_type == 'checkbox'){
      $values = $object->validVals;
      foreach($values->children() as $val){
          $input = $dom->createElement('input');

          $attr  = $dom->createAttribute('type');
          $attr->value = $ob_type;
          $input->appendChild($attr);

          $attr  = $dom->createAttribute('name');
          $attr->value = trim($ob_label).'[]';
          //echo $attr->value;
          $input->appendChild($attr);

          $attr = $dom->createAttribute('value');
          $attr->value = trim($val);
          $input->appendChild($attr);
          //echo $attr->value;

          $form->appendChild($input);
          $label =  $dom->createElement('label', trim($val));
          $form->appendChild($label);
          $form->appendChild($dom->createElement('br')); // line breaker
      }
    }



    $form->appendChild($dom->createElement('br')); // line breaker
    $form->appendChild($dom->createElement('br')); // line breaker

  }

  $form->appendChild($dom->createElement('hr')); //form horizontal ruler


  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker

  //=========================================================================//
  //submit button
  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'submit';
  $input->appendChild($attr);

  $attr = $dom->createAttribute('value');
  $attr->value = 'SUBMIT FORM';
  $input->appendChild($attr);

  $attr = $dom->createAttribute('style');
  $attr->value = "font-family: 'Oswald', sans-serif; size:";
  $input->appendChild($attr);

  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($input);

  //=========================================================================//

  echo $dom->saveHTML();  //run the html in the browser

?>
