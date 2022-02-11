<?php

use yii\bootstrap4\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var $status array */
/** @var $param array */
/** @var $search array */

?>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li <?= !isset($param['status'])? 'class="active"' : '' ?>><a href="<?= Url::to(['/orders/orders']) ?>"><?= Yii::t('common', 'All orders') ?></a></li>
        <?php foreach ($status as $stat): ?>
            <li <?= isset($param['status']) ? (($param['status']==array_keys($status, $stat)[0]) ? 'class="active"':'' ): '' ?> >
                <a href="<?= Url::to(['/orders/orders', 'status' => array_keys($status, $stat)[0]]) ?>"><?= $stat ?></a>
            </li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action="<?= Url::to(['/orders/orders']) ?>" method="get">
                <div class="input-group">
                    <?= isset($param['status']) ? '<input type="hidden" name="status" value="'.$param['status'].'">': ''  ?>
                    <input type="text" name="search" class="form-control" value="" placeholder="<?= Yii::t('common', 'Search orders') ?>">
                    <span class="input-group-btn search-select-wrap">
            <?= Html::dropDownList('search-type', 1, $search, ['class' => 'form-control search-select']) ?>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
                </div>
            </form>
        </li>
    </ul>