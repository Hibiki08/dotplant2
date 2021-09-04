<?php

namespace app\modules\seotext\models;

use yii\db\ActiveRecord;
use app\models\Category;
use app\modules\seotext\models\SeoCategoryVar;

/**
 * This is the model class for table "seo_category_variables".
 *
 * @property integer $id
 * @property string $word
 * @property integer $description
 */
class SeoCategoryVarItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seovars_categories_ref}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'seo_variable_id',], 'required',],
            [['category_id', 'seo_variable_id',], 'integer',],
            [['seo_word'], 'string', 'max' => 1024],
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getVar() {
        return $this->hasOne(SeoCategoryVar::className(), ['id' => 'seo_variable_id']);
    }
}
