<?php

namespace app\modules\import\controllers;

use app\backend\components\BackendController;
use app\modules\import\models\FileUrlForm;
use app\modules\import\models\ImportForm;
use app\modules\import\models\ImportService;
use app\modules\import\models\ImportRowsService;
use yii\filters\AccessControl;
use app\backend\traits\BackendRedirect;
use yii\helpers\Url;
use Yii;
use CdekSDK\Requests;
use app\modules\shop\models\Category;
use yii\base\Model;

class DefaultController extends BackendController
{
    use BackendRedirect;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'clear' => ['post'],
                ],
            ]
        ];
    }

    /**
     * Index page
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Скачивает файл csv по указанной ссылке
     *
     * @return string
     */
    public function actionDownload()
    {
        $model = new FileUrlForm();
        $model->url = Yii::$app->params['importUrl'];

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate() && $model->downloadFile()) {
            return $this->redirect(Url::toRoute('index'));
        }

        return $this->render('download',[
            'model' => $model,
        ]);
    }
    
    public function actionImportForm($categories = 1)
    {
        $service = new ImportRowsService();
        
        if($categories) {
            $service->importCategories();
        }

        $cats = Category::find()
            ->where(['!=', 'id', 1,])
            ->orderBy(['sort_order' => SORT_ASC,])
            ->all();
        $models = [];
        foreach($cats as $cat) {
            $models[$cat->id] = new ImportForm([
                'catName' => $cat->name,
                'catId' => $cat->id,
                'parent' => $cat->parent_id,
                'oldPriceOption' => ($cat->oldPrice ? $cat->oldPrice : 1),
                'priceOption' => ($cat->price ? $cat->price : 4),
                'oldPriceCoeff' => ($cat->oldPriceK ? $cat->oldPriceK : 1.5),
                'priceCoeff' => ($cat->priceK ? $cat->priceK : 2),
            ]);
        }

        $post = Yii::$app->request->post();

        if (Model::loadMultiple($models, $post) && Model::validateMultiple($models)) {
            foreach ($models as $model) {
                $category = Category::findOne($model->catId);
                $category->oldPrice = $model->oldPriceOption;
                $category->price = $model->priceOption;
                $category->priceK = $model->priceCoeff;
                $category->oldPriceK = $model->oldPriceCoeff;
                $category->save(false);
            }
            
            return $this->redirect(['save',]);
        }

        return $this->render('importform',[
            'models' => $models,
        ]);
    }

    /**
     * Импортирует файл в табл БД.
     *
     * @return redirect
     */
    public function actionImport() {
        $service = new ImportService();
        $service->import();

        return $this->redirect(Url::toRoute('index'));
    }

    public function actionSave() {
        $service = new ImportRowsService();

        $interval = 25; // 750;
        if($service->importProducts($interval)) {
            return $this->render('save', [
                'total' => $service->getTotal(),
                'imported' => $service->getImported(),
            ]);
        }

        return $this->redirect(Url::toRoute('index'));
    }

    public function actionClear() {
        ImportService::clearAll();
        return $this->redirect(Url::toRoute('index'));
    }

    public function actionSdek($update = false) {
        $condition = ($update ? '1 = 1' : 'cdek_code is null');
        $models = \app\models\City::find()->where($condition)->all();
        $i = 0;

        foreach ($models as $model) {

            $client = new \CdekSDK\CdekClient('Account', 'Secure', new \GuzzleHttp\Client([
                'base_uri' => 'https://integration.edu.cdek.ru',
            ]));

            $request = new Requests\CitiesRequest();
            $request->setCityName($model->name);
            //$request->setPage(0)->setSize(10)->setRegionCode(50);

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
        Yii::$app->session->addFlash('error', "Обновлено $i городов");

        return $this->redirect(Url::toRoute('index'));
    }
}
