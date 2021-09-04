<?php

namespace app\widgets;

use app\components\ISubdomainService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Widget;

abstract class SubdomainToolsWidget extends Widget
{
    /**
     * App component implements ISubdomainService interface.
     * Can be set it or `self::$subdomainServiceKey`.
     *
     * @see self::$subdomainServiceKey
     *
     * @var ISubdomainService
     */
    public $subdomainService;

    /**
     * Component key in app for component implements ISubdomainService interface.
     * Can be set it or `self::$subdomainService`.
     *
     * @see self::$subdomainService
     *
     * @var string
     */
    public $subdomainServiceKey = 'subdomainService';

    /**
     * {@inheritDoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!($this->subdomainService instanceof ISubdomainService)) {

            if (
                strlen($this->subdomainServiceKey) > 0 &&
                Yii::$app->has($this->subdomainServiceKey) &&
                Yii::$app->get($this->subdomainServiceKey) instanceof ISubdomainService
            ) {
                $this->subdomainService = Yii::$app->get($this->subdomainServiceKey);
            }

            if (!($this->subdomainService instanceof ISubdomainService)) {
                throw new InvalidArgumentException('Not found component "ISubdomainService".');
            }
        }
    }

    /**
     * Return subdomain.
     *
     * Search in storage with user value, then detecting by host name, then founding default domain.
     *
     * @param bool $founded link to variable with value, showing get subdomain from setted value
     * or detected from domain / founded by default
     *
     * @return \app\models\Subdomain|null
     */
    public function getSubdomain(&$founded = false)
    {
        // from saved
        $subdomain = $this->subdomainService->getSubdomain();

        // from domain name
        if (is_null($subdomain)) {
            $subdomain = $this->subdomainService->getSubdomainByHost();
            $founded = true;
        }

        // from default domain
        if (is_null($subdomain)) {
            $subdomain = $this->subdomainService->getDefaultSubdomain();
            $founded = true;
        }

        return $subdomain;
    }

    /**
     *
     * @return \app\models\Subdomain|null
     */
    public function getAllSubdomains()
    {
        return $this->subdomainService->getAllSubdomains();
    }
}
