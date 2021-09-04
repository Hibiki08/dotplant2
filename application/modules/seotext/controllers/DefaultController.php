<?php

namespace app\modules\seotext\controllers;

use app\backend\actions\UpdateEditable;
use app\backend\components\BackendController;
use app\modules\shop\models\Category;
use app\modules\shop\models\OrderTransaction;
use app\modules\shop\models\Product;
use app\modules\seo\models\Config;
use app\modules\seo\models\Counter;
use app\modules\seo\models\Meta;
use app\modules\seo\models\Redirect;
use app\modules\seo\models\Robots;
use devgroup\ace\AceHelper;
use devgroup\TagDependencyHelper\ActiveRecordHelper;
use yii\base\Event;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use Yii;

class DefaultController extends BackendController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['get-robots'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['flush-meta-cache', 'flush-counter-cache', 'flush-robots-cache'],
                        'roles' => ['cache manage'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['flush-meta-cache', 'flush-counter-cache', 'flush-robots-cache'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['seo manage'],
                    ],
                ],
            ],
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

}
