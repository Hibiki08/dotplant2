<?php
namespace app\web\theme\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class OwnerTree extends Widget
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

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        ?>

        <?php if(!$this->inHeader) : ?>
            <div class="menu-category__wrapper fade">
                <a class="catalog-header <?= (!$this->closer ? 'toggle' : '') ?> d-flex" 
                        href="<?= (!$this->closer ? '#': Url::to('/catalog')) ?>">
                    <i class="fas fa-th-large mr-2"></i>
                    Каталог
                </a>
                <div <?= (!$this->closer ? 'class="catalog" style="display:none"' : 'class="catalog d-lg-block d-md-none d-none"') ?>>
                    <ul>
                        <?= $this->nested($this->start, 0, ''); ?>
                    </ul>
                </div>
            </div>
        <?php else : ?>
            <div class="catalog-mobile-wrapper">
                <div class="catalog-mobile-inner">
                    <div class="catalog">
                        <ul>
                            <?= $this->nested($this->start, 0, ''); ?>
                        </ul>
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
        $rows = $command->queryAll();

        if (count($rows) != 0) {
            $level++;
            foreach ($rows as $row) {
                $nestResult = $this->nested($row['id'], $level, $row[$this->link] . '/');
                if ($nestResult != '') {
                    if ($level == 1) {
                        $child = ' class="has-sub"';
                        $nestResultUl = '<ul>' . $nestResult . '</ul>';
                    } else {
                        $child = '';
                        $nestResultUl = '
                            <li class="has-sub">
                                <ul>
                                    ' . $nestResult . '
                                </ul>
                            </li>';
                    }
                } else {
                    $child = '';
                    $nestResultUl = '';
                }

                if ($level == 1) {
                    $result .= '
                        <li' . $child . '>
                            <a href="/catalog/' . $cat . $row[$this->link] . '" class="">
                                <i class="fab fa-gratipay"></i>
                                <span>' . $row[$this->title_field] . '</span>
                            </a>
                            ' . $nestResultUl . '
                        </li>';
                } else {
                    $result .= '
                        <li' . $child . '>
                            <a href="/catalog/' . $cat . $row[$this->link] . '" class="">
                                ' . $row[$this->title_field] . '
                            </a>
                            ' . $nestResultUl . '
                        </li>';
                }
            }
            return $result;
        }
    }
}
