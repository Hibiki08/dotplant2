<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%subdomain}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $domain_prefix
 * @property integer $is_stock
 * @property boolean $default
 *
 * @property-read City[] $cities
 * @property-read Contact[] $contacts
 */
class Subdomain extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subdomain}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_stock'], 'integer'],
            [['default'], 'boolean'],
            [['domain_prefix'], 'required'],
            [['title', 'domain_prefix'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'domain_prefix' => Yii::t('app', 'Domain prefix'),
            'is_stock' => Yii::t('app', 'Stock'),
            'cities' => Yii::t('app', 'Cities'),
        ];
    }

    /**
     * Return query for list [[City]].
     *
     * @return ActiveQuery|City[]|array
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(SubdomainCityRef::tableName(), ['subdomain_id' => 'id']);
    }

    /**
     * Return default subdomain.
     *
     * @return array|ActiveRecord|null
     */
    public static function getDefaultSubdomain()
    {
        return static::find()->andWhere(['default' => 1])->one();
    }


    /**
     * Return default subdomain.
     *
     * @return array|ActiveRecord|null
     */
    public static function getAllSubdomains()
    {
        return static::find()->all();
    }

    /**
     * Return subdomain by domain prefix.
     *
     * @param string $prefix
     *
     * @return array|ActiveRecord|null
     */
    public static function getSubdomainByPrefix($prefix)
    {
        return static::find()->andWhere(['domain_prefix' => $prefix])->one();
    }

    /**
     * @return ActiveQuery
     */
    public function getContacts()
    {
        $query = Contact::find()
            ->andWhere(['subdomain_id' => $this->id]);

        $cities = $this->cities;

        if (count($cities) > 0) {
            $query->orWhere(['city_id' => ArrayHelper::getColumn($cities, 'id')]);
        }

        $query->multiple = true;

        return $query;
    }
}
