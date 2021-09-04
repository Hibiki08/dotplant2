<?php

namespace app\modules\shop\controllers;

use app\modules\shop\models\UserAddress;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AddressController
 * @package app\modules\shop\controllers
 */
class AddressController extends Controller
{
    /**
     * @var string
     */
    private $transactionErrors = '';

    /**
     * AddressController constructor.
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        $this->layout = '../../../../web/theme/views/modules/basic/layouts/lk';
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['list', 'index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'list', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list', [
            'dataProvider' => new ActiveDataProvider([
                'query' => UserAddress::find()->where(['user_id' => Yii::$app->user->id]),
            ])
        ]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new UserAddress();
        $message = '';
        $model->user_id = Yii::$app->user->id;

        if (
            Yii::$app->getRequest()->isPost &&
            $model->load(Yii::$app->getRequest()->post()) &&
            $model->validate()
        ) {
            if ($this->saveAddress($model)) {
                $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = $this->transactionErrors;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = UserAddress::getUserAddress($id);

        if (is_null($model)) {
            throw new NotFoundHttpException('Не найдено');
        }

        $message = '';
        $model->user_id = Yii::$app->user->id;

        if (
            Yii::$app->getRequest()->isPost &&
            $model->load(Yii::$app->getRequest()->post()) &&
            $model->validate()
        ) {
            if ($this->saveAddress($model)) {
                $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = $this->transactionErrors;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    /**
     * @param $id
     * @return string|array
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = UserAddress::getUserAddress($id);

        if (is_null($model)) {
            throw new NotFoundHttpException('Не найдено');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $model->toArray([
                'id',
                'country_id',
                'city_id',
                'zip_code',
                'address',
            ]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param UserAddress $model
     *
     * @return bool
     *
     * @throws Exception
     */
    private function saveAddress($model)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();

        try {
            $hasDefault = UserAddress::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['default' => 1])
                ->limit(1)
                ->exists();

            if ($model->default == 1 && $hasDefault) {
                $updated = UserAddress::updateAll(['default' => 0], ['user_id' => Yii::$app->user->id]);
            }

            if ($model->default == 0 && (!$hasDefault || $hasDefault && isset($updated))) {
                $model->default = 1;
            }

            if (!$model->save()) {
                throw new Exception(implode(', ', $model->getFirstErrors()));
            }

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->transactionErrors = $e->getMessage();

            return false;
        }
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->actionList();
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = UserAddress::getUserAddress($id);

        if (is_null($model)) {
            throw new NotFoundHttpException('Не найдено');
        }

        $model->delete();
        $this->redirect(['list']);
    }
}
