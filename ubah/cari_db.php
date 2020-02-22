<?php
require_once('../Library/Database.php');
require_once('../Config/Variables.php');

if (!session_id()) session_start();

Database::prepare(Variables::$db_host,
                    Variables::$db_username,
                    Variables::$db_password,
                    Variables::$db_name);

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

