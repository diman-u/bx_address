<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context;
use Bitrix\Highloadblock as HL;
global $USER;

$request = Context::getCurrent()->getRequest();

if (CModule::IncludeModule('highloadblock')) {
    $hlblock = HL\HighloadBlockTable::getById(1)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    $data = $entity_data_class::getRow([
        'filter' => ['ID' => $request->get('ID')]
    ]);
}

?>
<div class="row">
    <div class="col-12">
        <form action="" method="post" id="myForm">
            <input type="hidden" id="addrID_edit" value="<?= $request->get('ID') ?>">
            <label for="user_edit" class="form-label">ID пользователя</label>
            <input type="text" id="user_edit" value="<?= $data['UF_USER_ID'] ?>"><br>

            <label for="active_edit" class="form-label">Активен</label>
            <input type="checkbox" id="active_edit" class="form-control" value="<?= $data['UF_ACTIVE'] ?>"><br>

            <label for="address_edit" class="form-label">Ваш адрес</label>
            <input type="text" id="address_edit" class="form-control" value="<?= $data['UF_ADDRESS_USER'] ?>">
        </form>
    </div>
</div>