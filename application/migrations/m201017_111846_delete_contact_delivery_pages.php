<?php

use yii\db\Migration;
use app\modules\page\models\Page;

/**
 * Class m201017_111846_delete_contact_delivery_pages
 */
class m201017_111846_delete_contact_delivery_pages extends Migration
{

    public function safeUp()
    {
        Page::deleteAll(['slug' => ['delivery', 'contacts','payment', ]]);
    }


    public function safeDown()
    {

    }
}
