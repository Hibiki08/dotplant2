<?php

namespace app\widgets\subdomain\forms;

use app\models\Subdomain;
use yii\base\Model;

/**
 * Class ChangeSubdomainForm.
 *
 * @property integer $subdomain_id
 *
 * @property-read Subdomain $subdomain
 *
 * @package app\widgets\subdomain\forms
 */
class ChangeSubdomainForm extends Model
{
    /**
     * @var integer
     */
    public $subdomain_id;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['subdomain_id'], 'integer'],
            [['subdomain_id'], 'required'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
            'subdomain_id' => 'Город',
        ];
    }

    /**
     * Search and return model [[Subdomain]] by self::$subdomain_id.
     *
     * @return Subdomain|null
     */
    public function getSubdomain()
    {
        return Subdomain::findOne($this->subdomain_id);
    }
}
