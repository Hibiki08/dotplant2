<?php

namespace app\backend\controllers;

use app\backend\traits\BackendRedirect;
use app\models\Subdomain;
use app\models\SubdomainCityRef;
use Yii;
use app\components\SearchModel;
use yii\filters\AccessControl;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * SubdomainController implements the CRUD actions for Subdomain model.
 */
class SubdomainController extends Controller
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
                'model' => Subdomain::className(),
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
            $model = new Subdomain();
            $model->loadDefaultValues();
        } else {
            $model = $this->findModel($id);
        }

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isPost) {
            if ($model->load($post) && $model->validate()) {

                $cityIds = $post[$model->formName()]['cities'] && $post[$model->formName()]['cities']
                    ? $post[$model->formName()]['cities']
                    : [];

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->isNewRecord && $model->id > 0) {
                        SubdomainCityRef::deleteAll(['subdomain_id' => $model->id]);
                    }

                    if ($model->save()) {
                        $batchInsertData = [];
                        foreach ($cityIds as $cityId) {
                            $batchInsertData[] = [$model->id, $cityId];
                        }

                        if (count($batchInsertData) > 0) {
                            Yii::$app->db->createCommand()->batchInsert(
                                SubdomainCityRef::tableName(),
                                ['subdomain_id', 'city_id'],
                                $batchInsertData
                            )->execute();
                        }

                        $transaction->commit();

                        return $this->redirectUser($model->id, true, 'index', 'update');
                    } else {
                        $transaction->rollBack();

                        Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot save data'));
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();

                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_WARNING);
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Inner error'));
                }
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
     * @return Subdomain the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subdomain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Return list Subdomain of query string.
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
            'results' => Subdomain::find()
                ->select(['id', 'text' => 'CONCAT(title, " (", domain_prefix, ")")'])
                ->andWhere(['OR', 
                    ['LIKE', 'title', $q],
                    ['LIKE', 'domain_prefix', $q],
                ])
                ->limit(10)
                ->asArray()
                ->all()
        ]);
    }
}
