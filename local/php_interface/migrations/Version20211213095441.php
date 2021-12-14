<?php

namespace Sprint\Migration;


class Version20211213095441 extends Version
{
    protected $description = "HB Адреса";

    protected $moduleVersion = "3.30.1";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $hlblockId = $helper->Hlblock()->saveHlblock(array(
            'NAME' => 'Address',
            'TABLE_NAME' => 'address',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Адреса',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Address',
                        ),
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_USER_ID',
            'USER_TYPE_ID' => 'integer',
            'XML_ID' => '',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SIZE' => 20,
                    'MIN_VALUE' => 0,
                    'MAX_VALUE' => 0,
                    'DEFAULT_VALUE' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'user id',
                    'ru' => 'ИД пользователя',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'user id',
                    'ru' => 'ИД пользователя',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'user id',
                    'ru' => 'ИД пользователя',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_ACTIVE',
            'USER_TYPE_ID' => 'boolean',
            'XML_ID' => '',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'DEFAULT_VALUE' => 1,
                    'DISPLAY' => 'CHECKBOX',
                    'LABEL' =>
                        array(
                            0 => '',
                            1 => '',
                        ),
                    'LABEL_CHECKBOX' => '',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'Active',
                    'ru' => 'Активность',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'Active',
                    'ru' => 'Активность',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'Active',
                    'ru' => 'Активность',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
        ));
        $helper->Hlblock()->saveField($hlblockId, array(
            'FIELD_NAME' => 'UF_ADDRESS_USER',
            'USER_TYPE_ID' => 'address',
            'XML_ID' => '',
            'SORT' => '100',
            'MULTIPLE' => 'N',
            'MANDATORY' => 'N',
            'SHOW_FILTER' => 'N',
            'SHOW_IN_LIST' => 'Y',
            'EDIT_IN_LIST' => 'Y',
            'IS_SEARCHABLE' => 'N',
            'SETTINGS' =>
                array(
                    'SHOW_MAP' => 'Y',
                ),
            'EDIT_FORM_LABEL' =>
                array(
                    'en' => 'address user',
                    'ru' => 'Адрес пользователя',
                ),
            'LIST_COLUMN_LABEL' =>
                array(
                    'en' => 'address user',
                    'ru' => 'Адрес пользователя',
                ),
            'LIST_FILTER_LABEL' =>
                array(
                    'en' => 'address user',
                    'ru' => 'Адрес пользователя',
                ),
            'ERROR_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
            'HELP_MESSAGE' =>
                array(
                    'en' => '',
                    'ru' => '',
                ),
        ));
    }

    public function down()
    {
        //your code ...
    }
}
