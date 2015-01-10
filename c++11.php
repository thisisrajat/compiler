<?php 

    shell_exec("touch {$dynamic_dir}/file.cpp {$dynamic_dir}/input.txt");

    // Put the source in file.cpp
    file_put_contents("{$dynamic_dir}/file.cpp", $source);
    file_put_contents("{$dynamic_dir}/input.txt", $input);

    // Compile the file
    shell_exec("g++ -O2 -std=c++11 {$dynamic_dir}/file.cpp");

    // Move a.out to dynamic_dir
    shell_exec("mv a.out {$dynamic_dir}/a.out");

    // Run it
    shell_exec("{$dynamic_dir}/a.out < {$dynamic_dir}/input.txt > output");

    // Housekeeping
    shell_exec("rm -rf {$dynamic_dir}");

    // Redirect to the output page
    header('location: output');

?>