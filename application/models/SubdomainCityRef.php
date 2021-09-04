<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%subdomain_city_ref}}".
 *
 * @property integer $subdomain_id
 * @property integer $city_id
 *
 * @property-read City $city
 * @property-read Subdomain $subdomain
 */
class SubdomainCityRef extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subdomain_city_ref}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'subdomain_id'], 'integer'],
            [['city_id', 'subdomain_id',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('app', 'City'),
            'subdomain_id' => Yii::t('app', 'Subdomain'),
        ];
    }

    /**
     * Return query for [[Subdomain]].
     *
     * @return ActiveQuery|Subdomain
     */
    public function getSubdomain()
    {
        return $this->hasOne(Subdomain::class, ['id' => 'subdomain_id']);
    }

    /**
     * Return query for [[City]].
     *
     * @return ActiveQuery|City
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
}
