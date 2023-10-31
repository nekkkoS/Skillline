// modules/my_module/lib/slpasswordtable.php
<?php
use Bitrix\Main\Entity;
use Bitrix\Main\UserTable;

class SlPasswordTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'sl_password';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true,
            )),
            new Entity\StringField('NAME'),
            new Entity\StringField('PASSWORD'),
            new Entity\IntegerField('CATEGORY_ID'),
            new Entity\ReferenceField(
                'OWNER',
                UserTable::class,
                array('=this.OWNER_ID' => 'ref.ID')
            ),
            new Entity\DatetimeField('CREATED_AT'),
        );
    }
}
