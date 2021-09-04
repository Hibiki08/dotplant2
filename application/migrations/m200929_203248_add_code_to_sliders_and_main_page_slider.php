<?php

use yii\db\Migration;

/**
 * Class m200929_203248_add_code_to_sliders_and_main_page_slider
 */
class m200929_203248_add_code_to_sliders_and_main_page_slider extends Migration
{
    const SLIDER_TABLE = '{{%slider}}';
    const SLIDE_TABLE = '{{%slide}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::SLIDER_TABLE, 'code', $this->string(50)->defaultValue(''));

        $this->insert(self::SLIDER_TABLE, [
            'name' => 'Карусель акций на главной',
            'code' => 'mp_action_slider',
            'slider_handler_id' => '1',
            'resize_big_images' => '0',
            'params' => '{"interval":"5000"}',
        ]);

        $slider = (new \yii\db\Query())
            ->select(['id'])
            ->from(self::SLIDER_TABLE)
            ->where(['code' => 'mp_action_slider'])
            ->one();

        if (is_null($slider) || empty($slider['id'])) {
            \yii\helpers\Console::output('Not found slider mp_action_slider');

            return false;
        }

        $this->insert(self::SLIDE_TABLE, [
            'slider_id' => (int)$slider['id'],
            'sort_order' => 0,
            'image' => '/theme/images/carousels/actions/2.jpg',
            'link' => '/about-prices',
            'css_class' => 'fas fa-dollar-sign',
            'active' => 1,
            'text' => '<h2>Гарантия низкой цены</h2><span>для всех новых клиентов с 20 ноября до 31 декабря</span>',
        ]);

        $this->insert(self::SLIDE_TABLE, [
            'slider_id' => (int)$slider['id'],
            'sort_order' => 1,
            'image' => '/theme/images/carousels/actions/1.jpg',
            'link' => '/about-bonuses',
            'css_class' => 'fab fa-hotjar red',
            'active' => 1,
            'text' => '<h2>Бонусная программа</h2><span>для всех постоянных клиентов</span>',
        ]);

        $this->insert(self::SLIDE_TABLE, [
            'slider_id' => (int)$slider['id'],
            'sort_order' => 2,
            'image' => '/theme/images/carousels/actions/4.jpg',
            'link' => '/about-cashback',
            'css_class' => 'fas fa-percentage',
            'active' => 1,
            'text' => '<span>20% кэшбэк</span>',
        ]);

        $this->insert(self::SLIDE_TABLE, [
            'slider_id' => (int)$slider['id'],
            'sort_order' => 3,
            'image' => '/theme/images/carousels/actions/5.jpg',
            'link' => '/about-delivery',
            'css_class' => 'fas fa-truck yellow',
            'active' => 1,
            'text' => '<h2>Быстрая и бережная доставка</h2>',
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $slider = (new \yii\db\Query())
            ->select(['id'])
            ->from(self::SLIDER_TABLE)
            ->where(['code' => 'mp_action_slider'])
            ->one();

        if (is_null($slider) || empty($slider['id'])) {
            \yii\helpers\Console::output('Not found slider mp_action_slider');

            return false;
        }

        $this->dropColumn(self::SLIDER_TABLE, 'code');
        $this->delete(self::SLIDE_TABLE, ['slider_id' => (int)$slider['id']]);
        $this->delete(self::SLIDER_TABLE, ['id' => (int)$slider['id']]);

    }
}
