<?php

use app\modules\orders\widgets\ModeMenu;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $orders array */
/** @var $headers array */

?>

<?= GridView::widget([
    'dataProvider' => $orders,
    'layout' => "{items}\n{sorter}\n{summary}\n{pager}",
    'tableOptions' => [
        'class' => 'table order-table'
    ],
    'columns' => [
        ['attribute' => 'id',
            'header' => $headers['id'],
        ],
        ['attribute' => 'full_name',
            'header' => $headers['user_id'],
        ],
        ['attribute' => 'link',
            'header' => $headers['link'],
        ],
        ['attribute' => 'quantity',
            'header' => $headers['quantity'],
        ],
        ['attribute' => 'service_id',
            'header' => ModeMenu::widget(['items' => 'serviceMenu',
                'headers' => $headers['service_id']]),
            'content' => function($model) {
                return Html::tag('span', Html::encode($model['service_id']), ['class' => 'label-id'])  . " " . $model['service'] ;},
        ],
        ['attribute' => 'status',
            'header' => $headers['status'],
        ],
        ['attribute' => 'mode',
            'header' => ModeMenu::widget(['items' => 'modeMenu',
                'headers' => $headers['mode']]),
        ],
        ['attribute' => 'created',
            'header' => $headers['created_at'],
        ],
    ],
]) ?>