<?php

/** @var $statuses array */
/** @var $param array */
/** @var $search array */
/** @var $orders array */
/** @var $servicesMenu array */
/** @var $modeMenu array */
/** @var $headers array */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="container-fluid">
    <?= $this->render('../layouts/_filters', [
        'statuses' => $statuses,
        'param' => $param,
        'search' => $search,
    ]) ?>
    <?= $this->render('../layouts/_order_list', [
        'orders' => $orders,
        'servicesMenu' => $servicesMenu,
        'modeMenu' => $modeMenu,
        'headers' => $headers
    ]) ?>
    <div class="export-csv-link">
        <span>
            <?= Html::a(Yii::t('common', 'Save result'), Url::to(array_merge(['/orders/export'],$param))) ?>
        </span>
    </div>
</div>
</br>