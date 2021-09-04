<?php

use yii\db\Migration;

/**
 * Class m201017_120818_update_mainpage_sliades
 */
class m201017_120818_update_mainpage_sliades extends Migration
{
    const SLIDE_TABLE = '{{%slide}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update (self::SLIDE_TABLE, ['link' => '/info#about-prices',], ['link' => '/about-prices',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/info#about-bonuses',], ['link' => '/about-bonuses',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/info#about-cashback',], ['link' => '/about-cashback',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/info#about-delivery',], ['link' => '/about-delivery',]);
        return true;
    }

    public function safeDown() 
    {
        $this->update (self::SLIDE_TABLE, ['link' => '/about-prices',]  , ['link' => '/info#about-prices',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/about-bonuses',] , ['link' => '/info#about-bonuses',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/about-cashback',], ['link' => '/info#about-cashback',]);
        $this->update (self::SLIDE_TABLE, ['link' => '/about-delivery',], ['link' => '/info#about-delivery',]);
        return true;
    }
}
