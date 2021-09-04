<?php

namespace app\modules\seotext\models;

use yii\db\ActiveRecord;
use app\models\Product;
use app\modules\seotext\models\SeoProductVar;

/**
 * This is the model class for table "seo_product_variables".
 *
 * @property integer $id
 * @property string $word
 * @property integer $description
 */
class SeoProductVarItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seovars_products_ref}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'seo_variable_id',], 'required',],
            [['product_id', 'seo_variable_id',], 'integer',],
            [['seo_word'], 'string', 'max' => 1024],
        ];
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getVar() {
        return $this->hasOne(SeoProductVar::className(), ['id' => 'seo_variable_id']);
    }
}
