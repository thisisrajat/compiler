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

  file_put_contents('input.txt', $input);

  // Choose which language and Appropriately execute

  if($language === 'C++') {

    // Put the source in file.cpp
    file_put_contents('file.cpp', $source);

    // Execute the file
    shell_exec('g++ -Wall -Wextra -O2 file.cpp > output 2>&1');
    
    // Run it
    shell_exec('./a.out < input.txt > output');
    
    // Housekeeping
    shell_exec('rm -rf a.out && cat blank > file.cpp && cat blank > input.txt');
    
    // Redirect to the output page
    header('location: output');
  }

  else if($language === 'C++11') {

  }

  else if($language === 'Python2') {

  }

  else if($language === 'Java') {

  }

  else if ($language === 'PHP') {

  }

  else {
    shell_exec('cat not-supported > output');
  }

?>