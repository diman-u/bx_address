<?php

use Bitrix\Main\UI\Extension;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

global $USER;
if (!$USER->IsAuthorized()) { return false; }

Extension::load(
    [
        'ui.buttons',
        'ui.forms',
    ]
);

CUtil::InitJSCore( array('ajax' , 'jquery' , 'popup'));

?>
    <div class="row">
        <div class="col-2  offset-1">
                <a href="#" id="add_address" class="ui-btn ui-btn-primary">Добавить адрес</a>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-1">
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:main.ui.grid',
                '',
                [
                    'GRID_ID' => $arResult['GRID_ID'],
                    'COLUMNS' => $arResult['COLUMNS'],
                    'ROWS' => $arResult['ROWS'],
                    'SHOW_ROW_CHECKBOXES' => false,
                    'NAV_OBJECT' => $arResult['NAV'],
                    'AJAX_MODE' => 'Y',
                    'AJAX_ID' => CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
                    'PAGE_SIZES' => [
                        ['NAME' => "5", 'VALUE' => '5'],
                        ['NAME' => '10', 'VALUE' => '10'],
                        ['NAME' => '20', 'VALUE' => '20']
                    ],
                    'AJAX_OPTION_JUMP' => 'N',
                    'SHOW_CHECK_ALL_CHECKBOXES' => true,
                    'SHOW_ROW_ACTIONS_MENU' => true,
                    'SHOW_GRID_SETTINGS_MENU' => true,
                    'SHOW_NAVIGATION_PANEL' => true,
                    'SHOW_PAGINATION' => true,
                    'SHOW_SELECTED_COUNTER' => true,
                    'SHOW_TOTAL_COUNTER' => true,
                    'SHOW_PAGESIZE' => true,
                    'SHOW_ACTION_PANEL' => true,
                    'ALLOW_COLUMNS_SORT' => true,
                    'ALLOW_COLUMNS_RESIZE' => true,
                    'ALLOW_HORIZONTAL_SCROLL' => true,
                    'ALLOW_SORT' => true,
                    'ALLOW_PIN_HEADER' => true,
                    'AJAX_OPTION_HISTORY' => 'N',
                ]
            );
            ?>
            </div>
        </div>
    </div>
    <div id="ajax-add-answer"></div>
    <div id="ajax-edit-answer"></div>
    <div id="ajax-rm-answer"></div>


<script type="text/javascript">

    BX.ready(function(){

        var addAnswer = new BX.PopupWindow("my_answer", null, {
            content: BX('ajax-add-answer'),
            closeIcon: {right: "20px", top: "10px"},
            titleBar: {content: BX.create("span", {html: '<b>Добавить адрес</b>', 'props': {'className': 'access-title-bar'}})},
            zIndex: 0,
            offsetLeft: 0,
            offsetTop: 0,
            draggable: {restrict: false},
            buttons: [
                new BX.PopupWindowButton({
                    text: "Сохранить",
                    className: "popup-window-button-accept",
                    events: {click: function(){
                            BX.ajax.runComponentAction('app:address.list',
                                'addAddress', {
                                    mode: 'class',
                                    data: {
                                        userID: $('#userID').val(),
                                        address: $('#address').val()
                                    },
                                })
                                .then(function (response) {
                                    location.reload();
                                });
                            this.popupWindow.close();
                        }}
                }),
                new BX.PopupWindowButton({
                    text: "Закрыть",
                    className: "webform-button-link-cancel",
                    events: {click: function(){
                            this.popupWindow.close();
                        }}
                })
            ]
        });

        $('#add_address').click(function(){
            BX.ajax.insertToNode('<?=$templateFolder.'/ajax/add.php';?>', BX('ajax-add-answer'));
            addAnswer.show();
        });


        var editAnswer = new BX.PopupWindow("my_answer_edit", null, {
            content: BX('ajax-edit-answer'),
            closeIcon: {right: "20px", top: "10px"},
            titleBar: {content: BX.create("span", {html: '<b>Редактировать адрес</b>', 'props': {'className': 'access-title-bar'}})},
            zIndex: 0,
            offsetLeft: 0,
            offsetTop: 0,
            draggable: {restrict: false},
            buttons: [
                new BX.PopupWindowButton({
                    text: "Изменить",
                    className: "popup-window-button-accept",
                    events: {click: function(){
                            BX.ajax.runComponentAction('app:address.list',
                                'editAddress', {
                                    mode: 'class',
                                    data: {
                                        id: $('#addrID_edit').val(),
                                        userID: $('#user_edit').val(),
                                        address: $('#address_edit').val(),
                                        active: $('#active_edit').val(),
                                    },
                                })
                                .then(function (response) {
                                    location.reload();
                                });
                            this.popupWindow.close();
                        }}
                }),
                new BX.PopupWindowButton({
                    text: "Закрыть",
                    className: "webform-button-link-cancel",
                    events: {click: function(){
                            this.popupWindow.close();
                        }}
                })
            ]
        });

        $('.edit_address').click(function(){
            BX.ajax.insertToNode('<?=$templateFolder?>' +'/ajax/edit.php?ID=' + $(this).data('addressid'), BX('ajax-edit-answer'));
            editAnswer.show();
        });

        var rmAnswer = new BX.PopupWindow("my_answer_rm", null, {
            content: BX('ajax-rm-answer'),
            closeIcon: {right: "20px", top: "10px"},
            titleBar: {content: BX.create("span", {html: '<b>Удалить адрес</b>', 'props': {'className': 'access-title-bar'}})},
            zIndex: 0,
            offsetLeft: 0,
            offsetTop: 0,
            draggable: {restrict: false},
            buttons: [
                new BX.PopupWindowButton({
                    text: "Удалить",
                    className: "popup-window-button-accept",
                    events: {click: function(){
                            BX.ajax.runComponentAction('app:address.list',
                                'rmAddress', {
                                    mode: 'class',
                                    data: {
                                        id: $('#addrID_edit').val()
                                    },
                                })
                                .then(function (response) {
                                    location.reload();
                                });
                            this.popupWindow.close();
                        }}
                }),
                new BX.PopupWindowButton({
                    text: "Закрыть",
                    className: "webform-button-link-cancel",
                    events: {click: function(){
                            this.popupWindow.close();
                        }}
                })
            ]
        });

        $('.rm_address').click(function(){
            BX.ajax.insertToNode('<?=$templateFolder?>' +'/ajax/remove.php?ID=' + $(this).data('addressid'), BX('ajax-rm-answer'));
            rmAnswer.show();
        });
    });
</script>
