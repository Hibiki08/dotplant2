<?php
namespace app\components\delivery\sdek;

use CdekSDK\Requests;
use Yii;


class SdekDelivery extends \yii\base\Model 
{
    CONST TARIFF_ID = 10;
    CONST TARIFF_ID_CURIER = 11;

    public static function getDeliveryPrice($orderItems, $cityCode, $orderDeliveryInformation) {
        $client = new \CdekSDK\CdekClient('Account', 'Secure', new \GuzzleHttp\Client([
            'base_uri' => 'https://integration.cdek.ru',
        ]));

        $price =[
            'deliveryPrice' => [],
            'errors' => [],
        ];
        
        $request = new Requests\CalculationWithTariffListRequest();
        $request->setSenderCityId(44)
            ->setReceiverCityId($cityCode)
            ->addTariffToList(self::TARIFF_ID)
            ->addTariffToList(self::TARIFF_ID_CURIER);

        foreach($orderItems as $item) {
            $product = $item->product;
            for ($index = 0; $index < $item->quantity; $index++) {
                $request->addPackage([
                    'weight' => ($product->brutto      ? ($product->brutto / 1000) : 1),
                    'length' => ($product->brutto_length ? $product->brutto_length : 1),
                    'width'  => ($product->brutto_width  ? $product->brutto_width  : 1),
                    'height' => ($product->brutto_height ? $product->brutto_height : 1),
                ]);
            }
        }
        
        
        $response = $client->sendCalculationWithTariffListRequest($request);

        /** @var \CdekSDK\Responses\CalculationWithTariffListResponse $response */

        if ($response->hasErrors()) {
            // обработка ошибок

            foreach ($response->getMessages() as $message) {

                if ($message->getErrorCode() !== '') {
                    // Это ошибка; бывают случаи когда сообщение с ошибкой - пустая строка.
                    // Потому нужно смотреть и на код, и на описание ошибки.
                    $price['errors'][] = [$message->getErrorCode() => $message->getMessage(),];
                }
            }
            
        }

        $resultPrice = 0;

        foreach ($response->getResults() as $result) {

            if ($result->hasErrors()) {
                // обработка ошибок
                $errors = $result->getErrors();
                foreach($errors as $err)
                {
                    $price['errors'] = [$err->getErrorCode() => $err->getMessage()];
                }
                
                continue;
            }

            if (!$result->getStatus()) {
                continue;
            }

            $price['deliveryPrice'][$result->getTariffId()] = [
                'price' => $result->getPrice(),
                'minPeriod' => $result->getDeliveryPeriodMin(),
                'maxPeriod' => $result->getDeliveryPeriodMax(),
            ];
            $resultPrice = $result->getPrice();
        }
        
        return $price;
    }

    public static function getShippingPrice($cityCode, $orderDeliveryInformation, $isPickup = true) {
        $tariffId = $isPickup ? self::TARIFF_ID : self::TARIFF_ID_CURIER;

        $deliveryPrice = self::getDeliveryPrice($orderDeliveryInformation->order->items, $cityCode, $orderDeliveryInformation);

        return $deliveryPrice['deliveryPrice'][$tariffId]['price'] ?? 0;
    }

    public static function getInfo($orderItems, $cityCode, $orderDeliveryInformation, $isPickup = true) {
        $tariffId = $isPickup ? self::TARIFF_ID : self::TARIFF_ID_CURIER;
        $deliveryPrice = self::getDeliveryPrice($orderItems, $cityCode, $orderDeliveryInformation);
        if(empty($deliveryPrice['errors'])) {
            $result['price'] = $deliveryPrice['deliveryPrice'][$tariffId]['price'] ?? -1;
            $minPeriod = $deliveryPrice['deliveryPrice'][$tariffId]['minPeriod'] ?? -1;
            $maxPeriod = $deliveryPrice['deliveryPrice'][$tariffId]['minPeriod'] ?? -1;
            if($minPeriod == $maxPeriod) {
                $result['period'] = "до {$minPeriod} дней";
            } else {
                $result['period'] = "{$minPeriod}-{$maxPeriod} дней";
            }
        } else {
            Yii::error($deliveryPrice['errors']);
            $result = ['error' => 'Нет возможности оформить данный вид доставки для выбранного города'];
        }
        return $result;
    }
    
}