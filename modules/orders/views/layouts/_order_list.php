<?php

use app\modules\orders\widgets\ModeFilter;
use app\modules\orders\widgets\ServiceFilter;
use yii\db\Query;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $orders array */
/** @var $headers array */
/** @var $param array */
/** @var $services Query */

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
            'header' => ServiceFilter::widget(['items' => 'menu',
                'headers' => $headers['service_id'],
                'param' => $param,
                'services' => $services,
            ]),
            'content' => function($model) {
                return Html::tag('span', Html::encode($model['service_id']), ['class' => 'label-id'])  . " " . $model['service'] ;},
        ],
        ['attribute' => 'status',
            'header' => $headers['status'],
        ],
        ['attribute' => 'mode',
            'header' => ModeFilter::widget(['items' => 'menu',
                'headers' => $headers['mode'],
                'param' => $param
            ]),
        ],
        ['attribute' => 'created',
            'header' => $headers['created_at'],
        ],
    ],
]) ?>