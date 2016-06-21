<?php

$vars_cfg = fopen('vars.cfg', 'w');
$filewrite = "";
if(isset($_POST['checklist']))
foreach($_POST['checklist'] as $var){
  $filewrite .= $var.PHP_EOL;
}
fwrite($vars_cfg, $filewrite);

fclose($vars_cfg);


echo "<h2>SUCCESS: All .cfg files generated, Ready to submit a job</h2>";
?>
