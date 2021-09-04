<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%contacts}}".
 *
 * @property integer $id
 * @property string $phone_number
 * @property string $address
 * @property string $support_phone_number
 * @property string $email
 * @property integer $city_id
 * @property integer $subdomain_id
 * @property float $map_longitude
 * @property float $map_latitude
 * @property integer $map_zoom
 *
 * @property-read Subdomain $subdomain
 * @property-read City $city
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contacts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_number', 'support_phone_number', 'address'], 'string', 'max' => 255],
            [['map_longitude', 'map_latitude'], 'double'],
            [['email'], 'string', 'max' => 50],
            [['city_id', 'subdomain_id'], 'integer'],
            [['map_zoom'], 'default', 'value' => 17],
            [['map_zoom'], 'integer', 'min' => 1, 'max' => 19],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone_number' => Yii::t('app', 'Phone number'),
            'support_phone_number' => Yii::t('app', 'Support phone number'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Email'),
            'city_id' => Yii::t('app', 'City'),
            'subdomain_id' => Yii::t('app', 'Subdomain'),
            'map_longitude' => Yii::t('app', 'Map longitude'),
            'map_latitude' => Yii::t('app', 'Map latitude'),
            'map_zoom' => Yii::t('app', 'Map zoom'),
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getSubdomain()
    {
        return $this->hasOne(Subdomain::class, ['id' => 'subdomain_id']);
    }
}
