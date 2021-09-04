<?php

namespace app\modules\seotext\models;

use yii\db\ActiveRecord;
use app\models\City;
use app\modules\seotext\models\SeoCityVar;

/**
 * This is the model class for table "seo_city_variables".
 *
 * @property integer $id
 * @property string $word
 * @property integer $description
 */
class SeoCityVarItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_city_variables_cities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'seo_variable_id',], 'required',],
            [['city_id', 'seo_variable_id',], 'integer',],
            [['seo_word'], 'string', 'max' => 1024],
        ];
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getVar() {
        return $this->hasOne(SeoCityVar::className(), ['id' => 'seo_variable_id']);
    }
}
