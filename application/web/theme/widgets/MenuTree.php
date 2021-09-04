<?php
namespace app\web\theme\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use app\components\Menu;

class MenuTree extends Widget
{
    public $table;
    public $result = '';
    public $order;
    public $start;
    public $title_field;
    public $link;
    public $closer = 0;
    public $activeClass = 'is_active';
    public $inHeader = false;
    public $urlPrefix = '/catalog/';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ?>

        <?php if(!$this->inHeader) : ?>
            <div class="menu-category__wrapper d-lg-block d-sm-none d-none fade">
                <a class="catalog-header <?= (!$this->closer ? 'toggle' : '') ?> d-flex" 
                        href="<?= (!$this->closer ? '#': Url::to('/catalog')) ?>">
                    <i class="fas fa-th-large mr-2"></i>
                    Каталог
                </a>
                <div <?= (!$this->closer ? 'class="catalog" style="display:none"' : 'class="catalog d-lg-block d-md-none d-none"') ?>>
                        <?= Menu::widget(['items' => $this->nested($this->start, 0, ''), 'encodeLabels' => false, 'activeCssClass' => 'active-item', 'activateParents' => true,]); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="catalog-mobile-wrapper">
                <div class="close-menu"><i class="fas fa-times"></i></div>
                <div class="search-box-mobile">
                    <div class="d-flex justify-content-between align-items-center">
                        <?= \app\extensions\DefaultTheme\widgets\OneRowHeaderWithCart\ExpandableSearchField::widget([
                            'useFontAwesome' => false, //$useFontAwesome,
                            'autocomplete' => false,
                            'inputClass' => '22',
                        ]) ?>
                    </div>
                </div>
                
                <div class="catalog-mobile-inner">
                    <div class="catalog">
                        <?= Menu::widget(['items' => $this->nested($this->start, 0, ''), 'encodeLabels' => false, ]); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
    }

    public function nested($owner_id, $level, $cat)
    {
        $result = '';
        $command = Yii::$app->db->createCommand('
            SELECT `id`, ' . $this->title_field . ', ' . $this->link . '
            FROM ' . $this->table . '
            WHERE `parent_id` = ' . $owner_id . '
            ORDER BY ' . $this->order . '
        ');
        $rows = $command->cache(60)->queryAll();

        if (count($rows) != 0) {
            $level++;
            $result = [];
            foreach($rows as $r) {
                $nestResult = $this->nested($r['id'], $level, $r[$this->link] . '/');
                if ($level == 1 && $nestResult) {
                    $itemClass = 'has-sub';
                } else {
                    $itemClass = '';
                }

                $url = $this->urlPrefix . $cat . $r[$this->link];
                $item = [
                    'label' => ($level == 1 ? '<i class="fab fa-gratipay"></i>' : '') . $r[$this->title_field],
                    'url' => [$url],
                    'options'=>['class'=>$itemClass . ($url == \Yii::$app->request->url ? ' active' : '')],
                ];

                if($nestResult) {
                    $item['items'] = $nestResult;
                }

                $result[] = $item;
            }
            return $result;
        } else {
            return [];
        } 
    }

}
