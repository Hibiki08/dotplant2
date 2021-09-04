<?php

namespace app\backend\controllers;

use app\backend\traits\BackendRedirect;
use app\models\Contact;
use Yii;
use app\components\SearchModel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
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
     * Lists all Subdomain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel(
            [
                'model' => Contact::className(),
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
     * Updates an existing Subdomain model.
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
            $model = new Contact();
            $model->loadDefaultValues();
        } else {
            $model = $this->findModel($id);
        }

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isPost) {
            if ($model->load($post) && $model->validate() && $model->save()) {
                return $this->redirectUser($model->id, true, 'index', 'update');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot save data'));
            }
        }

        return $this->render('update', ['model' => $model,]);
    }


    /**
     * Deletes an existing Subdomain model.
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
     * Finds the Subdomain model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return Contact the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
