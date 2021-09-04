<?php

namespace app\backend\controllers;

use app\backend\traits\BackendRedirect;
use app\models\City;
use Yii;
use app\components\SearchModel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
{
    use BackendRedirect;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['content manage'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel(
            [
                'model' => City::className(),
                //'partialMatchAttributes' => ['name'],
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
     * Updates an existing City model.
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
            $model = new City();
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
     * Deletes an existing City model.
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
     * Finds the City model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return City the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
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
            'results' => City::find()
                ->select(['id', 'text' => 'name'])
                ->andWhere(['LIKE', 'name', $q])
                ->limit(10)
                ->asArray()
                ->all()
        ]);
    }
}
