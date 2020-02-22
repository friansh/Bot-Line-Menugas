<?php
require_once ('../database.php');

if (!session_id()) session_start();

Database::prepare('localhost', 'fikrirpc_friansh', 'a9B8c7D6.hUh?', 'fikrirpc_line_bot');
Database::connect();

$db = new Database();
$result = $db->query("DELETE FROM response WHERE id='" . $_POST['id'] ."'");

if ( $result )
    $_SESSION['flasher'] = [
        'type' => 'success',
        'text' => "Perintah '" . $_POST['command'] . "' <strong>berhasil</strong> dihapus."
    ];
else
    $_SESSION['flasher'] = [
        'type' => 'danger',
        'text' => "Perintah '" . $_POST['command'] . "' <strong>gagal</strong> dihapus."
    ];
?>