<?php

namespace app\web\theme\module\controllers;

use app\components\Controller;
//use app\modules\core\helpers\ContentBlockHelper;
//use app\modules\core\models\ContentBlock;
//use app\modules\page\models\Page;
//use app\models\Search;
use app\traits\LoadModel;
//use devgroup\TagDependencyHelper\ActiveRecordHelper;
use Yii;
//use yii\caching\TagDependency;
//use yii\data\Pagination;
//use yii\db\ActiveQuery;
//use yii\web\ForbiddenHttpException;
//use yii\web\NotFoundHttpException;
//use yii\web\Response;
use app\modules\seo\behaviors\SetCanonicalBehavior;
//use yii\helpers\Url;

class AboutController extends Controller
{
    use LoadModel;
    
    public function behaviors()
    {
        return [
            [
                'class' => SetCanonicalBehavior::className()
            ]
        ];
    }

    public function actionDelivery() {
        return $this->render('delivery');
    }

    public function actionPayment() {
        return $this->render('payment');
    }
    
    public function actionContacts() {
        return $this->render('contacts');
    }
    
    public function actionHelp() {
        return $this->render('help');
    }
    
    public function actionInfo() {
        return $this->render('info');
    }

    
}