<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => 'Список адресов пользователя',
    'DESCRIPTION' => 'Список адресов пользователя',
    'PATH' => [
        'ID' => 'content',
        'CHILD' => [
            'ID' => 'app',
            'NAME' => 'ADDRESS'
        ]
    ],
    'CACHE_PATH' => 'Y',
    'COMPLEX' => 'N'
];
