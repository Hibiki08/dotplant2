<?php

use yii\db\Migration;
use app\models\City;
use CdekSDK\Requests;

/**
 * Class m201203_091752_update_cities_table
 */
class m201203_091752_update_cities_table extends Migration
{

    public function safeUp()
    {
        $models = \app\models\City::find()->all();
        $i = 0;

        foreach ($models as $model) {

            $client = new \CdekSDK\CdekClient('Account', 'Secure', new \GuzzleHttp\Client([
                'base_uri' => 'https://integration.edu.cdek.ru',
            ]));

            $request = new Requests\CitiesRequest();
            $request->setCityName($model->name);

            $response = $client->sendCitiesRequest($request);

            if ($response->hasErrors()) {
                // обработка ошибок
            }

            $array = [];

            foreach ($response as $location) {
                /** @var \CdekSDK\Common\Location $location */
                $array[$location->getCityName()] = $location->getCityCode();
            }

            foreach($array as $name => $code) {
                if($city = \app\models\City::findOne(['name' => $name])) {
                    $city->cdek_code = $code;
                    $city->save(false);
                    $i++;
                }
            }
        }
        \yii\helpers\Console::stdout("Updated $i cities.\r\n");
    }

    public function safeDown()
    {
        City::updateAll(['cdek_code' => null], '1 = 1');
    }

}
