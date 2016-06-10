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
  $VALIDATOR_JS = 'validator.js';
  $FORM_CSS     = 'styler.css';
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
  $USER_MESSAGE= trim($xml->message);
  $FORM_FOOTER = trim($xml->end);
  //=========================================================================//


  //=========================================================================//
  //create DOM object -- (stays same for the whole php script) OPEN DOC 1.0
  $dom = new DOMDocument('1.0');
  /*supports createElement, createAttribute, appendChild*/
  //=========================================================================//


  //=========================================================================//
  $Jscript = "
              function descriptor(obj){
                var getter = obj.innerHTML;
                var ID = (getter.slice(0, -2)).trim();

                var ele = document.getElementById(ID);
                document.getElementById(\"descript\").innerHTML = ele.value;
              }

              function clear_descript(){
                document.getElementById(\"descript\").innerHTML = '';
              }
            ";
  /*
  //linking the doc to the validator JAVASCRIPT script
  $Jscript = "function descriptor(obj){
    var ID = obj.value;
    var ele = getElementByID(ID);
    alert('descriptor called! : ' + obj.value);
    getElementById('descript').innerHTML = obj.value;
  }

  function clear_descript(){
    getElementById('descript').innerHTML = '';
  }";
  $script = $dom->createElement('script', $Jscript);
  $attr = $dom->createAttribute('src');
  $attr->value = $VALIDATOR_JS;
  $script->appendChild($attr);

  $dom->appendChild($script);
  */
  //=========================================================================//


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



  //=========================================================================//

  //form header in h2
  $div = $dom->createElement('div');
  $attr = $dom->createAttribute('class');
  $attr->value = 'header';
  $div->appendChild($attr);
  $header = $dom->createElement('h1', $FORM_HEADER);
  $div->appendChild($header);
  $dom->appendChild($div);
  $dom->appendChild($dom->createElement('hr')); //dom horizontal ruler

  if(trim($USER_MESSAGE) != '' || $USER_MESSAGE != NULL){
    //<span class="glyphicons glyphicons-alert"></span>
    $alert = $dom->createElement('image', ' ');
    $attr = $dom->createAttribute('src');
    $attr->value = 'alert.png';
    $alert->appendChild($attr);
    $attr = $dom->createAttribute('style');
    $attr->value = "width:19px; height:19px; position:relative; top:4px; left: 2px;";
    $alert->appendChild($attr);
    $dom->appendChild($alert);
    $message = $dom->createElement('em', $USER_MESSAGE);
    $dom->appendChild($message);
    $dom->appendChild($dom->createElement('hr')); //dom horizontal ruler
  }

  $dom->appendChild($dom->createElement('br')); //dom line-breaker
  $dom->appendChild($dom->createElement('br')); //dom line-breaker

  $div = $dom->createElement('div');
  $dom->appendChild($div);
  //form tag code starts below (not form's start, just the code responsible for form tags are here)
  $form =  $dom->createElement('form');                 //make a form tag and drop all the content in it
  $attr =  $dom->createAttribute('action');             //create an attribute for the form tag
  $attr->value = $FORM_HANDLER;                         //set the value to form handler
  $form->appendChild($attr);                            //append the attribute to the form
  $attr =  $dom->createAttribute('method');             //create another attribute and do same as abve
  $attr->value = 'post';
  $form->appendChild($attr);                            //done making form attributes
  //end of form tag
  $div->appendChild($form);                             //append the form to dom right here.


  //=========================================================================//
  //PARSING AND ADDING THE OBJECTS BELOW
  $stray_bool = 0;
  foreach($xml->objects->children() as $object){
    if($stray_bool)
    $form->appendChild($dom->createElement('hr')); //form horizontal ruler
    $stray_bool = 1;
    $form->appendChild($dom->createElement('br')); // line breaker
    // write these below 2 to a file --- option1
    // make the for reading dynamic for the form_processor.php --- option2
    $ob_label = trim($object->label);             //object label
    $ob_type = trim($object->inputType);          //object type
    $ob_descript = trim($object->description);    //object description
    if(trim($object->script) != '' || trim($object->script) != NULL){
      $ob_script = ($object->script).'(this)';    //object script function if any
    }

    $label = $dom->createElement('h4', $ob_label." : ");    //object labels in h4
    // label description to be read by javascript script
    $attr = $dom->createAttribute('onmouseover');
    $attr->value = 'descriptor(this)';    // and this.value is the ob_label which inturn is the ID of it's descript
    $label->appendChild($attr);

    $attr = $dom->createAttribute('onmouseout');
    $attr->value = 'clear_descript()';
    $label->appendChild($attr);

    $form->appendChild($label);

    //start input tag code
    //get ob_type, ob_label and values...
    //$label = $dom->createElement('h5', $ob_label." : ");
    $input = $dom->createElement('input');

    if($ob_type == 'text'){ //text type handler
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);

      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);

      $attr = $dom->createAttribute('type');
      $attr->value = $ob_type;                  //type is specified in the xml file
      $input->appendChild($attr);
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;                 //label is specified in the xml file, becomes identity name && field description
      $input->appendChild($attr);
      $attr = $dom->createAttribute('placeholder');
      $attr->value = ' '.$ob_label;                 //label is specified in the xml file, becomes identity name && field description
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }


      $form->appendChild($input);
      $form->appendChild($dom->createElement('br')); // line breaker
    }

    //==================================//
    else if($ob_type == 'radio'){                         // radio type handler
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
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
    //==================================//
    else if($ob_type == 'select'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
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
    //==================================//
    else if($ob_type == 'checkbox'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
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
    //==================================//
    else if($ob_type == 'date'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $input = $dom->createElement('input');
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = $ob_type;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }
      $form->appendChild($input);               //append select input button
      $form->appendChild($dom->createElement('br')); // line breaker
    }
    //==================================//
    else if($ob_type == 'pinteger'){            //render positive only integers
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $input = $dom->createElement('input');
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'number';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('min');
      $attr->value = '0';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('placeholder');
      $attr->value = ' any positive integer';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }
      $form->appendChild($input);               //append select input button
      //$label =  $dom->createElement('label', ' (+ve integer)');
      //$form->appendChild($label);
      $form->appendChild($dom->createElement('br')); // line breaker
    }
    //==================================//
    else if($ob_type == 'integer'){             // render integer types -ve or +ve
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $input = $dom->createElement('input');
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'number';
      $input->appendChild($attr);
      /*
      $values = $object->validVals;
      $attr = $dom->createAttribute('value');
      $val = ($values->children())[0];
      $attr->value = trim(($val);
      $input->appendChild($attr);
      */
      $attr = $dom->createAttribute('placeholder');
      $attr->value = ' any integer';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }

      $form->appendChild($input);               //append select input button
      //$label =  $dom->createElement('label', ' (integer)');
      //$form->appendChild($label);
      $form->appendChild($dom->createElement('br')); // line breaker
    }
    //==================================//
    else if($ob_type == 'float' || $ob_type == 'number'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $input = $dom->createElement('input');          //render float/ decimal values upto 6 decimal places
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'number';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('step');
      $attr->value = '0.000001';  //supports upto 6 decimal places
      $input->appendChild($attr);
      $attr = $dom->createAttribute('placeholder');
      $attr->value = ' upto 6 decimal digits';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }
      $form->appendChild($input);               //append select input button
      //$label =  $dom->createElement('label', ' (float)');
      //$form->appendChild($label);
      $form->appendChild($dom->createElement('br')); // line breaker
    }
    //==================================//
    else if($ob_type == 'boolean'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $values = array('True', 'False');
      foreach($values as $val){
        //echo $val." ";
        $input = $dom->createElement('input');
        $attr = $dom->createAttribute('type');
        $attr->value = 'radio';                          //type is specified in the xml file
        $input->appendChild($attr);
        $attr = $dom->createAttribute('name');
        $attr->value = $ob_label;
        $input->appendChild($attr);
        $attr = $dom->createAttribute('value');          //get the value of the radio button for each $val
        $attr->value = trim($val);
        $input->appendChild($attr);
        if(isset($ob_script)){
          $attr = $dom->createAttribute('onchange');
          $attr->value = $ob_script;
          $input->appendChild($attr);
        }
        $form->appendChild($input);                      //append each and every radio input button
        $label =  $dom->createElement('label', ($val));  //option text as label
        $form->appendChild($label);
        $form->appendChild($dom->createElement('br'));   // line breaker
      }
    }

    else if($ob_type == 'password'){
      $hidden_descript = $dom->createElement('input');
      $attr = $dom->createAttribute('value');
      $attr->value = $ob_descript;
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('type');
      $attr->value = 'hidden';
      $hidden_descript->appendChild($attr);
      $attr = $dom->createAttribute('id');
      $attr->value = $ob_label;
      $hidden_descript->appendChild($attr);
      $dom->appendChild($hidden_descript);
      $input = $dom->createElement('input');
      $attr = $dom->createAttribute('type');
      $attr->value = 'password';                          //type is specified in the xml file
      $input->appendChild($attr);
      $attr = $dom->createAttribute('name');
      $attr->value = $ob_label;
      $input->appendChild($attr);
      $attr = $dom->createAttribute('placeholder');
      $attr->value = ' password';
      $input->appendChild($attr);
      $attr = $dom->createAttribute('style');
      $attr->value = "color:#404040; font-family: 'Open Sans Condensed', sans-serif; width: 170px;";
      $input->appendChild($attr);
      if(isset($ob_script)){
        $attr = $dom->createAttribute('onchange');
        $attr->value = $ob_script;
        $input->appendChild($attr);
      }
      $form->appendChild($input);                      //append each and every input
      //$label =  $dom->createElement('label', ' (password)');  //option text as label
      //$form->appendChild($label);
      $form->appendChild($dom->createElement('br'));   // line breaker
    }

    $form->appendChild($dom->createElement('br')); // line breaker
    $form->appendChild($dom->createElement('br')); // line breaker
    unset($ob_script);
  } /////====================end of foreach object



  $form->appendChild($dom->createElement('hr')); //form horizontal ruler


  //$form->appendChild($dom->createElement('br')); // line breaker
  //$form->appendChild($dom->createElement('br')); // line breaker

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
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 37.9%; font-size: 100%;";
  $input->appendChild($attr);

  $form->appendChild($dom->createElement('br')); // line breaker
  $form->appendChild($input);
  // form was already appended to the div which was appended to dom before.

  $form->appendChild($dom->createElement('br')); // line breaker
  $input = $dom->createElement('input');
  $attr = $dom->createAttribute('type');
  $attr->value = 'reset';
  $input->appendChild($attr);

  $attr = $dom->createAttribute('value');
  $attr->value = 'RESET FORM';
  $input->appendChild($attr);

  $attr = $dom->createAttribute('style');
  $attr->value = "font-family: 'Oswald', sans-serif; position: relative; left: 38.7%; font-size: 100%;";
  $input->appendChild($attr);

  $form->appendChild($dom->createElement('br')); // line breaker

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


  $label = $dom->createElement('label', $FORM_FOOTER);

  $footer = $dom->createElement('div');
  $attr = $dom->createAttribute('class');
  $attr->value = 'footer';
  $footer->appendChild($attr);
  $footer->appendChild($label);
  $dom->appendChild($footer);
//=========================================================================//
  // add the script at last
  $script = $dom->createElement('script', $Jscript);
  $dom->appendChild($script);

  echo $dom->saveHTML();  //run the html in the browser

?>
