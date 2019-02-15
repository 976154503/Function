<?php 
$myfile = fopen("name.txt", "r") or die("Unable to open file!");
echo print_r (explode(" ",$myfile));

fclose($myfile);
?>