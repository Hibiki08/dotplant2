<?php

namespace app\modules\seotext\controllers;

use app\backend\actions\UpdateEditable;
use app\backend\components\BackendController;
use app\modules\seotext\models\SeoCityVar;
use app\modules\seotext\models\SeoCityVarItem;
use app\modules\seotext\models\SeoVariable;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\components\SearchModel;
use app\backend\traits\BackendRedirect;
use app\models\Subdomain;
use app\models\SubdomainCityRef;
use app\models\City;
use yii\base\Model;

/*
use devgroup\ace\AceHelper;
use devgroup\TagDependencyHelper\ActiveRecordHelper;
use yii\base\Event;

use yii\helpers\Json;
*/
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use Yii;

class CityVarsItemsController extends BackendController
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
                        'roles' => ['seo manage'],
                    ],
                ],
            ],
        ];
    }
    

    public function actionIndex()
    {
        $searchModel = new SearchModel(
            [
                'model' => City::className(),
                'partialMatchAttributes' => ['name'],
                'scenario' => 'default',
            ]
        );
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Updates an existing SeoCityVarItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param null|string $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id = null)
    {
        $city = $this->findModel($id);
        $models = $this->getCityVarItems($id);

        $post = Yii::$app->request->post();

        $flag = true;
        if (Model::loadMultiple($models, Yii::$app->request->post()) 
            && Model::validateMultiple($models)) {
            foreach ($models as $model) {
                $flag = $flag && $model->save();
            }
            
            if($flag) {
                return $this->redirectUser($city->id, true, 'index', 'update');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot save data'));
            }
        }

        return $this->render('update', [
            'city' => $city, 
            'models' => $models,
        ]);
    }

    private function getCityVarItems($cityId) {
        $cityVarsIds = SeoCityVar::find()->select('id')->column();
        $models = [];

        foreach ($cityVarsIds as $varId) {
            $model = SeoCityVarItem::findOne([
                'city_id' => $cityId,
                'seo_variable_id' => $varId,
            ]);

            if($model) {
                $models[] = $model;
            } else {
                $models[] = new SeoCityVarItem ([
                    'city_id' => $cityId,
                    'seo_variable_id' => $varId,
                ]);
            }
        }

        return $models;
    }


    /**
     * Deletes an existing SeoCityVarItem model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    /*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */

    /**
     * Finds the SeoCityVarItem model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return SeoCityVarItem the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findItemModel($id)
    {
        if (($model = SeoCityVarItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Return list cities of query string.
     *
     * @param string $q query string.
     *
     * @return \yii\web\Response
     *
     * @throws ForbiddenHttpException
     */
    public function actionAjaxList($q)
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only ajax');
        }

        return $this->asJson([
            'results' => SeoCityVarItem::find()
                ->select(['id', 'text' => 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10)
                ->asArray()
                ->all()
        ]);
    }

}
