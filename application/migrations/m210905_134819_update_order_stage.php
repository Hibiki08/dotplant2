<?php

use yii\db\Migration;

/**
 * Class m210905_134819_update_order_stage
 */
class m210905_134819_update_order_stage extends Migration
{
    const TABLE = '{{%order_stage}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(self::TABLE, [
            'is_in_cart' => 1
        ], [
            'event_name' => 'order_stage_payment_pay'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(self::TABLE, [
            'is_in_cart' => 0
        ], [
            'event_name' => 'order_stage_payment_pay'
        ]);
    }
}
