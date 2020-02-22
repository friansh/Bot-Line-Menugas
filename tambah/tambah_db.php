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


if ( !empty($_POST['command']) and !empty($_POST['radio']) ) {
    if ( $_POST['radio'] == 'text' and !empty($_POST['jawabanteks']) ) {
        if ( insertRow($_POST['command'], $_POST['radio'], $_POST['jawabanteks'], null) )
            $_SESSION['flasher'] = [
                'type' => 'success',
                'text' => 'Perintah ' . $_POST['command'] . ' berhasil ditambah.'
            ];
        else
            $_SESSION['flasher'] = [
                'type' => 'danger',
                'text' => 'Galat database atau perintah sudah ada.'
            ];

    }elseif ( $_POST['radio'] == 'text' and empty($_POST['jawabanteks']) )
        $_SESSION['flasher'] = [
            'type' => 'danger',
            'text' => 'Isi kolom perintah dan teks.'
        ];

    if ( $_POST['radio'] == 'image' and !empty($_POST['linkgambar']) ) {
        if ( insertRow($_POST['command'], $_POST['radio'], null, $_POST['linkgambar']) )
            $_SESSION['flasher'] = [
                'type' => 'success',
                'text' => 'Perintah ' . $_POST['command'] . ' berhasil ditambah.'
            ];
        else
            $_SESSION['flasher'] = [
                'type' => 'danger',
                'text' => 'Galat database atau perintah sudah ada.'
            ];

    }elseif ( $_POST['radio'] == 'image' and empty($_POST['linkgambar']) )
        $_SESSION['flasher'] = [
            'type' => 'danger',
            'text' => 'Isi kolom perintah dan link gambar.'
        ];

    if ( $_POST['radio'] == 'imagetext' and !empty($_POST['jawabanteks']) and !empty($_POST['linkgambar'])) {
        if ( insertRow($_POST['command'], $_POST['radio'], $_POST['jawabanteks'], $_POST['linkgambar']) )
            $_SESSION['flasher'] = [
                'type' => 'success',
                'text' => 'Perintah ' . $_POST['command'] . ' berhasil ditambah.'
            ];
        else
            $_SESSION['flasher'] = [
                'type' => 'danger',
                'text' => 'Galat database atau perintah sudah ada.'
            ];

    }elseif ( $_POST['radio'] == 'imagetext' and ( empty($_POST['jawabanteks']) or empty($_POST['linkgambar']) ))
        $_SESSION['flasher'] = [
            'type' => 'danger',
            'text' => 'Isi kolom perintah, teks, dan link gambar.'
        ];
}else
    $_SESSION['flasher'] = [
        'type' => 'danger',
        'text' => 'Isi kolom perintah.'
    ];

header('Location: index.php');

function insertRow ($command, $response_type, $response_text, $response_imageurl){
    $stmt = "INSERT INTO `response`(`id`, `command`, `response_type`, `response_text`, `response_imgurl`, `response_sticker_package`, `response_sticker_id`)";
    $stmt .= " VALUES ( null, '$command', '$response_type', '$response_text', '$response_imageurl', '', '' )";

    global $db;
    $res = $db->query("SELECT * FROM response WHERE command='$command'");

    if ( $res == null )
        return $db->query($stmt);
    else
        return false;

}


