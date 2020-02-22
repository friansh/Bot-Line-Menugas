<?php

require('load.php');

$client = new LINEBotTiny(Variables::$channelAccessToken,
                            Variables::$channelSecret);
$db = new Database();

Database::prepare(Variables::$db_host,
                    Variables::$db_username,
                    Variables::$db_password,
                    Variables::$db_name);

Database::connect();

foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $usrr = $db->query("SELECT * FROM users WHERE userid ='" . $event['source']['userId'] . "';");
            if ( $usrr != null ){
                $message = $event['message'];
                switch ($message['type']) {
                    case 'text':
                        $message['text'] = strtolower(trim($message['text']));

                        $msgSrc = '';

                        if ( isset($event['source']['groupId'] ) ) $msgSrc = $event['source']['groupId'];
                        elseif ( isset($event['source']['roomId'] ) ) $msgSrc = $event['source']['roomId'];
                        elseif ( isset($event['source']['userId']) ) $msgSrc = $event['source']['userId'];

                        $cmd = explode(' tolong ', $message['text']);

                        if ( $cmd[0] == 'bot,') {
                            if ( count($cmd) == 2 ) {
                                $spec = explode(' ', $cmd[1]);
                                if ( count($spec) >= 2 ){
                                    switch ($spec[0] . ' tugas'){
                                        case 'tambahin tugas':
                                            unset ($spec[0]);
                                            $spec = implode(' ', $spec);
                                            $spec = trim($spec);
                                            $db->query("INSERT INTO `tugas`(`id`, `deskripsi`, `source`) VALUES (null, '" . $spec . "', '" . $msgSrc . "');");
                                            $text = 'tugas "' . $spec . '" sudah ditambah :)';
                                            $params = LINEMsgParams::text($event['replyToken'], $text);
                                            break;

                                        case 'hapusin tugas':
                                            unset ($spec[0]);
                                            $spec = implode(' ', $spec);
                                            $spec = trim($spec);
                                            $db->query("DELETE FROM `tugas` WHERE deskripsi='" . $spec . "'");
                                            $text = 'tugas "' . $spec . '" sudah dihapus :)';
                                            $params = LINEMsgParams::text($event['replyToken'], $text);
                                            break;

                                    }
                                }
                            }
                        } else {
                            switch ( $message['text'] ) {
                                case 'ada tugas apa aja?':
                                    $result = $db->query("SELECT deskripsi FROM tugas WHERE source='" . $msgSrc . "';", true);
                                    if ( $result != null ) {
                                        $count = 1;
                                        $text = "tugasnya segini aja kaka: \n";
                                        foreach ($result as $row) {
                                            $text .= "\n" . $count . '. ' . $row['deskripsi'];
                                            $count++;
                                        }
                                        $params = LINEMsgParams::text($event['replyToken'], $text);
                                    } else
                                        $params = LINEMsgParams::text($event['replyToken'], 'yee gaada tugazzzz!!!');
                                    break;

                                case 'dadah bot, makasi yaa':
                                    if ( isset( $event['source']['groupId'] ) ) {
                                        $params = LINEMsgParams::text($event['replyToken'], "sama sama kaka:) sedih harus keluar :'(");
                                        $client->replyMessage($params);
                                        lineLeftGrup($event['source']['groupId']);
                                        exit();
                                    } else
                                        $params = LINEMsgParams::text($event['replyToken'], 'gabisaa left huhu bukan grup');
                                    break;
                                case 'apa useridku?':
                                    $params = LINEMsgParams::text($event['replyToken'], $event['source']['userId'] . "\n" . lineSiapaAkun($event['source']['userId'])['displayName'] . "\n" . lineSiapaAkun($event['source']['userId'])['pictureUrl'] );
                                    break;

                                case 'kamu bisa jawab apa aja bot?':
                                    $result = $db->query("SELECT command FROM response", true);
                                    $count = 1;
                                    $teks = "Aku bisa jawab pertanyaan di bawah inii: \n\n[perintah yang hardcoded]\n1. ada tugas apa aja?\n2. bot, tolong tambahin tugas {nama tugas}\n3. bot, tolong hapusin tugas {nama tugas}\n4. dadah bot, makasi yaa\n5. apa useridku?\n6. kamu bisa jawab apa aja bot?\n7. siapa aku?\n\n[perintah yang ada di database]\n";
                                    foreach ( $result as $row ) {
                                        $teks .= $count . '. ' . $row['command'] . "\n";
                                        $count++;
                                    }
                                    $teks .= "\nkalau mau request pc fikri aja ya hehe:)";

                                    $params = LINEMsgParams::text($event['replyToken'], $teks);
                                    break;

                                case 'siapa aku??':
                                    $userpret = $db->query("SELECT displayname, pictureurl FROM users WHERE userid='" . $event['source']['userId'] . "'");
                                    $params = LINEMsgParams::pictureAndText($event['replyToken'], $userpret['pictureurl'],'kamu ' .  $userpret['displayname'] . "\n\nmasa lupa:)");
                                    break;

                                case 'bot minta group id!':
                                    $params = LINEMsgParams::text($event['replyToken'], $event['source']['groupId']);
                                    break;

                                default:
                                    $result = $db->query("SELECT * FROM response WHERE command='" . $message['text'] . "';");
                                    if ( $result != null ) {
                                        switch ( $result['response_type'] ){
                                            case 'text':
                                                $params = LINEMsgParams::text($event['replyToken'], $result['response_text']);
                                                break;

                                            case 'image':
                                                $params = LINEMsgParams::picture($event['replyToken'], $result['response_imgurl']);
                                                break;

                                            case 'sticker':
                                                $params = LINEMsgParams::sticker($event['replyToken'], $result['response_sticker_package'], $result['response_sticker_id']);
                                                break;

                                            case 'textsticker':
                                                $params = LINEMsgParams::textAndSticker($event['replyToken'], $result['response_text'], $result['response_sticker_package'], $result['response_sticker_id']);
                                                break;

                                            case 'imagetext':
                                                $params = LINEMsgParams::pictureAndText($event['replyToken'], $result['response_imgurl'], $result['response_text']);
                                                break;

                                            default:
                                                $params = LINEMsgParams::text($event['replyToken'], 'format salah, cek lagi di databasenya yaw;)');
                                                break;
                                        }
                                        break;

                                    }
                            }

                        }
                    }
                    if ( isset($params ) )
                        $client->replyMessage($params);
                    break;
                    // default:
                    //     $params = LINEMsgParams::textAndSticker($event['replyToken'], 'aq cm bisa baca teks huhuhuh', '11537', '52002753');
                    //     $client->replyMessage($params);
                    //     break;
                }
            break;

        case 'join':
            $db->query("INSERT INTO `groups`(`id`, `groupid`) VALUES ( null, '" . $event['source']['groupId'] . "');");
            $params = LINEMsgParams::text($event['replyToken'], 'salam kenal yaa semua ;)');
            $client->replyMessage($params);
            break;

        case 'left':
            $db->query("DELETE FROM `groups` WHERE groupid='" . $event['source']['groupId'] . "'");
            break;

        case 'follow':
            $db->query("INSERT INTO `users`(`id`, `userid`, `displayname`, `pictureUrl`) VALUES ( null, '" . $event['source']['userId'] . "', '" . lineSiapaAkun($event['source']['userId'])['displayName'] . "', '" . lineSiapaAkun($event['source']['userId'])['pictureUrl']  . "');");
            break;

        case 'unfollow':
            $db->query("DELETE FROM `users` WHERE userid='" . $event['source']['userId'] . "'");
            break;
    }
};

function lineLeftGrup($groupId){
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.line.me/v2/bot/group/" . $groupId ."/leave",
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer 5Thtncw74BKlpqvIlrtex+DVAmqNiCUIXcVntT0rUhLUS/+SAC5vJP+FnpaJ/LKYckQf5E2mZ+CCU6Z12o3rnaNiMFvmW/GAPEyILJ097tnLeV1JY1DFNDuwi3jFxDvxfd8Ea8KDMaas4zsvHQAcvAdB04t89/1O/w1cDnyilFU=',
        ]
    ]);

    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    return (array)$output;
}

function lineSiapaAkun($userId){
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.line.me/v2/bot/profile/" . $userId,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer 5Thtncw74BKlpqvIlrtex+DVAmqNiCUIXcVntT0rUhLUS/+SAC5vJP+FnpaJ/LKYckQf5E2mZ+CCU6Z12o3rnaNiMFvmW/GAPEyILJ097tnLeV1JY1DFNDuwi3jFxDvxfd8Ea8KDMaas4zsvHQAcvAdB04t89/1O/w1cDnyilFU=',
        ]
    ]);

    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    return (array)$output;
}

