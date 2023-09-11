<?php
include 'Sweng.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $conn = Sweng\connect();
    $result = shell_exec("mariadb --user=AzureDiamond --password=hunter2 -D sweng < /home/mpeschel/projects/life_management/college/software_engineering/h1/sunlab.sql");
    echo "Reset successful. Results:\n" . $result;
    http_response_code(200);
} else {
    http_response_code(405);
}
    