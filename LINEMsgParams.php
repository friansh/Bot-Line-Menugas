<?php

class LINEMsgParams {
    public static function text ($replyToken, $messageText){
        $param = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $messageText
                ]
            ]
        ];

        return $param;
    }

    public static function pictureAndText ($replyToken, $pictURL, $messageText){
        $param = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'image',
                    'originalContentUrl' => $pictURL,
                    'previewImageUrl' => $pictURL
                ],
                [
                    'type' => 'text',
                    'text' => $messageText
                ]
            ]
        ];

        return $param;
    }
    public static function textAndSticker ($replyToken, $messageText, $packageId, $stickerId){
        $param = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $messageText
                ],
                [
                    'type' => 'sticker',
                    'packageId' => $packageId,
                    'stickerId' => $stickerId
                ]
            ]
        ];

        return $param;
    }

    public static function picture ($replyToken, $pictURL){
        $param = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'image',
                    'originalContentUrl' => $pictURL,
                    'previewImageUrl' => $pictURL
                ]
            ]
        ];
        return $param;
    }

    public static function sticker ($replyToken, $packageId, $stickerId){
        $param = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'sticker',
                    'packageId' => $packageId,
                    'stickerId' => $stickerId
                ]
            ]
        ];
        return $param;
    }
}

