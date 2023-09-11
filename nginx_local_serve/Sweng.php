<?php
namespace Sweng;
use mysqli;

/*
new mysqli(...) throws mysqli_sql_exception $e.
($e->getSqlState(), $e->getCode())=>$reason, // Actual reason
("HY000", 2002)=>"php_network_getaddresses: getaddrinfo for lcalhost failed: Name or service not known", // Generic network error e.g. wrong url
("HY000", 1045)=>"Access denied for user 'AzureDiamond'@'localhost' (using password: YES)", // Wrong username/password
("HY000", 1044)=>"Access denied for user 'AzureDiamond'@'localhost' to database 'seng'", // Login ok, but asking for database which we do not have rights to or does not exist

//insert query throws:
("23000", 1062)=>"Duplicate entry 'dreadful bil' for key 'PRIMARY'",
*/

function connect()
{
    $conn = new mysqli('localhost', 'AzureDiamond', 'hunter2', 'sweng');
    return $conn;
}