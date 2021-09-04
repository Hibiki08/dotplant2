<?php

namespace app\widgets\contacts;

use app\widgets\SubdomainToolsWidget;

class CityContacts extends SubdomainToolsWidget
{
    /**
     * Template file.
     *
     * @var string
     */
    public $viewFile = 'city-contacts';

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $subdomain = $this->getSubdomain();

        $contacts = [];
        if ($subdomain) {
            $contacts = $subdomain->contacts;
        }

        return $this->render($this->viewFile, [
            'contacts' => $contacts,
        ]);
    }
}
