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