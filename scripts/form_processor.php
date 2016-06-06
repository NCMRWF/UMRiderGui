<?php
$i = 0;
$filewrite = "";
$cfgfile = fopen("setup.cfg", "w");
while(list($name, $value) = each($_POST) ){

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

?>
