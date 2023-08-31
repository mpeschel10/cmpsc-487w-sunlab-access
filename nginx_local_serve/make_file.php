<?php
    ini_set('display_errors', 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $myfile = fopen($_GET['test_name'], "w");
        fwrite($myfile, "This is test text");
        fclose($myfile);
        http_response_code(204);
    } else {
        http_response_code(405);
    }
