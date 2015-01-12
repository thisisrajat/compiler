<?php 

    shell_exec("touch {$dynamic_dir}/file.py {$dynamic_dir}/input.txt");

    // Put the source in file.py
    file_put_contents("{$dynamic_dir}/file.py", $source);
    file_put_contents("{$dynamic_dir}/input.txt", $input);

    // Change PWD

    chdir("{$dynamic_dir}");

    shell_exec("python file.py < input.txt > ../output 2>&1");

    // Housekeeping
    shell_exec("rm -rf {$dynamic_dir}");

    // Redirect to the output page
    header('location: output');

?>
