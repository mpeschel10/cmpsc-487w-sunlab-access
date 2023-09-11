<?php
ini_set('display_errors', 1);
include 'Sweng.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $conn = Sweng\connect();

    $id = $_GET['id'] ?? null;
    $sql = $id === null ?
        'SELECT * FROM user LIMIT 10' :
        "SELECT * FROM user  WHERE id = \"$id\"";
    $result = $conn->query($sql);
    $conn->close();
    
    $response = array();
    while ($row = $result->fetch_assoc())
    {
        $row['allowed'] = $row['allowed'] == '1';
        $response[] = $row;
    }

    echo '<pre>';
    echo json_encode($response, JSON_PRETTY_PRINT);
    echo '</pre>';

    http_response_code(200);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!array_key_exists('id', $_POST))
    {
        http_response_code(400);
        die(json_encode('POST requests to user.php endpoint must provide an "id" parameter in body.'));
    }

    $_POST['allowed'] = array_key_exists('allowed', $_POST) && $_POST['allowed'] === 'on';
    $_POST['exist-ok'] = array_key_exists('exist-ok', $_POST) && $_POST['exist-ok'] === 'on';
    
    $id = $_POST['id'];
    $kind = $_POST['kind'];
    $allowed = $_POST['allowed'];
    
    $conn = Sweng\connect();
    $sql = $_POST['exist-ok'] ?
        "INSERT IGNORE INTO user (kind, allowed, id) VALUES (\"$kind\", $allowed, \"$id\")" :
        "INSERT INTO user (kind, allowed, id) VALUES (\"$kind\", $allowed, \"$id\")";
    
    try {
        $conn->query($sql);
        http_response_code(204);
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062 && $e->getSqlState() === "23000") {
            http_response_code(400);
            die(json_encode("User id \"$id\" already exists."));
        } else {
            http_response_code(500);
            throw new Exception(json_encode(array(
                'event'=>'unknown exception', 'getCode'=>$e->getCode(), 'getSqlState'=>$e->getSqlState(), 'getMessage'=>$e->getMessage()
                )),
                $e->getCode(),
                $e
            );
        }
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (!array_key_exists('id', $_GET))
    {
        http_response_code(400);
        die(json_encode('DELETE requests to user.php endpoint must provide an "id" query parameter.'));
    }
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE id = \"$id\"";
    
    $conn = Sweng\connect();
    $result = $conn->query($sql);
    echo json_encode($result);

    http_response_code(200);
} else {
    http_response_code(405);
}
