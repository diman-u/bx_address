<?php

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;

class AppAddressComponent extends \CBitrixComponent implements Controllerable
{
    const HIGHLOAD_ADDRESS = 1;

    public function executeComponent()
    {
        global $USER;
        $cache = Cache::createInstance();
        $taggedCache = Application::getInstance()->getTaggedCache();
        $cache = Cache::createInstance();
        $taggedCache = Application::getInstance()->getTaggedCache();

        $cachePath = 'address';
        $cacheTtl = $this->arParams['SHOW_ELEMENTS'] ? (int)$this->arParams['SHOW_ELEMENTS'] : 3600;
        $cacheKey = SITE . '__address';

        if ($cache->initCache($cacheTtl, $cacheKey, $cachePath)) {
            $data = $cache->getVars();
        } elseif ($cache->startDataCache()) {

            $taggedCache->startTagCache($cachePath);
            if (CModule::IncludeModule('highloadblock')) {
                $hlblock = HL\HighloadBlockTable::getById(self::HIGHLOAD_ADDRESS)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $filter = ['UF_USER_ID' => $USER->GetID()];

                if ($this->arParams['SHOW_ELEMENTS'] == 'N') {
                    $filter['UF_ACTIVE'] = 1;
                }

                $query = $entity_data_class::getList([
                    'filter' => $filter,
                    'select' => ['*']
                ]);

                foreach ($query->fetchAll() as $item) {

                    $item['UF_ACTIVE'] = ($item['UF_ACTIVE']) ? 'Да' : 'Нет';
                    $item['ACTIONS'] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square edit_address" viewBox="0 0 16 16" data-addressid="'.$item['ID'].'">
                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash rm_address" viewBox="0 0 16 16" data-addressid="'.$item['ID'].'">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>';

                    $data[] = [
                        'data' => $item
                    ];
                }
            }

            $taggedCache->registerTag('hlblock_address');

            $cacheInvalid = false;
            if ($cacheInvalid) {
                $taggedCache->abortTagCache();
                $cache->abortDataCache();
            }

            $taggedCache->endTagCache();
            $cache->endDataCache($data);
        }

        $this->arResult['GRID_ID'] = 'Address';
        $this->arResult['COLUMNS'] = [
            ['id' => 'UF_USER_ID', 'name' => 'Пользователь ID', 'sort' => 'UF_USER_ID', 'default' => true],
            ['id' => 'UF_ACTIVE', 'sort' => 'UF_ACTIVE', 'name' => 'Активность', 'default' => true],
            ['id' => 'UF_ADDRESS_USER', 'sort' => 'UF_ADDRESS_USER', 'name' => 'Адрес пользователя', 'default' => true],
            ['id' => 'ACTIONS', 'name' => 'Действия', 'default' => true],
        ];

        $this->arResult['ROWS'] = $data;

        $this->includeComponentTemplate();
    }

    public function configureActions()
    {
        return [
            'addAddress' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                    new ActionFilter\HttpMethod(['POST']),
                    new ActionFilter\Authentication(),
                ],
            ],
            'editAddress' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                    new ActionFilter\HttpMethod(['POST']),
                    new ActionFilter\Authentication(),
                ],
            ],
            'rmAddress' => [
                'prefilters' => [
                    new ActionFilter\Csrf(),
                    new ActionFilter\HttpMethod(['POST']),
                    new ActionFilter\Authentication(),
                ],
            ]
        ];
    }

    public function addAddressAction($userID, $address)
    {
        if(empty($userID) && empty($address)) { return false;}

        if (CModule::IncludeModule('highloadblock')) {
            $hlblock = HL\HighloadBlockTable::getById(self::HIGHLOAD_ADDRESS)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $entity_data_class::add([
                'UF_USER_ID' => $userID,
                'UF_ACTIVE' => ['Y'],
                'UF_ADDRESS_USER' => $address
            ]);

            return ['success' => 'success'];
        }
    }

    public function editAddressAction($id, $userID, $address, $active)
    {
        if(empty($id) && empty($userID) && empty($address)) { return false;}

        if (CModule::IncludeModule('highloadblock')) {
            $hlblock = HL\HighloadBlockTable::getById(self::HIGHLOAD_ADDRESS)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $entity_data_class::update($id, [
                'UF_USER_ID' => $userID,
                'UF_ACTIVE' => $active ? ['Y'] : ['N'],
                'UF_ADDRESS_USER' => $address
            ]);

            return ['success' => 'success'];
        }
    }

    public function rmAddressAction($id)
    {
        if (empty($id)) { return false;}

        if (CModule::IncludeModule('highloadblock')) {
            $hlblock = HL\HighloadBlockTable::getById(self::HIGHLOAD_ADDRESS)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $entity_data_class::delete($id);

            return ['success' => 'success'];
        }
    }
}