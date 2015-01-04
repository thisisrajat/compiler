<?php

  function check_index($index) {
    if( !isset($_POST[$index]) ) {
      header('location: index.html');
    }
  }

  check_index('submit');
  check_index('source');
  check_index('language');

  $source = $_POST['source'];
  $input = $_POST['input'];
  $language = $_POST['language'];

  file_put_contents('input.txt', $input);
  if($language === 'C++') {
    file_put_contents('file.cpp', $source);
    shell_exec('g++ -Wall -Wextra -O2 file.cpp > output 2>&1');
    // echo shell_exec('./a.out < input.txt > output');
    // shell_exec('a.exe < input.txt > output 2>&1');
    shell_exec('rm -rf a.exe && cat blank > file.cpp && cat blank > input.txt');
    // echo shell_exec('cat blank > file.cpp');
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