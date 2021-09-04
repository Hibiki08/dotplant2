<?php

use yii\db\Migration;

/**
 * Class m201108_084041_add_seo_variables_into_tables
 */
class m201108_084041_add_seo_variables_into_tables extends Migration
{
    CONST CITY_VAR_TABLE = '{{%seo_city_variables}}';
    CONST CATEGORY_VAR_TABLE = '{{%seo_category_vars}}';
    CONST PRODUCT_VAR_TABLE = '{{%seo_product_vars}}';
    CONST CITY_TEXT_TABLE = '{{%city_quote_text}}';
    CONST SEO_TEXTS_TABLE = '{{%seo_texts}}';

    public function safeUp()
    {
        $this->batchInsert(
            self::CITY_VAR_TABLE, 
            ['word', 'example', 'description',], 
            [
                ['city_name', 'Пермь', 'Наименование в именительном падеже',],
                ['city_for_all', 'всей Перми', 'Текст для всего города',],
                ['city_predl_p', '(в) Перми', 'Наименование в предложном падеже (где)',],
                ['oblast', 'край', 'Регион (область, край, республика)',],
                ['po_oblast', 'краю', '(доставка по) краю, области, республике',],
                ['oblast_name', 'Пермский край', 'Наименование региона',],
                ['oblast_name_predl', '(по) Пермскому краю', 'Наименование региона в предл падеже',],
                ['jiteli', 'пермяки', 'Жители города',],
                ['jitel_ed_ch', 'пермяк', 'Житель города в ед.числе',],
            ]
        );

        
        $cityData = [
            'city_name' => 'Новосибирск',
            'city_for_all' => 'всего Новосибирска',
            'city_predl_p' => 'Новосибирске',
            'oblast' => 'область',
            'po_oblast' => 'области',
            'oblast_name' => 'Новосибирская область',
            'oblast_name_predl'  => 'Новосибирской области',
            'jiteli' => 'новосибиряки',
            'jitel_ed_ch' => 'новосибиряк',
        ];

        foreach ($cityData as $key => $value) {
            $id = app\modules\seotext\models\SeoCityVar::findOne(['word' => $key])->id;
            $this->insert(
                '{{%seo_city_variables_cities}}', 
                [
                    'city_id' => 627,
                    'seo_variable_id' => $id,
                    'seo_word' => $value,
                ]
            );
        }

        
        $this->batchInsert(
            self::CATEGORY_VAR_TABLE, 
            ['word', 'example', 'description',], 
            [
                ['cat_name', 'фаллоимитатор', 'Наименование в именительном падеже',],
                ['cat_name_mn', 'фаллоимитаторы', 'Наименование в мн.числе',],
                ['cat_name_mn_rod', 'фаллоимитаторов', 'Наименование в мн.числе и род.п.',],
                ['cat_predl_p', '(без) фаллоимитатора', 'Наименование в родительном падеже',],
                ['smart_text', 'Наши фаллоимтиторы максимально реалистичные', 'Уникальный текст для категории',],
                ['in_cat_count', '5000', 'Количество товаров в категории',],
            ]
        );
        
        $this->batchInsert(
            self::PRODUCT_VAR_TABLE, 
            ['word', 'example', 'description',], 
            [
                //['product_name', 'фаллоимитатор XXX', 'Наименование товара в именительном падеже',],
                ['product_name_mn', 'фаллоимитаторы XXX', 'Наименование товара в мн.числе',],
                ['product_predl_p', '(без) фаллоимитатора XXX', 'Наименование товара в родительном падеже',],
                ['smart_text', 'фаллоимитатор XXX может работать при любой температуре', 'Уникальный текст для товара',],
            ]
        );
        

        $this->batchInsert(
            self::CITY_TEXT_TABLE, 
            ['city_id', 'text',], 
            [
                ['1', 'Москва замечательный город',],
            ]
        );

        $this->batchInsert(
            self::SEO_TEXTS_TABLE, 
            ['text', 'description', 'published', 'inProduct', 'inCategory'], 
            [
                ['<p>Иногда, важно уделить внимание себе. Остановиться в бесконечной череде событий и забот, 
                    поставить скоротечность времени на паузу. Побыть эгоистом, если угодно. 
                    И в этот момент - подходящий <a href="{cat_url}">{cat_name}</a> будет кстати. Например, Вам может подойти <a href="{product_url}">{product_name}</a>. 
                    Больше {in_cat_count} {cat_name_mn_rod} всевозможных форм, размеров и материалов 
                    – найдете тот, который удовлетворит любые фантазии.<p/>
                    <p>Удовольствие наедине с собой, или... Приятное дополнение с партнёром. 
                    Используйте для предварительных ласк, "на разогреве", перед выступлением хэдлайнера, 
                    или во время основного действа, для открытия новых граней удовольствия - двойного проникновения. 
                    В разделе "Лубриканты и смазки", подберите подходящие для того или иного события
                    и материала {cat_predl_p}, лубриканты.<p/>
                    <p>{cat_name_mn}, реализуемые в нашем магазине, выполнены из гипоалергенных и тактильно 
                    приятных материалов. Выберите модели для различных случаев, будь то выполненные в анатомически
                    достоверных размерах и формах либо для самых смелых фантазий ;)<p/>
                    <p>{cat_name_mn} в {city_predl_p}<p/>
                    <p>Купить {cat_name_mn} для секса по приятной цене в интернет-магазине секс-шопа SexToys365.ru 
                    в городе {city_name}<p/>
                    <p>Сексуальное белье, игрушки для интимных развлечений мы поможем доставить ваш заказ до двери 
                    вашего дома. {city_name} - неповторимый город, с фантастическими людьми. Наш онлайн-магазин 
                    открыт для {city_for_all}.<p/>', 
                    
                    'Наш первый текст', 1, 0, 1],
            ]
        );
    }


    public function safeDown()
    {
        $this->delete(
            self::CITY_VAR_TABLE, 
            ['word' =>  
                [
                    'city_name',
                    'city_for_all',
                    'city_predl_p',
                    'oblast',
                    'po_oblast',
                    'oblast_name',
                    'oblast_name_predl',
                    'jiteli',
                    'jitel_ed_ch',
                ],
            ]
        );

        $this->delete('{{%seo_city_variables_cities}}', ['city_id' => 627,]);
        
        $this->delete(
            self::CATEGORY_VAR_TABLE, 
            ['word' =>  
                [
                    'cat_name',
                    'cat_name_mn',
                    'cat_predl_p',
                    'smart_text',
                    'cat_name_mn_rod',
                    'in_cat_count',
                ],
            ]
        );
        
        $this->delete(
            self::PRODUCT_VAR_TABLE, 
            ['word' =>  
                [
                    //'product_name',
                    'product_name_mn',
                    'product_predl_p',
                    'smart_text',
                ],
            ]
        );
        
        $this->delete(
            self::SEO_TEXTS_TABLE, 
            ['description' =>  
                [
                    'Наш первый текст',
                ],
            ]
        );
    }
}
