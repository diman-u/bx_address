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
        <input type="hidden" id="addrID_edit" value="<?= $request->get('ID') ?>">
        <h5>Вы действительно хотите удалить адрес <?= $data['UF_ADDRESS_USER'] ?>?</h5>
    </div>
</div>