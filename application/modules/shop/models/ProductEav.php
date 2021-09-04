<?php
namespace app\modules\shop\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $object_model_id
 * @property integer $property_group_id
 * @property integer $key
 * @property integer $value
 * @property integer $sort_order
 */

class ProductEav extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_eav}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_model_id', 'property_group_id', 'sort_order', ], 'integer'],
            [['key', ], 'string', 'max' => 255,],
            [['value', ], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'object_model_id' => Yii::t('app', 'Category ID'),
            'property_group_id' => Yii::t('app', 'Object model ID'),
            'key' => Yii::t('app', 'Sort Order'),
            'value' => Yii::t('app', 'Sort Order'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }
}