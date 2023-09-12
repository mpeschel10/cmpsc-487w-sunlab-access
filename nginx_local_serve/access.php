<?php
ini_set('display_errors', 1);
include 'Sweng.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $conn = Sweng\connect();

    $result = $conn->query('SELECT * FROM access');
    $conn->close();
    
    $response = array();
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $row['id'] = intval($row['id']);
            $row['allowed'] = $row === '1';
            $row['userId'] = $row['user_id'];
            unset($row['user_id']);
            $response[] = $row;
        }
    }

    echo json_encode($response, JSON_PRETTY_PRINT);
    http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!array_key_exists('id', $_POST))
    {
        http_response_code(400);
        die(json_encode('POST requests to access.php must include an "id" parameter in body.'));
    }
    if (!array_key_exists('timestamp', $_POST))
    {
        http_response_code(400);
        die(json_encode('POST requests to access.php must include a "timestamp" parameter in body.'));
    }
    if (!array_key_exists('kind', $_POST))
    {
        http_response_code(400);
        die(json_encode('POST requests to access.php must include a "kind" parameter in body.'));
    }

    $id = $_POST['id'];
    $timestamp = date('Y-m-d\\TH:i:s', intval($_POST['timestamp']));
    $kind = $_POST['kind'];

    $sql = "SELECT name, allowed FROM user WHERE id = \"$id\"";
    // echo "SQL search: " . $sql . "<br>\n";
    $conn = Sweng\connect();
    $result = $conn->query($sql);

    if ($result->num_rows === 0)
    {
        $name = null;
        $allowed = "0";
        $reason = 'unknown id';
    } else {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $allowed = $row['allowed'];
        $reason = $allowed ? 'known id' : 'suspended id';
    }

    $sql = "INSERT INTO access (user_id, kind, timestamp, allowed) VALUES (\"$id\", \"$kind\", \"$timestamp\", $allowed)";
    // echo "SQL insert: " . $sql . "<br>\n";
    $conn->query($sql);

    $allowed = $allowed === '1';
    $result = array('name'=>$name, 'allowed'=>$allowed, 'reason'=>$reason);

    echo json_encode($result);
    http_response_code(200);
} else {
    http_response_code(405);
}
