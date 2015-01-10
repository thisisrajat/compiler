<?php

  // Check if the post variable isset
  
  function check_index($index) {
    if( !isset($_POST[$index]) ) {
      header('location: index.html');
    }
  }

  // If these values are not set redirect user to index.html
  
  check_index('submit');
  check_index('source');
  check_index('language');

  // Assign values to the variable

  $source = $_POST['source'];
  $input = $_POST['input'];
  $language = $_POST['language'];

  // Output input to a file

  $dynamic_dir = md5(mt_rand());
  shell_exec("mkdir {$dynamic_dir}");

  if($language === 'C++') {
    require_once('lang/c++.php');
  }

  else if($language === 'C++11') {
    require_once('lang/c++11.php');
  }

  else if($language === 'Python2') {
    require_once('lang/python.php');
  }

  else {
    shell_exec('echo Not Supported, yet. > output');
    header('location: output');
  }

?>