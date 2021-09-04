<?php
namespace app\modules\shop\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $object_model_id
 * @property integer $sort_order
 */

class ProductCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_category}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'object_model_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'object_model_id' => Yii::t('app', 'Object model ID'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public function getProducts(){
        return $this->hasMany(Product::className(), ['object_model_id' => 'id']);
    }
}