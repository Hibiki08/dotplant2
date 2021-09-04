<?php

namespace app\models;

use Yii;
use app\modules\seotext\models\SeoCityVarItem;
use app\modules\seotext\models\SeoAboutCityText;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $parental_case
 * @property integer $sort_order
 * @property string $slug
 * @property integer $country_id
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort_order', 'country_id', 'cdek_code'], 'integer'],
            [['country_id'], 'required'],
            [['name', 'slug', 'parental_case'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'slug' => Yii::t('app', 'Slug'),
            'country_id' => Yii::t('app', 'Country ID'),
            'parental_case' => Yii::t('app', 'Parental case'),
        ];
    }

    public function getSeoVars() {
        return $this->hasMany(SeoCityVarItem::className(), ['city_id' => 'id']);
    }
    
    public function getSeoVarsCount() {
        return $this->getSeoVars()->count();
    }

    public function getAboutCitySeoText() {
        return $this->hasOne(SeoAboutCityText::className(), ['city_id' => 'id']);
    }
}
