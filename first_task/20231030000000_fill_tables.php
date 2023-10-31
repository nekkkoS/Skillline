<?php
use Bitrix\Main\Application;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use my_module\SlPasswordCategoriesTable;
use my_module\SlPasswordTable;

class FillPasswordTables2023Migrate extends CDbMigration
{
    public function up()
    {
        $connection = Application::getConnection();
        $connection->startTransaction();

        try {
            if (Loader::includeModule("my_module")) {
                $categories = array(
                    array('NAME' => 'Категория 1'),
                    array('NAME' => 'Категория 2'),
                );

                foreach ($categories as $categoryData) {
                    $categoryResult = SlPasswordCategoriesTable::add($categoryData);
                    if (!$categoryResult->isSuccess()) {
                        throw new Exception('Ошибка при добавлении категории: ' . implode(', ', $categoryResult->getErrorMessages()));
                    }
                }

                $passwords = array(
                    array('NAME' => 'Пароль 1', 'PASSWORD' => 'hash1', 'CATEGORY_ID' => 1, 'OWNER_ID' => 1, 'CREATED_AT' => new Bitrix\Main\Type\DateTime()),
                    array('NAME' => 'Пароль 2', 'PASSWORD' => 'hash2', 'CATEGORY_ID' => 2, 'OWNER_ID' => 2, 'CREATED_AT' => new Bitrix\Main\Type\DateTime()),
                );

                foreach ($passwords as $passwordData) {
                    $passwordResult = SlPasswordTable::add($passwordData);
                    if (!$passwordResult->isSuccess()) {
                        throw new Exception('Ошибка при добавлении пароля: ' . implode(', ', $passwordResult->getErrorMessages()));
                    }
                }

                $connection->commitTransaction();
            }
        } catch (Exception $e) {
            $connection->rollbackTransaction();
            throw new \Exception($e->getMessage());
        }
    }

    public function down()
    {
        
    }
}
