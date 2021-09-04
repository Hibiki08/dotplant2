<?php

namespace app\modules\import\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class ImportForm extends Model
{
    public $oldPriceOption = 1;
    public $priceOption = 1;
    public $oldPriceCoeff = 1.2;
    public $priceCoeff = 1;
    public $catName;
    public $catId;
    public $parent;

    public function rules()
    {
        return [
            [['oldPriceOption', 'priceOption' , 'oldPriceCoeff' , 'priceCoeff', 'catId'], 'required'],
            [['oldPriceOption', 'priceOption' , 'catId'], 'integer'],
            [[ 'oldPriceCoeff' , 'priceCoeff'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oldPriceOption' => 'Атрибут для старой цены', 
            'priceOption' => 'Атрибут для новой цены' , 
            'oldPriceCoeff' => 'Коэффициент умножения старой цены от указанной выше', 
            'priceCoeff' => 'Коэффициент умножения новой цены  от указанной выше', 
        ];
    }

    public function getOptions() {
        return [
            1 => 'Рекомендованная розничная цена c учетом скидки (RetailPrice)',
            2 => 'Базовая рекомендованная розничная цена (BaseRetailPrice)',
            3 => 'Оптовая цена c учетом скидки (WholePrice)',
            4 => 'Базовая оптовая цена (BaseWholePrice)',

        ];
    }

    public static function getOptionsSets() {
        return [
            1 => 'retailPrice',
            2 => 'baseRetailPrice',
            3 => 'wholePrice',
            4 => 'baseWholePrice',
        ];
    }

}