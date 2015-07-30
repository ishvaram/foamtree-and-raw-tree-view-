<?php
$dataJSON = $_POST['rawdata'];

echo $dataJSON;


$myfile = fopen("cluster.json", "w") or die("Unable to open file!");
chmod("cluster.json", 0777);
$txt = $dataJSON;
fwrite($myfile, $txt);
fclose($myfile);
?>