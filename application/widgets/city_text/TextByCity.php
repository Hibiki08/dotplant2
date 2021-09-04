<?php

namespace app\widgets\city_text;

use app\widgets\SubdomainToolsWidget;

/**
 * Class TextByCity.
 *
 * @package app\widgets\product_text
 */
class TextByCity extends SubdomainToolsWidget
{
    /**
     * Field name in city model with city name.
     *
     * @var string|callable
     */
    public $cityAttribute = 'name';

    /**
     * Key in text for replace.
     *
     * @var string
     */
    public $key = '{city_name}';

    /**
     * Text.
     *
     * @var string
     */
    public $text = 'sell in {city_name}';

    /**
     * Template file.
     *
     * @var string
     */
    public $viewFile = 'city-text';

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $subdomain = $this->getSubdomain();

        $cities = [];
        if ($subdomain) {
            $cities = $subdomain->cities;
        }

        return $this->render($this->viewFile, [
            'cities' => $cities,
            'text' => $this->text,
            'key' => $this->key,
            'cityAttribute' => $this->cityAttribute,
        ]);
    }
}
