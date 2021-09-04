<?php

use yii\db\Migration;

/**
 * Class m201018_135631_edit_block_links
 */
class m201018_135631_edit_block_links extends Migration
{
    const SLIDER_TABLE = '{{%slider}}';
    const SLIDE_TABLE = '{{%slide}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/info#about-prices'],
            ['image' => '/theme/images/carousels/actions/2.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/info#about-bonuses'],
            ['image' => '/theme/images/carousels/actions/1.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/info#about-cashback'],
            ['image' => '/theme/images/carousels/actions/4.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/info#about-delivery'],
            ['image' => '/theme/images/carousels/actions/5.jpg']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/about-prices'],
            ['image' => '/theme/images/carousels/actions/2.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/about-bonuses'],
            ['image' => '/theme/images/carousels/actions/1.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/about-cashback'],
            ['image' => '/theme/images/carousels/actions/4.jpg']
        );
        $this->update(
            self::SLIDE_TABLE,
            ['link' => '/about-delivery'],
            ['image' => '/theme/images/carousels/actions/5.jpg']
        );
    }
}
