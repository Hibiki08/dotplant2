<?php

use yii\db\Migration;

/**
 * Class m201129_135154_alter_product_table
 */
class m201129_135154_alter_product_table extends Migration
{
    CONST TABLE = '{{%product}}';

    public function safeUp()
    {
        $this->dropColumn(self::TABLE, 'notBox');
        $this->dropColumn(self::TABLE, 'notWeight');

        $this->addColumn(self::TABLE, 'brutto_length', $this->decimal());
        $this->addColumn(self::TABLE, 'brutto_width',  $this->decimal());
        $this->addColumn(self::TABLE, 'brutto_height', $this->decimal());
        $this->addColumn(self::TABLE, 'brutto', $this->decimal());
    }


    public function safeDown() {
        $this->addColumn(self::TABLE, 'notBox', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE, 'notWeight', $this->integer(1)->notNull()->defaultValue(0));
        
        $this->createIndex('indx_product_notbox', self::TABLE, ['notBox']);
        $this->createIndex('indx_product_notweight', self::TABLE, ['notWeight']);

        $this->dropColumn(self::TABLE, 'brutto_length');
        $this->dropColumn(self::TABLE, 'brutto_width');
        $this->dropColumn(self::TABLE, 'brutto_height');
        $this->dropColumn(self::TABLE, 'brutto');
    }
}
