<?php
// ini_set("display_errors", 1);
// echo http_build_query($_GET), '<br>';

$local_time = $_GET['timestamp'];
$id = $_GET['id'];

$conn = new mysqli('localhost', 'AzureDiamond', 'hunter2', 'sweng');
if ($conn->connect_error)
{
    die('Connection failed: ' . $conn->connected_error);
}

$check_access_query = "SELECT allowed FROM user WHERE id = \"$id\"";
$result = $conn->query($check_access_query);
if ($result->num_rows == 0)
{
    $response = array('result'=>false, 'reason'=>'unknown id');
}
else
{
    $row = $result->fetch_assoc();
    if ($row['allowed'] === '1')
    {
        $response = array('result'=>true, 'reason'=>'authorized id');
    }
    else
    {
        $response = array('result'=>false, 'reason'=>'suspended id');
    }
}

$user_id = $_GET['id'];
$kind = 'ENTRY';
$timestamp = date('Y-m-d H:i:s', $_GET['timestamp']);
$allowed = $response['result'] ? '1' : '0';
$log_query = "INSERT INTO access (user_id, kind, timestamp, allowed) VALUES ('$user_id', '$kind', '$timestamp', $allowed)";
// echo "Query: $log_query" . '<br>';

try {
    $result = $conn->query($log_query);
} catch (mysqli_sql_exception $e) {
    // If logging isn't working, there's not much we can do about that.
}

echo json_encode($response);
http_response_code(200);
