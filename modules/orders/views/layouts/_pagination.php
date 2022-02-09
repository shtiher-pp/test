<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/** @var $param array */
/** @var $pages array */
/** @var $pagination array */

$param = $this->params['params']['param'];
$pages = $this->params['params']['pages'];
$pagination = $this->params['params']['pagination'];

?>
<div class="row">
    <div class="col-sm-8">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <div class="col-sm-4 pagination-counters">
        <?= $pages?>
    </div>
