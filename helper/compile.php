<?php

  // Check if the post variable isset
  if( !isset($_POST['source']) ) {
    file_put_contents('output.txt', 'Missing source field. Try again, this time write some code :/');
    exit(0);
  }

  // Assign values from the superglobal for painless access
  $source = $_POST['source'];
  $input = $_POST['input'];
  $language = $_POST['lang'];
  $isWindows = false;

  if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $isWindows = true;
  }

  // Really long but it's good, anyways calling substr isn't worth it
  $dir = md5(mt_rand());

  // All dirty work is done in $dir we just made.
  shell_exec("mkdir {$dir}");
  if($isWindows) {
    shell_exec("fsutil file createnew {$dir}/input.txt 0");
  } else {
    shell_exec("touch {$dir}/input.txt");
  }
  file_put_contents("{$dir}/input.txt", $input);
  
  // Logic if the host machine is Windows
  if ($isWindows) {
    
    if($language === 'C++' || $language === 'C++11') {
      $flag = "";
      if($language === 'C++11') $flag = "-std=c++0x";
      shell_exec("fsutil file createnew {$dir}/file.cpp 0");
      file_put_contents("{$dir}/file.cpp", $source);
      shell_exec("g++ {$flag} {$dir}/file.cpp > output.txt 2>&1 && move a.exe {$dir}/a.exe && ({$dir}\a.exe < {$dir}\input.txt >output.txt 2>&1)");
    }
    else if($language === 'C') {
     shell_exec("fsutil file createnew {$dir}/file.c 0");
     file_put_contents("{$dir}/file.c", $source);
     shell_exec("gcc -std=c11 {$dir}/file.c > output.txt 2>&1 && move a.exe {$dir}/a.exe && {$dir}\a.exe <{$dir}\input.txt >output.txt 2>&1");
    }


    shell_exec("rmdir {$dir} /s /q");
    exit(0);
  }

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
  else if($language === 'C') {
    shell_exec("touch {$dir}/file.c");
    file_put_contents("{$dir}/file.c", $source);
    shell_exec("gcc {$dir}/file.c > output.txt 2>&1 && mv a.out {$dir}/a.out && chmod 544 {$dir} && ./{$dir}/timeout.sh -t 5 ./{$dir}/a.out <{$dir}/input.txt >output.txt 2>&1");
  }
  else {
    shell_exec("echo Not Supported Yet :( > output.txt");
  }

  shell_exec("chmod 777 {$dir}");
  shell_exec("rm -rf {$dir}");

?>