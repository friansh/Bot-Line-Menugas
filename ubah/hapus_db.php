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