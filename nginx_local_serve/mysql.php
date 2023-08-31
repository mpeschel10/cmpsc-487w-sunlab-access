<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>SQL test page</title>
</head>
<body>
<!-- Transcribed from https://www.w3schools.com/php/php_mysql_select.asp -->
<?php
    ini_set('display_errors', 1);
    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (!array_key_exists('username', $_GET) || !array_key_exists('password', $_GET) || !array_key_exists('apple', $_GET))
        {
            die('You must provide query parameters for username, password, apple.');
        }
        echo 'Your name is ' . $_GET['username'] . '<br>';
        $servername = 'localhost';
        $username = $_GET['username'];
        $password = $_GET['password'];
        $dbname = 'sweng';

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $sql = "INSERT INTO apples VALUES ('" . $_GET['apple'] . "')";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['name'] . "<br>";
            }
        }
        http_response_code(200);
    } else {
        echo '405 Wrong Access Method';
        http_response_code(405);
    }
?>
</body>
</html>
