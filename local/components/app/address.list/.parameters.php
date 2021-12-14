<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "GROUPS" => [
        "ADDRESS"    =>  [
            "NAME"  =>  "Настройка выборки адресов",
            "SORT"  =>  "300",
        ],
    ],
    "PARAMETERS" => [
        "SHOW_ELEMENTS"    =>  [
            "PARENT"    =>  "ADDRESS",
            "NAME"      =>  "Показывать все",
            "TYPE"      =>  "LIST",
            "VALUES"    =>  [
                "Y" =>  "Да",
                "N" =>  "Только активные"
            ],
            "DEFAULT"  =>  "Y",
        ]
    ]
];
