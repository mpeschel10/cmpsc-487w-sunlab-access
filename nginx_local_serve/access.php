<?php
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $conn = new mysqli('localhost', 'AzureDiamond', 'hunter2', 'sweng');
    if ($conn->connect_error)
    {
        http_response_code(500);
        die("Connection failed: " . $conn->connecte_error);
    }

    $result = $conn->query('SELECT * FROM access');
    $conn->close();
    
    $response = array();
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $row['id'] = intval($row['id']);
            $row['allowed'] = $row === '1';
            $response[] = $row;
        }
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
    http_response_code(200);
} else {
    http_response_code(405);
}
