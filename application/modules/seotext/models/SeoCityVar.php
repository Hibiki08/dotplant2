<?php

namespace app\modules\seotext\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_city_variables".
 *
 * @property integer $id
 * @property string $word
 * @property integer $description
 */
class SeoCityVar extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_city_variables}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['word', 'description', 'example',], 'required'],
            [['word', 'description'], 'string', 'max' => 1024],
            [['example'], 'string', 'max' => 1024],
            [['word'], 'unique',],
            ['word', 'match', 'pattern' => '/^[a-z_]+$/', 'message' => 'Можно вводить только строчную латиницу [a-z] и символ подчекивания _']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Выражение для замены в Seo-текстах',
            'description' => 'Краткое описание выражения',
            'example' => 'Пример',
        ];
    }
}
