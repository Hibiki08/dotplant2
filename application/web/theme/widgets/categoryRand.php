<?php
namespace app\web\theme\widgets;

use Yii;
use yii\base\Widget;

class categoryRand extends Widget
{
    public $numCats;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $command = Yii::$app->db->createCommand('SELECT slug FROM `category` ORDER BY RAND() LIMIT ' . $this->numCats);
        $rows = $command->cache(60)->queryAll();
        $result = array();
        foreach($rows as $r) {
            $result[] = $r['slug'];
        }
        return json_encode($result);
    }
}