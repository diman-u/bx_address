<?php

use Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (Loader::getLocal('/vendor/autoload.php')) {
    require(Loader::getLocal('/vendor/autoload.php'));
}

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('', 'AddressOnAfterAdd', 'OnAfterAdd');

/**
 * После добавления элемента HB Address
 * @param \Bitrix\Main\Entity\Event $event
 **/
function OnAfterAdd(\Bitrix\Main\Entity\Event $event) {

    BXClearCache( true, "/");
}