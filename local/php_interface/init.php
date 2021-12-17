<?php

use Bitrix\Main\Loader;
use \Bitrix\Main\Application;

if (Loader::getLocal('/vendor/autoload.php')) {
    require(Loader::getLocal('/vendor/autoload.php'));
}

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('', 'AddressReferenceOnAfterAdd', 'clearAddressReferenceCache');
$eventManager->addEventHandler('', 'AddressReferenceOnAfterUpdate', 'clearAddressReferenceCache');
$eventManager->addEventHandler('', 'AddressReferenceOnAfterDelete', 'clearAddressReferenceCache');

function clearAddressReferenceCache($event)
{
    $event->getEntity()->cleanCache();
}