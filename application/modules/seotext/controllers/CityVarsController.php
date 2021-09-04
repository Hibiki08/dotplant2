<?php

namespace app\modules\seotext\controllers;

use app\backend\actions\UpdateEditable;
use app\backend\components\BackendController;
use app\modules\seotext\models\SeoCityVar;
use app\modules\seotext\models\SeoVariable;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\components\SearchModel;
use app\backend\traits\BackendRedirect;
use app\models\Subdomain;
use app\models\SubdomainCityRef;

/*
use devgroup\ace\AceHelper;
use devgroup\TagDependencyHelper\ActiveRecordHelper;
use yii\base\Event;

use yii\helpers\Json;
*/
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use Yii;

class CityVarsController extends BackendController
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
                'model' => SeoCityVar::className(),
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
     * Updates an existing SeoCityVar model.
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
        if (is_null($id)) {
            $model = new SeoCityVar();
            $model->loadDefaultValues();
        } else {
            $model = $this->findModel($id);
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            if ($model->save()) {
                return $this->redirectUser($model->id, true, 'index', 'update');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot save data'));
            }
        }

        return $this->render('update', ['model' => $model,]);
    }


    /**
     * Deletes an existing SeoCityVar model.
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SeoCityVar model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return SeoCityVar the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeoCityVar::findOne($id)) !== null) {
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
            'results' => SeoCityVar::find()
                ->select(['id', 'text' => 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10)
                ->asArray()
                ->all()
        ]);
    }

}
