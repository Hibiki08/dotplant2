<?php

namespace app\modules\import\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class FileUrlForm extends Model
{
    public $url;

    public function rules()
    {
        return [
            [['url'], 'required', ],
            [['url'], 'url', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'url' => 'Ссылка',
        ];
    }

    public function downloadFile() {
        try {
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // grab URL and pass it to the browser
            $out = curl_exec($ch);

            // close cURL resource, and free up system resources
            curl_close($ch);

            $fileDirectory = FileHelper::normalizePath(Yii::getAlias('@files/import/'));
            FileHelper::removeDirectory($fileDirectory);
            FileHelper::createDirectory($fileDirectory);

            $fp = fopen($fileDirectory . '/data.csv', 'w');
            fwrite($fp, $out);
            fclose($fp);
            
            Yii::$app->session->addFlash('success', 'Загрузка файла удачно выполнена');
            return true;
        } catch (\Throwable $th) {
            Yii::$app->session->addFlash('error', 'Произошла ошибка при загрузке файла');
            Yii::error('Произошла ошибка при загрузке файла');
            Yii::error($th);
            return false;
        }
    }
}