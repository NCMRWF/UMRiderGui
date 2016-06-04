<?php
$i = 0;
$filewrite = "";
while(list($name, $value) = each($_POST) ){

  /*
  echo $name."</br>";
  if(is_array($name)){
    foreach($name as $var){
      echo $var.' ';
    }
  }
  if(is_array($value)){
    foreach($_POST[$name] as $var){
      echo $var.' ';
    }
    echo '<br>';
  }
  */
  $cfgfile = fopen("setup.cfg", "w");
  //echo "$i<br>"; $i++;

  $filewrite .= $name.' = ';
  //fwrite($cfgfile, $filewrite);
  if(is_array($value)){
    $val = '(';
    foreach($value as $var){
      $val .= $var.',';
    }
    $val = rtrim($val, ',');
    $val .= ')';

    $filewrite .= $val;
    //fwrite($cfgfile, $filewrite);
  }
  else{
    $filewrite .= $value;
    //fwrite($cfgfile, $filewrite);
  }

  $filewrite .= '  ';
}
fwrite($cfgfile, $filewrite);
echo "SUCCESS: File has been created";
fclose($cfgfile);

?>
