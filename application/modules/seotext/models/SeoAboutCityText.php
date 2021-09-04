<?php

namespace app\modules\seotext\models;

use yii\db\ActiveRecord;
use app\models\City;

/**
 * This is the model class for table "city_quote_text".
 *
 * @property integer $id
 * @property string $word
 * @property integer $description
 */
class SeoAboutCityText extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city_quote_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'text'], 'required'],
            [['city_id', ], 'integer'],
            [['city_id', ], 'exist', 'targetRelation' => 'city',],
            [['text'], 'string', 'max' => 9999],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'Город',
            'text' => 'Текст для вывода',
        ];
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
