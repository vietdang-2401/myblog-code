<?php

function loadClass($class_name) {
  $root = "../";
  $file = str_replace("\\", "/", $class_name).".php";
  $path = $root . $file;
  if (file_exists($path)) {
    require($path);
  }
}

spl_autoload_register('loadClass');

?>

