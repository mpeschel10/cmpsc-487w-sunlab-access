<?php
ini_set('display_errors', 1);
include 'Sweng.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $conn = Sweng\connect();

    $id = $_GET['id'] ?? null;
    $sql = $id === null ?
        'SELECT * FROM user' :
        "SELECT * FROM user  WHERE id = \"$id\"";
    $result = $conn->query($sql);
    $conn->close();
    
    $response = array();
    while ($row = $result->fetch_assoc())
    {
        $row['allowed'] = $row['allowed'] == '1';
        $response[] = $row;
    }

    echo json_encode($response, JSON_PRETTY_PRINT);

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
    $name = $_POST['name'];
    $allowed = $_POST['allowed'] ? "1" : "0";

    $operation = $_POST['exist-ok'] ? 'REPLACE' : 'INSERT';
    
    $conn = Sweng\connect();
    $sql = "$operation INTO user (kind, allowed, id, name) VALUES (\"$kind\", $allowed, \"$id\", \"$name\")";
    
    try {
        $conn->query($sql);
        http_response_code(204);
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062 && $e->getSqlState() === "23000") {
            http_response_code(400);
            die(json_encode("User id \"$id\" already exists."));
        } else {
            http_response_code(500);
            throw new Exception('event: unknown exception o_o getCode: '. $e->getCode() .
                ' o_o getSqlState: ' . $e->getSqlState() . ' o_o getMessage: ' . $e->getMessage() .
                ' o_o sql: ' . $sql
                ,
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

    http_response_code(204);
} else {
    http_response_code(405);
}
