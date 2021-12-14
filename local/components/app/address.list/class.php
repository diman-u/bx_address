<?php

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;

class AppAddressComponent extends \CBitrixComponent implements Controllerable
{
    const HIGHLOAD_ADDRESS = 1;

    public function executeComponent()
    {
        global $USER;
        $additionalCacheID = SITE_ID."_address";

        // время кеширования
        if (!isset($this->arParams['CACHE_TIME'])) {
            $this->arParams['CACHE_TIME'] = 3600;
        } else {
            $this->arParams['CACHE_TIME'] = intval($this->arParams['CACHE_TIME']);
        }

        if ($this->StartResultCache($this->arParams['CACHE_TIME'], $additionalCacheID, '/')) {

            if (CModule::IncludeModule('highloadblock')) {
                $data = [];
                $hlblock = HL\HighloadBlockTable::getById(self::HIGHLOAD_ADDRESS)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $filter = ['UF_USER_ID' => $USER->GetID()];

                if ($this->arParams['SHOW_ELEMENTS'] == 'N') {
                    $filter['UF_ACTIVE'] = 1;
                }

                $query = $entity_data_class::getList([
                    'filter' => $filter,
                    'cache' => [
                        'ttl' => 3600,
                        'cache_joins' => true,
                    ]
                ]);

                foreach ($query->fetchAll() as $item) {

                    $data[] = [
                        $item['UF_ACTIVE'] = ($item['UF_ACTIVE']) ? 'Да' : 'Нет',
                        'data' => $item
                    ];
                }
            }

            $this->SetResultCacheKeys(
                ['UF_USER_ID', 'UF_ACTIVE', 'UF_ADDRESS_USER']
            );
            $this->EndResultCache();


        } else {
            $this->AbortResultCache();
        }

        $this->arResult['GRID_ID'] = 'Address';
        $this->arResult['COLUMNS'] = [
            ['id' => 'UF_USER_ID', 'name' => 'Пользователь ID', 'sort' => 'UF_USER_ID', 'default' => true],
            ['id' => 'UF_ACTIVE', 'sort' => 'UF_ACTIVE', 'name' => 'Активность', 'default' => true],
            ['id' => 'UF_ADDRESS_USER', 'sort' => 'UF_ADDRESS_USER', 'name' => 'Адрес пользователя', 'default' => true],
            ['id' => 'actions', 'name' => 'Действия'],
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
}