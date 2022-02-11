<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/** @var $pages array */
/** @var $pagination array */

?>
<div class="row">
    <div class="col-sm-8">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <div class="col-sm-4 pagination-counters">
        <?= $pages?>
    </div>