<?php
require_once ('../database.php');

if (!session_id()) session_start();

Database::prepare('localhost', 'fikrirpc_friansh', 'a9B8c7D6.hUh?', 'fikrirpc_line_bot');
Database::connect();

$db = new Database();

$result = $db->query("UPDATE response SET command='" . $_POST['command'] . "', response_type='" . $_POST['response_type'] . "', response_text='" . $_POST['response_text'] . "', response_imgurl='" . $_POST['response_imgurl'] . "' WHERE id='" . $_POST['id'] ."'");

if ( $result ) {
    echo json_encode("ok");
    $_SESSION['flasher'] = [
      'type' => 'success',
      'text' => "Perintah '" . $_POST['command'] . "' <strong>berhasil</strong> disunting."
    ];
}else {
    echo json_encode("gagal");
    $_SESSION['flasher'] = [
        'type' => 'danger',
        'text' => "Perintah '" . $_POST['command'] . "' <strong>gagal</strong> disunting."
    ];
}