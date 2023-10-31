// modules/my_module/lib/slpasswordcategoriestable.php
<?php
use Bitrix\Main\Entity;

class SlPasswordCategoriesTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'sl_password_categories';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
            )),
            new Entity\StringField('NAME'),
        );
    }
}
