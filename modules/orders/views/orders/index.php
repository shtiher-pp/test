<?php

use yii\helpers\Url;

/* @var $this \yii\web\View */
/** @var $orders array */
/** @var $services array */
/** @var $pagination array */
/** @var $totalCount string */
/** @var $status array */
/** @var $mode array */
/** @var $pages array */
/** @var $param array */
/** @var $search array */

?>

<?= $this->render('../layouts/_filters', [
    'status' => $status,
    'param' => $param,
    'search' => $search,
]) ?>

<?= $this->render('../layouts/_order_list', [
    'orders' => $orders,
    'services' => $services,
    'totalCount' => $totalCount,
    'status' => $status,
    'mode' => $mode,
    'param' => $param,
]) ?>

<?= $this->render('../layouts/_pagination', [
    'pagination' => $pagination,
    'pages' => $pages,
]) ?>

<div class="export-csv-link">
        <span>
        <a href="<?=Url::to(['/orders/export']).'?'.http_build_query(array_merge($param))?>"><?=Yii::t('common', Yii::t('common', 'Save result')) ?></a></span>
</div>
</div>
</div>
