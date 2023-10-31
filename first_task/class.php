<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use my_module\SlPasswordTable;
use my_module\SlPasswordCategoriesTable;

class MyComponentName extends CBitrixComponent
{
    public function executeComponent()
    {
        if (Loader::includeModule("my_module")) {
            $categories = SlPasswordCategoriesTable::getList(array(
                'select' => array('ID', 'NAME'),
            ))->fetchAll();

            $passwords = SlPasswordTable::getList(array(
                'select' => array('ID', 'NAME', 'PASSWORD', 'CREATED_AT'),
            ))->fetchAll();

            $this->arResult = array(
                'CATEGORIES' => $categories,
                'PASSWORDS' => $passwords,
            );

            $this->includeComponentTemplate();
        }
    }
}
