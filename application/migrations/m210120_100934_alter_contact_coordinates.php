<?php

use yii\db\Migration;

/**
 * Class m210120_100934_alter_contact_coordinates
 */
class m210120_100934_alter_contact_coordinates extends Migration
{
    const TABLE = '{{%contacts}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE, 'map_longitude', $this->double());
        $this->alterColumn(self::TABLE, 'map_latitude', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::TABLE, 'map_longitude', $this->float(10));
        $this->alterColumn(self::TABLE, 'map_latitude', $this->float(10));
    }
}
