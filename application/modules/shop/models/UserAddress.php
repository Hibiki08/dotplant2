<?php

namespace app\modules\shop\models;

use app\modules\user\models\User;
use Yii;
use app\models\City;
use app\models\Country;

/**
 * This is the model class for table "user_address".
 *
 * @property int $id
 * @property int $user_id
 * @property int $default
 * @property string $name
 * @property int $country_id
 * @property int $city_id
 * @property int $zip_code
 * @property string $address
 *
 * @property City $city
 * @property Country $country
 * @property User $user
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'country_id', 'city_id', 'zip_code', 'address'], 'required'],
            [['user_id', 'default', 'country_id', 'city_id', 'zip_code'], 'integer'],
            [['zip_code'], 'integer', 'max' => 999999],
            [['name', 'address'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'default' => Yii::t('app', 'Default'),
            'name' => Yii::t('app', 'Name'),
            'country_id' => Yii::t('app', 'Country ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param null $userId
     * @return static|\yii\db\ActiveRecord|null
     */
    public static function getDefaultAddress($userId = null)
    {
        if (is_null($userId)) {
            $userId = (int)Yii::$app->user->id;
        }

        return static::find()
            ->where(['user_id' => $userId])
            ->andWhere(['default' => 1])
            ->one();
    }

    /**
     * @param null $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUserAddresses($userId = null)
    {
        if (is_null($userId)) {
            $userId = (int)Yii::$app->user->id;
        }

        return static::find()
            ->where(['user_id' => $userId])
            ->all();
    }

    /**
     * @param $addressId
     * @param null $userId
     * @return array|\yii\db\ActiveRecord|null|static
     */
    public static function getUserAddress($addressId, $userId = null)
    {
        if (is_null($userId)) {
            $userId = (int)Yii::$app->user->id;
        }

        return static::find()
            ->where(['user_id' => $userId])
            ->andWhere(['id' => $addressId])
            ->one();
    }
}
