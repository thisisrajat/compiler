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

  // Choose which language and Appropriately Compile

  if($language === 'C++') {

    // Put the source in file.cpp
    file_put_contents('file.cpp', $source);

    // Compile the file
    shell_exec('g++ -Wall -Wextra -O2 file.cpp > output 2>&1');
    
    // Run it
    shell_exec('./a.out < input.txt > output');
    
    // Housekeeping
    shell_exec('rm -rf a.out && cat blank > file.cpp && cat blank > input.txt');
    
    // Redirect to the output page
    header('location: output');
  }

  else if($language === 'C++11') {

    // Put the source in the file.cpp
    file_put_contents('file.cpp', $source);

    // Compile the file
    shell_exec('g++ -Wall -std=c++11 -O2 file.cpp > output 2>&1');

    // Run it
    shell_exec('./a.out < input.txt > output');

    //Housekeeping
    shell_exec('rm -rf a.out && cat blank > file.cpp && cat blank > input.txt');

    // Redirect
    header('location: output');
  }

  // else if($language === 'Python2') {

  //   // Put the source in file.py
  //   file_put_contents('file.py', $source);

  //   // Interpret it
  //   shell_exec('python file.py > output 2>&1');

  //   // Housekeeping
  //   shell_exec('cat blank > file.py && cat blank > input.txt');

  //   // Redirect
  //   header('location: output');

  // }

  // else if($language === 'Java') {

  // }

  // else if ($language === 'PHP') {

  // }

  else if($language === 'C') {

    // Put the source in the file.cpp
    file_put_contents('file.c', $source);

    // Compile the file
    shell_exec('gcc file.c > output 2>&1');

    // Run it
    shell_exec('./a.out < input.txt > output');

    //Housekeeping
    shell_exec('rm -rf a.out && cat blank > file.c && cat blank > input.txt');

    // Redirect
    header('location: output');
  }

  else {
    shell_exec('cat not-supported > output');
  }

?>