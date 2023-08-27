<?php
    ini_set('display_errors', 1);
    $myfile = fopen("my_file.txt", "w");
    fwrite($myfile, "Never have I ever");
    fclose($myfile);
?>