<?php

namespace app\widgets\subdomain;

use app\widgets\subdomain\forms\ChangeSubdomainForm;
use app\widgets\SubdomainToolsWidget;

/**
 * Class SubdomainSelect.
 *
 * @package app\widgets\subdomain
 */
class SubdomainSelect extends SubdomainToolsWidget
{
    /**
     * URL for ajax search subdomains.
     *
     * @var array
     */
    public $subdomainSearchUrl = '';

    /**
     * URL for set subdomain.
     *
     * @var array
     */
    public $subdomainSetUrl = '';

    /**
     * Template file.
     *
     * @var string
     */
    public $viewFile = 'subdomain-select';

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $suggest = false;
        $subdomain = $this->getSubdomain($suggest);
        $subdomainForm = new ChangeSubdomainForm(['subdomain_id' => $subdomain ? $subdomain->id : null]);

        return $this->render($this->viewFile, [
            'subdomainForm' => $subdomainForm,
            'subdomain' => $subdomain,
            'suggest' => $suggest,
            'formUrl' => $this->subdomainSetUrl,
            'searchUrl' => $this->subdomainSearchUrl,
            'allDomains' => $this->getAllSubdomains()
        ]);
    }
}
