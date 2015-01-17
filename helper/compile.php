<?php

  // Check if the post variable isset
  if( !isset($_POST['source']) ) {
    shell_exec("echo Missing Fields > output.txt 2>&1");
    exit(0);
  }

  // Assign values from the superglobal for painless access
  $source = $_POST['source'];
  $input = $_POST['input'];
  $language = $_POST['lang'];


  // Really long but it's good, anyways calling substr isn't worth it
  $dir = md5(mt_rand());

  // All dirty work is done in $dir we just made.
  shell_exec("mkdir {$dir}");
  shell_exec("touch {$dir}/input.txt");
  file_put_contents("{$dir}/input.txt", $input);
  
  // Chmod $dir to make a sandbox. Only read and execute permission. No write.
  shell_exec("cp timeout.sh {$dir}/timeout.sh && chmod 777 {$dir}/timeout.sh");

  // Language specific logics now.

  if($language === 'C++' || $language === 'C++11') {

    $flag = "";
    if($language === 'C++11') $flag = "-std=c++0x";

    shell_exec("touch {$dir}/file.cpp");
    file_put_contents("{$dir}/file.cpp", $source);
    shell_exec("g++ {$flag} {$dir}/file.cpp > output.txt 2>&1 && mv a.out {$dir}/a.out && chmod 544 {$dir} && ./{$dir}/timeout.sh -t 5 ./{$dir}/a.out < {$dir}/input.txt > output.txt 2>&1");
  
  }
  else if($language === 'Python 2') {

    shell_exec("touch {$dir}/file.py");
    file_put_contents("{$dir}/file.py", $source);
    shell_exec("chmod 544 {$dir}");
    shell_exec("./{$dir}/timeout.sh -t 5 python {$dir}/file.py < {$dir}/input.txt > output.txt 2>&1");
  
  }
  else {
    shell_exec("echo Not Supported Yet :( > output.txt");
  }

  shell_exec("chmod 777 {$dir}");
  shell_exec("rm -rf {$dir}");

?>