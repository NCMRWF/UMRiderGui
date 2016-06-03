<?php

  //constants
  $FORMAT_XML   = 'description.xml';
  $FORM_HANDLER = 'form_processor.php';
  $FORM_HEADER  = 'ALL FIELDS NECCESSARY';
  //$BRLINE = '</br>';
  //load the xml file to read the object's format from.
  $xml = simplexml_load_file($FORMAT_XML) or die("Error: FATAL ERROR. POSSIBLY CORRUPT XML FORMAT.");
  //print_r($xml);
  $FORM_HEADER = $xml->title;
  echo '<h2><mark>'.$FORM_HEADER.'</mark></h2><br>';

  $FORM_HEADER = trim($xml->title);

  $dom = new DOMDocument('1.0');  // create DOM object
  /* createElement, createAttribute, appendChild*/


  //form tag code starts below (not form's start, just the code responsible for form tags are here)
  $form =  $dom->createElement('form');  //make a form tag and drop all the content in it
  $attr =  $dom->createAttribute('action');             //create an attribute for the form tag
  $attr->value = $FORM_HANDLER;                         //set the value to form handler
  $form->appendChild($attr);                            //append the attribute to the form
  $attr =  $dom->createAttribute('method');             //create another attribute and do same as abve
  $attr->value = 'post';
  $form->appendChild($attr);                            //done making form attributes
  //end of form tag
  $dom->appendChild($form);




  foreach($xml->objects->children() as $object){

    $ob_label = trim($object->label);           //object label
    $ob_type = trim($object->inputType);        //object type


    $label = $dom->createElement('h4', $ob_label." : ");
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
    }


    else if($ob_type == 'radio'){  // radio type handler
      $values = $object->validVals;
      foreach($values->children() as $val){
        //echo $val." ";
        $input = $dom->createElement('input');
        $attr = $dom->createAttribute('type');
        $attr->value = $ob_type;                  //type is specified in the xml file
        $input->appendChild($attr);
        $attr = $dom->createAttribute('name');
        $attr->value = $ob_label;
        $input->appendChild($attr);
        $attr = $dom->createAttribute('value');   //get the value of the radio button for each $val
        $attr->value = trim($val);
        $input->appendChild($attr);
        
        $form->appendChild($input);               //append each and every radio input button
        $label =  $dom->createElement('label', ($val));
        $form->appendChild($label);
        $form->appendChild($dom->createElement('br')); // line breaker
      }
    }

    else if($ob_type == 'select'){
      $values = $object->validVals;
      $select = $dom->createElement('select');
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
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
    }

    else if($ob_type == 'checkbox'){
      $values = $object->validVals;
      foreach($values->children() as $val){
          $input = $dom->createElement('input');
          $attr  = $dom->createAttribute('type');
          $attr->value = $ob_type;
          $input->appendChild($attr);
          $attr  = $dom->createAttribute('name');
          $attr->value = $ob_label.'[]';
          $input->appendChild($attr);
          $attr = $dom->createElement('value');
          $attr->value = trim($val);
          $input->appendChild($attr);

          $form->appendChild($input);
          $label =  $dom->createElement('label', ($val));
          $form->appendChild($label);
          $form->appendChild($dom->createElement('br')); // line breaker
      }
    }



    $form->appendChild($dom->createElement('br')); // line breaker
    $form->appendChild($dom->createElement('br')); // line breaker

  }

  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($dom->createElement('br')); // line breaker
  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'submit';
  $input->appendChild($attr);

  $attr = $dom->createAttribute('value');
  $attr->value = 'submit form';
  $input->appendChild($attr);
  $form->appendChild($dom->createElement('br')); // line breaker

  $form->appendChild($input);

  //$dom->appendChild($form);

  echo $dom->saveHTML();  //run the html in the browser

?>
