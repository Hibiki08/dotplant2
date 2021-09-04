<?php

namespace app\components;

use app\models\Subdomain;
use Yii;
use yii\base\Component;
use yii\web\Cookie;

/**
 * Class SubdomainService.
 *
 * @package app\components
 */
class SubdomainService extends Component implements ISubdomainService
{
    /**
     * Model class implementing the list of subdomains.
     *
     * @var Subdomain
     */
    public $subdomainModelClass = Subdomain::class;

    /**
     * Key in session with id changed Subdomain model.
     *
     * @var string
     */
    public $sessionKey = 'ssub_id';

    /**
     * Excluded words from host name.
     *
     * @var array
     */
    public $excludedDomainWords = ['www'];

    /**
     * {@inheritDoc}
     */
    public function setSubdomain(Subdomain $subdomain)
    {
        return Yii::$app->response->cookies->add(new Cookie([
            'name' => $this->sessionKey,
            'value' => $subdomain->id,
            'domain' => '.' . $this->getBaseDomainFromRequest(false),
        ]));
    }

    /**
     * {@inheritDoc}
     */
    public function getSubdomain()
    {
        if (Yii::$app->request->cookies->has($this->sessionKey)) {
            return $this->subdomainModelClass::findOne((int)Yii::$app->request->cookies->getValue($this->sessionKey));
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultSubdomain()
    {
        return $this->subdomainModelClass::getDefaultSubdomain();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubdomainByHost()
    {
        return $this->subdomainModelClass::getSubdomainByPrefix($this->getDomainPrefixFromRequest());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllSubdomains()
    {
        return $this->subdomainModelClass::find()->all();
    }

    /**
     * Get host name without 1 and 2 domain level.
     *
     * Example: from `same.big.toys.com` returned `same.big`.
     * For exclude worlds from domain used $excludedDomainWords.
     * By default excluded `www`: from `www.big.toys.com` returned `big`.
     *
     * @return string
     */
    private function getDomainPrefixFromRequest()
    {
        $domainParts = explode('.', Yii::$app->request->hostName);

        $domainParts = array_filter($domainParts, function ($i) {
            return !in_array($i, $this->excludedDomainWords);
        });
        array_pop($domainParts); // drop 1 domain lvl
        array_pop($domainParts); // drop 2 domain lvl

        return implode('.', $domainParts);
    }

    /**
     * Return 1 and 2 lvl host name.
     *
     * Example: from `same.big.toys.com` returned `toys.com`.
     *
     * @param bool $port add port to host name (without 80, 433).
     *
     * @return string|null
     */
    public function getBaseDomainFromRequest($port = true)
    {
        $domainParts = explode('.', Yii::$app->request->hostName);
        $domain = Yii::$app->request->hostName;

        if ($domainParts >= 2) {
            $firstLvl = array_pop($domainParts);
            $secondLvl = array_pop($domainParts);

            $domain = $secondLvl . '.' . $firstLvl;
        }

        if ($port && !in_array(Yii::$app->request->port, [80, 433])) {
            $domain .= ':' . Yii::$app->request->port;
        }

        return $domain;
    }
}
