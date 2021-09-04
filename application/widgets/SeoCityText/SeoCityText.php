<?php

namespace app\widgets\SeoCityText;

use app\widgets\SubdomainToolsWidget;
use app\modules\seotext\models\SeoText;

/**
 * Class SeoCityText.
 *
 * @package app\widgets\product_text
 */
class SeoCityText extends SubdomainToolsWidget
{
    /**
     * Field name in city model with city name.
     *
     * @var string|callable
     */
    public $cityAttribute = 'name';

    /**
     * Template file.
     *
     * @var string
     */
    public $viewFile = 'city-text';

    /**
     * 
     */

    public $isCategory = true;
    public $categoryId;
    public $productId;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->render($this->viewFile, [
            'texts' => $this->getTexts(),
            'aboutCities' => $this->getAboutCities(),
        ]);
    }

    public function getAboutCities() {
        $seoTexts = [];
        foreach ($this->getCities() as $city) {
            $seoTexts[$city->id] = ($city->aboutCitySeoText ? $city->aboutCitySeoText->text : '');
        }

        return $seoTexts;
    }

    public function getTexts() {
        $seoTexts = [];
        foreach ($this->getCities() as $city) {

            if($this->isCategory) {
                $seoTexts[$city->id] = SeoText::getSeoTextInCategory($city->id, $this->categoryId, true);
            } else {
                $seoTexts[$city->id] = SeoText::getSeoTextInProduct($city->id, $this->productId, true);
            }
        }
        return $seoTexts;
    }

    public function getCities() {
        $subdomain = $this->getSubdomain();

        $cities = [];
        if ($subdomain) {
            $cities = $subdomain->cities;
        }

        return $cities;
    }
}
