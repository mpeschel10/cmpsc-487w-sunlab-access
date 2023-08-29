<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>SQL test page</title>
</head>
<body>
</body>
<?php
    ini_set('display_errors', 1);
    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo 'Your name is ', $_GET['name'];
        ?><br><?php
        $servername = 'localhost';
        $username = 'AzureDiamond';
        $password = 'hunter2';
        $dbname = 'sweng';

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $sql = "SELECT * FROM apples";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['name'] . "<br>";
            }
        }
        http_response_code(200);
    } else {
        http_response_code(405);
    }
?>
</html>
