<?php

use app\modules\orders\models\models\Orders;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $orders array */
/** @var $servicesMenu array */
/** @var $modeMenu array */
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
            'header' => $this->render('../layouts/_services_menu', [
                'servicesMenu' => $servicesMenu,
                'headers' => $headers
            ]),
            'content' => function($model) {
                return Html::tag('span', Html::encode($model['service_id']), ['class' => 'label-id'])  . " " . Yii::t('common', $model['service']) ;},
        ],
        ['attribute' => 'status',
            'header' => $headers['status'],
            'value' => function ($model, $key, $index, $column){
                $status = Orders::getStatuses();
                return $status[$model[$column->attribute]];
            },
        ],
        ['attribute' => 'mode',
            'header' => $this->render('../layouts/_mode_menu', [
                'modeMenu' => $modeMenu,
                'headers' => $headers,
            ]),
            'value' => function ($model, $key, $index, $column) {
                $active = $model[$column->attribute] == 1;
                return $active ? Yii::t('common', 'orders.auto_mode') : Yii::t('common', 'orders.manual_mode');
            },
        ],
        ['attribute' => 'created',
            'header' => $headers['created_at'],
            'format' =>  ['date', 'YYYY-MM-dd HH:mm:ss'],
            'options' => ['width' => '200']
        ],
    ],
]) ?>