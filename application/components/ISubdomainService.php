<?php

namespace app\components;

use app\models\Subdomain;

/**
 * Interface ISubdomainService.
 *
 * Interface for work with site subdomains(city).
 *
 * @package app\components
 */
interface ISubdomainService
{
    /**
     * Save subdomain like changed by user.
     *
     * @param Subdomain $subdomain
     *
     * @return void
     */
    public function setSubdomain(Subdomain $subdomain);

    /**
     * Return saved subdomain.
     *
     * @return Subdomain|null
     */
    public function getSubdomain();

    /**
     * Return default subdomain. Used when subdomain not set or not defined.
     *
     * @return Subdomain|null
     */
    public function getDefaultSubdomain();

    /**
     * Try to define subdomain by host name.
     *
     * @return Subdomain|null
     */
    public function getSubdomainByHost();

    /**
     * Try to define all subdomains.
     *
     * @return Subdomain|null
     */
    public function getAllSubdomains();
}
