<?php

use yii\db\Migration;

/**
 * Class m201106_194651_add_contact_coordinates
 */
class m201106_194651_add_contact_coordinates extends Migration
{
    const TABLE = '{{%contacts}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'map_longitude', $this->float(10));
        $this->addColumn(self::TABLE, 'map_latitude', $this->float(10));
        $this->addColumn(self::TABLE, 'map_zoom', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'map_longitude');
        $this->dropColumn(self::TABLE, 'map_latitude');
        $this->dropColumn(self::TABLE, 'map_zoom');
    }
}
