<?php
require_once ('../database.php');

if (!session_id()) session_start();

Database::prepare('localhost', 'fikrirpc_friansh', 'a9B8c7D6.hUh?', 'fikrirpc_line_bot');
Database::connect();

$db = new Database();

$id = '';
if ( isset($_POST['id']) ) {
    global $id;
    $id = $_POST['id'];
}else {
    echo json_encode(null);
    exit();
}

$result = $db->query("SELECT * FROM response WHERE id='" . $id . "'");

echo json_encode($result);

