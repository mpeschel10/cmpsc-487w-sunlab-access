<?php
ini_set('display_errors', 1);
include 'Sweng.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $utc = new DateTimeZone('UTC');
    $_GET['user_id_active'] = array_key_exists('user-id-active', $_GET) && $_GET['user-id-active'] === 'on';
    $_GET['datetime_active'] = array_key_exists('datetime-active', $_GET) && $_GET['datetime-active'] === 'on';
    $_GET['instant_active'] = array_key_exists('instant-active', $_GET) && $_GET['instant-active'] === 'on';
    
    $sql = 'SELECT timestamp, name, user_id, access.kind, access.allowed FROM access LEFT JOIN user ON access.user_id = user.id';
    $paramTypes = '';
    $params = array();
    $predicates = array();

    if ($_GET['user_id_active'])
    {
        $paramTypes .= 's';
        $params[] = $_GET['user-id'];
        $predicates[] = 'access.user_id = ?';
    }

    if ($_GET['datetime_active'])
    {
        if ($_GET['datetime-start'] !== '')
        {
            $paramTypes .= 's';
            $params[] = date('Y-m-d H:i:s', $_GET['datetime-start']);
            $predicates[] = 'timestamp >= ?';
        }
        if ($_GET['datetime-end'] !== '')
        {
            $paramTypes .= 's';
            $params[] = date('Y-m-d H:i:s', $_GET['datetime-end']);
            $predicates[] = 'timestamp <= ?';
        }
    }

    if ($_GET['instant_active'])
    {
        $paramTypes .= 'ss';
        $dayStart = intval($_GET['instant']);
        $dayEnd = $dayStart + 86400;

        $dayStart = date('Y-m-d H:i:s', $dayStart);
        $dayEnd = date('Y-m-d H:i:s', $dayEnd);
        array_push($params, $dayStart, $dayEnd);
        
        $predicates[] = 'timestamp >= ? AND timestamp <= ?';
    }

    if (count($params) > 0)
    {
        $predicatesString = join(' AND ', $predicates);
        $sql = $sql . ' WHERE ' . $predicatesString;
    }

    $conn = Sweng\connect();
    $stmt = $conn->prepare($sql);
    if (count($params) > 0)
        $stmt->bind_param($paramTypes, ...$params);
    
    $stmt->execute();
    $result = $stmt->get_result();
    // $result = $conn->query();
    $conn->close();
    // echo json_encode($result);
    
    $response = array();
    $response[] = array('userId'=>json_encode($_GET));
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $row['allowed'] = $row['allowed'] === 1;
            $row['userId'] = $row['user_id'];
            unset($row['user_id']);
            $row['name'] = $row['name'] ?? null;

            $timestamp = new DateTimeImmutable($row['timestamp'], $utc);
            $row['timestamp'] = $timestamp->getTimestamp();
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
